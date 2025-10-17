// Movies Watchlist Page - Remove from Watchlist Management
class MoviesWatchlistManager {
    constructor() {
        this.init();
    }

    init() {
        this.csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
        if (!this.csrfToken) {
            console.warn('CSRF token not found. Watchlist functionality may not work.');
        }
    }

    async removeFromWatchlist(movieId) {
        if (!confirm('Bạn có chắc muốn xóa phim này khỏi danh sách xem?')) {
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

            const data = await response.json();
            
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
            alert('Có lỗi xảy ra khi xóa phim');
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

// Global function for backward compatibility
window.removeFromWatchlist = (movieId) => moviesWatchlistManager.removeFromWatchlist(movieId);