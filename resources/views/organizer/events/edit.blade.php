<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Edit Event') }}
            </h2>
            <a href="{{ route('organizer.events.index') }}" class="text-blue-500 hover:text-blue-700">Back to Events</a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form method="POST" action="{{ route('organizer.events.update', $event->id) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <!-- Event Name -->
                        <div>
                            <label for="name" class="block font-medium text-sm text-gray-700">Event Name</label>
                            <input id="name" name="name" type="text" class="block mt-1 w-full"
                                value="{{ old('name', $event->name) }}" required>
                        </div>

                        <!-- Description -->
                        <div>
                            <label for="description" class="block font-medium text-sm text-gray-700">Description</label>
                            <textarea id="description" name="description" class="block mt-1 w-full" required>{{ old('description', $event->description) }}</textarea>
                        </div>

                        <!-- Location -->
                        <div>
                            <label for="location" class="block font-medium text-sm text-gray-700">Location</label>
                            <input id="location" name="location" type="text" class="block mt-1 w-full"
                                value="{{ old('location', $event->location) }}" required>
                        </div>

                        <!-- Date & Time -->
                        <div>
                            <label for="date_time" class="block font-medium text-sm text-gray-700">Date & Time</label>
                            <input id="date_time" name="date_time" type="datetime-local" class="block mt-1 w-full"
                                value="{{ old('date_time', $event->date_time ? \Carbon\Carbon::parse($event->date_time)->format('Y-m-d\TH:i') : '') }}" required>
                        </div>

                        <!-- Category -->
                        <div>
                            <label for="category_id" class="block font-medium text-sm text-gray-700">Category</label>
                            <select id="category_id" name="category_id" class="block mt-1 w-full" required>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}" {{ $category->id == old('category_id', $event->category_id) ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Max Attendees -->
                        <div>
                            <label for="max_attendees" class="block font-medium text-sm text-gray-700">Max Attendees</label>
                            <input id="max_attendees" name="max_attendees" type="number" class="block mt-1 w-full"
                                value="{{ old('max_attendees', $event->max_attendees) }}" required>
                        </div>

                        <!-- Ticket Price -->
                        <div>
                            <label for="ticket_price" class="block font-medium text-sm text-gray-700">Ticket Price (Rands)</label>
                            <input id="ticket_price" name="ticket_price" type="number" step="0.01" class="block mt-1 w-full"
                                value="{{ old('ticket_price', $event->ticket_price) }}" required>
                        </div>

                        <!-- Status -->
                        <div>
                            <label for="status" class="block font-medium text-sm text-gray-700">Event Status</label>
                            <select id="status" name="status" class="block mt-1 w-full" required>
                                <option value="Upcoming" {{ old('status', $event->status) == 'Upcoming' ? 'selected' : '' }}>Upcoming</option>
                                <option value="Ongoing" {{ old('status', $event->status) == 'Ongoing' ? 'selected' : '' }}>Ongoing</option>
                                <option value="Completed" {{ old('status', $event->status) == 'Completed' ? 'selected' : '' }}>Completed</option>
                            </select>
                        </div>

                        <!-- Visibility -->
                        <div>
                            <label for="visibility" class="block font-medium text-sm text-gray-700">Visibility</label>
                            <select id="visibility" name="visibility" class="block mt-1 w-full" required>
                                <option value="Public" {{ old('visibility', $event->visibility) == 'Public' ? 'selected' : '' }}>Public</option>
                                <option value="Private" {{ old('visibility', $event->visibility) == 'Private' ? 'selected' : '' }}>Private</option>
                            </select>
                        </div>

                        <!-- Event Image -->
                        <div>
                            <label for="image" class="block font-medium text-sm text-gray-700">Event Image</label>
                            <input id="image" name="image" type="file" class="block mt-1 w-full">
                        </div>

                        <!-- Submit Button -->
                        <div class="mt-4">
                            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                Update Event
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
