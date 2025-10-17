<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div class="flex items-center space-x-4">
                <h2 class="font-semibold text-xl text-blue-800 leading-tight">
                    Danh sách Phim
                </h2>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
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
                                            <button onclick="toggleWatchlist({{ $movie->id }})" 
                                                    id="watchlist-btn-{{ $movie->id }}"
                                                    class="watchlist-btn p-2 rounded-full shadow-lg transition-all duration-200 {{ auth()->user()->hasInWatchlist($movie->id) ? 'bg-red-500 hover:bg-red-600' : 'bg-blue-600 hover:bg-blue-700' }} text-white"
                                                    title="{{ auth()->user()->hasInWatchlist($movie->id) ? 'Xóa khỏi danh sách xem' : 'Thêm vào danh sách xem' }}">
                                                @if(auth()->user()->hasInWatchlist($movie->id))
                                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" clip-rule="evenodd"></path>
                                                    </svg>
                                                @else
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
                                <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 4V2a1 1 0 011-1h8a1 1 0 011 1v2h4a1 1 0 011 1v16a1 1 0 01-1 1H6a1 1 0 01-1-1V5a1 1 0 011-1h1z"></path>
                                </svg>
                            </div>
                            <h3 class="text-xl font-semibold text-gray-800 mb-2">Chưa có phim nào</h3>
                            <p class="text-gray-600">Hệ thống chưa có phim nào được thêm vào.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>    <script>
        function toggleWatchlist(movieId) {
            const button = document.getElementById(`watchlist-btn-${movieId}`);
            const isInWatchlist = button.classList.contains('bg-red-500');
            
            // Disable button temporarily
            button.disabled = true;
            button.classList.add('opacity-50');

            fetch(`/movies/${movieId}/watchlist`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Update button appearance
                    if (data.inWatchlist) {
                        // Added to watchlist - show filled heart
                        button.classList.remove('bg-blue-600', 'hover:bg-blue-700');
                        button.classList.add('bg-red-500', 'hover:bg-red-600');
                        button.title = 'Xóa khỏi danh sách xem';
                        button.innerHTML = `
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" clip-rule="evenodd"></path>
                            </svg>
                        `;
                    } else {
                        // Removed from watchlist - show plus icon
                        button.classList.remove('bg-red-500', 'hover:bg-red-600');
                        button.classList.add('bg-blue-600', 'hover:bg-blue-700');
                        button.title = 'Thêm vào danh sách xem';
                        button.innerHTML = `
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                            </svg>
                        `;
                    }

                    // Show success message (optional)
                    const message = document.createElement('div');
                    message.className = 'fixed top-4 right-4 bg-green-500 text-white px-4 py-2 rounded-lg shadow-lg z-50';
                    message.textContent = data.message;
                    document.body.appendChild(message);
                    
                    setTimeout(() => {
                        message.remove();
                    }, 3000);
                } else {
                    alert(data.message || 'Có lỗi xảy ra');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Có lỗi xảy ra khi thực hiện thao tác');
            })
            .finally(() => {
                // Re-enable button
                button.disabled = false;
                button.classList.remove('opacity-50');
            });
        }
    </script>
</x-app-layout>