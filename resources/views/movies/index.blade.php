<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-blue-900 leading-tight">
            {{ __('Movies') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="card">
                <div class="card-body">
                    <div class="grid grid-cols-1 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 xl:grid-cols-6 gap-8">
                        @forelse ($movies as $movie)
                            <div class="movie-card group flex justify-between bg-white rounded-lg overflow-hidden shadow-lg border border-blue-200 hover:border-blue-400 transition-all duration-300">
                                @if($movie->poster_url)
                                    <div class="relative overflow-hidden">
                                        <img src="{{ $movie->poster_url }}" alt="{{ $movie->title }}" 
                                             class="w-48 h-48 object-cover group-hover:scale-105 transition-transform duration-300">
                                        <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-30 transition-all duration-300"></div>
                                        
                                        @auth
                                            <!-- Watchlist Button (chỉ hiện khi hover) -->
                                            <div class="absolute top-2 right-2 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                                <button onclick="toggleWatchlist({{ $movie->id }})" 
                                                        id="watchlist-btn-{{ $movie->id }}"
                                                        class="watchlist-btn bg-blue-600 hover:bg-blue-700 text-white p-2 rounded-full shadow-lg transition-all duration-200 {{ auth()->user()->hasInWatchlist($movie->id) ? 'bg-red-500 hover:bg-red-600' : '' }}"
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
                                    </div>
                                @else
                                    <div class="relative w-full h-48 bg-blue-50 flex items-center justify-center border-2 border-dashed border-blue-300">
                                        <span class="text-blue-500 text-sm">🎬 No Poster</span>
                                        
                                        @auth
                                            <!-- Watchlist Button for no poster movies -->
                                            <div class="absolute top-2 right-2 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                                <button onclick="toggleWatchlist({{ $movie->id }})" 
                                                        id="watchlist-btn-{{ $movie->id }}"
                                                        class="watchlist-btn bg-blue-600 hover:bg-blue-700 text-white p-2 rounded-full shadow-lg transition-all duration-200 {{ auth()->user()->hasInWatchlist($movie->id) ? 'bg-red-500 hover:bg-red-600' : '' }}"
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
                                    </div>
                                @endif
                                
                                <div class="p-3">
                                    <h3 class="font-semibold text-sm mb-2 truncate text-blue-900 group-hover:text-blue-600 transition-colors duration-300" title="{{ $movie->title }}">
                                        {{ $movie->title }}
                                    </h3>
                                    
                                    <div class="flex items-center justify-between mb-2">
                                        <p class="text-blue-600 text-xs">{{ $movie->release_year }}</p>
                                        <div class="flex items-center">
                                            <span class="star-rating text-sm">★</span>
                                            <span class="ml-1 text-xs text-blue-700">{{ number_format($movie->average_rating, 1) }}</span>
                                        </div>
                                    </div>
                                    
                                    @if($movie->genre)
                                        <p class="text-blue-500 text-xs mb-2 truncate" title="{{ $movie->genre }}">{{ $movie->genre }}</p>
                                    @endif
                                    
                                    <p class="text-blue-600 text-xs mb-3 line-clamp-2" title="{{ $movie->description }}">
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

    <script>
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