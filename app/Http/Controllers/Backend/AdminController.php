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
}
