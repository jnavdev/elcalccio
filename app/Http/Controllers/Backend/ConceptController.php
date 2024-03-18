<?php

namespace App\Http\Controllers\Backend;

use App\Http\Requests\Backend\Concept\UpdateRequest;
use App\Http\Requests\Backend\Concept\StoreRequest;
use Illuminate\Support\Facades\Lang;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Concept;

class ConceptController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Concept::select('id', 'name', 'type');

            return datatables()->of($data)
                ->filter(function ($query) use ($request) {
                    if ($request->get('search')['value']) {
                        // global search
                        $query->where('name', 'like', "%" . $request->get('search')['value'] . "%");
                    }

                    if ($request->get('filter_type')) {
                        $query->where('type', $request->get('filter_type'));
                    }
                })
                ->addColumn('action', function ($row) {
                    $buttons = "<a class='btn btn-sm btn-primary' title='Editar' href='" . route('concepts.edit', $row->id) . "'><i class='fas fa-pencil'></i></a> ";
                    $buttons .= "<button class='btn btn-sm btn-danger btn-delete' data-id='{$row->id}' title='Eliminar'><i class='fas fa-trash'></i></button>";

                    return $buttons;
                })
                ->rawColumns(['action'])
                ->addIndexColumn()
                ->toJson();
        }

        return view('backend.sections.concepts.index');
    }

    public function create()
    {
        return view('backend.sections.concepts.create');
    }

    public function store(StoreRequest $request)
    {
        Concept::create([
            'name' => $request->get('name'),
            'type' => $request->get('type')
        ]);

        flasher(Lang::get('messages.crud.created'), 'success');
        return to_route('concepts.index');
    }

    public function edit($id)
    {
        $concept = Concept::find($id);

        return view('backend.sections.concepts.edit', compact('concept'));
    }

    public function update(UpdateRequest $request, $id)
    {
        $concept = Concept::find($id);
        $concept->update([
            'name' => $request->get('name'),
            'type' => $request->get('type')
        ]);

        flasher(Lang::get('messages.crud.updated'), 'success');
        return to_route('concepts.index');
    }

    public function destroy($id)
    {
        $concept = Concept::find($id);
        $concept->delete();

        flasher(Lang::get('messages.crud.deleted'), 'success');
        return to_route('concepts.index');
    }
}
