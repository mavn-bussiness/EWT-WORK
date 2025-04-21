<?php

namespace App\Http\Controllers\Headteacher;

use App\Models\{
    User,
    Teacher,
    Announcement,
    ReportComment,
    SchoolEvent,
    StaffReport,
    Bursar,
    Student
};
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\Hash;

class HeadteacherController extends Controller
{
    // Dashboard
    public function dashboard()
    {
        $stats = [
            'teachers' => Teacher::count(),
            'students' => Student::count(),
            'pending_reports' => StaffReport::where('status', 'pending')->count(),
            'upcoming_events' => SchoolEvent::where('event_date', '>=', now())->count(),
        ];

        $recentAnnouncements = Announcement::latest()->take(5)->get();
        $pendingReports = StaffReport::with('user')->where('status', 'pending')->latest()->take(5)->get();

        return view('headteacher.dashboard', compact('stats', 'recentAnnouncements', 'pendingReports'));
    }

    // DOS Management
    public function dosIndex()
    {
        // Get the current DOS first
        $currentDos = Teacher::where('is_dos', true)->first();

        // Then load the relationship if $currentDos exists
        if ($currentDos) {
            $currentDos->load('user');
        }

        // Get all non-DOS teachers
        $teacherUsers = Teacher::where('is_dos', false)->get();

        // Then load the user relationship for all teachers
        $teacherUsers->load('user');

        return view('headteacher.staff.dos', compact('currentDos', 'teacherUsers'));
    }

    public function promoteToDos(Request $request)
    {
        $request->validate([
            'teacher_id' => 'required|exists:teachers,id',
            'department' => 'required|string|max:255'
        ]);

        // Demote current DOS if exists
        Teacher::where('is_dos', true)->update([
            'is_dos' => false,
            'dos_department' => null
        ]);

        // Promote new DOS
        $teacher = Teacher::find($request->teacher_id);
        $teacher->update([
            'is_dos' => true,
            'dos_department' => $request->department
        ]);

        // Update user role
        $teacher->user->update(['role' => 'teacher,dos']);

        return redirect()->route('headteacher.staff.dos')
            ->with('success', 'Teacher promoted to DOS successfully');
    }

    public function demoteDos(Teacher $teacher)
    {
        $teacher->update([
            'is_dos' => false,
            'dos_department' => null
        ]);

        // Update user role
        $teacher->user->update(['role' => 'teacher']);

        return back()->with('success', 'DOS demoted to regular teacher');
    }

    // Bursar Management (unchanged)
    public function bursarsIndex()
    {
        $maxBursars = 5;
        $bursarsList = Bursar::with('user')->get();
        return view('headteacher.staff.bursar', compact('bursarsList', 'maxBursars'));
    }

    public function registerBursar(Request $request)
    {
        $maxBursars = 5;

        if (Bursar::count() >= $maxBursars) {
            return redirect()->route('headteacher.staff.bursars')
                ->with('error', "Maximum number of bursars ({$maxBursars}) already reached.");
        }

        $request->validate([
            'firstName' => 'required|string|max:255',
            'lastName' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'phoneNumber' => 'required|string',
            'role' => 'required|in:chief_bursar,assistant_bursar,accounts_clerk,cashier',
        ]);

        $defaultPassword = strtolower($request->firstName . $request->lastName);

        $user = User::create([
            'firstName' => $request->firstName,
            'lastName' => $request->lastName,
            'email' => $request->email,
            'role' => 'bursar',
            'password' => Hash::make('defaultPassward'),
            'is_active' => true,
        ]);

        Bursar::create([
            'user_id' => $user->id,
            'staffId' => 'BUR-' . now()->format('Y') . str_pad(Bursar::count() + 1, 4, '0', STR_PAD_LEFT),
            'role' => $request->role,
            'phoneNumber' => $request->phoneNumber,
            'transaction_limit' => $request->role === 'chief_bursar' ? null : 500000,
            'can_approve_expenses' => $request->role === 'chief_bursar',
        ]);

        return redirect()->route('headteacher.dashboard')
            ->with('success', 'Bursar registered successfully.');
    }
    public function updateBursar(Request $request, Bursar $bursar)
{
    $request->validate([
        'firstName' => 'required|string|max:255',
        'lastName' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:users,email,' . $bursar->user->id,
        'phoneNumber' => 'required|string',
        'role' => 'required|in:chief_bursar,assistant_bursar,accounts_clerk,cashier',
        'transaction_limit' => 'nullable|numeric|min:0',
        'is_active' => 'nullable|boolean'
    ]);

    // Update user info
    $bursar->user->update([
        'firstName' => $request->firstName,
        'lastName' => $request->lastName,
        'email' => $request->email,
        'is_active' => $request->has('is_active')
    ]);

    // Update bursar info
    $bursar->update([
        'phoneNumber' => $request->phoneNumber,
        'role' => $request->role,
        'transaction_limit' => $request->role === 'chief_bursar' ? null : $request->transaction_limit,
        'can_approve_expenses' => $request->role === 'chief_bursar'
    ]);

    return redirect()->route('headteacher.staff.bursars')
        ->with('success', 'Bursar information updated successfully');
}

