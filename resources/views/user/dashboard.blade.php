<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('User Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-100">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 text-center text-lg font-medium">
                    {{ __("Welcome, User!") }}
                </div>
            </div>
        </div>
    </div>

    <!-- Filter Form -->
    <div class="py-6 bg-white">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <form action="{{ route('user.dashboard') }}" method="GET" class="bg-gray-100 p-6 rounded-lg shadow-md">
                <h3 class="text-lg font-semibold mb-4">Filter Events</h3>
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <!-- Category -->
                    <select name="category_id" class="border border-gray-300 p-2 rounded-md">
                        <option value="">Select Category</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>

                    <!-- Location -->
                    <input type="text" name="location" placeholder="Location" 
                           class="border border-gray-300 p-2 rounded-md" />

                    <!-- Date -->
                    <input type="date" name="date" 
                           class="border border-gray-300 p-2 rounded-md" />

                    <!-- Price -->
                    <input type="number" name="price" placeholder="Max Price" 
                           class="border border-gray-300 p-2 rounded-md" />
                </div>

                <!-- Submit Button -->
                <div class="mt-4">
                    <button type="submit" 
                            class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600">
                        Filter
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Events List -->
    <div class="py-6 bg-gray-100">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <h2 class="text-xl font-semibold mb-4">Upcoming Events</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach ($events as $event)
                    <div class="bg-white p-4 rounded-lg shadow-md">
                        <h3 class="text-lg font-semibold mb-2">{{ $event->name }}</h3>
                        <p class="text-gray-700 text-sm">{{ $event->description }}</p>
                        <p class="text-gray-500 text-sm mt-1">{{ $event->location }} - {{ $event->date }}</p>
                        <p class="text-gray-800 text-md font-semibold mt-2">R{{ $event->ticket_price }}</p>


                        <!-- Booking Button -->
                        <form action="{{ route('bookings.store') }}" method="POST" class="mt-4">
                            @csrf
                            <input type="hidden" name="event_id" value="{{ $event->id }}">
                            <button type="submit" 
                                    class="bg-green-500 text-white px-4 py-2 rounded-md hover:bg-green-600 w-full">
                                Book Now
                            </button>
                        </form>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</x-app-layout>
