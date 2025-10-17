// Movies Index Page - Watchlist Management
class MoviesIndexManager {
    constructor() {
        this.init();
    }

    init() {
        this.csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
        if (!this.csrfToken) {
            console.warn('CSRF token not found. Watchlist functionality may not work.');
        }
    }

    async toggleWatchlist(movieId) {
        const button = document.getElementById(`watchlist-btn-${movieId}`);
        if (!button) {
            console.error('Watchlist button not found for movie ID:', movieId);
            return;
        }

        // Disable button temporarily
        button.disabled = true;
        button.classList.add('opacity-50');

        try {
            const response = await fetch(`/movies/${movieId}/watchlist`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': this.csrfToken
                }
            });

            const data = await response.json();
            
            if (data.success) {
                this.updateButtonState(button, data.inWatchlist);
                this.showSuccessMessage(data.message);
            } else {
                alert(data.message || 'Có lỗi xảy ra');
            }
        } catch (error) {
            console.error('Error:', error);
            alert('Có lỗi xảy ra khi thực hiện thao tác');
        } finally {
            // Re-enable button
            button.disabled = false;
            button.classList.remove('opacity-50');
        }
    }

    updateButtonState(button, inWatchlist) {
        if (inWatchlist) {
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
    }

    showSuccessMessage(message) {
        const messageDiv = document.createElement('div');
        messageDiv.className = 'fixed top-4 right-4 bg-green-500 text-white px-4 py-2 rounded-lg shadow-lg z-50';
        messageDiv.textContent = message;
        document.body.appendChild(messageDiv);
        
        setTimeout(() => {
            if (messageDiv.parentNode) {
                messageDiv.remove();
            }
        }, 3000);
    }
}

// Initialize movies index manager
const moviesIndexManager = new MoviesIndexManager();

// Global function for backward compatibility
window.toggleWatchlist = (movieId) => moviesIndexManager.toggleWatchlist(movieId);