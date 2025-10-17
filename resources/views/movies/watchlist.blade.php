<x-app-layout>
    <div class="min-h-screen bg-gradient-to-br from-blue-50 to-white">
        <div class="container mx-auto px-4 py-8">
            <!-- Header -->
            <div class="mb-8">
                <div class="flex items-center space-x-3 mb-4">
                    <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                    </svg>
                    <h1 class="text-4xl font-bold text-blue-800">Danh sách xem của tôi</h1>
                </div>
                <p class="text-blue-600 text-lg">{{ $watchlistMovies->total() }} phim trong danh sách xem</p>
            </div>

            @if($watchlistMovies->count() > 0)
                <!-- Movies Grid -->
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-6 gap-6">
                    @foreach($watchlistMovies as $movie)
                        <div class="group relative bg-white rounded-xl shadow-md hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2">
                            <!-- Movie Poster -->
                            <div class="relative overflow-hidden rounded-t-xl">
                                <a href="{{ route('movies.show', $movie) }}">
                                    @if($movie->poster_url)
                                        <img src="{{ $movie->poster_url }}" 
                                             alt="{{ $movie->title }}" 
                                             class="w-full h-64 object-cover transition-transform duration-300 group-hover:scale-110">
                                    @else
                                        <div class="w-full h-64 bg-gradient-to-br from-blue-100 to-blue-200 flex items-center justify-center">
                                            <svg class="w-16 h-16 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 4V2a1 1 0 011-1h8a1 1 0 011 1v2h4a1 1 0 011 1v16a1 1 0 01-1 1H6a1 1 0 01-1-1V5a1 1 0 011-1h1z"></path>
                                            </svg>
                                        </div>
                                    @endif
                                </a>

                                <!-- Remove from Watchlist Button -->
                                <div class="absolute top-2 right-2 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                    <button onclick="removeFromWatchlist({{ $movie->id }})" 
                                            class="bg-red-500 hover:bg-red-600 text-white p-2 rounded-full shadow-lg transition-colors duration-200"
                                            title="Xóa khỏi danh sách xem">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                        </svg>
                                    </button>
                                </div>

                                <!-- Rating Badge -->
                                @if($movie->ratings_avg_score)
                                    <div class="absolute top-2 left-2 bg-yellow-500 text-white px-2 py-1 rounded-full text-xs font-semibold flex items-center space-x-1">
                                        <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                        </svg>
                                        <span>{{ number_format($movie->ratings_avg_score, 1) }}</span>
                                    </div>
                                @endif
                            </div>

                            <!-- Movie Info -->
                            <div class="p-4">
                                <h3 class="font-bold text-blue-800 text-lg mb-2 line-clamp-2 group-hover:text-blue-600 transition-colors duration-200">
                                    <a href="{{ route('movies.show', $movie) }}">{{ $movie->title }}</a>
                                </h3>
                                
                                <div class="flex items-center justify-between text-sm text-blue-600">
                                    <span>{{ $movie->release_year }}</span>
                                    @if($movie->duration)
                                        <span>{{ $movie->duration }} phút</span>
                                    @endif
                                </div>

                                @if($movie->genre)
                                    <div class="mt-2">
                                        <span class="inline-block bg-blue-100 text-blue-800 px-2 py-1 rounded-full text-xs font-medium">
                                            {{ $movie->genre }}
                                        </span>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                @if($watchlistMovies->hasPages())
                    <div class="mt-12 flex justify-center">
                        {{ $watchlistMovies->links() }}
                    </div>
                @endif
            @else
                <!-- Empty State -->
                <div class="text-center py-16">
                    <div class="w-24 h-24 mx-auto mb-6 bg-blue-100 rounded-full flex items-center justify-center">
                        <svg class="w-12 h-12 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-blue-800 mb-4">Danh sách xem trống</h3>
                    <p class="text-blue-600 mb-8 max-w-md mx-auto">
                        Bạn chưa thêm phim nào vào danh sách xem. Hãy khám phá và thêm những bộ phim yêu thích!
                    </p>
                    <a href="{{ route('movies.index') }}" 
                       class="inline-flex items-center px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg transition-colors duration-200 space-x-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                        <span>Khám phá phim</span>
                    </a>
                </div>
            @endif
        </div>
    </div>

    @vite(['resources/js/app.js', 'resources/js/movies-watchlist.js'])
</x-app-layout>
</x-app-layout>