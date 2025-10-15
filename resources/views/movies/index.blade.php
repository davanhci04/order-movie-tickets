<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-100 leading-tight">
            {{ __('Movies') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="card">
                <div class="card-body">
                    <div class="grid grid-cols-1 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 xl:grid-cols-6 gap-8">
                        @forelse ($movies as $movie)
                            <div class="movie-card group flex justify-between bg-dark-800 rounded-lg overflow-hidden shadow-lg border border-gray-700 hover:border-red-500 transition-all duration-300">
                                @if($movie->poster_url)
                                    <div class="relative overflow-hidden">
                                        <img src="{{ $movie->poster_url }}" alt="{{ $movie->title }}" 
                                             class="w-48 h-48 object-cover group-hover:scale-105 transition-transform duration-300">
                                        <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-30 transition-all duration-300"></div>
                                    </div>
                                @else
                                    <div class="w-full h-48 bg-dark-700 flex items-center justify-center border-2 border-dashed border-gray-600">
                                        <span class="text-gray-500 text-sm">🎬 No Poster</span>
                                    </div>
                                @endif
                                
                                <div class="p-3">
                                    <h3 class="font-semibold text-sm mb-2 truncate text-gray-100 group-hover:text-red-400 transition-colors duration-300" title="{{ $movie->title }}">
                                        {{ $movie->title }}
                                    </h3>
                                    
                                    <div class="flex items-center justify-between mb-2">
                                        <p class="text-gray-400 text-xs">{{ $movie->release_year }}</p>
                                        <div class="flex items-center">
                                            <span class="star-rating text-sm">★</span>
                                            <span class="ml-1 text-xs text-gray-300">{{ number_format($movie->average_rating, 1) }}</span>
                                        </div>
                                    </div>
                                    
                                    @if($movie->genre)
                                        <p class="text-gray-500 text-xs mb-2 truncate" title="{{ $movie->genre }}">{{ $movie->genre }}</p>
                                    @endif
                                    
                                    <p class="text-gray-400 text-xs mb-3 line-clamp-2" title="{{ $movie->description }}">
                                        {{ Str::limit($movie->description, 60) }}
                                    </p>
                                    
                                    <a href="{{ route('movies.show', $movie) }}" 
                                       class="w-full btn-primary block text-center text-xs py-2">
                                        View Details
                                    </a>
                                </div>
                            </div>
                        @empty
                            <div class="col-span-full text-center py-16">
                                <div class="text-8xl text-gray-600 mb-6">🎬</div>
                                <p class="text-gray-400 text-xl mb-6">No movies available yet.</p>
                                @auth
                                    @if(auth()->user()->isAdmin())
                                        <a href="{{ route('admin.movies.create') }}" class="btn-primary inline-block px-6 py-3">
                                            Add First Movie
                                        </a>
                                    @endif
                                @endauth
                            </div>
                        @endforelse
                    </div>
                    
                    @if($movies->hasPages())
                        <div class="mt-8">
                            <div class="flex justify-center">
                                {{ $movies->links('pagination::tailwind') }}
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>