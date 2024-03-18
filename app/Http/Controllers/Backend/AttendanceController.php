<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\Subscription;
use Carbon\Carbon;
use App\Models\Attendance;
use Illuminate\Support\Facades\Lang;

class AttendanceController extends Controller
{
    public function checkView(Request $request)
    {
        $students = collect();
        $courses = Course::with('school')
            ->where('is_active', true)
            ->get();

        if ($request->get('course_id') && $request->get('date')) {
            $subscriptions = Subscription::with('student')->where('course_id', $request->get('course_id'))->get();

            foreach ($subscriptions as $subscription) {
                $subStartDate = $subscription->start_date;
                $subEndDate = $subscription->end_date;
                $selectedDate = Carbon::parse($request->get('date'));

                if ($selectedDate->between($subStartDate, $subEndDate)) {
                    $student = $subscription->student;

                    $attendance = Attendance::where('course_id', $request->get('course_id'))
                        ->where('student_id', $student->id)
                        ->where('date', Carbon::parse($request->get('date'))->format('Y-m-d'))
                        ->first();

                    $student->attendance = $attendance;

                    $students->push($student);
                }
            }
        }

        return view('backend.sections.attendance.check', compact('courses', 'students'));
    }

    public function checkSave(Request $request)
    {
        $attendance = $request->get('attendance');

        if (! $attendance) {
            flasher(Lang::get('messages.attendance.no_students'), 'warning');
            return redirect()->back();
        }

        // clean all attendance
        Attendance::where('date', Carbon::parse($request->get('attendance_date'))->format('Y-m-d'))
            ->where('course_id', $request->get('attendance_course_id'))
            ->delete();

        foreach ($attendance as $studentId => $state) {
            Attendance::create([
                'state' => ($state == 1) ? 'Presente' : 'Ausente',
                'date' => Carbon::parse($request->get('attendance_date'))->format('Y-m-d'),
                'course_id' => $request->get('attendance_course_id'),
                'student_id' => $studentId
            ]);
        }

        flasher(Lang::get('messages.crud.created'), 'success');
        return redirect()->route('attendance.check_view');
    }
}
