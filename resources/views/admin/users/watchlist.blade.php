<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div class="flex items-center space-x-4">
                <a href="{{ route('admin.users.index') }}" class="text-blue-600 hover:text-blue-800 transition duration-200">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                </a>
                <div>
                    <h2 class="font-semibold text-xl text-blue-800 leading-tight">
                        Watchlist của {{ $user->name }}
                    </h2>
                    <p class="text-blue-600 text-sm">{{ $user->email }}</p>
                </div>
            </div>
            <div class="flex items-center space-x-3">
                <span class="bg-purple-100 text-purple-800 px-3 py-1 rounded-full text-sm font-medium">
                    {{ $watchlistMovies->total() }} phim
                </span>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    @if($watchlistMovies->count() > 0)
                        <!-- Movies List Table -->
                        <div class="overflow-x-auto">
                            <table class="min-w-full table-auto border-collapse">
                                <thead>
                                    <tr class="bg-gray-50 border-b border-gray-200">
                                        <th class="text-left py-4 px-6 font-semibold text-gray-700">#</th>
                                        <th class="text-left py-4 px-6 font-semibold text-gray-700">Poster</th>
                                        <th class="text-left py-4 px-6 font-semibold text-gray-700">Tên phim</th>
                                        <th class="text-left py-4 px-6 font-semibold text-gray-700">Đạo diễn</th>
                                        <th class="text-left py-4 px-6 font-semibold text-gray-700">Năm</th>
                                        <th class="text-left py-4 px-6 font-semibold text-gray-700">Thời lượng</th>
                                        <th class="text-left py-4 px-6 font-semibold text-gray-700">Đánh giá</th>
                                        <th class="text-left py-4 px-6 font-semibold text-gray-700">Thêm ngày</th>
                                        <th class="text-left py-4 px-6 font-semibold text-gray-700">Hành động</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200">
                                    @foreach($watchlistMovies as $index => $movie)
                                        <tr class="hover:bg-gray-50 transition-colors duration-200">
                                            <!-- Index -->
                                            <td class="py-4 px-6 text-gray-600">
                                                {{ ($watchlistMovies->currentPage() - 1) * $watchlistMovies->perPage() + $index + 1 }}
                                            </td>

                                            <!-- Poster -->
                                            <td class="py-4 px-6">
                                                @if($movie->poster_url)
                                                    <img src="{{ $movie->poster_url }}" 
                                                         alt="{{ $movie->title }}" 
                                                         class="w-12 h-16 object-cover rounded shadow-sm">
                                                @else
                                                    <div class="w-12 h-16 bg-gray-200 rounded flex items-center justify-center">
                                                        <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 4V2a1 1 0 011-1h8a1 1 0 011 1v2h4a1 1 0 011 1v16a1 1 0 01-1 1H6a1 1 0 01-1-1V5a1 1 0 011-1h1z"></path>
                                                        </svg>
                                                    </div>
                                                @endif
                                            </td>

                                            <!-- Movie Title -->
                                            <td class="py-4 px-6">
                                                <div>
                                                    <a href="{{ route('movies.show', $movie) }}" target="_blank" 
                                                       class="text-blue-600 hover:text-blue-800 font-semibold transition-colors duration-200">
                                                        {{ $movie->title }}
                                                    </a>
                                                    @if($movie->genre)
                                                        <p class="text-sm text-gray-500 mt-1">{{ $movie->genre }}</p>
                                                    @endif
                                                </div>
                                            </td>

                                            <!-- Director -->
                                            <td class="py-4 px-6">
                                                <span class="text-gray-700">
                                                    {{ $movie->director ?: '-' }}
                                                </span>
                                            </td>

                                            <!-- Release Year -->
                                            <td class="py-4 px-6">
                                                <span class="text-gray-700">{{ $movie->release_year }}</span>
                                            </td>

                                            <!-- Duration -->
                                            <td class="py-4 px-6">
                                                <span class="text-gray-700">
                                                    {{ $movie->duration ? $movie->duration . ' phút' : '-' }}
                                                </span>
                                            </td>

                                            <!-- Rating -->
                                            <td class="py-4 px-6">
                                                @if(isset($movie->ratings_avg_score) && $movie->ratings_avg_score)
                                                    <div class="flex items-center space-x-1">
                                                        <svg class="w-4 h-4 text-yellow-500" fill="currentColor" viewBox="0 0 20 20">
                                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                                        </svg>
                                                        <span class="text-yellow-600 font-medium">{{ number_format($movie->ratings_avg_score, 1) }}</span>
                                                        <span class="text-gray-500 text-sm">({{ $movie->ratings_count ?? 0 }})</span>
                                                    </div>
                                                @else
                                                    <span class="text-gray-500">Chưa có</span>
                                                @endif
                                            </td>

                                            <!-- Added Date -->
                                            <td class="py-4 px-6">
                                                <div>
                                                    <span class="text-gray-700">{{ $movie->pivot->created_at->format('d/m/Y') }}</span>
                                                    <p class="text-xs text-gray-500">{{ $movie->pivot->created_at->format('H:i') }}</p>
                                                </div>
                                            </td>

                                            <!-- Actions -->
                                            <td class="py-4 px-6">
                                                <div class="flex items-center space-x-2">
                                                    <a href="{{ route('movies.show', $movie) }}" target="_blank"
                                                       class="text-blue-600 hover:text-blue-800 text-sm bg-blue-100 px-2 py-1 rounded transition-colors duration-200"
                                                       title="Xem chi tiết phim">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                                        </svg>
                                                    </a>
                                                    <button onclick="removeFromWatchlist({{ $user->id }}, {{ $movie->id }})" 
                                                            class="text-red-600 hover:text-red-800 text-sm bg-red-100 px-2 py-1 rounded transition-colors duration-200"
                                                            title="Xóa khỏi watchlist">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                        </svg>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
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
                            <div class="w-24 h-24 mx-auto mb-6 bg-gray-100 rounded-full flex items-center justify-center">
                                <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                                </svg>
                            </div>
                            <h3 class="text-2xl font-bold text-gray-800 mb-4">Watchlist trống</h3>
                            <p class="text-gray-600 mb-8 max-w-md mx-auto">
                                {{ $user->name }} chưa thêm phim nào vào watchlist.
                            </p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <script>
        function removeFromWatchlist(userId, movieId) {
            if (!confirm('Bạn có chắc chắn muốn xóa phim này khỏi watchlist của user không?')) {
                return;
            }

            // Get CSRF token
            const csrfToken = document.querySelector('meta[name="csrf-token"]');
            if (!csrfToken) {
                showNotification('Lỗi: Không tìm thấy CSRF token!', 'error');
                return;
            }

            // Show loading state
            const button = event.target.closest('button');
            if (!button) {
                showNotification('Lỗi: Không tìm thấy button!', 'error');
                return;
            }

            const originalContent = button.innerHTML;
            button.innerHTML = '<div class="w-4 h-4 border-2 border-red-400 border-t-transparent rounded-full animate-spin"></div>';
            button.disabled = true;

            // Make request
            fetch(`{{ route('admin.watchlists.remove') }}`, {
                method: 'DELETE',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken.getAttribute('content'),
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    user_id: userId,
                    movie_id: movieId
                })
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    // Remove the row from table with animation
                    const row = button.closest('tr');
                    if (row) {
                        row.style.transition = 'all 0.3s ease';
                        row.style.opacity = '0.5';
                        row.style.transform = 'translateX(-20px)';
                        
                        setTimeout(() => {
                            row.remove();
                            updateWatchlistCount();
                            showNotification(data.message || 'Đã xóa phim khỏi watchlist thành công!', 'success');
                        }, 300);
                    }
                } else {
                    throw new Error(data.message || 'Có lỗi xảy ra');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showNotification(error.message || 'Có lỗi xảy ra khi xóa phim!', 'error');
                
                // Restore button
                button.innerHTML = originalContent;
                button.disabled = false;
            });
        }

        function updateWatchlistCount() {
            const remainingRows = document.querySelectorAll('tbody tr').length;
            
            // Update count badge
            const countBadge = document.querySelector('.bg-purple-100');
            if (countBadge) {
                countBadge.textContent = `${remainingRows} phim`;
            }
            
            // If no movies left, show empty state after delay
            if (remainingRows === 0) {
                setTimeout(() => {
                    location.reload(); // Reload to show empty state
                }, 1000);
            }
        }

        function showNotification(message, type = 'success') {
            // Remove any existing notifications
            const existingNotifications = document.querySelectorAll('.notification-toast');
            existingNotifications.forEach(n => n.remove());

            // Create notification element
            const notification = document.createElement('div');
            notification.className = `notification-toast fixed top-4 right-4 z-50 p-4 rounded-lg shadow-lg transition-all duration-300 transform translate-x-full ${
                type === 'success' ? 'bg-green-500 text-white' : 'bg-red-500 text-white'
            }`;
            notification.innerHTML = `
                <div class="flex items-center space-x-2">
                    <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        ${type === 'success' 
                            ? '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>'
                            : '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>'
                        }
                    </svg>
                    <span>${message}</span>
                </div>
            `;
            
            document.body.appendChild(notification);
            
            // Show notification
            setTimeout(() => {
                notification.classList.remove('translate-x-full');
            }, 100);
            
            // Hide notification after 4 seconds
            setTimeout(() => {
                notification.classList.add('translate-x-full');
                setTimeout(() => {
                    if (document.body.contains(notification)) {
                        document.body.removeChild(notification);
                    }
                }, 300);
            }, 4000);
        }

        // Debug function
        function debugInfo() {
            console.log('CSRF Token:', document.querySelector('meta[name="csrf-token"]')?.getAttribute('content'));
            console.log('Route URL:', '{{ route('admin.watchlists.remove') }}');
        }

        // Call debug on page load
        document.addEventListener('DOMContentLoaded', function() {
            console.log('Watchlist page loaded');
            debugInfo();
        });
    </script>
</x-app-layout>