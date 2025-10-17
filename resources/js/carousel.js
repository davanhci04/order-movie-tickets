// Carousel Management System
class CarouselManager {
    constructor() {
        this.carousels = {
            'top-rated': { currentIndex: 0, totalItems: 8, visibleItems: 5 },
            'recent': { currentIndex: 0, totalItems: 8, visibleItems: 5 },
            'recommended': { currentIndex: 0, totalItems: 8, visibleItems: 5 }
        };
        this.init();
    }

    init() {
        document.addEventListener('DOMContentLoaded', () => {
            Object.keys(this.carousels).forEach(carouselName => {
                this.updateCarousel(carouselName);
            });
        });
    }

    updateCarousel(carouselName) {
        const config = this.carousels[carouselName];
        if (!config) return;

        const carousel = document.getElementById(`${carouselName}-carousel`);
        if (!carousel) return;
        
        const maxIndex = config.totalItems - config.visibleItems;
        const offset = config.currentIndex * 20; // 20% per slide
        carousel.style.transform = `translateX(-${offset}%)`;
        
        // Update buttons
        const prevBtn = document.getElementById(`${carouselName}-prev`);
        const nextBtn = document.getElementById(`${carouselName}-next`);
        
        if (prevBtn) {
            prevBtn.disabled = config.currentIndex <= 0;
            prevBtn.style.opacity = config.currentIndex <= 0 ? '0.5' : '1';
        }
        if (nextBtn) {
            nextBtn.disabled = config.currentIndex >= maxIndex;
            nextBtn.style.opacity = config.currentIndex >= maxIndex ? '0.5' : '1';
        }
    }

    moveCarousel(carouselName, direction) {
        const config = this.carousels[carouselName];
        if (!config) return;

        const maxIndex = config.totalItems - config.visibleItems;
        
        if (direction === 'next' && config.currentIndex < maxIndex) {
            config.currentIndex++;
            this.updateCarousel(carouselName);
        } else if (direction === 'prev' && config.currentIndex > 0) {
            config.currentIndex--;
            this.updateCarousel(carouselName);
        }
    }

    // Public API methods
    next(carouselName) { this.moveCarousel(carouselName, 'next'); }
    prev(carouselName) { this.moveCarousel(carouselName, 'prev'); }
}

// Initialize carousel manager
const carouselManager = new CarouselManager();

// Global functions for backward compatibility
window.topRatedNext = () => carouselManager.next('top-rated');
window.topRatedPrev = () => carouselManager.prev('top-rated');
window.recentNext = () => carouselManager.next('recent');
window.recentPrev = () => carouselManager.prev('recent');
window.recommendedNext = () => carouselManager.next('recommended');
window.recommendedPrev = () => carouselManager.prev('recommended');