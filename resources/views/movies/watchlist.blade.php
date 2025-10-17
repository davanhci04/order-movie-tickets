<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div class="flex items-center space-x-4">
                <a href="{{ route('movies.index') }}" class="text-blue-600 hover:text-blue-800 transition duration-200">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                </a>
                <h2 class="font-semibold text-xl text-blue-800 leading-tight">
                    Danh sách xem của tôi
                </h2>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <!-- Results Info -->
                    <div class="mb-6 flex items-center justify-between border-b border-gray-200 pb-4">
                        <div class="flex items-center space-x-4">
                            <p class="text-gray-600">
                                <span class="font-semibold text-blue-700">{{ $watchlistMovies->total() }}</span> phim trong danh sách xem
                            </p>
                        </div>
                    </div>

                    @if($watchlistMovies->count() > 0)
                        <!-- Movies Grid -->
                        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-6">
                            @foreach($watchlistMovies as $movie)
                                <div class="group relative bg-white rounded-xl shadow-md hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2 border border-gray-200 h-80 overflow-hidden">
                                    <a href="{{ route('movies.show', $movie) }}" class="block h-full relative">
                                        <!-- Movie Poster -->
                                        @if($movie->poster_url)
                                            <img src="{{ $movie->poster_url }}" 
                                                 alt="{{ $movie->title }}" 
                                                 class="w-full h-full object-cover transition-transform duration-300 group-hover:scale-105">
                                        @else
                                            <div class="w-full h-full bg-gradient-to-br from-blue-100 to-blue-200 flex items-center justify-center">
                                                <svg class="w-16 h-16 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 4V2a1 1 0 011-1h8a1 1 0 011 1v2h4a1 1 0 011 1v16a1 1 0 01-1 1H6a1 1 0 01-1-1V5a1 1 0 011-1h1z"></path>
                                                </svg>
                                            </div>
                                        @endif

                                        <!-- Dark Overlay for Movie Info -->
                                        <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                                        
                                        <!-- Movie Info Overlay -->
                                        <div class="absolute bottom-0 left-0 right-0 p-4 text-white transform translate-y-full group-hover:translate-y-0 transition-transform duration-300">
                                            <h3 class="font-bold text-lg mb-2 line-clamp-2">
                                                {{ $movie->title }}
                                            </h3>
                                            
                                            <div class="flex items-center justify-between text-sm mb-2">
                                                <span>{{ $movie->release_year }}</span>
                                                @if($movie->duration)
                                                    <span>{{ $movie->duration }} phút</span>
                                                @endif
                                            </div>

                                            @if($movie->genre)
                                                <div class="mb-2">
                                                    <span class="inline-block bg-white/20 backdrop-blur-sm text-white px-2 py-1 rounded-full text-xs font-medium">
                                                        {{ $movie->genre }}
                                                    </span>
                                                </div>
                                            @endif

                                            @if($movie->director)
                                                <p class="text-white/90 text-xs">
                                                    <span class="font-medium">Đạo diễn:</span> {{ $movie->director }}
                                                </p>
                                            @endif
                                        </div>
                                    </a>

                                    <!-- Remove from Watchlist Button -->
                                    <div class="absolute top-2 right-2 opacity-0 group-hover:opacity-100 transition-opacity duration-300 z-10">
                                        <button id="remove-watchlist-btn-{{ $movie->id }}"
                                                class="remove-watchlist-btn bg-red-500 hover:bg-red-600 text-white p-2 rounded-full shadow-lg transition-colors duration-200"
                                                data-movie-id="{{ $movie->id }}"
                                                title="Xóa khỏi danh sách xem">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                            </svg>
                                        </button>
                                    </div>

                                    <!-- Rating Badge -->
                                    @if($movie->average_rating > 0)
                                        <div class="absolute top-2 left-2 bg-yellow-500 text-white px-2 py-1 rounded-full text-xs font-semibold flex items-center space-x-1 z-10">
                                            <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                            </svg>
                                            <span>{{ number_format($movie->average_rating, 1) }}</span>
                                        </div>
                                    @endif
                                </div>
                            @endforeach
                        </div>

                        <!-- Pagination -->
                        @if($watchlistMovies->hasPages())
                            <div class="mt-8 flex justify-center">
                                {{ $watchlistMovies->links() }}
                            </div>
                        @endif
                    @else
                        <!-- Empty State -->
                        <div class="text-center py-16">
                            <div class="w-20 h-20 mx-auto mb-6 bg-gray-100 rounded-full flex items-center justify-center">
                                <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                                </svg>
                            </div>
                            <h3 class="text-xl font-semibold text-gray-800 mb-2">Danh sách xem trống</h3>
                            <p class="text-gray-600 mb-4">Bạn chưa thêm phim nào vào danh sách xem. Hãy khám phá và thêm những bộ phim yêu thích!</p>
                            <a href="{{ route('movies.index') }}" 
                               class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition-colors duration-200 space-x-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                </svg>
                                <span>Khám phá phim</span>
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    @vite(['resources/js/app.js', 'resources/js/movies-watchlist.js'])
</x-app-layout>