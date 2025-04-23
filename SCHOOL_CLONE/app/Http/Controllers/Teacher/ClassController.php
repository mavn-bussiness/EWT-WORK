<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\SchoolClass;
use App\Models\Student;
use Illuminate\Support\Facades\Auth;

class ClassController extends Controller
{
    public function index()
    {
        $teacher = Auth::user()->teacher;
        $classSubjects = $teacher->subjects() // Changed from teacherSubjects()
        ->with(['class', 'subject'])
            ->get()
            ->unique('class_id');

        return view('teacher.classes.index', compact('classSubjects'));
    }

    public function show($classId)
    {
        $teacher = Auth::user()->teacher;

        $teacherClassSubject = $teacher->subjects() // Changed from teacherSubjects()
        ->where('class_id', $classId)
            ->first();

        if (!$teacherClassSubject) {
            abort(403, 'Unauthorized action.');
        }

        $term = \App\Models\Term::where('is_current', true)->first();
        if (!$term) {
            abort(500, 'No active term found.');
        }

        $class = SchoolClass::findOrFail($classId);
        $studentIds = \App\Models\ClassRegistration::where('class_id', $classId)
            ->where('term_id', $term->id)
            ->where('status', 'registered')
            ->pluck('student_id')
            ->toArray();
        $students = Student::whereIn('id', $studentIds)
            ->whereNull('deleted_at')
            ->with('user')
            ->get();
        $subjects = $teacher->subjects() // Changed from teacherSubjects()
        ->where('class_id', $classId)
            ->where('term_id', $term->id)
            ->with('subject')
            ->get()
            ->pluck('subject');

        return view('teacher.classes.show', compact('class', 'students', 'subjects'));
    }
}
