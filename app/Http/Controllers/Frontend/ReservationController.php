<?php

namespace App\Http\Controllers\Frontend;

use App\Helpers\ReservationCalendar;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use App\Models\Stadium;
use App\Http\Requests\Frontend\Reservation\StoreRequest;
use Illuminate\Support\Facades\Lang;
use App\Models\Reservation;
use App\Models\ReservationItem;

class ReservationController extends Controller
{
    public function reservationsCalendar($date = null, $stadium_id = null)
    {
        session()->forget('reservation');

        $dateStart = ($date) ? Carbon::parse($date) : Carbon::now();
        $selectedStadiumId = ($stadium_id) ? $stadium_id : Stadium::orderBy('id', 'ASC')->first()->id;

        $reservationCalendar = new ReservationCalendar($dateStart, $selectedStadiumId);
        $table = $reservationCalendar->renderTable();
        $stadiums = Stadium::select('name', 'id')->get();

        return view('frontend.reservations-calendar', compact('table', 'stadiums'));
    }

    public function saveSession(StoreRequest $request)
    {
        $stadium = Stadium::find($request->get('stadium'));
        $reservations = [];
        $data = explode(',', $request->get('res'));
        $i = 0;
        $total = 0;

        foreach ($data as $d) {
            $d = explode('_', $d);

            $reservations['data'][$i]['hour'] = $d[0];
            $reservations['data'][$i]['date'] = $d[1];
            $reservations['data'][$i]['price'] = $d[2];

            $i++;
            $total += $d[2];
        }

        session()->put('reservation', [
            'stadium_id' => $stadium->id,
            'stadium_name' => $stadium->name,
            'reservations' => $reservations,
            'total' => $total,
            'user_id' => auth()->id()
        ]);

        return response()->json([
            'success' => true,
            'url' => route('frontend.reservations_preview')
        ], 200);
    }

    public function preview()
    {
        $reservationData = session()->get('reservation');

        return view('frontend.reservation-preview', compact('reservationData'));
    }

    public function store()
    {
        $reservationData = session()->get('reservation');

        $newReservation = Reservation::create([
            'type' => 'Normal',
            'commerce_order' => rand(100, 100000) . '-' . time(),
            'total' => str_replace('.', '', $reservationData['total']),
            'state' => 'Pendiente',
            'payment_media' => 'Efectivo',
            'user_id' => $reservationData['user_id'],
            'stadium_id' => $reservationData['stadium_id']
        ]);

        foreach ($reservationData['reservations']['data'] as $d) {
            ReservationItem::create([
                'hour' => $d['hour'],
                'date' => Carbon::createFromFormat('d-m-Y', $d['date'])->format('Y-m-d'),
                'price' => $d['price'],
                'reservation_id' => $newReservation->id
            ]);
        }

        flasher(Lang::get('messages.frontend.saved_reservation'), 'success');
        return to_route('frontend.my_account.reservations');
    }
}
