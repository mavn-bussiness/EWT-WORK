<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\SchoolEvent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    /**
     * Display the admin dashboard.
     */
    public function dashboard()
    {
        // Get counts for dashboard stats
        $stats = [
            'users' => User::count(),
            'teachers' => User::where('role', 'teacher')->count(),
            'students' => User::where('role', 'student')->count(),
            'events' => SchoolEvent::count(),
            'upcoming_events' => SchoolEvent::where('event_date', '>=', now())->count(),
        ];
        
        // Get recent users and events for quick preview
        $recentUsers = User::latest()->take(5)->get();
        $upcomingEvents = SchoolEvent::where('event_date', '>=', now())
            ->orderBy('event_date')
            ->take(5)
            ->get();
        
        return view('admin.dashboard', compact('stats', 'recentUsers', 'upcomingEvents'));
    }

    // User Management Methods
    public function index()
    {
        $users = User::orderBy('created_at', 'desc')->get();
        return view('admin.users.index', compact('users'));
    }

    public function create()
    {
        return view('admin.users.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'firstName' => ['required', 'string', 'max:255'],
            'lastName' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'role' => ['required', 'string', 'in:admin,teacher,student,headteacher,dos'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'firstName' => $validatedData['firstName'],
            'lastName' => $validatedData['lastName'],
            'email' => $validatedData['email'],
            'role' => $validatedData['role'],
            'password' => Hash::make($validatedData['password']),
        ]);

        return redirect()->route('admin.dashboard')
            ->with('success', 'User created successfully.');
    }

    public function show($id)
    {
        $user = User::findOrFail($id);
        return view('admin.users.show', compact('user'));
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $validatedData = $request->validate([
            'firstName' => ['required', 'string', 'max:255'],
            'lastName' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,'.$user->id],
            'role' => ['required', 'string', 'in:admin,teacher,student,headteacher,dos'],
            'password' => ['nullable', 'confirmed', Rules\Password::defaults()],
        ]);

        $updateData = [
            'firstName' => $validatedData['firstName'],
            'lastName' => $validatedData['lastName'],
            'email' => $validatedData['email'],
            'role' => $validatedData['role'],
        ];

        if (!empty($validatedData['password'])) {
            $updateData['password'] = Hash::make($validatedData['password']);
        }

        $user->update($updateData);

        return redirect()->route('admin.users.index')
            ->with('success', 'User updated successfully.');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('admin.users.index')
            ->with('success', 'User deleted successfully.');
    }

    // Events Management Methods
    public function eventIndex()
    {
        $events = SchoolEvent::with('organizer')->orderBy('event_date', 'desc')->get();
        return view('admin.events.index', compact('events'));
    }

    public function eventCreate()
    {
        $users = User::where('is_active', true)
                     ->whereIn('role', ['admin', 'headteacher', 'teacher', 'dos'])
                     ->orderBy('firstName')
                     ->get();
                     
        return view('admin.events.create', compact('users'));
    }

    public function eventStore(Request $request)
    {
        $validatedData = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'event_date' => ['required', 'date'],
            'start_time' => ['nullable', 'date_format:H:i'],
            'end_time' => ['nullable', 'date_format:H:i', 'after_or_equal:start_time'],
            'location' => ['nullable', 'string', 'max:255'],
            'organizer_id' => ['required', 'exists:users,id'],
        ]);
        
        SchoolEvent::create($validatedData);
        
        return redirect()->route('admin.events.index')
            ->with('success', 'Event created successfully.');
    }

    public function eventShow($id)
    {
        $schoolEvent = SchoolEvent::with('organizer')->findOrFail($id);
        return view('admin.events.show', compact('schoolEvent'));
    }

    public function eventEdit($id)
    {
        $schoolEvent = SchoolEvent::findOrFail($id);
        $users = User::where('is_active', true)
                     ->whereIn('role', ['admin', 'headteacher', 'teacher', 'dos'])
                     ->orderBy('firstName')
                     ->get();
                     
        return view('admin.events.edit', compact('schoolEvent', 'users'));
    }

    public function eventUpdate(Request $request, $id)
    {
        $schoolEvent = SchoolEvent::findOrFail($id);
        
        $validatedData = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'event_date' => ['required', 'date'],
            'start_time' => ['nullable', 'date_format:H:i'],
            'end_time' => ['nullable', 'date_format:H:i', 'after_or_equal:start_time'],
            'location' => ['nullable', 'string', 'max:255'],
            'organizer_id' => ['required', 'exists:users,id'],
        ]);
        
        $schoolEvent->update($validatedData);
        
        return redirect()->route('admin.events.index')
            ->with('success', 'Event updated successfully.');
    }

    public function eventDestroy($id)
    {
        $schoolEvent = SchoolEvent::findOrFail($id);
        $schoolEvent->delete();
        
        return redirect()->route('admin.events.index')
            ->with('success', 'Event deleted successfully.');
    }
}