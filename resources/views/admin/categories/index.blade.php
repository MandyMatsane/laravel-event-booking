<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Admin Dashboard') }}
            </h2>

            <a href="{{ route('admin.categories.create') }}" class="text-blue-500 hover:text-blue-700">Create New Category</a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h1 class="text-2xl font-semibold text-gray-800 mb-6">Manage Categories</h1>
                    
                    <table class="min-w-full table-auto border-collapse bg-white shadow-lg rounded-lg overflow-hidden">
                        <thead>
                            <tr class="bg-gray-100">
                                <th class="py-3 px-6 text-left text-sm font-medium text-gray-700">Name</th>
                                <th class="py-3 px-6 text-left text-sm font-medium text-gray-700">Description</th>
                                <th class="py-3 px-6 text-left text-sm font-medium text-gray-700">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($categories as $category)
                                <tr class="border-t border-gray-200">
                                    <td class="py-3 px-6 text-sm text-gray-800">{{ $category->name }}</td>
                                    <td class="py-3 px-6 text-sm text-gray-800">{{ $category->description }}</td>
                                    <td class="py-3 px-6 text-sm">
                                        <a href="{{ route('admin.categories.edit', $category->id) }}" class="text-blue-500 hover:text-blue-700 mr-2">Edit</a>
                                        
                                        <form action="{{ route('admin.categories.destroy', $category->id) }}" method="POST" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-500 hover:text-red-700">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
