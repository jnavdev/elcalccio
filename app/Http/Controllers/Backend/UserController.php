<?php

namespace App\Http\Controllers\Backend;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Lang;
use App\Http\Requests\Backend\User\StoreRequest;
use App\Http\Requests\Backend\User\UpdateRequest;

class UserController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = User::with('role')->where('role_id', '!=', 2);

            return datatables()->of($data)
                ->addColumn('action', function ($row) {
                    $buttons = "<button class='btn btn-sm btn-info btn-detail' data-id='{$row->id}' title='Detalle'><i class='fas fa-eye'></i></button> ";
                    $buttons .= "<a class='btn btn-sm btn-primary' href='" . route('users.edit', $row->id) . "' title='Editar'><i class='fas fa-pencil'></i></a> ";
                    $buttons .= "<button class='btn btn-sm btn-danger btn-delete' data-id='{$row->id}' title='Eliminar'><i class='fas fa-trash'></i></button>";

                    return $buttons;
                })
                ->addIndexColumn()
                ->toJson();
        }

        return view('backend.sections.users.index');
    }

    public function create()
    {
        $roles = Role::where('id', '!=', 2)->select('name', 'id')->get();

        return view('backend.sections.users.create', compact('roles'));
    }

    public function store(StoreRequest $request)
    {
        User::create([
            'name' => $request->get('name'),
            'email' => $request->get('email'),
            'password' => bcrypt($request->get('password')),
            'role_id' => $request->get('role_id')
        ]);

        flasher(Lang::get('messages.crud.created'), 'success');
        return to_route('users.index');
    }

    public function edit($id)
    {
        $user = User::find($id);
        $roles = Role::where('id', '!=', 2)->select('name', 'id')->get();

        return view('backend.sections.users.edit', compact('user', 'roles'));
    }

    public function update(UpdateRequest $request, $id)
    {
        $user = User::find($id);
        $user->update([
            'name' => $request->get('name'),
            'email' => $request->get('email'),
            'role_id' => $request->get('role_id')
        ]);

        if ($request->get('password')) {
            $user->update([
                'password' => bcrypt($request->get('password'))
            ]);
        }

        flasher(Lang::get('messages.crud.updated'), 'success');
        return to_route('users.index');
    }

    public function show($id)
    {
        $user = User::with('role')->find($id);

        return [
            'name' => $user->name,
            'email' => $user->email,
            'role' => $user->role->name
        ];
    }

    public function destroy($id)
    {
        $user = User::find($id);
        $user->delete();

        flasher(Lang::get('messages.crud.deleted'), 'success');
        return to_route('users.index');
    }
}
