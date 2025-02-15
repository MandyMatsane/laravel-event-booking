<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Category;
use App\Models\Event;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $eventsQuery = Event::query();

        // Validate the inputs
        $request->validate([
            'price' => 'nullable|numeric', // Ensure price is a number or null
        ]);

        // Apply filters
        if ($request->has('price') && $request->price !== null) {
            $eventsQuery->where('price', '<=', $request->price);
        }

        if ($request->has('category_id') && $request->category_id !== null) {
            $eventsQuery->where('category_id', $request->category_id);
        }

        if ($request->has('location') && $request->location !== null) {
            $eventsQuery->where('location', 'like', '%' . $request->location . '%');
        }

        if ($request->has('date') && $request->date !== null) {
            $eventsQuery->whereDate('date', $request->date);
        }

        $events = $eventsQuery->get();

        // Pass events and categories to the view
        $categories = Category::all();

        return view('user.dashboard', compact('events', 'categories'));
    }


    public function store(Request $request)
    {
        $event = Event::findOrFail($request->event_id);

        if ($event->bookings()->count() >= $event->max_attendees) {
            return back()->with('error', 'This event is fully booked.');
        }

        $booking = Booking::create([
            'user_id' => auth()->id(),
            'event_id' => $event->id,
            'booking_date' => now(),
            'payment_status' => 'Pending',
        ]);

        // Notification::send(auth()->user(), new BookingConfirmation($booking));

        return back()->with('success', 'Your booking is confirmed.');
    }

    public function show()
    {
        $bookings = Booking::where('user_id', auth()->id())->with('event')->get();
        return view('user.bookings', compact('bookings'));
    }

    public function destroy($id)
    {
        $booking = Booking::findOrFail($id);

        if ($booking->user_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        $booking->delete();

        return back()->with('success', 'Booking cancelled.');
    }
}
