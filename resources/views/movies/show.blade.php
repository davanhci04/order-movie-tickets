<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-100 leading-tight">
                {{ $movie->title }}
            </h2>
            <a href="{{ route('movies.index') }}" class="text-red-400 hover:text-red-300 transition duration-200">
                ← Back to Movies
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
            <!-- Movie Details -->
            <div class="card mb-8">
                <div class="card-body">
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                        <!-- Poster -->
                        <div class="md:col-span-1">
                            @if($movie->poster_url)
                                <img src="{{ $movie->poster_url }}" alt="{{ $movie->title }}" class="w-full h-auto max-h-80 object-cover rounded-lg shadow-lg border border-gray-600">
                            @else
                                <div class="w-full h-80 bg-dark-700 rounded-lg flex items-center justify-center border-2 border-dashed border-gray-600">
                                    <span class="text-gray-500 text-lg">🎦 No Poster Available</span>
                                </div>
                            @endif
                        </div>
                        
                        <!-- Movie Info -->
                        <div class="md:col-span-3">
                            <h1 class="text-3xl font-bold mb-4 text-gray-100">{{ $movie->title }}</h1>
                            
                            <div class="grid grid-cols-2 gap-4 mb-6 text-gray-300">
                                <div>
                                    <span class="font-semibold text-red-400">Release Year:</span>
                                    <span>{{ $movie->release_year }}</span>
                                </div>
                                
                                @if($movie->genre)
                                <div>
                                    <span class="font-semibold text-red-400">Genre:</span>
                                    <span>{{ $movie->genre }}</span>
                                </div>
                                @endif
                                
                                @if($movie->duration)
                                <div>
                                    <span class="font-semibold text-red-400">Duration:</span>
                                    <span>{{ $movie->duration }} minutes</span>
                                </div>
                                @endif
                                
                                @if($movie->director)
                                <div>
                                    <span class="font-semibold text-red-400">Director:</span>
                                    <span>{{ $movie->director }}</span>
                                </div>
                                @endif
                            </div>
                            
                            <!-- Watchlist and Rating -->
                            <div class="mb-6">
                                @auth
                                    <!-- Watchlist Button -->
                                    <div class="mb-4">
                                        <button onclick="toggleWatchlist({{ $movie->id }})" 
                                                id="watchlist-btn-{{ $movie->id }}"
                                                class="watchlist-btn inline-flex items-center px-4 py-2 rounded-lg font-medium transition-all duration-200 {{ auth()->user()->hasInWatchlist($movie->id) ? 'bg-red-600 hover:bg-red-700 text-white' : 'bg-blue-600 hover:bg-blue-700 text-white' }}"
                                                title="{{ auth()->user()->hasInWatchlist($movie->id) ? 'Xóa khỏi danh sách xem' : 'Thêm vào danh sách xem' }}">
                                            @if(auth()->user()->hasInWatchlist($movie->id))
                                                <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" clip-rule="evenodd"></path>
                                                </svg>
                                                Đã thêm vào danh sách xem
                                            @else
                                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                                </svg>
                                                Thêm vào danh sách xem
                                            @endif
                                        </button>
                                    </div>
                                @endauth
                                
                                <!-- Rating -->
                                <div class="flex items-center mb-4">
                                    <span class="star-rating text-3xl">★</span>
                                    <span class="ml-2 text-xl font-semibold text-gray-100">{{ number_format($movie->average_rating, 1) }}/10</span>
                                    <span class="ml-2 text-gray-400">({{ $movie->ratings->count() }} {{ Str::plural('rating', $movie->ratings->count()) }})</span>
                                </div>
                                
                                @auth
                                    <!-- User Rating Form -->
                                    <form action="{{ route('movies.rate', $movie) }}" method="POST" class="mb-4">
                                        @csrf
                                        <div class="flex items-center gap-4">
                                            <label for="score" class="font-medium text-gray-300">Your Rating:</label>
                                            <select name="score" id="score" class="bg-dark-700 border-gray-600 text-gray-100 rounded px-3 py-1 focus:border-red-500 focus:ring-red-500" required>
                                                <option value="" class="text-gray-400">Select Rating</option>
                                                @for($i = 1; $i <= 10; $i++)
                                                    <option value="{{ $i }}" {{ $userRating && $userRating->score == $i ? 'selected' : '' }}>
                                                        {{ $i }}
                                                    </option>
                                                @endfor
                                            </select>
                                            <button type="submit" class="btn-primary">
                                                {{ $userRating ? 'Update' : 'Rate' }}
                                            </button>
                                            @if($userRating)
                                                <form action="{{ route('movies.rate.destroy', $movie) }}" method="POST" class="inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-red-400 hover:text-red-300 ml-2 transition duration-200" onclick="return confirm('Are you sure?')">
                                                        Remove Rating
                                                    </button>
                                                </form>
                                            @endif
                                        </div>
                                    </form>
                                @else
                                    <p class="text-gray-400">
                                        <a href="{{ route('login') }}" class="text-red-400 hover:text-red-300 transition duration-200">Login</a> to rate this movie
                                    </p>
                                @endauth
                            </div>
                            
                            <!-- Description -->
                            <div class="mb-6">
                                <h3 class="font-semibold text-lg mb-2 text-red-400">Description</h3>
                                <p class="text-gray-300 leading-relaxed">{{ $movie->description }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Comments Section -->
            <div class="card">
                <div class="card-header">
                    <h3 class="font-semibold text-lg text-gray-100">Comments ({{ $movie->comments->count() }})</h3>
                </div>
                <div class="card-body">
                    @auth
                        <!-- Add Comment Form -->
                        <form action="{{ route('movies.comments.store', $movie) }}" method="POST" class="mb-8 p-4 bg-dark-700 rounded-lg border border-gray-600">
                            @csrf
                            <div class="mb-4">
                                <textarea name="content" rows="3" 
                                         class="w-full bg-dark-800 border-gray-600 text-gray-100 rounded px-3 py-2 focus:border-red-500 focus:ring-red-500" 
                                         placeholder="Write your comment..." required></textarea>
                            </div>
                            <button type="submit" class="btn-primary">
                                Post Comment
                            </button>
                        </form>
                    @else
                        <div class="mb-8 p-4 bg-dark-700 rounded-lg border border-gray-600 text-center">
                            <p class="text-gray-400">
                                <a href="{{ route('login') }}" class="text-red-400 hover:text-red-300 transition duration-200">Login</a> to post a comment
                            </p>
                        </div>
                    @endauth
                    
                    <!-- Comments List -->
                    <div class="space-y-6">
                        @forelse($movie->comments->sortByDesc('created_at') as $comment)
                            <div class="border-b border-gray-700 pb-4">
                                <div class="flex items-center justify-between mb-2">
                                    <div class="flex items-center">
                                        <div class="w-8 h-8 bg-red-600 rounded-full flex items-center justify-center mr-3">
                                            <span class="text-white font-bold text-sm">{{ substr($comment->user->name, 0, 1) }}</span>
                                        </div>
                                        <div>
                                            <span class="font-medium text-gray-100">{{ $comment->user->name }}</span>
                                            <span class="text-gray-500 text-sm ml-2">{{ $comment->created_at->diffForHumans() }}</span>
                                        </div>
                                    </div>
                                    
                                    @auth
                                        @if($comment->user_id == auth()->id() || auth()->user()->isAdmin())
                                            <form action="{{ route('comments.destroy', $comment) }}" method="POST" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-400 hover:text-red-300 text-sm transition duration-200" onclick="return confirm('Are you sure?')">
                                                    Delete
                                                </button>
                                            </form>
                                        @endif
                                    @endauth
                                </div>
                                <p class="text-gray-300 ml-11">{{ $comment->content }}</p>
                            </div>
                        @empty
                            <div class="text-center py-8">
                                <div class="text-4xl text-gray-600 mb-4">💬</div>
                                <p class="text-gray-500">No comments yet. Be the first to comment!</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Success/Error Messages -->
    @if(session('success'))
        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3000)" 
             class="fixed top-4 right-4 bg-green-600 text-white px-6 py-3 rounded-lg shadow-lg z-50 border border-green-500">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3000)" 
             class="fixed top-4 right-4 bg-red-700 text-white px-6 py-3 rounded-lg shadow-lg z-50 border border-red-600">
            {{ session('error') }}
        </div>
    @endif

    <script>
        function toggleWatchlist(movieId) {
            const button = document.getElementById(`watchlist-btn-${movieId}`);
            
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
                        // Added to watchlist
                        button.classList.remove('bg-blue-600', 'hover:bg-blue-700');
                        button.classList.add('bg-red-600', 'hover:bg-red-700');
                        button.title = 'Xóa khỏi danh sách xem';
                        button.innerHTML = `
                            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" clip-rule="evenodd"></path>
                            </svg>
                            Đã thêm vào danh sách xem
                        `;
                    } else {
                        // Removed from watchlist
                        button.classList.remove('bg-red-600', 'hover:bg-red-700');
                        button.classList.add('bg-blue-600', 'hover:bg-blue-700');
                        button.title = 'Thêm vào danh sách xem';
                        button.innerHTML = `
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                            </svg>
                            Thêm vào danh sách xem
                        `;
                    }

                    // Show success message
                    const message = document.createElement('div');
                    message.className = 'fixed top-4 right-4 bg-green-600 text-white px-6 py-3 rounded-lg shadow-lg z-50 border border-green-500';
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