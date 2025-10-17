<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between space-y-4 lg:space-y-0">
            <div class="flex items-center space-x-4">
                <h2 class="font-semibold text-xl text-blue-800 leading-tight">
                    Danh sách Phim
                </h2>
            </div>
            
            <!-- Search Bar -->
            <div class="flex-1 max-w-md lg:mx-8">
                <form action="{{ route('movies.index') }}" method="GET" class="relative">
                    @if(request('sort'))
                        <input type="hidden" name="sort" value="{{ request('sort') }}">
                    @endif
                    
                    <div class="relative">
                        <input type="text" 
                               name="search" 
                               value="{{ request('search') }}"
                               placeholder="Tìm kiếm phim theo tên..." 
                               class="w-full px-4 py-2.5 pl-10 pr-12 text-sm text-blue-900 bg-white border border-blue-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-200 placeholder-blue-400">
                        
                        <!-- Search Icon -->
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="w-4 h-4 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </div>
                        
                        <!-- Clear/Submit Button -->
                        <div class="absolute inset-y-0 right-0 flex items-center">
                            @if(request('search'))
                                <a href="{{ route('movies.index') }}{{ request('sort') ? '?sort=' . request('sort') : '' }}" 
                                   class="p-2 text-gray-400 hover:text-gray-600 transition-colors duration-200"
                                   title="Xóa tìm kiếm">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                </a>
                            @endif
                            <button type="submit" 
                                    class="p-2 text-blue-500 hover:text-blue-700 transition-colors duration-200 mr-1"
                                    title="Tìm kiếm">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                </svg>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
            
            <!-- Sort Options -->
            <div class="flex items-center space-x-4">
                <form action="{{ route('movies.index') }}" method="GET" class="flex flex-col sm:flex-row sm:items-center space-y-2 sm:space-y-0 sm:space-x-3">
                    @if(request('search'))
                        <input type="hidden" name="search" value="{{ request('search') }}">
                    @endif
                    
                    <label for="sort" class="text-sm font-medium text-blue-700 sm:whitespace-nowrap">Sắp xếp:</label>
                    <select name="sort" id="sort" 
                            class="bg-white border-blue-300 text-blue-900 rounded-lg px-3 py-2 text-sm focus:border-blue-500 focus:ring-blue-500 min-w-[160px]"
                            onchange="this.form.submit()">
                        <option value="created_desc" {{ request('sort') == 'created_desc' || !request('sort') ? 'selected' : '' }}>Mới thêm</option>
                        <option value="title" {{ request('sort') == 'title' ? 'selected' : '' }}>Tên A-Z</option>
                        <option value="rating_desc" {{ request('sort') == 'rating_desc' ? 'selected' : '' }}>Đánh giá cao</option>
                        <option value="rating_asc" {{ request('sort') == 'rating_asc' ? 'selected' : '' }}>Đánh giá thấp</option>
                        <option value="year_desc" {{ request('sort') == 'year_desc' ? 'selected' : '' }}>Năm mới</option>
                        <option value="year_asc" {{ request('sort') == 'year_asc' ? 'selected' : '' }}>Năm cũ</option>
                    </select>
                </form>
            </div>
        </div>
    </x-slot>

    <div class="py-12 movies-index-page">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <!-- Results Info -->
                    <div class="mb-6 flex items-center justify-between border-b border-gray-200 pb-4">
                        <div class="flex items-center space-x-4">
                            <p class="text-gray-600">
                                <span class="font-semibold text-blue-700">{{ $movies->total() }}</span> phim được tìm thấy
                                @if(request('search'))
                                    cho từ khóa "<span class="font-medium text-blue-600">{{ request('search') }}</span>"
                                @endif
                            </p>
                        </div>
                        
                        @if(request('search') || request('sort'))
                            <a href="{{ route('movies.index') }}" 
                               class="text-sm text-blue-600 hover:text-blue-800 font-medium flex items-center space-x-1">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                                <span>Xóa bộ lọc</span>
                            </a>
                        @endif
                    </div>

                    @if($movies->count() > 0)
                        <!-- Movies Grid -->
                        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-6">
                            @foreach($movies as $movie)
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

                                    @auth
                                        <!-- Watchlist Button -->
                                        <div class="absolute top-2 right-2 opacity-0 group-hover:opacity-100 transition-opacity duration-300 z-10">
                                            <button id="watchlist-btn-{{ $movie->id }}"
                                                    class="watchlist-btn p-2 rounded-full shadow-lg transition-all duration-200 {{ auth()->user()->hasInWatchlist($movie->id) ? 'bg-red-500 hover:bg-red-600' : 'bg-blue-600 hover:bg-blue-700' }} text-white"
                                                    data-movie-id="{{ $movie->id }}"
                                                    data-in-watchlist="{{ auth()->user()->hasInWatchlist($movie->id) ? 'true' : 'false' }}">
                                                @if(auth()->user()->hasInWatchlist($movie->id))
                                                    <!-- Heart Icon (In Watchlist) -->
                                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd" d="M3.172 5.172a4 4 0 0 15.656 0L10 6.343l1.172-1.171a4 4 0 1 15.656 5.656L10 17.657l-6.828-6.829a4 4 0 0 10-5.656z" clip-rule="evenodd"></path>
                                                    </svg>
                                                @else
                                                    <!-- Plus Icon (Add to Watchlist) -->
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                                    </svg>
                                                @endif
                                            </button>
                                        </div>
                                    @endauth

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
                        @if($movies->hasPages())
                            <div class="mt-8 flex justify-center">
                                {{ $movies->links() }}
                            </div>
                        @endif
                    @else
                        <!-- Empty State -->
                        <div class="text-center py-16">
                            <div class="w-20 h-20 mx-auto mb-6 bg-gray-100 rounded-full flex items-center justify-center">
                                @if(request('search'))
                                    <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                    </svg>
                                @else
                                    <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 4V2a1 1 0 011-1h8a1 1 0 011 1v2h4a1 1 0 011 1v16a1 1 0 01-1 1H6a1 1 0 01-1-1V5a1 1 0 011-1h1z"></path>
                                    </svg>
                                @endif
                            </div>
                            @if(request('search'))
                                <h3 class="text-xl font-semibold text-gray-800 mb-2">Không tìm thấy phim nào</h3>
                                <p class="text-gray-600 mb-4">Không có phim nào phù hợp với từ khóa "<span class="font-medium">{{ request('search') }}</span>".</p>
                                <a href="{{ route('movies.index') }}" 
                                   class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition-colors duration-200 space-x-2">
                                    <span>Xem tất cả phim</span>
                                </a>
                            @else
                                <h3 class="text-xl font-semibold text-gray-800 mb-2">Chưa có phim nào</h3>
                                <p class="text-gray-600">Hệ thống chưa có phim nào được thêm vào.</p>
                            @endif
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    @vite(['resources/js/app.js'])
</x-app-layout>