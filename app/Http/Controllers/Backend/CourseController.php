<?php

namespace App\Http\Controllers\Backend;

use App\Models\School;
use App\Models\Course;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\Course\StoreRequest;
use App\Http\Requests\Backend\Course\UpdateRequest;
use Illuminate\Support\Facades\Lang;

class CourseController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Course::with('school');

            return datatables()->of($data)
                ->filter(function ($query) use ($request) {
                    if ($request->get('search')['value']) {
                        // global search
                        $query->where('courses.name', 'like', "%" . $request->get('search')['value'] . "%")
                            ->orWhere('courses.price', 'like', "%" . $request->get('search')['value'] . "%")
                            ->orWhere('courses.period', 'like', "%" . $request->get('search')['value'] . "%")
                            ->orWhereHas('school', function ($query) use ($request) {
                                $query->where('name', 'like', "%" . $request->get('search')['value'] . "%");
                            });
                    }
                })
                ->editColumn('price', function ($row) {
                    return '<span class="badge badge-pill badge-primary">$' . chileanPeso($row->price) . '</span>';
                })
                ->editColumn('is_active', function ($row) {
                    $span = ($row->is_active) ? '<span class="badge badge-pill badge-success">Activo</span>' : '<span class="badge badge-pill badge-danger">Inactivo</span>';

                    return $span;
                })
                ->addColumn('action', function ($row) {
                    $buttons = "<a class='btn btn-sm btn-info' title='Detalle' href='" . route('courses.show', $row->id) . "'><i class='fas fa-eye'></i></a> ";
                    $buttons .= "<a class='btn btn-sm btn-primary' title='Editar' href='" . route('courses.edit', $row->id) . "'><i class='fas fa-pencil'></i></a> ";
                    $buttons .= "<button class='btn btn-sm btn-danger btn-delete' data-id='{$row->id}' title='Eliminar'><i class='fas fa-trash'></i></button>";

                    return $buttons;
                })
                ->rawColumns(['price', 'is_active', 'action'])
                ->addIndexColumn()
                ->toJson();
        }

        return view('backend.sections.courses.index');
    }

    public function create()
    {
        $schools = School::select('name', 'id')->get();

        return view('backend.sections.courses.create', compact('schools'));
    }

    public function store(StoreRequest $request)
    {
        Course::create([
            'school_id' => $request->get('school_id'),
            'name' => $request->get('name'),
            'description' => $request->get('description'),
            'price' => str_replace('.', '', $request->get('price')),
            'period' => $request->get('period')
        ]);

        flasher(Lang::get('messages.crud.created'), 'success');
        return to_route('courses.index');
    }

    public function edit($id)
    {
        $course = Course::find($id);
        $schools = School::select('name', 'id')->get();

        return view('backend.sections.courses.edit', compact('course', 'schools'));
    }

    public function update(UpdateRequest $request, $id)
    {
        $course = Course::find($id);
        $course->update([
            'school_id' => $request->get('school_id'),
            'name' => $request->get('name'),
            'description' => $request->get('description'),
            'price' => str_replace('.', '', $request->get('price')),
            'period' => $request->get('period'),
            'is_active' => $request->get('is_active')
        ]);

        flasher(Lang::get('messages.crud.updated'), 'success');
        return to_route('courses.index');
    }

    public function show($id)
    {
        $course = Course::with('school')->find($id);

        return view('backend.sections.courses.show', compact('course'));
    }

    public function destroy($id)
    {
        $course = Course::find($id);
        $course->delete();

        flasher(Lang::get('messages.crud.deleted'), 'success');
        return to_route('courses.index');
    }
}
