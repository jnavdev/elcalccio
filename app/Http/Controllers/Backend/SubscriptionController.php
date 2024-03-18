<?php

namespace App\Http\Controllers\Backend;

use Carbon\Carbon;
use App\Models\Subscription;
use App\Models\Course;
use App\Models\Student;
use App\Models\Proxy;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Lang;
use App\Http\Requests\Backend\Subscription\StoreRequest;
use App\Http\Requests\Backend\Subscription\UpdateRequest;

class SubscriptionController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Subscription::with('student', 'course');

            return datatables()->of($data)
                ->filter(function ($query) use ($request) {
                    if ($request->get('search')['value']) {
                        // global search
                        $query->whereHas('student', function ($query) use ($request) {
                            $query->where('full_name', 'like', "%" . $request->get('search')['value'] . "%");
                        });
                    }

                    if ($request->get('filter_state')) {
                        $query->where('subscriptions.payed', ($request->get('filter_state') == 'unpaid') ? false : true);
                    }

                    if ($request->get('filter_class')) {
                        if ($request->get('filter_class') == 'Menor Edad') {
                            $query->whereHas('student', function ($query) {
                                $query->where('class', 'Menor Edad');
                            });
                        } else if ($request->get('filter_class') == 'Mayor Edad') {
                            $query->whereHas('student', function ($query) {
                                $query->where('class', 'Mayor Edad');
                            });
                        }
                    }

                    if ($request->get('filter_birth_date')) {
                        $query->whereHas('student', function ($query) use ($request) {
                            $query->whereYear('birth_date', $request->get('filter_birth_date'));
                        });
                    }

                    if ($request->get('filter_year')) {
                        $query->whereYear('subscriptions.start_date', $request->get('filter_year'));
                    }

                    if ($request->get('filter_month')) {
                        $query->whereMonth('subscriptions.start_date', $request->get('filter_month'));
                    }
                })
                ->editColumn('total', function ($row) {
                    return '<span class="badge badge-pill badge-info">$' . chileanPeso($row->total) . '</span>';
                })
                ->editColumn('payed', function ($row) {
                    $span = '<span class="badge badge-pill badge-danger">Sin Pagar</span>';

                    if ($row->payed) {
                        $span = '<span class="badge badge-pill badge-success">Pagado</span>';
                    }

                    return $span;
                })
                ->addColumn('payButton', function ($row) {
                    $button = "<button class='btn btn-sm btn-success' title='Pagar' disabled><i class='fas fa-check'></i></button>";

                    if (!$row->payed) {
                        $button = "<button class='btn btn-sm btn-success btn-pay' data-id='{$row->id}' title='Pagar'><i class='fas fa-check'></i></button>";
                    }

                    return $button;
                })
                ->addColumn('action', function ($row) {
                    $buttons = "<button class='btn btn-sm btn-info btn-detail' data-id='{$row->id}' title='Detalle'><i class='fas fa-eye'></i></button> ";
                    $buttons .= "<a class='btn btn-sm btn-primary' href='" . route('subscriptions.edit', $row->id) . "' title='Editar'><i class='fas fa-pencil'></i></a> ";
                    $buttons .= "<button class='btn btn-sm btn-danger btn-delete' data-id='{$row->id}' title='Eliminar'><i class='fas fa-trash'></i></button>";

                    return $buttons;
                })
                ->rawColumns(['total', 'payed', 'payButton', 'action'])
                ->addIndexColumn()
                ->toJson();
        }

        $olderStudent = Student::select('birth_date')
            ->where('is_active', true)
            ->whereNotNull('birth_date')
            ->orderBy('birth_date', 'ASC')
            ->first();

        $youngerStudent = Student::select('birth_date')
            ->where('is_active', true)
            ->whereNotNull('birth_date')
            ->orderBy('birth_date', 'DESC')
            ->first();

        $firstSubscription = Subscription::select('start_date')
            ->orderBy('start_date', 'ASC')
            ->first();

        $lastSubscription = Subscription::select('start_date')
            ->orderBy('start_date', 'DESC')
            ->first();

        $years = ($firstSubscription && $lastSubscription) ? range($firstSubscription->start_date->year, $lastSubscription->start_date->year) : range(now()->year, now()->year);
        $birthDateYears = ($olderStudent && $youngerStudent) ? range($olderStudent->birth_date->year, $youngerStudent->birth_date->year) : range(now()->year, now()->year);

        return view('backend.sections.subscriptions.index', compact('birthDateYears', 'years'));
    }

    public function create($student_id = null)
    {
        $students = Student::select('full_name', 'id')->where('is_active', true)->get();

        $courses = Course::select(DB::raw("CONCAT(name,' (',period, ')') AS name"), 'id')
            ->where('is_active', true)
            ->get();

        return view('backend.sections.subscriptions.create', compact('students', 'courses'));
    }

    public function store(StoreRequest $request)
    {
        $subscription = Subscription::create([
            'start_date' => Carbon::createFromFormat('d-m-Y', $request->get('start_date'))->format('Y-m-d'),
            'end_date' => Carbon::createFromFormat('d-m-Y', $request->get('end_date'))->format('Y-m-d'),
            'total' => str_replace('.', '', $request->get('total')),
            'payment_media' => $request->get('payment_media'),
            'payed' => $request->get('payed'),
            'course_id' => $request->get('course_id'),
            'student_id' => $request->get('student_id')
        ]);

        if ($request->get('payed')) {
            $course = Course::find($subscription->course_id);

            if ($course->period != 'Dia unico') {
                $calculatedNextDays = $this->calculateNextDates($course->period, $subscription->start_date, $subscription->end_date);

                $nextStartDate = $calculatedNextDays['start_date'];
                $nextEndDate = $calculatedNextDays['end_date'];

                Subscription::create([
                    'start_date' => $nextStartDate,
                    'end_date' => $nextEndDate,
                    'total' => $subscription->total,
                    'payment_media' => $subscription->payment_media,
                    'payed' => false,
                    'course_id' => $request->get('course_id'),
                    'student_id' => $request->get('student_id')
                ]);
            }
        }

        flasher(Lang::get('messages.crud.created'), 'success');
        return to_route('subscriptions.index');
    }

    public function show($id)
    {
        $subscription = Subscription::with('course', 'course.school', 'student')->find($id);

        return [
            'start_date' => $subscription->start_date->format('d-m-Y'),
            'end_date' => $subscription->end_date->format('d-m-Y'),
            'total' => '$' . chileanPeso($subscription->total),
            'payment_media' => $subscription->payment_media,
            'payed' => ($subscription->payed) ? 'Si' : 'No',
            'school' => $subscription->course->school->name,
            'course' => $subscription->course->name,
            'student_full_name' => $subscription->student->full_name,
            'student_rut' => $subscription->student->rut,
            'student_birth_date' => ($subscription->student->birth_date) ? $subscription->student->birth_date->format('d-m-Y') : '-',
            'proxy' => Proxy::where('student_id', $subscription->student->id)->first()
        ];
    }

    public function edit($id)
    {
        $subscription = Subscription::with('course', 'student')->find($id);

        $students = Student::select('full_name', 'id')->where('is_active', true)->get();

        $courses = Course::select(DB::raw("CONCAT(name,' (',period, ')') AS name"), 'id')
            ->where('is_active', true)
            ->get();

        return view('backend.sections.subscriptions.edit', compact('subscription', 'students', 'courses'));
    }

    public function update(UpdateRequest $request, $id)
    {
        $subscription = Subscription::find($id);
        $subscription->update([
            'start_date' => Carbon::createFromFormat('d-m-Y', $request->get('start_date'))->format('Y-m-d'),
            'end_date' => Carbon::createFromFormat('d-m-Y', $request->get('end_date'))->format('Y-m-d'),
            'total' => str_replace('.', '', $request->get('total')),
            'payment_media' => $request->get('payment_media'),
            'course_id' => $request->get('course_id'),
            'student_id' => $request->get('student_id')
        ]);

        flasher(Lang::get('messages.crud.updated'), 'success');
        return to_route('subscriptions.index');
    }

    public function destroy($id)
    {
        $subscription = Subscription::find($id);
        $subscription->delete();

        flasher(Lang::get('messages.crud.deleted'), 'success');
        return to_route('subscriptions.index');
    }

    public function getCourseData($id)
    {
        return Course::find($id);
    }

    public function pay(Request $request)
    {
        $subscription = Subscription::find($request->get('subscription_id'));
        $subscription->update([
            'payed' => true
        ]);

        if ($request->get('next_subscription')) {
            $course = Course::find($subscription->course_id);

            if ($course->period != 'Dia unico') {
                $calculatedNextDays = $this->calculateNextDates($course->period, $subscription->start_date, $subscription->end_date);

                $nextStartDate = $calculatedNextDays['start_date'];
                $nextEndDate = $calculatedNextDays['end_date'];

                Subscription::create([
                    'start_date' => $nextStartDate,
                    'end_date' => $nextEndDate,
                    'total' => $subscription->total,
                    'payment_media' => $subscription->payment_media,
                    'payed' => false,
                    'course_id' => $subscription->course_id,
                    'student_id' => $subscription->student_id
                ]);
            }
        }

        return response()->json([
            'success' => true,
            'message' => Lang::get('messages.crud.updated'),
        ], 200);
    }

    private function calculateNextDates($period, Carbon $startDate, Carbon $endDate)
    {
        $start_date = null;
        $end_date = null;

        switch ($period) {
            case 'Semanal':
                $start_date = $startDate->addWeek();
                $end_date = $endDate->addWeek();
                break;
            case 'Mensual':
                $start_date = $startDate->addMonth();
                $end_date = $endDate->addMonth();
                break;
            case 'Semestral':
                $start_date = $startDate->addMonths(6);
                $end_date = $endDate->addMonths(6);
                break;
            case 'Anual':
                $start_date = $startDate->addYear();
                $end_date = $endDate->addYear();
                break;
        }

        return [
            'start_date' => $start_date,
            'end_date' => $end_date
        ];
    }

    public function payments(Request $request)
    {
        if ($request->ajax()) {
            $data = Subscription::with('student', 'course');

            return datatables()->of($data)
                ->filter(function ($query) use ($request) {
                    if ($request->get('search')['value']) {
                        // global search
                        $query->whereHas('student', function ($query) use ($request) {
                            $query->where('full_name', 'like', "%" . $request->get('search')['value'] . "%");
                        });
                    }

                    if ($request->get('filter_class')) {
                        if ($request->get('filter_class') == 'Menor Edad') {
                            $query->whereHas('student', function ($query) {
                                $query->where('class', 'Menor Edad');
                            });
                        } else if ($request->get('filter_class') == 'Mayor Edad') {
                            $query->whereHas('student', function ($query) {
                                $query->where('class', 'Mayor Edad');
                            });
                        }
                    }

                    if ($request->get('filter_year')) {
                        $query->whereYear('subscriptions.start_date', $request->get('filter_year'));
                    }

                    if ($request->get('filter_month')) {
                        $query->whereMonth('subscriptions.start_date', $request->get('filter_month'));
                    }
                })
                ->editColumn('total', function ($row) {
                    return '<span class="badge badge-pill badge-info">$' . chileanPeso($row->total) . '</span>';
                })
                ->editColumn('payed', function ($row) {
                    $span = '<span class="badge badge-pill badge-danger">Sin Pagar</span>';

                    if ($row->payed) {
                        $span = '<span class="badge badge-pill badge-success">Pagado</span>';
                    }

                    return $span;
                })
                ->addColumn('action', function ($row) {
                    $buttons = "<button class='btn btn-sm btn-info btn-detail' data-id='{$row->id}' title='Detalle'><i class='fas fa-eye'></i></button> ";

                    return $buttons;
                })
                ->rawColumns(['total', 'payed', 'action'])
                ->addIndexColumn()
                ->toJson();
        }

        $firstSubscription = Subscription::select('start_date')
            ->orderBy('start_date', 'ASC')
            ->first();

        $lastSubscription = Subscription::select('start_date')
            ->orderBy('start_date', 'DESC')
            ->first();

        $years = ($firstSubscription && $lastSubscription) ? range($firstSubscription->start_date->year, $lastSubscription->start_date->year) : range(now()->year, now()->year);

        // balance
        $totalPayed = 0;
        $totalUnpaid = 0;
        $totalFinal = 0;

        $payedSubscriptions = Subscription::where('payed', true)
            ->whereMonth('start_date', now()->month)
            ->whereYear('start_date', now()->year)
            ->get();

        $unpaidSubscriptions = Subscription::where('payed', false)
            ->whereMonth('start_date', now()->month)
            ->whereYear('start_date', now()->year)
            ->get();

        $allSubscriptions = Subscription::whereMonth('start_date', now()->month)
            ->whereYear('start_date', now()->year)
            ->get();

        foreach ($payedSubscriptions as $subscription) {
            $totalPayed += $subscription->total;
        }
        foreach ($unpaidSubscriptions as $subscription) {
            $totalUnpaid += $subscription->total;
        }
        foreach ($allSubscriptions as $subscription) {
            $totalFinal += $subscription->total;
        }

        $studentsCount = Student::where('is_active', true)->count();

        return view('backend.sections.subscriptions.payments', compact('years', 'totalPayed', 'totalUnpaid', 'totalFinal', 'studentsCount'));
    }

    public function getBalance($month, $year, $class)
    {
        // balance
        $totalPayed = 0;
        $totalUnpaid = 0;
        $totalFinal = 0;

        $payedSubscriptions = Subscription::with('student')
            ->where('payed', true)
            ->whereMonth('start_date', $month)
            ->whereYear('start_date', $year)
            ->when($class, function ($query) use ($class) {
                if ($class != 'all') {
                    $query->whereHas('student', function ($query) use ($class) {
                        $query->where('class', $class);
                    });
                }
            })
            ->get();

        $unpaidSubscriptions = Subscription::with('student')
            ->where('payed', false)
            ->whereMonth('start_date', $month)
            ->whereYear('start_date', $year)
            ->when($class, function ($query) use ($class) {
                if ($class != 'all') {
                    $query->whereHas('student', function ($query) use ($class) {
                        $query->where('class', $class);
                    });
                }
            })
            ->get();

        $allSubscriptions = Subscription::with('student')
            ->whereMonth('start_date', $month)
            ->whereYear('start_date', $year)
            ->when($class, function ($query) use ($class) {
                if ($class != 'all') {
                    $query->whereHas('student', function ($query) use ($class) {
                        $query->where('class', $class);
                    });
                }
            })
            ->get();

        foreach ($payedSubscriptions as $subscription) {
            $totalPayed += $subscription->total;
        }
        foreach ($unpaidSubscriptions as $subscription) {
            $totalUnpaid += $subscription->total;
        }
        foreach ($allSubscriptions as $subscription) {
            $totalFinal += $subscription->total;
        }

        return [
            'balance_title' => 'Balance ' . $month . '-' . $year,
            'balance_total_payed' => chileanPeso($totalPayed),
            'balance_total_unpaid' => chileanPeso($totalUnpaid),
            'balance_total_final' => chileanPeso($totalFinal)
        ];
    }
}
