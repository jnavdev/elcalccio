<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\Role\UpdateRequest;
use Illuminate\Support\Facades\Lang;
use Illuminate\Http\Request;
use App\Models\Permission;
use App\Models\Role;

class RoleController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Role::select('id', 'name');

            return datatables()->of($data)
                ->filter(function ($query) use ($request) {
                    if ($request->get('search')['value']) {
                        // global search
                        $query->where('name', 'like', "%" . $request->get('search')['value'] . "%");
                    }
                })
                ->addColumn('action', function ($row) {
                    return "<a class='btn btn-sm btn-primary' href='" . route('roles.edit', $row->id) . "' title='Editar'><i class='fas fa-pencil'></i></a> ";
                })
                ->rawColumns(['action'])
                ->addIndexColumn()
                ->toJson();
        }

        return view('backend.sections.roles.index');
    }

    public function edit($id)
    {
        $role = Role::with('permissions')->find($id);
        $permissions = Permission::all();

        return view('backend.sections.roles.edit', compact('role', 'permissions'));
    }

    public function update(UpdateRequest $request, $id)
    {
        $role = Role::find($id);

        $role->update([
            'name' => $request->get('name')
        ]);

        $role->permissions()->sync($request->get('permissions'));

        flasher(Lang::get('messages.crud.updated'), 'success');
        return to_route('roles.index');
    }
}
