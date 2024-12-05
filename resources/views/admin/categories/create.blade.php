<x-app-layout>
    <x-slot name="header">
        
    </x-slot>

    <div class="flex justify-center items-center min-h-screen bg-gray-100">
        <form action="{{ route('admin.categories.store') }}" method="POST" class="bg-gray-50 p-8 rounded-lg shadow-lg w-full max-w-md">
            @csrf
            <h1 class="text-2xl font-semibold text-gray-800 mb-6 text-center">Create Event Category</h1>

            <div class="mb-4">
                <label for="name" class="block text-sm font-medium text-gray-700">Category Name</label>
                <input type="text" name="name" id="name" value="{{ old('name') }}" required
                    class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            <div class="mb-4">
                <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                <textarea name="description" id="description" rows="4"
                    class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">{{ old('description') }}</textarea>
            </div>

            <button type="submit" class="w-full py-2 px-4 bg-blue-500 text-white rounded-lg hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500">
                Create
            </button>
        </form>
    </div>
</x-app-layout>
