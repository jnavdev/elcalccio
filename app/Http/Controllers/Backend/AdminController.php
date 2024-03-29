<?php

namespace App\Http\Controllers\Backend;

use App\Models\User;
use Carbon\Carbon;
use App\Models\ReservationItem;
use App\Models\Student;
use Illuminate\Support\Facades\Lang;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Http\Requests\Backend\Admin\ChangePasswordRequest;
use Illuminate\Support\Facades\Crypt;
use App\Models\Commune;
use Illuminate\Validation\Rule;

class AdminController extends Controller
{
    public function index()
    {
        $totalCustomers = User::where('role_id', 2)->count();
        $totalReservationHoursToday = ReservationItem::where('date', Carbon::now()->format('Y-m-d'))->count();
        $totalYoungStudents = Student::where('class', 'Menor Edad')->where('is_active', true)->count();
        $totalAdultStudents = Student::where('class', 'Mayor Edad')->where('is_active', true)->count();
        $birthdayStudentsToday = Student::query()
            ->birthDayBetween(now(), now()->addDays(7))
            ->orderByRaw("DATE_FORMAT(birth_date,'%m%d')")
            ->orderByRaw("DATE_FORMAT(birth_date,'%y') desc")
            ->where('is_active', true)
            ->get();

        return view(
            'backend.home',
            compact(
                'totalCustomers',
                'totalReservationHoursToday',
                'totalYoungStudents',
                'totalAdultStudents',
                'birthdayStudentsToday'
            )
        );
    }

    public function generateBirthdatePdf(Request $request)
    {
        $students = Student::whereMonth('birth_date', $request->get('birthdate_month'))
            ->where('is_active', true)
            ->get();

        $pdf = PDF::loadView('backend.sections.young-students.dashboard-birthdate-pdf', [
            'students' => $students
        ]);

        return $pdf->download("ESTUDIANTES-MES-{$request->get('birthdate_month')}.pdf");
    }

    public function changePasswordView()
    {
        return view('backend.change-password');
    }

    public function changePasswordDb(ChangePasswordRequest $request)
    {
        $user = $request->user();
        $user->update([
            'password' => bcrypt($request->get('password'))
        ]);

        flasher(Lang::get('messages.crud.updated'), 'success');
        return to_route('admin.home');
    }

    public function loginView()
    {
        return view('backend.auth.login');
    }

    public function parentStudentForm($encryptedId)
    {
        $id = Crypt::decryptString($encryptedId);
        $student = Student::find($id);
        $communes = Commune::select('name', 'id')->orderBy('name', 'ASC')->get();

        return view('backend.parent-update-student', compact('student', 'communes', 'encryptedId'));
    }

    public function parentStudentUpdate(Request $request, $encryptedId)
    {
        $id = Crypt::decryptString($encryptedId);

        $request->validate([
            'full_name' => ['required', 'max:255'],
            'rut' => ['required', 'cl_rut', Rule::unique('students', 'rut')->ignore($id)],
            'birth_date' => ['required'],
            'commune_id' => ['required'],
            'address' => ['required', 'max:255'],
            'shirt_size' => ['required'],
            'pants_size' => ['required'],
            'shirt_number' => ['required'],
        ]);

        $student = Student::find($id);
        $student->update([
            'full_name' => $request->input('full_name'),
            'rut' => $request->input('rut'),
            'birth_date' => $request->input('birth_date'),
            'commune_id' => $request->input('commune_id'),
            'address' => $request->input('address'),
            'shirt_size' => $request->input('shirt_size'),
            'pants_size' => $request->input('pants_size'),
            'shirt_number' => $request->input('shirt_number'),
            'disability' => $request->input('disability'),
            'diseases' => $request->input('diseases'),
            'medicines' => $request->input('medicines'),
            'allergies' => $request->input('allergies'),
            'blood_type' => $request->input('blood_type'),
        ]);

        flasher(Lang::get('messages.crud.updated'), 'success');
        return to_route('frontend.home');
    }
}
