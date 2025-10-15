<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-100 leading-tight">
                {{ __('Edit Movie: ' . $movie->title) }}
            </h2>
            <a href="{{ route('admin.movies.index') }}" class="text-red-400 hover:text-red-300">
                ← Back to Movies
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('admin.movies.update', $movie) }}" method="POST" class="space-y-6">
                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Title -->
                            <div class="md:col-span-2">
                                <label for="title" class="block text-sm font-medium mb-2 text-gray-200">Title *</label>
                                <input type="text" name="title" id="title" value="{{ old('title', $movie->title) }}" 
                                       class="form-input" required>
                                @error('title')
                                    <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Release Year -->
                            <div>
                                <label for="release_year" class="block text-sm font-medium mb-2 text-gray-200">Release Year *</label>
                                <input type="number" name="release_year" id="release_year" value="{{ old('release_year', $movie->release_year) }}" 
                                       min="1900" max="{{ date('Y') + 5 }}"
                                       class="form-input" required>
                                @error('release_year')
                                    <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Genre -->
                            <div>
                                <label for="genre" class="block text-sm font-medium mb-2 text-gray-200">Genre</label>
                                <input type="text" name="genre" id="genre" value="{{ old('genre', $movie->genre) }}" 
                                       class="form-input"
                                       placeholder="e.g., Action, Drama, Comedy">
                                @error('genre')
                                    <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Director -->
                            <div>
                                <label for="director" class="block text-sm font-medium mb-2 text-gray-200">Director</label>
                                <input type="text" name="director" id="director" value="{{ old('director', $movie->director) }}" 
                                       class="form-input">
                                @error('director')
                                    <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Duration -->
                            <div>
                                <label for="duration" class="block text-sm font-medium mb-2 text-gray-200">Duration (minutes)</label>
                                <input type="number" name="duration" id="duration" value="{{ old('duration', $movie->duration) }}" 
                                       min="1"
                                       class="form-input">
                                @error('duration')
                                    <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Poster URL -->
                            <div class="md:col-span-2">
                                <label for="poster_url" class="block text-sm font-medium mb-2 text-gray-200">Poster URL</label>
                                <input type="url" name="poster_url" id="poster_url" value="{{ old('poster_url', $movie->poster_url) }}" 
                                       class="form-input"
                                       placeholder="https://example.com/poster.jpg">
                                @error('poster_url')
                                    <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Description -->
                            <div class="md:col-span-2">
                                <label for="description" class="block text-sm font-medium mb-2 text-gray-200">Description *</label>
                                <textarea name="description" id="description" rows="4" required
                                          class="form-input">{{ old('description', $movie->description) }}</textarea>
                                @error('description')
                                    <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Current Stats -->
                        <div class="bg-dark-700 p-4 rounded-lg border border-gray-600">
                            <h3 class="font-medium mb-2 text-gray-100">Current Statistics</h3>
                            <div class="grid grid-cols-3 gap-4 text-sm">
                                <div>
                                    <span class="text-gray-400">Average Rating:</span>
                                    <span class="font-medium text-red-400">{{ number_format($movie->average_rating, 1) }}/10</span>
                                </div>
                                <div>
                                    <span class="text-gray-400">Total Ratings:</span>
                                    <span class="font-medium text-gray-200">{{ $movie->ratings->count() }}</span>
                                </div>
                                <div>
                                    <span class="text-gray-400">Comments:</span>
                                    <span class="font-medium text-gray-200">{{ $movie->comments->count() }}</span>
                                </div>
                            </div>
                        </div>

                        <div class="flex items-center justify-end space-x-4">
                            <a href="{{ route('admin.movies.index') }}" class="text-gray-400 hover:text-gray-300">
                                Cancel
                            </a>
                            <button type="submit" class="btn-primary">
                                Update Movie
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>