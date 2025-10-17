// Admin Users Watchlist Management
class AdminUsersWatchlistManager {
    constructor() {
        this.init();
    }

    init() {
        this.csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
        if (!this.csrfToken) {
            console.warn('CSRF token not found. Admin watchlist functionality may not work.');
        }
        
        // Debug info on page load
        document.addEventListener('DOMContentLoaded', () => {
            console.log('Admin Users Watchlist page loaded');
            this.debugInfo();
        });
    }

    async removeFromWatchlist(userId, movieId) {
        if (!confirm('Bạn có chắc chắn muốn xóa phim này khỏi watchlist của user không?')) {
            return;
        }

        if (!this.csrfToken) {
            this.showNotification('Lỗi: Không tìm thấy CSRF token!', 'error');
            return;
        }

        // Show loading state
        const button = event.target.closest('button');
        if (!button) {
            this.showNotification('Lỗi: Không tìm thấy button!', 'error');
            return;
        }

        const originalContent = button.innerHTML;
        button.innerHTML = '<div class="w-4 h-4 border-2 border-red-400 border-t-transparent rounded-full animate-spin"></div>';
        button.disabled = true;

        try {
            // Use Laravel route helper directly from template
            const removeUrl = window.adminWatchlistRemoveRoute || '/admin/watchlists/remove';
            
            const response = await fetch(removeUrl, {
                method: 'DELETE',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': this.csrfToken,
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    user_id: userId,
                    movie_id: movieId
                })
            });

            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }

            const data = await response.json();
            
            if (data.success) {
                // Remove the row from table with animation
                const row = button.closest('tr');
                if (row) {
                    row.style.transition = 'all 0.3s ease';
                    row.style.opacity = '0.5';
                    row.style.transform = 'translateX(-20px)';
                    
                    setTimeout(() => {
                        row.remove();
                        this.updateWatchlistCount();
                        this.showNotification(data.message || 'Đã xóa phim khỏi watchlist thành công!', 'success');
                    }, 300);
                }
            } else {
                throw new Error(data.message || 'Có lỗi xảy ra');
            }
        } catch (error) {
            console.error('Error:', error);
            this.showNotification(error.message || 'Có lỗi xảy ra khi xóa phim!', 'error');
            
            // Restore button
            button.innerHTML = originalContent;
            button.disabled = false;
        }
    }

    updateWatchlistCount() {
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

    showNotification(message, type = 'success') {
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

    debugInfo() {
        console.log('CSRF Token:', this.csrfToken);
        console.log('Remove Route URL:', window.adminWatchlistRemoveRoute);
    }
}

// Initialize admin users watchlist manager
const adminUsersWatchlistManager = new AdminUsersWatchlistManager();

// Global functions for backward compatibility
window.removeFromWatchlist = (userId, movieId) => adminUsersWatchlistManager.removeFromWatchlist(userId, movieId);
window.updateWatchlistCount = () => adminUsersWatchlistManager.updateWatchlistCount();
window.showNotification = (message, type) => adminUsersWatchlistManager.showNotification(message, type);
window.debugInfo = () => adminUsersWatchlistManager.debugInfo();