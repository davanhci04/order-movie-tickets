<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-100 leading-tight">
                {{ __('Add New Movie') }}
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
                    <form action="{{ route('admin.movies.store') }}" method="POST" class="space-y-6">
                        @csrf

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Title -->
                            <div class="md:col-span-2">
                                <label for="title" class="block text-sm font-medium mb-2 text-gray-200">Title *</label>
                                <input type="text" name="title" id="title" value="{{ old('title') }}" 
                                       class="form-input" required>
                                @error('title')
                                    <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Release Year -->
                            <div>
                                <label for="release_year" class="block text-sm font-medium mb-2 text-gray-200">Release Year *</label>
                                <input type="number" name="release_year" id="release_year" value="{{ old('release_year') }}" 
                                       min="1900" max="{{ date('Y') + 5 }}"
                                       class="form-input" required>
                                @error('release_year')
                                    <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Genre -->
                            <div>
                                <label for="genre" class="block text-sm font-medium mb-2 text-gray-200">Genre</label>
                                <input type="text" name="genre" id="genre" value="{{ old('genre') }}" 
                                       class="form-input"
                                       placeholder="e.g., Action, Drama, Comedy">
                                @error('genre')
                                    <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Director -->
                            <div>
                                <label for="director" class="block text-sm font-medium mb-2 text-gray-200">Director</label>
                                <input type="text" name="director" id="director" value="{{ old('director') }}" 
                                       class="form-input">
                                @error('director')
                                    <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Duration -->
                            <div>
                                <label for="duration" class="block text-sm font-medium mb-2 text-gray-200">Duration (minutes)</label>
                                <input type="number" name="duration" id="duration" value="{{ old('duration') }}" 
                                       min="1"
                                       class="form-input">
                                @error('duration')
                                    <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Poster URL -->
                            <div class="md:col-span-2">
                                <label for="poster_url" class="block text-sm font-medium mb-2 text-gray-200">Poster URL</label>
                                <input type="url" name="poster_url" id="poster_url" value="{{ old('poster_url') }}" 
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
                                          class="form-input">{{ old('description') }}</textarea>
                                @error('description')
                                    <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="flex items-center justify-end space-x-4">
                            <a href="{{ route('admin.movies.index') }}" class="text-gray-400 hover:text-gray-300">
                                Cancel
                            </a>
                            <button type="submit" class="btn-primary">
                                Create Movie
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>