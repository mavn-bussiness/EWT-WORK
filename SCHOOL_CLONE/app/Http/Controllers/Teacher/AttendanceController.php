<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\ClassRegistration;
use App\Models\SchoolClass;
use App\Models\Student;
use App\Models\Term;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AttendanceController extends Controller
{
    public function index()
    {
        $teacher = Auth::user()->teacher;
        $term = Term::where('is_current', true)->first();
        if (!$term) {
            return back()->with('error', 'No active term found.');
        }

        $classes = $teacher->subjects() // Changed from teacherSubjects()
        ->with('class')
            ->where('term_id', $term->id)
            ->get()
            ->pluck('class')
            ->unique('id');

        return view('teacher.attendance.index', compact('classes'));
    }

    public function mark($classId)
    {
        $teacher = Auth::user()->teacher;
        $term = Term::where('is_current', true)->first();
        if (!$term) {
            abort(500, 'No active term found.');
        }

        $teacherClassSubject = $teacher->subjects() // Changed from teacherSubjects()
        ->where('class_id', $classId)
            ->where('term_id', $term->id)
            ->exists();

        if (!$teacherClassSubject) {
            abort(403, 'Unauthorized action.');
        }

        $class = SchoolClass::findOrFail($classId);
        $studentIds = ClassRegistration::where('class_id', $classId)
            ->where('term_id', $term->id)
            ->where('status', 'registered')
            ->pluck('student_id')
            ->toArray();

        $students = Student::whereIn('id', $studentIds)
            ->whereNull('deleted_at')
            ->with(['user', 'attendances' => fn($query) => $query->where('date', now()->format('Y-m-d'))->where('class_id', $classId)])
            ->get();

        return view('teacher.attendance.mark', compact('class', 'students'));
    }

    public function store(Request $request, $classId)
    {
        $teacher = Auth::user()->teacher;
        $term = Term::where('is_current', true)->first();
        if (!$term) {
            return back()->with('error', 'No active term found.');
        }

        $teacherClassSubject = $teacher->subjects() // Changed from teacherSubjects()
        ->where('class_id', $classId)
            ->where('term_id', $term->id)
            ->exists();

        if (!$teacherClassSubject) {
            abort(403, 'Unauthorized action.');
        }

        $statuses = $request->input('statuses', []);
        $remarks = $request->input('remarks', []);

        foreach ($statuses as $studentId => $status) {
            if ($status) {
                Attendance::updateOrCreate(
                    [
                        'student_id' => $studentId,
                        'class_id' => $classId,
                        'date' => now()->format('Y-m-d'),
                    ],
                    [
                        'status' => $status,
                        'remarks' => $remarks[$studentId] ?? null,
                        'marked_by' => Auth::id(),
                    ]
                );
            }
        }

        return redirect()->route('teacher.attendance.index')
            ->with('success', 'Attendance marked successfully!');
    }
}
