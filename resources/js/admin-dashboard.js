// Admin Dashboard - Coming Soon Features & Utilities
class AdminDashboardManager {
    constructor() {
        this.init();
    }

    init() {
        // Add any dashboard initialization here
        console.log('Admin Dashboard initialized');
    }

    showComingSoonAlert(featureName) {
        // Enhanced coming soon alert with better UX
        const message = `${featureName} feature is coming soon! Stay tuned for updates.`;
        
        // Create a more professional modal instead of basic alert
        this.showModal('Coming Soon', message, 'info');
    }

    showModal(title, message, type = 'info') {
        // Create modal backdrop
        const backdrop = document.createElement('div');
        backdrop.className = 'fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50';
        
        // Modal content
        const modal = document.createElement('div');
        modal.className = 'bg-white rounded-lg shadow-xl max-w-md w-full mx-4 p-6';
        
        // Icon based on type
        const iconColors = {
            info: 'text-blue-500',
            success: 'text-green-500',
            warning: 'text-yellow-500',
            error: 'text-red-500'
        };
        
        modal.innerHTML = `
            <div class="flex items-center mb-4">
                <div class="flex-shrink-0">
                    <svg class="w-6 h-6 ${iconColors[type]}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <h3 class="ml-3 text-lg font-semibold text-gray-900">${title}</h3>
            </div>
            <p class="text-gray-600 mb-6">${message}</p>
            <div class="flex justify-end">
                <button class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-medium transition-colors duration-200" onclick="this.closest('.fixed').remove()">
                    Got it
                </button>
            </div>
        `;
        
        backdrop.appendChild(modal);
        document.body.appendChild(backdrop);
        
        // Auto remove after 5 seconds
        setTimeout(() => {
            if (backdrop.parentNode) {
                backdrop.remove();
            }
        }, 5000);
        
        // Close on backdrop click
        backdrop.addEventListener('click', (e) => {
            if (e.target === backdrop) {
                backdrop.remove();
            }
        });
    }

    // Quick stats refresh functionality
    refreshStats() {
        this.showModal('Refreshing...', 'Dashboard statistics are being updated.', 'info');
        
        // Simulate API call
        setTimeout(() => {
            // In real implementation, this would fetch fresh data
            window.location.reload();
        }, 1500);
    }

    // Export functionality placeholder
    exportReports() {
        this.showModal('Export Feature', 'Reports export functionality will be available soon. You will be able to export data in CSV, PDF, and Excel formats.', 'info');
    }
}

// Initialize admin dashboard manager
const adminDashboardManager = new AdminDashboardManager();

// Global functions for backward compatibility and new features
window.showReportsComingSoon = () => adminDashboardManager.showComingSoonAlert('Reports');
window.showSettingsComingSoon = () => adminDashboardManager.showComingSoonAlert('Settings');
window.refreshDashboard = () => adminDashboardManager.refreshStats();
window.exportReports = () => adminDashboardManager.exportReports();