    // Other methods remain unchanged...
    public function announcementsIndex()
    {
        $announcements = Announcement::latest()->paginate(10);
        return view('headteacher.announcements.index', compact('announcements'));
    }

    public function viewStaffReports()
    {
        $reports = StaffReport::with(['user', 'comments'])
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('headteacher.reports.index', compact('reports'));
    }

    public function commentOnReport(Request $request, StaffReport $report)
    {
        $request->validate([
            'comment' => 'required|string|max:1000',
            'status' => 'required|in:approved,rejected,reviewed',
        ]);

        $report->update([
            'status' => $request->status,
            'headteacher_comments' => $request->comment,
            'reviewed_at' => now(),
        ]);

        ReportComment::create([
            'report_id' => $report->id,
            'user_id' => auth()->id(),
            'comment' => $request->comment,
            'status_change' => $request->status,
        ]);

        return redirect()->route('headteacher.reports.show', $report)
            ->with('success', 'Report comments submitted successfully.');
    }

    public function uploadCircular(Request $request)
{
    $request->validate([
        'title' => 'required|string|max:255',
        'content' => 'required|string',
        'audience' => 'required|in:all,teachers,students,parents',
        'attachment' => 'nullable|file|mimes:pdf,doc,docx|max:2048',
        'publish_date' => 'required|date',
        'expiry_date' => 'nullable|date|after:publish_date',
    ]);

    $announcement = new Announcement([
        'title' => $request->title,
        'content' => $request->content,
        'audience' => $request->audience, // Don't wrap in array
        'publish_date' => $request->publish_date,
        'expiry_date' => $request->expiry_date,
        'posted_by' => auth()->id(),
    ]);

    if ($request->hasFile('attachment')) {
        $path = $request->file('attachment')->store('announcements/attachments', 'public');
        $announcement->attachment_path = $path;
    }

    $announcement->save();

    return redirect()->route('headteacher.announcements.index')
        ->with('success', 'Circular uploaded successfully.');
}
    public function generateStaffPerformanceReport()
    {
        $teachers = Teacher::with(['user', 'subjects', 'assessments'])
            ->withCount(['assessments', 'timetables'])
            ->get();

        return view('headteacher.reports.performance', compact('teachers'));
    }
    public function editBursar(Bursar $bursar)
    {
        return view('headteacher.staff.edit-bursar', compact('bursar'));
    }

    public function manageSchoolEvents()
    {
        $events = SchoolEvent::with('organizer')
            ->orderBy('event_date')
            ->paginate(10);
        return view('headteacher.events.index', compact('events'));
    }
    public function showEvent(SchoolEvent $event){
        return view('headteacher.events.show', ['schoolEvent' => $event]);

    }
    public function approveSchoolEvent(SchoolEvent $event)
    {
        $event->update(['is_approved' => true]);
        return back()->with('success', 'Event approved successfully.');
    }
}
