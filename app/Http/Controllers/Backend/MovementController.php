<?php

namespace App\Http\Controllers\Backend;

use App\Http\Requests\Backend\Movement\UpdateRequest;
use App\Http\Requests\Backend\Movement\StoreRequest;
use Illuminate\Support\Facades\Lang;
use App\Http\Controllers\Controller;
use App\Models\PaymentMethod;
use Illuminate\Http\Request;
use App\Models\Movement;
use App\Models\Concept;
use Carbon\Carbon;

class MovementController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Movement::with('concept');

            return datatables()->of($data)
                ->filter(function ($query) use ($request) {
                    if ($request->get('search')['value']) {
                        // global search
                        $query->where('movements.description', 'like', "%" . $request->get('search')['value'] . "%")
                            ->orWhereHas('concept', function ($query) use ($request) {
                                $query->where('name', 'like', "%" . $request->get('search')['value'] . "%");
                            });
                    }

                    if ($request->get('filter_month')) {
                        $query->whereMonth('date', $request->get('filter_month'));
                    }

                    if ($request->get('filter_year')) {
                        $query->whereYear('date', $request->get('filter_year'));
                    }
                })
                ->editColumn('amount', function ($row) {
                    $spanClass = ($row->concept->type == 'Ingreso') ? 'success' : 'danger';

                    return '<span class="badge badge-pill badge-' . $spanClass . '">$' . chileanPeso($row->amount) . '</span>';
                })
                ->addColumn('action', function ($row) {
                    $buttons = "<button class='btn btn-sm btn-info btn-detail' data-id='{$row->id}' title='Detalle'><i class='fas fa-eye'></i></button> ";
                    $buttons .= "<a class='btn btn-sm btn-primary' title='Editar' href='" . route('movements.edit', $row->id) . "'><i class='fas fa-pencil'></i></a> ";
                    $buttons .= "<button class='btn btn-sm btn-danger btn-delete' data-id='{$row->id}' title='Eliminar'><i class='fas fa-trash'></i></button>";

                    return $buttons;
                })
                ->rawColumns(['amount', 'action'])
                ->addIndexColumn()
                ->toJson();
        }

        $firstMovement = Movement::select('date')
            ->orderBy('date', 'ASC')
            ->first();

        $lastMovement = Movement::select('date')
            ->orderBy('date', 'DESC')
            ->first();

        $years = ($firstMovement && $lastMovement) ? range($firstMovement->date->year, $lastMovement->date->year) : range(now()->year, now()->year);

        return view('backend.sections.movements.index', compact('years'));
    }

    public function create()
    {
        $incomes = Concept::select('id', 'name')->where('type', 'Ingreso')->get();
        $expenses = Concept::select('id', 'name')->where('type', 'Gasto')->get();
        $paymentMethods = PaymentMethod::select('id', 'bank', 'account_number')->where('id', '!=', 1)->get();

        return view('backend.sections.movements.create', compact('incomes', 'expenses', 'paymentMethods'));
    }

    public function store(StoreRequest $request)
    {
        Movement::create([
            'date' => Carbon::createFromFormat('d-m-Y', $request->get('date'))->format('Y-m-d'),
            'amount' => str_replace('.', '', $request->get('amount')),
            'description' => $request->get('description'),
            'concept_id' => ($request->get('concept_type') == 'Ingreso') ? $request->get('concept_id_income') : $request->get('concept_id_expense'),
            'payment_method_id' => ($request->get('payment_type') == 'bank') ? $request->get('payment_method_id') : 1
        ]);

        flasher(Lang::get('messages.crud.created'), 'success');
        return to_route('movements.index');
    }

    public function edit($id)
    {
        $movement = Movement::with('concept', 'paymentMethod')->find($id);
        $incomes = Concept::select('id', 'name')->where('type', 'Ingreso')->get();
        $expenses = Concept::select('id', 'name')->where('type', 'Gasto')->get();
        $paymentMethods = PaymentMethod::select('id', 'bank', 'account_number')->where('id', '!=', 1)->get();

        return view('backend.sections.movements.edit', compact('movement', 'incomes', 'expenses', 'paymentMethods'));
    }

    public function update(UpdateRequest $request, $id)
    {
        $movement = Movement::find($id);
        $movement->update([
            'date' => Carbon::createFromFormat('d-m-Y', $request->get('date'))->format('Y-m-d'),
            'amount' => str_replace('.', '', $request->get('amount')),
            'description' => $request->get('description'),
            'concept_id' => ($request->get('concept_type') == 'Ingreso') ? $request->get('concept_id_income') : $request->get('concept_id_expense'),
            'payment_method_id' => ($request->get('payment_type') == 'bank') ? $request->get('payment_method_id') : 1
        ]);

        flasher(Lang::get('messages.crud.updated'), 'success');
        return to_route('movements.index');
    }

    public function show($id)
    {
        $movement = Movement::with('concept', 'paymentMethod')->find($id);

        return [
            'date' => $movement->date->format('d-m-Y'),
            'amount' => '$' . chileanPeso($movement->amount),
            'description' => ($movement->description) ? $movement->description : '-',
            'concept_type' => $movement->concept->type,
            'concept_name' => $movement->concept->name,
            'payment_method' => ($movement->paymentMethod->id == 1) ? 'Efectivo' : 'Cuenta Bancaria: ' . $movement->paymentMethod->bank . ' - ' . $movement->paymentMethod->account_number
        ];
    }

    public function destroy($id)
    {
        $movement = Movement::find($id);
        $movement->delete();

        flasher(Lang::get('messages.crud.deleted'), 'success');
        return to_route('movements.index');
    }
}
