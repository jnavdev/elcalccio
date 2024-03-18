<?php

namespace App\Http\Controllers\Backend;

use App\Models\Stadium;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Lang;
use App\Http\Requests\Backend\Stadium\StoreRequest;
use App\Http\Requests\Backend\Stadium\UpdateRequest;

class StadiumController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Stadium::select('id', 'name');

            return datatables()->of($data)
                ->filter(function ($query) use ($request) {
                    if ($request->get('search')['value']) {
                        // global search
                        $query->where('name', 'like', "%" . $request->get('search')['value'] . "%");
                    }
                })
                ->addColumn('prices', function ($row) {
                    return "<a class='btn btn-sm btn-warning' href='" . route('stadium_prices.create', $row->id) . "' title='Editar precios'><i class='fas fa-dollar'></i></a> ";
                })
                ->addColumn('action', function ($row) {
                    $buttons = "<button class='btn btn-sm btn-info btn-detail' data-id='{$row->id}' title='Detalle'><i class='fas fa-eye'></i></button> ";
                    $buttons .= "<a class='btn btn-sm btn-primary' href='" . route('stadiums.edit', $row->id) . "' title='Editar'><i class='fas fa-pencil'></i></a> ";

                    return $buttons;
                })
                ->addIndexColumn()
                ->rawColumns(['prices', 'action'])
                ->toJson();
        }

        return view('backend.sections.stadiums.index');
    }

    public function create()
    {
        return view('backend.sections.stadiums.create');
    }

    public function store(StoreRequest $request)
    {
        Stadium::create([
            'name' => $request->get('name')
        ]);

        flasher(Lang::get('messages.crud.created'), 'success');
        return to_route('stadiums.index');
    }

    public function edit($id)
    {
        $stadium = Stadium::find($id);

        return view('backend.sections.stadiums.edit', compact('stadium'));
    }

    public function update(UpdateRequest $request, $id)
    {
        $stadium = Stadium::find($id);
        $stadium->update([
            'name' => $request->get('name')
        ]);

        flasher(Lang::get('messages.crud.updated'), 'success');
        return to_route('stadiums.index');
    }

    public function show($id)
    {
        $stadium = Stadium::find($id);

        return [
            'name' => $stadium->name
        ];
    }

    public function destroy($id)
    {
        $stadium = Stadium::find($id);
        $stadium->delete();

        flasher(Lang::get('messages.crud.deleted'), 'success');
        return to_route('stadiums.index');
    }
}
