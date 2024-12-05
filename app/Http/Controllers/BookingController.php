<?php

namespace App\Http\Controllers;

use App\Mail\BookingConfirmation;
use App\Models\Booking;
use App\Models\Event;
use App\Models\User;
use Illuminate\Http\Request;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;
use Illuminate\Support\Facades\Mail;

class BookingController extends Controller
{
    public function index()
    {
        $bookings = Booking::where('user_id', auth()->id())->with('event')->get();
        return view('bookings.index', compact('bookings'));
    }

    public function create()
    {
        $events = Event::where('status', 'Upcoming')->get();
        return view('bookings.create', compact('events'));
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

        // Generate QR code
        $qrCode = new QrCode("Booking ID: {$booking->id}, Event: {$event->name}");
        $writer = new PngWriter();
        $result = $writer->write($qrCode);

        $filePath = 'qr_codes/' . $booking->id . '.png';

        if (!file_exists(public_path('qr_codes'))) {
            mkdir(public_path('qr_codes'), 0755, true);
        }

        // Save the QR code as a file
        $filePath = 'qr_codes/' . $booking->id . '.png';
        $result->saveToFile(public_path($filePath));

        // Store the QR code path in the booking record
        $booking->update(['qr_code' => $filePath]);

        // Send booking confirmation email
        Mail::to(auth()->user()->email)->send(new BookingConfirmation($booking));

        return redirect()->route('bookings.show', $booking->id)->with('success', 'Your booking is confirmed!');
    }

    public function show(string $id)
    {
        // $booking = Booking::with('event')->findOrFail($id);
        $booking = Booking::where('id', $id)
            ->where('user_id', auth()->id())
            ->with('event')
            ->firstOrFail();

        return view('bookings.show', compact('booking'));
    }

    public function destroy(string $id)
    {
        $booking = Booking::where('id', $id)->where('user_id', auth()->id())->firstOrFail();
        // $booking = Booking::findOrFail($id);

        $booking->delete();

        return redirect()->route('bookings.index')->with('success', 'Booking cancelled successfully.');
    }
}
