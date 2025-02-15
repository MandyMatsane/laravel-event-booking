<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Your Bookings') }}
            </h2>

            <a href="{{ route('user.dashboard') }}" class="text-blue-500 hover:underline">
                Go Back to Book an Event
            </a>
        </div>
    </x-slot>

    <div class="container mx-auto p-4">
        <h1 class="text-2xl font-semibold mb-4">Your Bookings</h1>

        @if ($bookings->isEmpty())
            <p>You have no bookings yet.</p>
        @else
            <table class="min-w-full bg-white border border-gray-200">
                <thead>
                    <tr>
                        <th class="px-4 py-2 border">Event Name</th>
                        <th class="px-4 py-2 border">Booking Date</th>
                        <th class="px-4 py-2 border">Payment Status</th>
                        <th class="px-4 py-2 border">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($bookings as $booking)
                        <tr>
                            <td class="px-4 py-2 border">{{ $booking->event->name }}</td>
                            <td class="px-4 py-2 border">{{ $booking->booking_date->format('d M Y') }}</td>
                            <td class="px-4 py-2 border">{{ $booking->payment_status }}</td>
                            <td class="px-4 py-2 border">
                                <!-- Cancel Booking Form -->
                                <form action="{{ route('bookings.destroy', $booking->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to cancel this booking?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700">Cancel Booking</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
</x-app-layout>
