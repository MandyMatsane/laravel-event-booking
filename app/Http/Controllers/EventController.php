<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $events = Event::where('organizer_id', Auth::id())->orderBy('created_at', 'desc')->paginate(10);

        return view('organizer.events.index', compact('events'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();

        return view('organizer.events.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'location' => 'required|string|max:255',
            'date_time' => 'required|date',
            'category_id' => 'required|exists:categories,id',
            'max_attendees' => 'required|integer',
            'ticket_price' => 'required|numeric|min:0',
            'status' => 'required|in:Upcoming,Ongoing,Completed',
            'visibility' => 'required|in:Public,Private',
            'image' => 'nullable|image|max:2048',
        ]);

        // Handling the image upload
        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('event-images', 'public');
        }

        // Adding the organizer's ID
        $validated['organizer_id'] = Auth::id();

        // Create event
        Event::create($validated);

        return redirect()->route('organizer.events.index')->with('success', 'Event created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Event $event)
    {
        $this->authorizeEvent($event);

        return view('organizer.events.show', compact('event'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Event $event)
    {
        $this->authorizeEvent($event);

        $categories = Category::all();

        return view('organizer.events.edit', compact('event', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Event $event)
    {
        $this->authorizeEvent($event);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'location' => 'required|string|max:255',
            'date_time' => 'required|date',
            'category_id' => 'required|exists:categories,id',
            'max_attendees' => 'required|integer',
            'ticket_price' => 'required|numeric|min:0',
            'status' => 'required|in:Upcoming,Ongoing,Completed',
            'visibility' => 'required|in:Public,Private',
            'image' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('event-images', 'public');
        }

        $event->update($validated);

        return redirect()->route('organizer.events.index')->with('success', 'Event updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Event $event)
    {
        $this->authorizeEvent($event);

        $event->delete();

        return redirect()->route('organizer.events.index')->with('success', 'Event deleted successfully!');
    }

    private function authorizeEvent(Event $event)
    {
        if ($event->organizer_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }
    }
}
