<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Models\Mark;
use App\Models\Assessment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MarkController extends Controller
{
    public function index()
    {
        $teacher = Auth::user()->teacher;
        $term = \App\Models\Term::where('is_current', true)->first();
        if (!$term) {
            return back()->with('error', 'No active term found.');
        }

        $assessments = Assessment::whereIn('class_id', $teacher->subjects()->pluck('class_id')) // Changed from teacherSubjects()
        ->whereIn('subject_id', $teacher->subjects()->pluck('subject_id')) // Changed from teacherSubjects()
        ->where('term_id', $term->id)
            ->with(['class', 'subject'])
            ->orderBy('assessment_date', 'desc')
            ->paginate(10);

        return view('teacher.marks.index', compact('assessments'));
    }

    public function create($assessmentId)
    {
        $teacher = Auth::user()->teacher;
        $assessment = Assessment::findOrFail($assessmentId);

        // Verify teacher authorization
        $teacherClassSubject = $teacher->subjects() // Changed from teacherSubjects()
        ->where('class_id', $assessment->class_id)
            ->where('subject_id', $assessment->subject_id)
            ->where('term_id', $assessment->term_id)
            ->exists();

        if (!$teacherClassSubject) {
            abort(403, 'Unauthorized action.');
        }

        $studentIds = \App\Models\ClassRegistration::where('class_id', $assessment->class_id)
            ->where('term_id', $assessment->term_id)
            ->where('status', 'registered')
            ->pluck('student_id')
            ->toArray();

        $students = Student::whereIn('id', $studentIds)
            ->whereNull('deleted_at')
            ->with(['user', 'marks' => fn($query) => $query->where('assessment_id', $assessmentId)])
            ->get();

        return view('teacher.marks.create', compact('assessment', 'students'));
    }

    public function store(Request $request, $assessmentId)
    {
        $teacher = Auth::user()->teacher;
        $assessment = Assessment::findOrFail($assessmentId);

        // Verify teacher authorization
        $teacherClassSubject = $teacher->subjects() // Changed from teacherSubjects()
        ->where('class_id', $assessment->class_id)
            ->where('subject_id', $assessment->subject_id)
            ->where('term_id', $assessment->term_id)
            ->exists();

        if (!$teacherClassSubject) {
            abort(403, 'Unauthorized action.');
        }

        $scores = $request->input('scores', []);
        $remarks = $request->input('remarks', []);

        foreach ($scores as $studentId => $score) {
            if ($score !== null && $score !== '') {
                $validScore = min(max(0, (int)$score), $assessment->max_score);
                $percentage = ($validScore / $assessment->max_score) * 100;
                $grade = $this->calculateGrade($percentage);

                $mark = Mark::updateOrCreate(
                    [
                        'student_id' => $studentId,
                        'assessment_id' => $assessmentId,
                    ],
                    [
                        'score' => $validScore,
                        'grade' => $grade,
                        'teacher_remarks' => $remarks[$studentId] ?? null,
                        'recorded_by' => Auth::id(),
                    ]
                );
            }
        }

        return redirect()->route('teacher.marks.index')
            ->with('success', 'Marks recorded successfully!');
    }

    public function edit($assessmentId)
    {
        return $this->create($assessmentId); // Reuse the create view for editing
    }

    public function destroy($markId)
    {
        $mark = Mark::findOrFail($markId);
        $teacher = Auth::user()->teacher;
        $assessment = $mark->assessment;

        $teacherClassSubject = $teacher->subjects() // Changed from teacherSubjects()
        ->where('class_id', $assessment->class_id)
            ->where('subject_id', $assessment->subject_id)
            ->where('term_id', $assessment->term_id)
            ->exists();

        if (!$teacherClassSubject) {
            abort(403, 'Unauthorized action.');
        }

        $mark->delete();
        return back()->with('success', 'Mark deleted successfully!');
    }

    private function calculateGrade($percentage)
    {
        if ($percentage >= 80) return 'A';
        if ($percentage >= 60) return 'B';
        if ($percentage >= 40) return 'C';
        return 'D';
    }
}
