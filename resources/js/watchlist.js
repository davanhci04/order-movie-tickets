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
        
        // Check for duplicate IDs on page load
        this.checkForDuplicateIds();
        
        // Also attach event listeners as backup
        this.attachEventListeners();
    }
    
    attachEventListeners() {
        document.querySelectorAll('[id*="watchlist-btn"]').forEach(button => {
            // Skip remove buttons - they're handled by movies-watchlist.js
            if (button.id.includes('remove-watchlist-btn')) {
                return;
            }
            
            // Remove existing listener if any
            button.removeEventListener('click', this.handleButtonClick);
            
            // Add new listener with double-click prevention
            button.addEventListener('click', (e) => {
                e.preventDefault();
                e.stopPropagation();
                
                // Prevent double-clicks
                if (button.disabled) {
                    console.log('Button already disabled, ignoring click');
                    return;
                }
                
                // Skip remove buttons - they're handled by movies-watchlist.js
                if (button.id.includes('remove-watchlist-btn')) {
                    return;
                }
                
                const movieId = this.extractMovieId(button.id);
                if (movieId) {
                    console.log('Click detected on button:', button.id, 'movieId:', movieId);
                    this.toggle(movieId);
                }
            });
        });
    }
    
    extractMovieId(buttonId) {
        // Extract movie ID from button ID
        const patterns = [
            /watchlist-btn-(\d+)/,
            /hero-watchlist-btn-(\d+)/,
            /top-rated-watchlist-btn-(\d+)/,
            /recent-watchlist-btn-(\d+)/,
            /recommended-watchlist-btn-(\d+)/
        ];
        
        for (const pattern of patterns) {
            const match = buttonId.match(pattern);
            if (match) {
                return parseInt(match[1]);
            }
        }
        return null;
    }
    
    checkForDuplicateIds() {
        const watchlistButtons = document.querySelectorAll('[id*="watchlist-btn"]');
        const ids = [];
        const duplicates = [];
        
        watchlistButtons.forEach(btn => {
            if (ids.includes(btn.id)) {
                duplicates.push(btn.id);
            } else {
                ids.push(btn.id);
            }
        });
        
        if (duplicates.length > 0) {
            console.error('Duplicate watchlist button IDs found:', duplicates);
        }
        
        // Only log button count, not all IDs
        console.log('Watchlist buttons found:', ids.length);
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
        // Check each possible button ID and log which one is found
        const buttonIds = [
            `watchlist-btn-${movieId}`,
            `hero-watchlist-btn-${movieId}`,
            `top-rated-watchlist-btn-${movieId}`,
            `recent-watchlist-btn-${movieId}`,
            `recommended-watchlist-btn-${movieId}`
        ];
        
        for (const id of buttonIds) {
            const button = document.getElementById(id);
            if (button) {
                return button;
            }
        }
        
        console.error('No watchlist button found for movie ID:', movieId);
        return null;
    }

    updateButtonState(button, inWatchlist) {
        const isHeroButton = button.id.includes('hero-watchlist-btn');
        const isDetailPageButton = button.classList.contains('inline-flex');
        
        console.log('Updating button:', button.id, 'isHero:', isHeroButton, 'isDetailPage:', isDetailPageButton, 'inWatchlist:', inWatchlist);
        
        if (isHeroButton) {
            this.updateHeroButton(button, inWatchlist);
        } else if (isDetailPageButton) {
            this.updateDetailPageButton(button, inWatchlist);
        } else {
            this.updateSectionButton(button, inWatchlist);
        }
    }

    updateHeroButton(button, inWatchlist) {
        const svg = button.querySelector('svg');
        if (!svg) return;
        
        if (inWatchlist) {
            // Style for "In watchlist" - checkmark icon, GREEN background
            button.className = 'bg-green-500 hover:bg-green-600 text-white border-2 border-green-400 p-3 rounded-lg transition-all duration-300 shadow-lg';
            button.title = 'Đã thêm vào danh sách xem';
            
            // Update to checkmark icon
            svg.setAttribute('class', 'w-6 h-6');
            svg.setAttribute('fill', 'none');
            svg.setAttribute('stroke', 'currentColor');
            svg.setAttribute('viewBox', '0 0 24 24');
            svg.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>';
        } else {
            // Style for "Add to watchlist" - plus icon, blue background
            button.className = 'bg-blue-600 hover:bg-blue-700 text-white border-2 border-blue-500 p-3 rounded-lg transition-all duration-300 hover:scale-105 shadow-lg';
            button.title = 'Thêm vào danh sách xem';
            
            // Update to plus icon
            svg.setAttribute('class', 'w-6 h-6');
            svg.setAttribute('fill', 'none');
            svg.setAttribute('stroke', 'currentColor');
            svg.setAttribute('viewBox', '0 0 24 24');
            svg.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>';
        }
    }

    updateSectionButton(button, inWatchlist) {
        // IMMEDIATELY clean button content first to prevent text flashing
        const existingTextNodes = Array.from(button.childNodes).filter(node => node.nodeType === Node.TEXT_NODE);
        existingTextNodes.forEach(node => node.remove());
        const existingSpans = button.querySelectorAll('span');
        existingSpans.forEach(span => span.remove());
        
        console.log('updateSectionButton called for:', button.id, 'inWatchlist:', inWatchlist);
        
        // Remove all existing background classes first
        button.classList.remove('bg-blue-600', 'hover:bg-blue-700', 'bg-red-500', 'hover:bg-red-600');
        
        // Find existing SVG element
        const svg = button.querySelector('svg');
        console.log('Found SVG:', svg);
        
        if (inWatchlist) {
            // Added to watchlist - RED heart with immediate effect
            button.classList.add('bg-red-500', 'hover:bg-red-600');
            button.title = 'Xóa khỏi danh sách xem';
            
            // Update SVG to heart icon
            if (svg) {
                svg.setAttribute('class', 'w-4 h-4');
                svg.setAttribute('fill', 'currentColor');
                svg.setAttribute('viewBox', '0 0 20 20');
                svg.removeAttribute('stroke');
                svg.removeAttribute('stroke-linecap');
                svg.removeAttribute('stroke-linejoin');
                svg.removeAttribute('stroke-width');
                svg.innerHTML = '<path fill-rule="evenodd" d="M3.172 5.172a4 4 0 0 15.656 0L10 6.343l1.172-1.171a4 4 0 1 15.656 5.656L10 17.657l-6.828-6.829a4 4 0 0 10-5.656z" clip-rule="evenodd"></path>';
                console.log('Updated to heart icon');
                
                // Force clean button - only SVG
                button.innerHTML = svg.outerHTML;
            }
            
        } else {
            // Removed from watchlist - BLUE plus with immediate effect
            button.classList.add('bg-blue-600', 'hover:bg-blue-700');
            button.title = 'Thêm vào danh sách xem';
            
            // Update SVG to plus icon
            if (svg) {
                svg.setAttribute('class', 'w-4 h-4');
                svg.removeAttribute('fill');
                svg.setAttribute('stroke', 'currentColor');
                svg.setAttribute('viewBox', '0 0 24 24');
                svg.setAttribute('stroke-linecap', 'round');
                svg.setAttribute('stroke-linejoin', 'round');
                svg.setAttribute('stroke-width', '2');
                svg.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>';
                console.log('Updated to plus icon');
                
                // Force clean button - only SVG  
                button.innerHTML = svg.outerHTML;
            }
        }
    }

    updateDetailPageButton(button, inWatchlist) {
        // Remove existing background classes
        button.classList.remove('bg-blue-600', 'hover:bg-blue-700', 'bg-red-600', 'hover:bg-red-700');
        
        const svg = button.querySelector('svg');
        const textSpan = button.querySelector('span:last-child');
        
        if (inWatchlist) {
            // In watchlist - RED background with heart icon
            button.classList.add('bg-red-600', 'hover:bg-red-700');
            button.title = 'Xóa khỏi danh sách xem';
            
            if (textSpan) textSpan.textContent = 'Đã thêm';
            
            if (svg) {
                svg.setAttribute('fill', 'currentColor');
                svg.setAttribute('viewBox', '0 0 20 20');
                svg.removeAttribute('stroke');
                svg.innerHTML = '<path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" clip-rule="evenodd"></path>';
            }
        } else {
            // Not in watchlist - BLUE background with plus icon
            button.classList.add('bg-blue-600', 'hover:bg-blue-700');
            button.title = 'Thêm vào danh sách xem';
            
            if (textSpan) textSpan.textContent = 'Thêm vào danh sách';
            
            if (svg) {
                svg.removeAttribute('fill');
                svg.setAttribute('stroke', 'currentColor');
                svg.setAttribute('viewBox', '0 0 24 24');
                svg.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>';
            }
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

// No global functions - using event-driven approach only