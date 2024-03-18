<?php

namespace App\Http\Controllers\Backend;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Stadium;
use Carbon\CarbonPeriod;
use Illuminate\Support\Facades\DB;
use App\Models\Reservation;
use Illuminate\Http\Request;
use App\Models\ReservationItem;
use App\Http\Controllers\Controller;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Lang;
use App\Helpers\ReservationCalendar;
use App\Http\Requests\Backend\Reservation\StoreFixedRequest;
use App\Http\Requests\Backend\Reservation\StoreRequest;

class ReservationController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Reservation::select(
                'reservations.id',
                'reservations.total',
                'reservations.state',
                'reservations.advancement',
                'reservations.payment_media',
                'users.name as user_name',
                'stadiums.name as stadium_name',
                'reservation_items.date as reservation_date'
            )
                ->join('users', 'reservations.user_id', '=', 'users.id')
                ->join('stadiums', 'reservations.stadium_id', '=', 'stadiums.id')
                ->join('reservation_items', function ($query) {
                    $query->on('reservation_items.reservation_id', '=', 'reservations.id')
                        ->whereRaw('reservation_items.id IN (select MAX(ri.id) from reservation_items as ri join reservations as r on r.id = ri.reservation_id group by r.id)');
                });

            return datatables()->of($data)
                ->filter(function ($query) use ($request) {
                    if ($request->get('search')['value']) {
                        // global search
                        $query->whereHas('user', function ($query) use ($request) {
                            $query->where('users.name', 'like', "%" . $request->get('search')['value'] . "%");
                        });
                    }

                    if ($request->get('filter_year')) {
                        $query->havingRaw("reservation_date between '" . $request->get('filter_year') . "-01-01' and '" . $request->get('filter_year') . "-12-31'");
                    }
                })
                ->editColumn('advancement', function ($row) {
                    $span = '<span class="badge badge-pill badge-danger">$0</span>';

                    if ($row->advancement) {
                        $span = '<span class="badge badge-pill badge-info">$' . chileanPeso($row->advancement) . '</span>';
                    }

                    return $span;
                })
                ->editColumn('total', function ($row) {
                    $total = chileanPeso($row->total);

                    return '<span class="badge badge-pill badge-success">$' . $total . '</span>';
                })
                ->addColumn('changeStateButton', function ($row) {
                    $html = '<div class="dropdown">
                      <button class="btn btn-sm btn-secondary dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false">' . $row->state . '</button>
                      <div class="dropdown-menu">
                        <a class="dropdown-item dropdown-state" data-id="' . $row->id . '" data-state="Pendiente" href="#">Pendiente</a>
                        <a class="dropdown-item dropdown-state" data-id="' . $row->id . '" data-state="Pagada" href="#">Pagada</a>
                      </div>
                    </div>';

                    return $html;
                })
                ->addColumn('action', function ($row) {
                    $buttons = "<button class='btn btn-sm btn-primary btn-detail' data-id='{$row->id}' title='Detalle'><i class='fas fa-eye'></i></button> ";

                    $deleteButton = "<button class='btn btn-sm btn-danger' disabled><i class='fa fa-trash'></i></button>";

                    if (request()->user()->hasPermission('reservations.destroy')) {
                        $deleteButton = "<button class='btn btn-sm btn-danger btn-delete' data-id='{$row->id}' title='Eliminar'><i class='fas fa-trash'></i></button>";
                    }

                    $buttons .= $deleteButton;

                    return $buttons;
                })
                ->rawColumns(['advancement', 'total', 'changeStateButton', 'action'])
                ->addIndexColumn()
                ->toJson();
        }

        $lastReservationItem = ReservationItem::select('date')->orderBy('id', 'DESC')->first();
        $years = range(now()->year, now()->year);

        if ($lastReservationItem) {
            $years = range($lastReservationItem->date->format('Y'), 2020);
        }

        return view('backend.sections.reservations.index', compact('years'));
    }

    public function changeState($id, Request $request)
    {
        $reservation = Reservation::with('reservationItems')->find($id);
        $available = true;
        $stateRequest = $request->get('state');

        if ($stateRequest == 'Pendiente') {
            if ($reservation->state == 'Pendiente') {
                flasher(Lang::get('messages.reservations.change_state.no_changes'), 'warning');
                return back();
            } else if ($reservation->state == 'Pagada') {
                $reservation->update([
                    'state' => $stateRequest
                ]);

                flasher(Lang::get('messages.reservations.change_state.success'), 'success');
                return back();
            }
        } else if ($stateRequest == 'Pagada') {
            if ($reservation->state == 'Pagada') {
                flasher(Lang::get('messages.reservations.change_state.no_changes'), 'warning');
                return back();
            } else if ($reservation->state == 'Pendiente') {
                foreach ($reservation->reservationItems as $reservationItem) {
                    $searchItem = ReservationItem::find($reservationItem->id);
                    if ($searchItem) {
                        if ($searchItem->reservation->state == 'Pagada') {
                            $available = false;
                            break;
                        }
                    }
                }
            }
        }

        if ($available) {
            $reservation->update([
                'state' => $request->get('state')
            ]);

            flasher(Lang::get('messages.reservations.change_state.success'), 'success');
            return back();
        }

        flasher(Lang::get('messages.reservations.change_state.error'), 'error');
        return back();
    }

    public function detail($id)
    {
        $reservation = Reservation::select(
            'users.name as user_name',
            'users.rut as user_rut',
            'users.phone as user_phone',
            'stadiums.name as stadium_name',
            'reservations.payment_media',
            'reservations.state',
            'reservations.total',
            'reservations.advancement'
        )
            ->join('users', 'reservations.user_id', '=', 'users.id')
            ->join('stadiums', 'reservations.stadium_id', '=', 'stadiums.id')
            ->where('reservations.id', $id)
            ->first();

        $reservationItems = ReservationItem::select(
            'date',
            'hour'
        )
            ->where('reservation_id', $id)
            ->get();

        $data = [
            'reservation' => $reservation,
            'reservationItems' => $reservationItems,
            'discountFormatted' => '$' . chileanPeso($reservation->getDiscount()),
            'totalFormatted' => '$' . chileanPeso($reservation->total),
            'advancementFormatted' => ($reservation->advancement) ? '$' . chileanPeso($reservation->advancement) : '$0'
        ];

        return $data;
    }

    public function destroy($id)
    {
        DB::table('reservation_items')
            ->where('reservation_id', $id)
            ->delete();

        Reservation::destroy($id);

        flasher(Lang::get('messages.crud.deleted'), 'success');
        return to_route('reservations.index');
    }

    public function searchCustomer(Request $request)
    {
        $user = User::select('name', 'email', 'phone')->where('rut', $request->get('rut'))->first();

        if ($user) {
            return [
                'success' => true,
                'customer' => $user
            ];
        }

        return [
            'success' => false,
            'customer' => null
        ];
    }

    public function create($date = null, $stadium_id = null)
    {
        $dateStart = ($date) ? Carbon::parse($date) : Carbon::now();
        $selectedStadiumId = ($stadium_id) ? $stadium_id : Stadium::orderBy('id', 'ASC')->first()->id;

        $reservationCalendar = new ReservationCalendar($dateStart, $selectedStadiumId);
        $table = $reservationCalendar->renderTable();
        $stadiums = Stadium::select('name', 'id')->get();

        return view('backend.sections.reservations.create', compact('table', 'stadiums'));
    }

    public function store(StoreRequest $request)
    {
        $user = User::where('rut', $request->get('rut'))->first();

        if (!$user) {
            $user = User::create([
                'rut' => $request->get('rut'),
                'name' => $request->get('name'),
                'email' => $request->get('email'),
                'phone' => $request->get('phone'),
                'role_id' => 2,
                'password' => bcrypt(substr(str_replace('.', '', $request->get('rut')), 0, 4)) // primeros 4 digitos de su rut
            ]);
        }

        $stadiumId = $request->get('stadium');

        $reservations = [];
        $data = $request->get('res');
        $i = 0;

        foreach ($data as $d) {
            $d = explode('_', $d);

            $reservations['data'][$i]['hour'] = $d[0];
            $reservations['data'][$i]['date'] = $d[1];
            $reservations['data'][$i]['price'] = $d[2];

            $i++;
        }

        $advancement = null;

        if ($request->get('advancement')) {
            $advancement = str_replace('.', '', $request->get('advancement'));
        }

        $newReservation = Reservation::create([
            'type' => 'Normal',
            'commerce_order' => rand(100, 100000) . '-' . time(),
            'total' => str_replace('.', '', $request->get('total')),
            'advancement' => $advancement,
            'state' => 'Pendiente',
            'payment_media' => $request->get('payment_media'),
            'user_id' => $user->id,
            'stadium_id' => $stadiumId
        ]);

        foreach ($reservations['data'] as $d) {
            ReservationItem::create([
                'hour' => $d['hour'],
                'date' => Carbon::createFromFormat('d-m-Y', $d['date'])->format('Y-m-d'),
                'price' => $d['price'],
                'reservation_id' => $newReservation->id
            ]);
        }

        flasher(Lang::get('messages.crud.created'), 'success');
        return to_route('reservations.index');
    }

    public function createFixed()
    {
        $stadiums = Stadium::select('name', 'id')->get();
        $weekDays = config('reusable.week_days');
        $hours = config('reusable.reservation_hours');

        return view('backend.sections.reservations.create-fixed', compact('stadiums', 'weekDays', 'hours'));
    }

    public function storeFixed(StoreFixedRequest $request)
    {
        $startDate = Carbon::createFromFormat('d-m-Y', $request->get('start_date'));
        $endDate = Carbon::createFromFormat('d-m-Y', $request->get('end_date'));
        $days = $request->get('days');
        $hours = $request->get('hours');
        $stadium_id = $request->get('stadium_id');

        $response = $this->checkAvailableDates($startDate, $endDate, $days, $hours, $stadium_id);

        if (!$response) {
            flasher(Lang::get('messages.reservations.fixed.not_available'), 'warning');
            return back();
        }

        $this->saveDateRangeReservations($request);

        flasher(Lang::get('messages.crud.created'), 'success');
        return to_route('reservations.index');
    }

    private function checkAvailableDates($startDate, $endDate, $days, $hours, $stadium_id)
    {
        $response = true;

        $period = CarbonPeriod::create($startDate->format('Y-m-d'), $endDate->format('Y-m-d'));

        foreach ($period->toArray() as $date) {
            foreach ($days as $day) {
                if ($day == $date->format('l')) {
                    foreach ($hours as $hour) {
                        $reservationItem = ReservationItem::whereHas('reservation', function ($query) use ($stadium_id) {
                            $query->where('stadium_id', $stadium_id);
                        })
                            ->where('date', $date->format('Y-m-d'))
                            ->where('hour', $hour)
                            ->first();

                        if ($reservationItem) {
                            if ($reservationItem->reservation->state == 'Pagada' || $reservationItem->reservation->state == 'Pendiente') {
                                $response = false;
                                break;
                            }
                        }
                    }
                }
            }
        }

        return $response;
    }

    private function saveDateRangeReservations($request)
    {
        $startDate = Carbon::createFromFormat('d-m-Y', $request->get('start_date'));
        $endDate = Carbon::createFromFormat('d-m-Y', $request->get('end_date'));
        $period = CarbonPeriod::create($startDate->format('Y-m-d'), $endDate->format('Y-m-d'));
        $stadiumId = $request->get('stadium_id');
        $user = User::where('rut', $request->get('rut'))->first();

        if (!$user) {
            $user = User::create([
                'rut' => $request->get('rut'),
                'name' => $request->get('name'),
                'email' => $request->get('email'),
                'phone' => $request->get('phone'),
                'role_id' => 2,
                'password' => bcrypt(substr(str_replace('.', '', $request->get('rut')), 0, 4)) // primeros 4 digitos de su rut
            ]);
        }

        foreach ($period->toArray() as $date) {
            foreach ($request->get('days') as $day) {
                if ($day == $date->format('l')) {
                    foreach ($request->get('hours') as $hour) {
                        $newReservation = Reservation::create([
                            'type' => 'Fija',
                            'commerce_order' => rand(100, 100000) . '-' . time(),
                            'total' => str_replace('.', '', $request->get('hour_price')),
                            'state' => 'Pendiente',
                            'payment_media' => $request->get('payment_media'),
                            'user_id' => $user->id,
                            'stadium_id' => $stadiumId
                        ]);

                        $reservationCalendar = new ReservationCalendar();

                        ReservationItem::create([
                            'hour' => $hour,
                            'date' => $date->format('Y-m-d'),
                            'price' => $reservationCalendar->calculatePrice($hour, $date)['price'],
                            'reservation_id' => $newReservation->id
                        ]);
                    }
                }
            }
        }
    }

    public function reservationsByDay($date = null, $stadium_id = null)
    {
        $dateStart = ($date) ? Carbon::parse($date) : Carbon::now();
        $selectedStadiumId = ($stadium_id) ? $stadium_id : Stadium::orderBy('id', 'ASC')->first()->id;
        $stadiums = Stadium::select('name', 'id')->get();

        $reservationCalendar = new ReservationCalendar($dateStart, $selectedStadiumId);
        $table = $reservationCalendar->renderReservationsByDay();

        return view('backend.sections.reservations-by-day.index', compact('table', 'stadiums'));
    }

    public function reservationsByDayPdf($date, $stadium_id)
    {
        $carbonDate = Carbon::parse($date);
        $stadium = Stadium::select('name')->find($stadium_id);

        $reservationCalendar = new ReservationCalendar($carbonDate, $stadium_id);
        $html = $reservationCalendar->renderHtmlReservationsByDayPdf();

        $pdf = Pdf::loadView('backend.sections.reservations-by-day.pdf', [
            'date' => $carbonDate,
            'html' => $html,
            'stadium' => $stadium
        ]);

        $pdf->setPaper('A4', 'landscape');

        return $pdf->download("CAJA DIARIA {$carbonDate->format('d-m-Y')}.pdf");
    }

    public function pendingReservations(Request $request)
    {
        if ($request->ajax()) {
            $data = Reservation::select(
                'reservations.id',
                'reservations.total',
                'reservations.state',
                'reservations.advancement',
                'reservations.payment_media',
                'users.name as user_name',
                'stadiums.name as stadium_name',
                'reservation_items.date as reservation_date'
            )
                ->join('users', 'reservations.user_id', '=', 'users.id')
                ->join('stadiums', 'reservations.stadium_id', '=', 'stadiums.id')
                ->join('reservation_items', function ($query) {
                    $query->on('reservation_items.reservation_id', '=', 'reservations.id')
                        ->whereRaw('reservation_items.id IN (select MAX(ri.id) from reservation_items as ri join reservations as r on r.id = ri.reservation_id group by r.id)');
                })
                ->havingRaw("reservation_date <= CURDATE()")
                ->where('reservations.state', 'Pendiente');

            return datatables()->of($data)
                ->filter(function ($query) use ($request) {
                    if ($request->get('search')['value']) {
                        // global search
                        $query->whereHas('user', function ($query) use ($request) {
                            $query->where('users.name', 'like', "%" . $request->get('search')['value'] . "%");
                        });
                    }

                    if ($request->get('filter_year')) {
                        $query->havingRaw("reservation_date between '" . $request->get('filter_year') . "-01-01' and '" . $request->get('filter_year') . "-12-31'");
                    }
                })
                ->editColumn('advancement', function ($row) {
                    $span = '<span class="badge badge-pill badge-danger">$0</span>';

                    if ($row->advancement) {
                        $span = '<span class="badge badge-pill badge-info">$' . chileanPeso($row->advancement) . '</span>';
                    }

                    return $span;
                })
                ->editColumn('total', function ($row) {
                    $total = chileanPeso($row->total);

                    return '<span class="badge badge-pill badge-success">$' . $total . '</span>';
                })
                ->addColumn('changeStateButton', function ($row) {
                    $html = '<div class="dropdown">
                      <button class="btn btn-sm btn-secondary dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false">' . $row->state . '</button>
                      <div class="dropdown-menu">
                        <a class="dropdown-item dropdown-state" data-id="' . $row->id . '" data-state="Pendiente" href="#">Pendiente</a>
                        <a class="dropdown-item dropdown-state" data-id="' . $row->id . '" data-state="Pagada" href="#">Pagada</a>
                      </div>
                    </div>';

                    return $html;
                })
                ->addColumn('action', function ($row) {
                    $buttons = "<button class='btn btn-sm btn-primary btn-detail' data-id='{$row->id}' title='Detalle'><i class='fas fa-eye'></i></button> ";

                    $deleteButton = "<button class='btn btn-sm btn-danger' disabled><i class='fa fa-trash'></i></button>";

                    if (request()->user()->hasPermission('reservations.destroy')) {
                        $deleteButton = "<button class='btn btn-sm btn-danger btn-delete' data-id='{$row->id}' title='Eliminar'><i class='fas fa-trash'></i></button>";
                    }

                    $buttons .= $deleteButton;

                    return $buttons;
                })
                ->rawColumns(['advancement', 'total', 'changeStateButton', 'action'])
                ->addIndexColumn()
                ->toJson();
        }

        $years = range(now()->year, now()->year);
        $lastReservationItem = ReservationItem::select('date')->orderBy('id', 'DESC')->first();
        if ($lastReservationItem) {
            $years = range($lastReservationItem->date->format('Y'), 2020);
        }

        return view('backend.sections.pending-reservations.index', compact('years'));
    }
}
