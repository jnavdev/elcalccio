<?php

namespace App\Http\Controllers\Backend;

use App\Http\Requests\Backend\PaymentMethod\UpdateRequest;
use App\Http\Requests\Backend\PaymentMethod\StoreRequest;
use Illuminate\Support\Facades\Lang;
use App\Http\Controllers\Controller;
use App\Models\PaymentMethod;
use Illuminate\Http\Request;

class PaymentMethodController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = PaymentMethod::select('id', 'account_number', 'bank')->where('id', '!=', 1);

            return datatables()->of($data)
                ->filter(function ($query) use ($request) {
                    if ($request->get('search')['value']) {
                        // global search
                        $query->where('account_number', 'like', "%" . $request->get('search')['value'] . "%")
                            ->orWhere('bank', 'like', "%" . $request->get('search')['value'] . "%");
                    }
                })
                ->addColumn('action', function ($row) {
                    $buttons = "<button class='btn btn-sm btn-info btn-detail' data-id='{$row->id}' title='Detalle'><i class='fas fa-eye'></i></button> ";
                    $buttons .= "<a class='btn btn-sm btn-primary' title='Editar' href='" . route('payment_methods.edit', $row->id) . "'><i class='fas fa-pencil'></i></a> ";
                    $buttons .= "<button class='btn btn-sm btn-danger btn-delete' data-id='{$row->id}' title='Eliminar'><i class='fas fa-trash'></i></button>";

                    return $buttons;
                })
                ->rawColumns(['action'])
                ->addIndexColumn()
                ->toJson();
        }

        return view('backend.sections.payment-methods.index');
    }

    public function create()
    {
        return view('backend.sections.payment-methods.create');
    }

    public function store(StoreRequest $request)
    {
        PaymentMethod::create([
            'account_number' => $request->get('account_number'),
            'bank' => $request->get('bank'),
            'description' => $request->get('description'),
            'executive_name' => $request->get('executive_name')
        ]);

        flasher(Lang::get('messages.crud.created'), 'success');
        return to_route('payment_methods.index');
    }

    public function edit($id)
    {
        $paymentMethod = PaymentMethod::find($id);

        return view('backend.sections.payment-methods.edit', compact('paymentMethod'));
    }

    public function update(UpdateRequest $request, $id)
    {
        $paymentMethod = PaymentMethod::find($id);
        $paymentMethod->update([
            'account_number' => $request->get('account_number'),
            'bank' => $request->get('bank'),
            'description' => $request->get('description'),
            'executive_name' => $request->get('executive_name')
        ]);

        flasher(Lang::get('messages.crud.updated'), 'success');
        return to_route('payment_methods.index');
    }

    public function show($id)
    {
        $paymentMethod = PaymentMethod::find($id);

        return [
            'account_number' => $paymentMethod->account_number,
            'bank' => $paymentMethod->bank,
            'description' => $paymentMethod->description ? $paymentMethod->description : '-',
            'executive_name' => $paymentMethod->executive_name ? $paymentMethod->executive_name : '-'
        ];
    }

    public function destroy($id)
    {
        $paymentMethod = PaymentMethod::find($id);
        $paymentMethod->delete();

        flasher(Lang::get('messages.crud.deleted'), 'success');
        return to_route('payment_methods.index');
    }
}
