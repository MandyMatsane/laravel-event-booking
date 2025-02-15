<x-app-layout>
    <div class="container mx-auto p-6">
        <div class="bg-white shadow rounded-lg p-6">
            <h1 class="text-2xl font-bold text-gray-800 mb-4">Booking Details</h1>
            <p class="text-gray-600 mb-2">
                <strong class="font-semibold text-gray-700">Booking ID:</strong> {{ $booking->id }}
            </p>
            <p class="text-gray-600 mb-2">
                <strong class="font-semibold text-gray-700">Event Name:</strong> {{ $booking->event->name }}
            </p>
            <p class="text-gray-600 mb-2">
                <strong class="font-semibold text-gray-700">Booking Date:</strong> {{ $booking->booking_date }}
            </p>
            <p class="text-gray-600 mb-4">
                <strong class="font-semibold text-gray-700">Payment Status:</strong> {{ $booking->payment_status }}
            </p>
            <p class="text-gray-600 mb-2">
                <strong class="font-semibold text-gray-700">Ticket Price:</strong>
                {{ $booking->event->ticket_price ?? 'Not available' }}
            </p>

            @if ($booking->qr_code)
                <div class="mb-6">
                    <h3 class="text-lg font-semibold text-gray-700 mb-2">Your QR Code:</h3>
                    <img src="{{ asset($booking->qr_code) }}" alt="QR Code" class="w-48 h-48">
                </div>
            @endif
        </div>

        <form action="{{ route('paypal.checkout', $booking->id) }}" method="GET" class="mt-6">
            <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded shadow hover:bg-blue-600 transition">
                Pay with PayPal
            </button>
        </form>
    </div>
</x-app-layout>
