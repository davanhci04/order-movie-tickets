<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-100 leading-tight">
                {{ __('Manage Movies') }}
            </h2>
            <a href="{{ route('admin.movies.create') }}" class="btn-primary">
                Add New Movie
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="card">
                <div class="card-body">
                    @if(session('success'))
                        <div class="bg-green-600 text-white px-4 py-3 rounded mb-6 border border-green-500">
                            {{ session('success') }}
                        </div>
                    @endif

                    <div class="overflow-x-auto">
                        <table class="min-w-full table-auto">
                            <thead>
                                <tr class="border-b border-gray-700">
                                    <th class="text-left py-3 px-4 text-gray-100">Poster</th>
                                    <th class="text-left py-3 px-4 text-gray-100">Title</th>
                                    <th class="text-left py-3 px-4 text-gray-100">Year</th>
                                    <th class="text-left py-3 px-4 text-gray-100">Genre</th>
                                    <th class="text-left py-3 px-4 text-gray-100">Rating</th>
                                    <th class="text-left py-3 px-4 text-gray-100">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($movies as $movie)
                                    <tr class="border-b border-gray-700 hover:bg-dark-700 transition duration-200">
                                        <td class="py-3 px-4">
                                            @if($movie->poster_url)
                                                <img src="{{ $movie->poster_url }}" alt="{{ $movie->title }}" class="w-12 h-16 object-cover rounded">
                                            @else
                                                <div class="w-12 h-16 bg-gray-600 rounded flex items-center justify-center">
                                                    <span class="text-xs text-gray-400">No Image</span>
                                                </div>
                                            @endif
                                        </td>
                                        <td class="py-3 px-4">
                                            <div class="font-medium text-gray-100">{{ $movie->title }}</div>
                                            @if($movie->director)
                                                <div class="text-sm text-gray-400">by {{ $movie->director }}</div>
                                            @endif
                                        </td>
                                        <td class="py-3 px-4 text-gray-200">{{ $movie->release_year }}</td>
                                        <td class="py-3 px-4 text-gray-200">{{ $movie->genre ?: '-' }}</td>
                                        <td class="py-3 px-4">
                                            <div class="flex items-center">
                                                <span class="text-red-400">★</span>
                                                <span class="ml-1 text-gray-200">{{ number_format($movie->average_rating, 1) }}</span>
                                                <span class="text-sm text-gray-400 ml-1">({{ $movie->ratings->count() }})</span>
                                            </div>
                                        </td>
                                        <td class="py-3 px-4">
                                            <div class="flex items-center space-x-2">
                                                <a href="{{ route('movies.show', $movie) }}" class="text-blue-400 hover:text-blue-300" target="_blank">
                                                    View
                                                </a>
                                                <a href="{{ route('admin.movies.edit', $movie) }}" class="text-green-400 hover:text-green-300">
                                                    Edit
                                                </a>
                                                <form action="{{ route('admin.movies.destroy', $movie) }}" method="POST" class="inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-red-400 hover:text-red-300" onclick="return confirm('Are you sure? This will delete all ratings and comments for this movie.')">
                                                        Delete
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="py-8 text-center text-gray-400">
                                            No movies found. 
                                            <a href="{{ route('admin.movies.create') }}" class="text-red-400 hover:text-red-300 underline">
                                                Add the first movie
                                            </a>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    @if($movies->hasPages())
                        <div class="mt-6">
                            {{ $movies->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>