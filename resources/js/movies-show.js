// Movies Show Page - Watchlist Management & Confirmation Dialogs
class MoviesShowManager {
    constructor() {
        this.init();
    }

    init() {
        this.csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
        if (!this.csrfToken) {
            console.warn('CSRF token not found. Some functionality may not work.');
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
                this.updateWatchlistButton(button, data.inWatchlist);
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

    updateWatchlistButton(button, inWatchlist) {
        if (inWatchlist) {
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
    }

    showSuccessMessage(message) {
        const messageDiv = document.createElement('div');
        messageDiv.className = 'fixed top-4 right-4 bg-green-600 text-white px-6 py-3 rounded-lg shadow-lg z-50 border border-green-500';
        messageDiv.textContent = message;
        document.body.appendChild(messageDiv);
        
        setTimeout(() => {
            if (messageDiv.parentNode) {
                messageDiv.remove();
            }
        }, 3000);
    }

    // Confirmation dialog for delete actions
    confirmDelete(message = 'Are you sure?') {
        return confirm(message);
    }
}

// Initialize movies show manager
const moviesShowManager = new MoviesShowManager();

// Global functions for backward compatibility
window.toggleWatchlist = (movieId) => moviesShowManager.toggleWatchlist(movieId);

// Enhanced confirmation function for delete buttons
window.confirmDelete = (message) => moviesShowManager.confirmDelete(message);