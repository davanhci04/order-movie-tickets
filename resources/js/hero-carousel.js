// Hero Carousel Management
class HeroCarousel {
    constructor() {
        this.currentSlide = 0;
        this.slides = document.querySelectorAll('.carousel-slide');
        this.indicators = document.querySelectorAll('.carousel-indicator');
        this.totalSlides = this.slides.length;
        this.autoPlayInterval = null;
        this.init();
    }

    init() {
        if (this.totalSlides > 0) {
            this.startAutoPlay();
            this.bindEvents();
        }
    }

    showSlide(n) {
        this.slides.forEach(slide => slide.classList.remove('active'));
        this.indicators.forEach(indicator => {
            indicator.classList.remove('bg-white');
            indicator.classList.add('bg-white/50');
        });

        this.currentSlide = (n + this.totalSlides) % this.totalSlides;
        this.slides[this.currentSlide].classList.add('active');
        this.indicators[this.currentSlide].classList.remove('bg-white/50');
        this.indicators[this.currentSlide].classList.add('bg-white');
    }

    nextSlide() {
        this.showSlide(this.currentSlide + 1);
    }

    previousSlide() {
        this.showSlide(this.currentSlide - 1);
    }

    goToSlide(n) {
        this.showSlide(n);
    }

    startAutoPlay() {
        this.autoPlayInterval = setInterval(() => this.nextSlide(), 5000);
    }

    stopAutoPlay() {
        if (this.autoPlayInterval) {
            clearInterval(this.autoPlayInterval);
            this.autoPlayInterval = null;
        }
    }

    bindEvents() {
        // Pause autoplay on hover
        const heroSection = document.querySelector('.carousel-container');
        if (heroSection) {
            heroSection.addEventListener('mouseenter', () => this.stopAutoPlay());
            heroSection.addEventListener('mouseleave', () => this.startAutoPlay());
        }
    }
}

// Initialize hero carousel
const heroCarousel = new HeroCarousel();

// Global functions for backward compatibility
window.nextSlide = () => heroCarousel.nextSlide();
window.previousSlide = () => heroCarousel.previousSlide();
window.goToSlide = (n) => heroCarousel.goToSlide(n);