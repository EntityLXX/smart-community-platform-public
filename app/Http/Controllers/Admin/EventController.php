<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Event;
use Illuminate\Support\Facades\Storage;
use App\Models\User;
use App\Models\Notification;


class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $events = \App\Models\Event::orderBy('date', 'asc')->paginate(5);
        return view('admin.events.index', compact('events'));
    
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.events.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'event_name' => 'required|string|max:255',
            'description' => 'required|string',
            'date' => 'required|date',
            'time' => 'required',
            'location' => 'required|string|max:255',
            'picture' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);
    
        if ($request->hasFile('picture')) {
            $validated['picture'] = $request->file('picture')->store('event_pictures', 'public');
        }
    
        $event = Event::create($validated);
    
        // Notify all users
        foreach (User::all() as $user) {
            Notification::create([
                'user_id' => $user->id,
                'title' => 'New Event: ' . $event->event_name,
                'message' => 'A new event is happening at ' . $event->location . ' on ' . $event->date . ' at ' . $event->time,
                'read' => false,
            ]);
        }
    
        return redirect()->route('admin.events.index')->with('success', 'Event created successfully!');
    }
    

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $event = Event::findOrFail($id);
        return view('admin.events.edit', compact('event'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'event_name' => 'required|string|max:255',
            'description' => 'required|string',
            'date' => 'required|date',
            'time' => 'required',
            'location' => 'required|string|max:255',
            'picture' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);
    
        $event = Event::findOrFail($id);
    
        if ($request->hasFile('picture')) {
            if ($event->picture) {
                Storage::disk('public')->delete($event->picture);
            }
            $validated['picture'] = $request->file('picture')->store('event_pictures', 'public');
        }
    
        $event->update($validated);
    
        // Notify all users
        foreach (User::all() as $user) {
            Notification::create([
                'user_id' => $user->id,
                'title' => 'Event Updated: ' . $event->event_name,
                'message' => 'An event has been updated. Check the new details for ' . $event->date . ' at ' . $event->location,
                'read' => false,
            ]);
        }
    
        return redirect()->route('admin.events.index')->with('success', 'Event updated successfully!');
    }
    

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $event = Event::findOrFail($id);
    
        if ($event->picture) {
            Storage::disk('public')->delete($event->picture);
        }
    
        // Notify all users before deletion
        foreach (User::all() as $user) {
            Notification::create([
                'user_id' => $user->id,
                'title' => 'Event Cancelled: ' . $event->event_name,
                'message' => 'The event scheduled for ' . $event->date . ' has been cancelled.',
                'read' => false,
            ]);
        }
    
        $event->delete();
    
        return redirect()->route('admin.events.index')->with('success', 'Event deleted successfully.');
    }
    
    
}
