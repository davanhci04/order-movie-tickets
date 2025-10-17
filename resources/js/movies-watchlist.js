// Movies Watchlist Page - Remove from Watchlist Management
class MoviesWatchlistManager {
    constructor() {
        this.init();
        this.attachEventListeners();
    }

    init() {
        // Only initialize on user watchlist page, not admin pages
        if (window.location.pathname.includes('/admin/')) {
            console.log('Admin page detected, skipping Movies Watchlist Manager');
            return;
        }

        this.csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
        if (!this.csrfToken) {
            console.warn('CSRF token not found. Watchlist functionality may not work.');
        }
        console.log('Movies Watchlist Manager initialized');
    }

    attachEventListeners() {
        // Only attach if not admin page
        if (window.location.pathname.includes('/admin/')) {
            return;
        }

        // Use event delegation for better performance
        document.addEventListener('click', (e) => {
            if (e.target.closest('.remove-watchlist-btn')) {
                e.preventDefault();
                e.stopPropagation();
                e.stopImmediatePropagation();
                
                const button = e.target.closest('.remove-watchlist-btn');
                const movieId = button.dataset.movieId;
                if (movieId) {
                    console.log('Remove button clicked for movie:', movieId);
                    this.removeFromWatchlist(movieId);
                }
            }
        }, true); // Use capture phase to handle before other listeners

        const removeButtons = document.querySelectorAll('.remove-watchlist-btn');
        console.log('Remove watchlist buttons found:', removeButtons.length);
    }

    async removeFromWatchlist(movieId) {
        if (!confirm('Bạn có chắc muốn xóa phim này khỏi danh sách xem?')) {
            return;
        }

        console.log('Removing movie from watchlist:', movieId);
        console.log('CSRF Token:', this.csrfToken);

        if (!this.csrfToken) {
            alert('CSRF token không tìm thấy. Vui lòng refresh trang.');
            return;
        }

        try {
            const response = await fetch(`/movies/${movieId}/watchlist`, {
                method: 'DELETE',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': this.csrfToken
                }
            });

            console.log('Response status:', response.status);
            console.log('Response ok:', response.ok);

            if (!response.ok) {
                const errorText = await response.text();
                console.error('HTTP error response:', errorText);
                throw new Error(`HTTP error! status: ${response.status}`);
            }

            const data = await response.json();
            console.log('Response data:', data);
            
            if (data.success) {
                // Show success message before reload
                this.showSuccessMessage(data.message || 'Đã xóa phim khỏi danh sách xem');
                
                // Reload page after a short delay to update the list
                setTimeout(() => {
                    location.reload();
                }, 1000);
            } else {
                alert(data.message || 'Có lỗi xảy ra');
            }
        } catch (error) {
            console.error('Error:', error);
            alert(`Có lỗi xảy ra khi xóa phim: ${error.message}`);
        }
    }

    showSuccessMessage(message) {
        const messageDiv = document.createElement('div');
        messageDiv.className = 'fixed top-4 right-4 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg z-50 border border-green-400';
        messageDiv.style.fontWeight = 'bold';
        messageDiv.textContent = message;
        document.body.appendChild(messageDiv);
        
        setTimeout(() => {
            if (messageDiv.parentNode) {
                messageDiv.remove();
            }
        }, 2000);
    }

    // Enhanced confirmation dialog
    confirmRemoval(message = 'Bạn có chắc muốn xóa phim này khỏi danh sách xem?') {
        return confirm(message);
    }
}

// Initialize movies watchlist manager
const moviesWatchlistManager = new MoviesWatchlistManager();

// No global functions to avoid conflicts with admin scripts