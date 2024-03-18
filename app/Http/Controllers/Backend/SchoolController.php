<?php

namespace App\Http\Controllers\Backend;

use App\Models\School;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\School\StoreRequest;
use App\Http\Requests\Backend\School\UpdateRequest;
use Illuminate\Support\Facades\Lang;

class SchoolController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = School::select('id', 'name');

            return datatables()->of($data)
                ->filter(function ($query) use ($request) {
                    if ($request->get('search')['value']) {
                        // global search
                        $query->where('name', 'like', "%" . $request->get('search')['value'] . "%");
                    }
                })
                ->addColumn('action', function ($row) {
                    $buttons = "<a class='btn btn-sm btn-primary' title='Editar' href='" . route('schools.edit', $row->id) . "'><i class='fas fa-pencil'></i></a> ";
                    $buttons .= "<button class='btn btn-sm btn-danger btn-delete' data-id='{$row->id}' title='Eliminar'><i class='fas fa-trash'></i></button>";

                    return $buttons;
                })
                ->rawColumns(['action'])
                ->addIndexColumn()
                ->toJson();
        }

        return view('backend.sections.schools.index');
    }

    public function create()
    {
        return view('backend.sections.schools.create');
    }

    public function store(StoreRequest $request)
    {
        School::create([
            'name' => $request->get('name')
        ]);

        flasher(Lang::get('messages.crud.created'), 'success');
        return to_route('schools.index');
    }

    public function edit($id)
    {
        $school = School::find($id);

        return view('backend.sections.schools.edit', compact('school'));
    }

    public function update(UpdateRequest $request, $id)
    {
        $school = School::find($id);

        $school->update([
            'name' => $request->get('name')
        ]);

        flasher(Lang::get('messages.crud.updated'), 'success');
        return to_route('schools.index');
    }

    public function destroy($id)
    {
        $school = School::find($id);
        $school->delete();

        flasher(Lang::get('messages.crud.deleted'), 'success');
        return to_route('schools.index');
    }
}
