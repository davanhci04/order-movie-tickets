import './bootstrap';

import Alpine from 'alpinejs';

// Import our custom modules for different pages
import './carousel';
import './hero-carousel';
import './watchlist';

// Page-specific modules (conditionally loaded based on page)
// These will be imported via @vite directive in specific Blade templates
// import './movies-index';
// import './movies-show';
// import './movies-watchlist';
// import './admin-dashboard';
// import './admin-users-watchlist';

window.Alpine = Alpine;

Alpine.start();
