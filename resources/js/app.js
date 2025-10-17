import './bootstrap';

import Alpine from 'alpinejs';

// Import global utilities first
import './globals';

// Import our custom modules for different pages
import './carousel';
import './hero-carousel';
import './watchlist';
import './movies-watchlist';

// Page-specific modules (conditionally loaded based on page)
// These will be imported via @vite directive in specific Blade templates
import './movies-show';
import './movies-watchlist';
import './admin-dashboard';
import './admin-users-watchlist';

window.Alpine = Alpine;

Alpine.start();
