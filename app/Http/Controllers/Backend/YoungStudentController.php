<?php

namespace App\Http\Controllers\Backend;

use Carbon\Carbon;
use App\Models\Commune;
use App\Models\Student;
use App\Models\Proxy;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\Student\Young\StoreRequest;
use App\Http\Requests\Backend\Student\Young\UpdateRequest;
use App\Http\Requests\Backend\Student\Young\UpdateProxyRequest;
use App\Models\Course;
use Illuminate\Support\Facades\Crypt;
use Intervention\Image\Facades\Image as ImageIntervention;
use Illuminate\Support\Facades\Lang;

class YoungStudentController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Student::with('commune')->where('class', 'Menor Edad');

            return datatables()->of($data)
                ->filter(function ($query) use ($request) {
                    if ($request->get('search')['value']) {
                        // global search
                        $query->where('students.full_name', 'like', "%" . $request->get('search')['value'] . "%")
                            ->orWhere('students.rut', 'like', "%" . $request->get('search')['value'] . "%");
                    }

                    if ($request->get('filter_subscription')) {
                        if ($request->get('filter_subscription') == 'none') {
                            $query->where('students.is_active', 1)->doesntHave('subscriptions');
                        }
                    }

                    if ($request->get('filter_course_id')) {
                        $query->whereHas('subscriptions', function ($q) use ($request) {
                            $q->where('subscriptions.course_id', $request->get('filter_course_id'));
                        });
                    }

                    if ($request->get('filter_start_year') && $request->get('filter_end_year')) {
                        $query->whereBetween('birth_date', [request('filter_start_year') . '-01-01', request('filter_end_year') . '-12-31']);
                    }
                })
                ->editColumn('profile_picture', function ($row) {
                    return '<img src="' . asset($row->profile_picture) . '" width="70" height="90">';
                })
                ->editColumn('sex', function ($row) {
                    return ($row->sex == 'M') ? 'Masculino' : 'Femenino';
                })
                ->addColumn('proxyButton', function ($row) {
                    return "<button class='btn btn-sm btn-info btn-proxy' data-id='{$row->id}' title='Apoderado'><i class='fa fa-user'></i></button>";
                })
                ->addColumn('subscriptionButton', function ($row) {
                    return "<a " . (!$row->is_active ? "disabled" : "") . " class='btn btn-sm btn-success' title='Crear suscripcion' href='" . route('subscriptions.create', $row->id) . "'><i class='fa fa-plus'><i></a>";
                })
                ->addColumn('action', function ($row) {
                    $buttons = "<button class='btn btn-sm btn-info btn-detail' data-id='{$row->id}' title='Detalle'><i class='fas fa-eye'></i></button> ";
                    $buttons .= "<a class='btn btn-sm btn-primary' href='" . route('young_students.edit', $row->id) . "' title='Editar'><i class='fas fa-pencil'></i></a> ";
                    $buttons .= "<button class='btn btn-sm btn-danger delete-student' data-id='{$row->id}' title='Eliminar'><i class='fas fa-trash'></i></button> ";

                    $deleteButton = "<button class='btn btn-sm btn-warning btn-delete' data-id='{$row->id}' title='Desactivar'><i class='fas fa-close'></i> Desactivar</button>";

                    if (!$row->is_active) {
                        $deleteButton = "<button class='btn btn-sm btn-success btn-delete' data-id='{$row->id}' title='Activar'><i class='fas fa-check'></i> Activar</button>";
                    }

                    $buttons .= $deleteButton;

                    return $buttons;
                })
                ->rawColumns(['profile_picture', 'proxyButton', 'subscriptionButton', 'action'])
                ->addIndexColumn()
                ->toJson();
        }

        $communes = Commune::select('name', 'id')->orderBy('name', 'ASC')->get();

        $olderStudent = Student::select('birth_date')
            ->where('class', 'Menor Edad')
            ->where('is_active', true)
            ->whereNotNull('birth_date')
            ->orderBy('birth_date', 'ASC')
            ->first();

        $youngerStudent = Student::select('birth_date')
            ->where('class', 'Menor Edad')
            ->where('is_active', true)
            ->whereNotNull('birth_date')
            ->orderBy('birth_date', 'DESC')
            ->first();

        $years = ($olderStudent && $youngerStudent) ? range($olderStudent->birth_date->year, $youngerStudent->birth_date->year) : range(now()->year, now()->year);

        $courses = Course::select('id', 'name')->get();

        return view('backend.sections.young-students.index', compact('communes', 'years', 'courses'));
    }

    public function create()
    {
        $communes = Commune::select('name', 'id')->orderBy('name', 'ASC')->get();

        return view('backend.sections.young-students.create', compact('communes'));
    }

    public function store(StoreRequest $request)
    {
        $birthDate = null;
        if ($request->get('birth_date')) {
            $birthDate = Carbon::createFromFormat('d-m-Y', $request->get('birth_date'))->format('Y-m-d');
        }

        $student = Student::create([
            'class' => 'Menor Edad',
            'full_name' => $request->get('full_name'),
            'rut' => $request->get('rut'),
            'birth_date' => $birthDate,
            'nationality' => $request->get('nationality'),
            'address' => $request->get('address'),
            'sex' => $request->get('sex'),
            'phone' => $request->get('phone'),
            'email' => $request->get('email'),
            'disability' => $request->get('disability'),
            'conadis' => $request->get('conadis'),
            'diseases' => $request->get('diseases'),
            'medicines' => $request->get('medicines'),
            'allergies' => $request->get('allergies'),
            'blood_type' => $request->get('blood_type'),
            'shoe_number' => $request->get('shoe_number'),
            'shirt_size' => $request->get('shirt_size'),
            'shirt_number' => $request->get('shirt_number'),
            'pants_size' => $request->get('pants_size'),
            'height' => $request->get('height'),
            'weight' => $request->get('weight'),
            'commune_id' => $request->get('commune_id')
        ]);

        if ($request->hasFile('profile_picture')) {
            // save profile picture
            $image = $request->file('profile_picture');
            $thumbnailImage = ImageIntervention::make($image)->orientate();
            $thumbnailPath = public_path() . '/uploads/students/profile_pictures/';
            $imageName = time() . $image->getClientOriginalName();
            $thumbnailImage->save($thumbnailPath . $imageName, 60);

            $student->profile_picture = "uploads/students/profile_pictures/{$imageName}";
            $student->save();
        }

        if ($request->hasFile('authorization_file')) {
            // save authorization_file
            $authorizationFile = $request->file('authorization_file');
            $destinationPath = public_path() . '/uploads/students/authorization_files/';
            $filename = time() . $authorizationFile->getClientOriginalName();
            $authorizationFile->move($destinationPath, $filename);

            $student->profile_picture = "uploads/students/authorization_files/{$filename}";
            $student->save();
        }

        Proxy::create([
            'full_name' => $request->get('proxy_full_name'),
            'rut' => $request->get('proxy_rut'),
            'email' => $request->get('proxy_email'),
            'relationship' => $request->get('proxy_relationship'),
            'address' => $request->get('proxy_address'),
            'phone' => $request->get('proxy_phone'),
            'commune_id' => $request->get('proxy_commune_id'),
            'student_id' => $student->id
        ]);

        flasher(Lang::get('messages.crud.created'), 'success');
        return to_route('young_students.index');
    }

    public function show($id)
    {
        $queryStudent = Student::with('commune')->find($id);
        $queryProxy = Proxy::with('commune')->where('student_id', $queryStudent->id)->first();

        $student = [
            'profile_picture' => asset($queryStudent->profile_picture),
            'full_name' => $queryStudent->full_name,
            'rut' => $queryStudent->rut,
            'birth_date' => ($queryStudent->birth_date) ? $queryStudent->birth_date->format('d-m-Y') : '-',
            'nationality' => ($queryStudent->nationality) ? $queryStudent->nationality : '-',
            'sex' => ($queryStudent->sex == 'M') ? 'Masculino' : 'Femenino',
            'commune' => $queryStudent->commune->name,
            'address' => $queryStudent->address,
            'email' => ($queryStudent->email) ? $queryStudent->email : '-',
            'phone' => ($queryStudent->phone) ? $queryStudent->phone : '-',
            'disability' => ($queryStudent->disability) ? $queryStudent->disability : '-',
            'conadis' => ($queryStudent->conadis) ? $queryStudent->conadis : '-',
            'diseases' => ($queryStudent->diseases) ? $queryStudent->diseases : '-',
            'medicines' => ($queryStudent->medicines) ? $queryStudent->medicines : '-',
            'allergies' => ($queryStudent->allergies) ? $queryStudent->allergies : '-',
            'blood_type' => ($queryStudent->blood_type) ? $queryStudent->blood_type : '-',
            'shoe_number' => ($queryStudent->shoe_number) ? $queryStudent->shoe_number : '-',
            'shirt_size' => ($queryStudent->shirt_size) ? $queryStudent->shirt_size : '-',
            'pants_size' => ($queryStudent->pants_size) ? $queryStudent->pants_size : '-',
            'height' => ($queryStudent->height) ? $queryStudent->height . ' cm' : '-',
            'weight' => ($queryStudent->weight) ? $queryStudent->weight . ' kg' : '-',
            'created_at' => $queryStudent->created_at->format('d-m-Y')
        ];

        $proxy = [
            'full_name' => $queryProxy->full_name,
            'rut' => $queryProxy->rut,
            'email' => ($queryProxy->email) ? $queryProxy->email : '-',
            'relationship' => $queryProxy->relationship,
            'phone' => $queryProxy->phone,
            'commune' => $queryProxy->commune->name,
            'address' => $queryProxy->address
        ];

        $encryptedId = Crypt::encryptString($id);
        $routeParentStudent = route('parent_update_student_form', $encryptedId);

        return [
            'student' => $student,
            'proxy' => $proxy,
            'routeParentStudent' => $routeParentStudent
        ];
    }

    public function edit($id)
    {
        $student = Student::with('commune')->find($id);
        $proxy = Proxy::where('student_id', $student->id)->first();
        $communes = Commune::select('name', 'id')->orderBy('name', 'ASC')->get();

        return view('backend.sections.young-students.edit', compact('student', 'proxy', 'communes'));
    }

    public function update(UpdateRequest $request, $id)
    {
        $student = Student::find($id);
        $student->update([
            'full_name' => $request->get('full_name'),
            'rut' => $request->get('rut'),
            'birth_date' => Carbon::createFromFormat('d-m-Y', $request->get('birth_date'))->format('Y-m-d'),
            'nationality' => $request->get('nationality'),
            'address' => $request->get('address'),
            'sex' => $request->get('sex'),
            'phone' => $request->get('phone'),
            'email' => $request->get('email'),
            'disability' => $request->get('disability'),
            'conadis' => $request->get('conadis'),
            'diseases' => $request->get('diseases'),
            'medicines' => $request->get('medicines'),
            'allergies' => $request->get('allergies'),
            'blood_type' => $request->get('blood_type'),
            'shoe_number' => $request->get('shoe_number'),
            'shirt_size' => $request->get('shirt_size'),
            'shirt_number' => $request->get('shirt_number'),
            'pants_size' => $request->get('pants_size'),
            'height' => $request->get('height'),
            'weight' => $request->get('weight'),
            'commune_id' => $request->get('commune_id')
        ]);

        if ($request->hasFile('profile_picture')) {
            $image = $request->file('profile_picture');
            $thumbnailImage = ImageIntervention::make($image)->orientate();
            $thumbnailPath = public_path() . '/uploads/students/profile_pictures/';
            $imageName = time() . $image->getClientOriginalName();
            $thumbnailImage->save($thumbnailPath . $imageName, 60);

            $student->update([
                'profile_picture' => "uploads/students/profile_pictures/{$imageName}",
            ]);
        }

        if ($request->hasFile('authorization_file')) {
            $authorizationFile = $request->file('authorization_file');
            $destinationPath = public_path() . '/uploads/students/authorization_files/';
            $filename = time() . $authorizationFile->getClientOriginalName();
            $authorizationFile->move($destinationPath, $filename);

            $student->update([
                'authorization_file' => "uploads/students/authorization_files/{$filename}",
            ]);
        }

        flasher(Lang::get('messages.crud.updated'), 'success');
        return to_route('young_students.index');
    }

    public function destroy($id)
    {
        $student = Student::find($id);

        if ($student->is_active) {
            $student->update([
                'is_active' => false
            ]);
        } else {
            $student->update([
                'is_active' => true
            ]);
        }

        flasher(Lang::get('messages.crud.updated'), 'success');
        return to_route('young_students.index');
    }

    public function editProxy($id)
    {
        return Proxy::where('student_id', $id)->first();
    }

    public function updateProxy(UpdateProxyRequest $request)
    {
        $proxy = Proxy::find($request->get('proxy_id'));
        $proxy->update([
            'full_name' => $request->get('full_name'),
            'rut' => $request->get('rut'),
            'email' => $request->get('email'),
            'relationship' => $request->get('relationship'),
            'address' => $request->get('address'),
            'phone' => $request->get('phone'),
            'commune_id' => $request->get('commune_id'),
        ]);

        return response()->json([
            'success' => true,
            'message' => Lang::get('messages.crud.updated'),
        ], 200);
    }

    public function dateOfBirthPdf(Request $request)
    {
        $from = $request->get('filter_start_year');
        $to = $request->get('filter_end_year');
        $course = ($request->get('filter_course_id')) ? Course::find($request->get('filter_course_id'))->name : 'Todos';

        $students = Student::with('commune')
            ->where('students.class', '=', 'Menor Edad')
            ->where('students.is_active', 1)
            ->whereBetween('students.birth_date', [$from . '-01-01', $to . '-12-31'])
            ->orderBy('students.id', 'DESC');

        if ($request->get('filter_subscription')) {
            if ($request->get('filter_subscription') == 'none') {
                $students->where('students.is_active', 1)->doesntHave('subscriptions');
            }
        }

        if ($request->get('filter_course_id')) {
            $students->whereHas('subscriptions', function ($q) use ($request) {
                $q->where('subscriptions.course_id', $request->get('filter_course_id'));
            });
        }

        $students = $students->get();

        $pdf = PDF::loadView('backend.sections.young-students.date-of-birth-pdf', [
            'students' => $students,
            'from' => $from,
            'to' => $to,
            'course' => $course
        ]);

        return $pdf->download("LISTADO-ESTUDIANTES.pdf");
    }

    public function delete($id)
    {
        $student = Student::with('proxies', 'subscriptions')->find($id);

        if ($student->proxies->count()) {
            $student->proxies()->delete();
        }

        if ($student->subscriptions->count()) {
            $student->subscriptions()->delete();
        }

        $student->delete();

        flasher(Lang::get('messages.crud.deleted'), 'success');
        return to_route('young_students.index');
    }
}
