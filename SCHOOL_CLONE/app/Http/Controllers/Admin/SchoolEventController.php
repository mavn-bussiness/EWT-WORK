<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SchoolEvent;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SchoolEventController extends Controller
{
    /**
     * Display a listing of the school events.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $events = SchoolEvent::with('organizer')->orderBy('event_date', 'desc')->get();
        return view('admin.events.index', compact('events'));
    }

    /**
     * Show the form for creating a new school event.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // Get all users who could potentially be organizers
        $users = User::where('is_active', true)
                     ->whereIn('role', ['admin', 'headteacher', 'teacher', 'dos'])
                     ->orderBy('firstName')
                     ->get();
                     
        return view('admin.events.create', compact('users'));
    }

    /**
     * Store a newly created school event in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
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

    /**
     * Display the specified school event.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $schoolEvent = SchoolEvent::with('organizer')->findOrFail($id);
        return view('admin.events.show', compact('schoolEvent'));
    }

    /**
     * Show the form for editing the specified school event.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $schoolEvent = SchoolEvent::findOrFail($id);
        
        // Get all users who could potentially be organizers
        $users = User::where('is_active', true)
                     ->whereIn('role', ['admin', 'headteacher', 'teacher', 'dos'])
                     ->orderBy('firstName')
                     ->get();
                     
        return view('admin.events.edit', compact('schoolEvent', 'users'));
    }

    /**
     * Update the specified school event in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
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

    /**
     * Remove the specified school event from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $schoolEvent = SchoolEvent::findOrFail($id);
        $schoolEvent->delete();
        
        return redirect()->route('admin.events.index')
            ->with('success', 'Event deleted successfully.');
    }
}