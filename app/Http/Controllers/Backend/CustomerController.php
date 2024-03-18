<?php

namespace App\Http\Controllers\Backend;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\Customer\StoreRequest;
use App\Http\Requests\Backend\Customer\UpdateRequest;
use Illuminate\Support\Facades\Lang;

class CustomerController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = User::where('role_id', 2) // customer
                ->select(
                    'id',
                    'name',
                    'email',
                    'rut',
                    'phone',
                    'partner'
                );

            return datatables()->of($data)
                ->editColumn('partner', function ($row) {
                    return ($row->partner) ? 'Si' : 'No';
                })
                ->addColumn('action', function ($row) {
                    $buttons = "<a class='btn btn-sm btn-primary' title='Editar' href='" . route('customers.edit', $row->id) . "'><i class='fas fa-pencil'></i></a> ";
                    $buttons .= "<button class='btn btn-sm btn-danger btn-delete' data-id='{$row->id}' title='Eliminar'><i class='fas fa-trash'></i></button>";

                    return $buttons;
                })
                ->rawColumns(['action'])
                ->addIndexColumn()
                ->toJson();
        }

        return view('backend.sections.customers.index');
    }

    public function create()
    {
        return view('backend.sections.customers.create');
    }

    public function store(StoreRequest $request)
    {
        User::create([
            'name' => $request->get('name'),
            'email' => $request->get('email'),
            'rut' => $request->get('rut'),
            'phone' => $request->get('phone'),
            'role_id' => 2, // customer
            'partner' => $request->get('partner'),
            'password' => bcrypt($request->get('password'))
        ]);

        flasher(Lang::get('messages.crud.created'), 'success');
        return to_route('customers.index');
    }

    public function edit($id)
    {
        $user = User::find($id);

        return view('backend.sections.customers.edit', compact('user'));
    }

    public function update(UpdateRequest $request, $id)
    {
        $user = User::find($id);

        $user->update([
            'name' => $request->get('name'),
            'email' => $request->get('email'),
            'rut' => $request->get('rut'),
            'phone' => $request->get('phone'),
            'partner' => $request->get('partner'),
        ]);

        if ($request->get('password')) {
            $user->update([
                'password' => bcrypt($request->get('password'))
            ]);
        }

        flasher(Lang::get('messages.crud.updated'), 'success');
        return to_route('customers.index');
    }

    public function destroy($id)
    {
        $user = User::find($id);
        $user->delete();

        flasher(Lang::get('messages.crud.deleted'), 'success');
        return to_route('customers.index');
    }
}
