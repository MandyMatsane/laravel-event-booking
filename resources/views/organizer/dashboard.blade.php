<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Organizer Dashboard') }}
            </h2>

            <a href="{{ route('organizer.events.create') }}" class="text-blue-500 hover:text-blue-700">
                Create Events
            </a>

            <a href="{{ route('organizer.events.index') }}" class="text-blue-500 hover:text-blue-700">
                Manage Events
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h3 class="text-lg font-bold mb-4">Your Events</h3>
                    
                    @if($events->isEmpty())
                        <p>No events found.</p>
                    @else
                        <table class="min-w-full border-collapse border border-gray-300">
                            <thead>
                                <tr>
                                    <th class="border border-gray-300 px-4 py-2">Name</th>
                                    <th class="border border-gray-300 px-4 py-2">Category</th>
                                    <th class="border border-gray-300 px-4 py-2">Date</th>
                                    <th class="border border-gray-300 px-4 py-2">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($events as $event)
                                <tr>
                                    <td class="border border-gray-300 px-4 py-2">{{ $event->name }}</td>
                                    <td class="border border-gray-300 px-4 py-2">{{ $event->category->name }}</td>
                                    <td class="border border-gray-300 px-4 py-2">{{ $event->date_time }}</td>
                                    <td class="border border-gray-300 px-4 py-2">{{ $event->status }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>

                        <div class="mt-4">
                            {{ $events->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
