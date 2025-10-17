// Watchlist Management
class WatchlistManager {
    constructor() {
        this.init();
    }

    init() {
        // Get CSRF token
        this.csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
        if (!this.csrfToken) {
            console.warn('CSRF token not found. Watchlist functionality may not work.');
        }
    }

    async toggle(movieId) {
        const button = this.findButton(movieId);
        if (!button) {
            console.error('Button not found for movie ID:', movieId);
            return;
        }
        
        // Disable button temporarily
        button.disabled = true;
        const originalOpacity = button.style.opacity;
        button.style.opacity = '0.7';

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
            button.style.opacity = originalOpacity || '1';
        }
    }

    findButton(movieId) {
        return document.getElementById(`hero-watchlist-btn-${movieId}`) ||
               document.getElementById(`top-rated-watchlist-btn-${movieId}`) ||
               document.getElementById(`recent-watchlist-btn-${movieId}`) ||
               document.getElementById(`recommended-watchlist-btn-${movieId}`) ||
               document.getElementById(`watchlist-btn-${movieId}`);
    }

    updateButtonState(button, inWatchlist) {
        const isHeroButton = button.id.includes('hero-watchlist-btn');
        
        if (isHeroButton) {
            this.updateHeroButton(button, inWatchlist);
        } else {
            this.updateSectionButton(button, inWatchlist);
        }
    }

    updateHeroButton(button, inWatchlist) {
        const svg = button.querySelector('svg');
        if (inWatchlist) {
            // Style for "In watchlist" - checkmark icon, GREEN background
            button.className = 'bg-green-500 hover:bg-green-600 text-white border-2 border-green-400 p-3 rounded-lg transition-all duration-200 shadow-lg';
            svg.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>';
            svg.setAttribute('fill', 'none');
            svg.setAttribute('stroke', 'currentColor');
        } else {
            // Style for "Add to watchlist" - plus icon, blue background
            button.className = 'bg-blue-600 hover:bg-blue-700 text-white border-2 border-blue-500 p-3 rounded-lg transition-all duration-200 hover:scale-105 shadow-lg';
            svg.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>';
            svg.setAttribute('fill', 'none');
            svg.setAttribute('stroke', 'currentColor');
        }
    }

    updateSectionButton(button, inWatchlist) {
        // Remove all existing background classes first
        button.classList.remove('bg-blue-600', 'hover:bg-blue-700', 'bg-red-500', 'hover:bg-red-600');
        
        if (inWatchlist) {
            // Added to watchlist - RED heart with immediate effect
            button.classList.add('bg-red-500', 'hover:bg-red-600');
            button.title = 'Xóa khỏi danh sách xem';
            button.innerHTML = `
                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" clip-rule="evenodd"></path>
                </svg>
            `;
            // Force immediate style application
            button.style.backgroundColor = '#ef4444';
            setTimeout(() => { button.style.backgroundColor = ''; }, 100);
        } else {
            // Removed from watchlist - BLUE plus with immediate effect
            button.classList.add('bg-blue-600', 'hover:bg-blue-700');
            button.title = 'Thêm vào danh sách xem';
            button.innerHTML = `
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                </svg>
            `;
            // Force immediate style application
            button.style.backgroundColor = '#2563eb';
            setTimeout(() => { button.style.backgroundColor = ''; }, 100);
        }
    }

    showSuccessMessage(message) {
        const messageDiv = document.createElement('div');
        messageDiv.className = 'fixed top-4 right-4 bg-green-500 text-white px-6 py-3 rounded-lg shadow-xl z-50 border border-green-400';
        messageDiv.style.fontWeight = 'bold';
        messageDiv.textContent = message;
        document.body.appendChild(messageDiv);
        
        setTimeout(() => {
            if (messageDiv.parentNode) {
                messageDiv.remove();
            }
        }, 3000);
    }
}

// Initialize watchlist manager
const watchlistManager = new WatchlistManager();

// Global function for backward compatibility
window.toggleWatchlist = (movieId) => watchlistManager.toggle(movieId);