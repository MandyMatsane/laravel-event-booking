<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('User Dashboard') }}
        </h2>
    </x-slot>

    <form action="{{ route('user.index') }}" method="GET">
        <div class="filter-options">
            <select name="category_id">
                <option value="">Select Category</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                @endforeach
            </select>

            <input type="text" name="location" placeholder="Location">
            <input type="date" name="date" placeholder="Date">
            <input type="number" name="price" placeholder="Max Price">
            <button type="submit">Filter</button>
        </div>
    </form>

    <h2>Upcoming Events</h2>
    @foreach ($events as $event)
        <div class="event">
            <h3>{{ $event->name }}</h3>
            <p>{{ $event->description }}</p>
            <p>{{ $event->location }} - {{ $event->date }}</p>
            <p>{{ $event->price }} R</p>

            <!-- Booking Form -->
            <form action="{{ route('bookings.store') }}" method="POST">
                @csrf
                <input type="hidden" name="event_id" value="{{ $event->id }}">
                <button type="submit" class="btn btn-primary">Book Now</button>
            </form>
        </div>
    @endforeach
</x-app-layout>
