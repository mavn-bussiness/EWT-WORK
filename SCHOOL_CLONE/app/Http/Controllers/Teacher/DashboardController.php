<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\Term;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $teacher = Auth::user()->teacher;

//         Check if the user has a teacher record
        if (!$teacher) {
            return redirect()->route('login')->with('error', 'Unauthorized access. You are not a teacher.');
        }

        $term = Term::where('is_current', true)->first();

        if (!$term) {
            return view('teacher.dashboard')->with('error', 'No active term found.');
        }

        $classSubjects = $teacher->subjects() // Changed from teacherSubjects() to subjects()
        ->with(['class', 'subject'])
            ->where('term_id', $term->id)
            ->get()
            ->unique('class_id');

        $assignments = $teacher->assignments()
            ->where('term_id', $term->id)
            ->with(['class', 'subject'])
            ->orderBy('due_date', 'asc')
            ->take(5)
            ->get();

        $assessments = \App\Models\Assessment::whereIn('class_id', $teacher->subjects()->pluck('class_id')) // Changed here
        ->whereIn('subject_id', $teacher->subjects()->pluck('subject_id')) // Changed here
        ->where('term_id', $term->id)
            ->with(['class', 'subject'])
            ->orderBy('assessment_date', 'asc')
            ->take(5)
            ->get();

        $attendancePending = Attendance::whereIn('class_id', $teacher->subjects()->pluck('class_id')) // Changed here
        ->where('date', now()->format('Y-m-d'))
            ->whereNull('status')
            ->exists();

        return view('teacher.dashboard', compact('classSubjects', 'assignments', 'assessments', 'attendancePending'));
    }
}
