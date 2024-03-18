<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Support\Facades\Lang;
use App\Models\MoneyClosure;
use App\Models\ReservationItem;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\MoneyClosure\StoreRequest;
use App\Http\Requests\Backend\MoneyClosure\UpdateRequest;
use App\Models\Stadium;
use Carbon\Carbon;

class MoneyClosureController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = MoneyClosure::with('user', 'stadium');

            return datatables()->of($data)
                ->filter(function ($query) use ($request) {
                    if ($request->get('search')['value']) {
                        // global search
                        $query->whereHas('user', function ($query) use ($request) {
                            $query->where('name', 'like', "%" . $request->get('search')['value'] . "%");
                        })->orWhereHas('stadium' . function ($query) use ($request) {
                            $query->where('name', 'like', "%" . $request->get('search')['value'] . "%");
                        });
                    }
                })
                ->editColumn('cash_collected_total', function ($row) {
                    return '$' . chileanPeso($row->cash_collected_total);
                })
                ->editColumn('cash_real_total', function ($row) {
                    return '$' . chileanPeso($row->cash_real_total);
                })
                ->editColumn('transfer_collected_total', function ($row) {
                    return '$' . chileanPeso($row->transfer_collected_total);
                })
                ->editColumn('transfer_real_total', function ($row) {
                    return '$' . chileanPeso($row->transfer_real_total);
                })
                ->editColumn('debt_collected_total', function ($row) {
                    return '$' . chileanPeso($row->debt_collected_total);
                })
                ->editColumn('debt_real_total', function ($row) {
                    return '$' . chileanPeso($row->debt_real_total);
                })
                ->editColumn('credit_collected_total', function ($row) {
                    return '$' . chileanPeso($row->credit_collected_total);
                })
                ->editColumn('credit_real_total', function ($row) {
                    return '$' . chileanPeso($row->credit_real_total);
                })
                ->addColumn('action', function ($row) {
                    $buttons = "<button class='btn btn-sm btn-info btn-detail' data-id='{$row->id}' title='Detalle'><i class='fas fa-eye'></i></button> ";
                    $buttons .= "<a class='btn btn-sm btn-primary' href='" . route('money_closures.edit', $row->id) . "' title='Editar'><i class='fas fa-pencil'></i></a> ";
                    $buttons .= "<button class='btn btn-sm btn-danger btn-delete' data-id='{$row->id}' title='Eliminar'><i class='fas fa-trash'></i></button>";

                    return $buttons;
                })
                ->rawColumns([
                    'action'
                ])
                ->addIndexColumn()
                ->toJson();
        }

        return view('backend.sections.money-closures.index');
    }

    public function create()
    {
        $stadiums = Stadium::select('id', 'name')->get();

        return view('backend.sections.money-closures.create', compact('stadiums'));
    }

    public function store(StoreRequest $request)
    {
        MoneyClosure::create([
            'date' => $request->get('date'),
            'stadium_id' => $request->get('stadium_id'),
            'cash_collected_total' => str_replace('.', '', $request->get('cash_collected_total')),
            'cash_real_total' => str_replace('.', '', $request->get('cash_real_total')),
            'transfer_collected_total' => str_replace('.', '', $request->get('transfer_collected_total')),
            'transfer_real_total' => str_replace('.', '', $request->get('transfer_real_total')),
            'debt_collected_total' => str_replace('.', '', $request->get('debt_collected_total')),
            'debt_real_total' => str_replace('.', '', $request->get('debt_real_total')),
            'credit_collected_total' => str_replace('.', '', $request->get('credit_collected_total')),
            'credit_real_total' => str_replace('.', '', $request->get('credit_real_total')),
            'user_id' => request()->user()->id
        ]);

        flasher(Lang::get('messages.crud.created'), 'success');
        return to_route('money_closures.index');
    }

    public function show($id)
    {
        $queryMoneyClosure = MoneyClosure::with('user', 'stadium')->find($id);

        return [
            'user' => $queryMoneyClosure->user->name,
            'date' => $queryMoneyClosure->date->format('d-m-Y'),
            'stadium' => $queryMoneyClosure->stadium->name,
            'cash_collected_total' => '$' . chileanPeso($queryMoneyClosure->cash_collected_total),
            'cash_real_total' => '$' . chileanPeso($queryMoneyClosure->cash_real_total),
            'cash_closure' => ($queryMoneyClosure->cash_collected_total == $queryMoneyClosure->cash_real_total ? 'Si' : 'No'),
            'transfer_collected_total' => '$' . chileanPeso($queryMoneyClosure->transfer_collected_total),
            'transfer_real_total' => '$' . chileanPeso($queryMoneyClosure->transfer_real_total),
            'transfer_closure' => ($queryMoneyClosure->transfer_collected_total == $queryMoneyClosure->transfer_real_total ? 'Si' : 'No'),
            'debt_collected_total' => '$' . chileanPeso($queryMoneyClosure->debt_collected_total),
            'debt_real_total' => '$' . chileanPeso($queryMoneyClosure->debt_real_total),
            'debt_closure' => ($queryMoneyClosure->debt_collected_total == $queryMoneyClosure->debt_real_total ? 'Si' : 'No'),
            'credit_collected_total' => '$' . chileanPeso($queryMoneyClosure->credit_collected_total),
            'credit_real_total' => '$' . chileanPeso($queryMoneyClosure->credit_real_total),
            'credit_closure' => ($queryMoneyClosure->credit_collected_total == $queryMoneyClosure->credit_real_total ? 'Si' : 'No')
        ];
    }

    public function edit($id)
    {
        $moneyClosure = MoneyClosure::with('user')->find($id);
        $realTotal = $this->getRealTotal(
            $moneyClosure->date->format('d-m-Y'),
            $moneyClosure->stadium_id
        );

        return view('backend.sections.money-closures.edit', compact('moneyClosure', 'realTotal'));
    }

    public function update(UpdateRequest $request, $id)
    {
        $moneyClosure = MoneyClosure::find($id);
        $moneyClosure->update([
            'cash_collected_total' => str_replace('.', '', $request->get('cash_collected_total')),
            'transfer_collected_total' => str_replace('.', '', $request->get('transfer_collected_total')),
            'debt_collected_total' => str_replace('.', '', $request->get('debt_collected_total')),
            'credit_collected_total' => str_replace('.', '', $request->get('credit_collected_total'))
        ]);

        flasher(Lang::get('messages.crud.updated'), 'success');
        return to_route('money_closures.index');
    }

    public function destroy($id)
    {
        $moneyClosure = MoneyClosure::find($id);
        $moneyClosure->delete();

        flasher(Lang::get('messages.crud.deleted'), 'success');
        return to_route('money_closures.index');
    }

    public function getRealTotal($date, $stadiumId)
    {
        $formattedDate = Carbon::createFromFormat('d-m-Y', $date)->format('Y-m-d');

        // get total cash of given date for reservations
        $totalCashReal = 0;
        $cashReservationItems = ReservationItem::where('reservation_items.date', $formattedDate)
            ->whereHas('reservation', function ($query) use ($stadiumId) {
                return $query->where('payment_media', 'Efectivo')->where('state', 'Pagada')->where('stadium_id', $stadiumId);
            })
            ->get();

        foreach ($cashReservationItems as $item) {
            $totalCashReal += $item->reservation->total;
        }

        // get total transfer of given date for reservations
        $totalTransferReal = 0;
        $transferReservationItems = ReservationItem::where('reservation_items.date', $formattedDate)
            ->whereHas('reservation', function ($query) use ($stadiumId) {
                return $query->where('payment_media', 'Transferencia')->where('state', 'Pagada')->where('stadium_id', $stadiumId);
            })
            ->get();

        foreach ($transferReservationItems as $item) {
            $totalTransferReal += $item->reservation->total;
        }

        // get total debt of given date for reservations
        $totalDebtReal = 0;
        $debtReservationItems = ReservationItem::where('reservation_items.date', $formattedDate)
            ->whereHas('reservation', function ($query) use ($stadiumId) {
                return $query->where('payment_media', 'Débito')->where('state', 'Pagada')->where('stadium_id', $stadiumId);
            })
            ->get();

        foreach ($debtReservationItems as $item) {
            $totalDebtReal += $item->reservation->total;
        }

        // get total credit of given date for reservations
        $totalCreditReal = 0;
        $creditReservationItems = ReservationItem::where('reservation_items.date', $formattedDate)
            ->whereHas('reservation', function ($query) use ($stadiumId) {
                return $query->where('payment_media', 'Crédito')->where('state', 'Pagada')->where('stadium_id', $stadiumId);
            })
            ->get();

        foreach ($creditReservationItems as $item) {
            $totalCreditReal += $item->reservation->total;
        }

        return [
            'total_cash_real' => $totalCashReal,
            'total_transfer_real' => $totalTransferReal,
            'total_debt_real' => $totalDebtReal,
            'total_credit_real' => $totalCreditReal
        ];
    }
}
