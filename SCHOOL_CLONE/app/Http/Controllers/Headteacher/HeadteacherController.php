<?php

namespace App\Http\Controllers\Headteacher;

use App\Models\{
    User, Headteacher, Announcement, ReportComment, SchoolEvent, StaffReport
};
use App\Models\Teacher;
use App\Models\Student;
use App\Models\DeanOfStudent;
use App\Models\Bursar;
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

// Staff Management
public function registerDos(Request $request)
{
    // Check if a DOS already exists
    if (DeanOfStudent::count() > 0) {
        return redirect()->route('headteacher.staff.dos')
            ->with('error', 'A Dean of Students already exists. Please update the existing record instead.');
    }
    
    $request->validate([
        'firstName' => 'required|string|max:255',
        'lastName' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:users',
        'phoneNumber' => 'required|string',
        'department' => 'required|string'
    ]);
    // In registerDos and registerBursar methods
    $defaultPassword = strtolower($request->firstName . $request->lastName);

$user = User::create([
    'firstName' => $request->firstName,
    'lastName' => $request->lastName,
    'email' => $request->email,
    'role' => 'dos', // or 'bursar'
    'password' => Hash::make($defaultPassword),
    'is_active' => true,
]);

  
    // Create DOS record
    DeanOfStudent::create([
        'user_id' => $user->id,
        'staffId' => 'DOS-' . now()->format('Y') . str_pad(DeanOfStudent::count() + 1, 4, '0', STR_PAD_LEFT),
        'department' => $request->department,
        'phoneNumber' => $request->phoneNumber,
    ]);

    // Redirect to dashboard with success message
    return redirect()->route('headteacher.dashboard')
        ->with('success', 'Dean of Students registered successfully.');
}
public function editDos(DeanOfStudent $deanOfStudent)
{
    return view('headteacher.staff.edit-dos', compact('deanOfStudent'));
}

public function updateDos(Request $request, DeanOfStudent $deanOfStudent)
{
    $request->validate([
        'firstName' => 'required|string|max:255',
        'lastName' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:users,email,' . $deanOfStudent->user_id,
        'phoneNumber' => 'required|string',
        'department' => 'required|string',
    ]);

    // Update user info
    $deanOfStudent->user->update([
        'firstName' => $request->firstName,
        'lastName' => $request->lastName,
        'email' => $request->email,
    ]);

    // Update DOS info
    $deanOfStudent->update([
        'department' => $request->department,
        'phoneNumber' => $request->phoneNumber,
    ]);

    return redirect()->route('headteacher.staff.dos')
        ->with('success', 'Dean of Students updated successfully.');
}
public function deleteDos(DeanOfStudent $deanOfStudent)
{
    // Store user ID for later deletion
    $userId = $deanOfStudent->user_id;
    
    // Delete DOS record
    $deanOfStudent->delete();
    
    // Delete associated user
    User::find($userId)->delete();

    return redirect()->route('headteacher.staff.dos')
        ->with('success', 'Dean of Students deleted successfully.');
}

public function deleteBursar(Bursar $bursar)
{
    // Store user ID for later deletion
    $userId = $bursar->user_id;
    
    // Delete bursar record
    $bursar->delete();
    
    // Delete associated user
    User::find($userId)->delete();

    return redirect()->route('headteacher.staff.bursars')
        ->with('success', 'Bursar deleted successfully.');
}

// Similar methods for editBursar and updateBursar
// In your HeadteacherController:

public function dosIndex()
{
    $dosList = DeanOfStudent::with('user')->get();
    return view('headteacher.staff.dos', compact('dosList'));
}

public function bursarsIndex()
{
    $maxBursars = 5; // Set your maximum number
    $bursarsList = Bursar::with('user')->get();
    return view('headteacher.staff.bursar', compact('bursarsList', 'maxBursars'));
}

public function registerBursar(Request $request)
{
    // Set maximum number of bursars
    $maxBursars = 2;
    
    // Check if max bursars limit is reached
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
        'password' => ['required', 'confirmed', Rules\Password::defaults()],
    ]);
    $defaultPassword = strtolower($request->firstName . $request->lastName);

    // Create user
    $user = User::create([
        'firstName' => $request->firstName,
        'lastName' => $request->lastName,
        'email' => $request->email,
        'role' => 'bursar',
        'password' => Hash::make($request->password),
        'is_active' => true,
    ]);

    // Create Bursar record
    Bursar::create([
        'user_id' => $user->id,
        'staffId' => 'BUR-' . now()->format('Y') . str_pad(Bursar::count() + 1, 4, '0', STR_PAD_LEFT),
        'role' => $request->role,
        'phoneNumber' => $request->phoneNumber,
        'transaction_limit' => $request->role === 'chief_bursar' ? null : 500000, // Example limit
        'can_approve_expenses' => $request->role === 'chief_bursar',
    ]);

    return redirect()->route('headteacher.dashboard')
        ->with('success', 'Bursar registered successfully.');
}

public function announcementsIndex()
{
    $announcements = Announcement::latest()->paginate(10);
    return view('headteacher.announcements.index', compact('announcements'));
}

// Report Management
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

    // Add to report comments history
    ReportComment::create([
        'report_id' => $report->id,
        'user_id' => auth()->id(),
        'comment' => $request->comment,
        'status_change' => $request->status,
    ]);

    return redirect()->route('headteacher.reports.show', $report)
        ->with('success', 'Report comments submitted successfully.');
}

    // Circulars/Announcements
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
            'audience' => $request->audience,
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

    // Report Management
    public function generateStaffPerformanceReport()
    {
        $teachers = Teacher::with(['user', 'subjects', 'assessments'])
            ->withCount(['assessments', 'timetables'])
            ->get();

        return view('headteacher.reports.performance', compact('teachers'));
    }

    // School Calendar Management
    public function manageSchoolEvents()
    {
        $events = SchoolEvent::orderBy('event_date')->paginate(10);
        return view('headteacher.events.index', compact('events'));
    }

    public function approveSchoolEvent(SchoolEvent $event)
    {
        $event->update(['is_approved' => true]);
        return back()->with('success', 'Event approved successfully.');
    }
}