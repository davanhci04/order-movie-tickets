// Global JavaScript functions and utilities

// Confirm delete function with Vietnamese text
window.confirmDelete = function(message = 'Bạn có chắc muốn xóa?') {
    return confirm(message);
};

// Success/Error message display function
window.showMessage = function(message, type = 'success') {
    const messageDiv = document.createElement('div');
    const bgColor = type === 'success' ? 'bg-green-500' : 'bg-red-500';
    const borderColor = type === 'success' ? 'border-green-400' : 'border-red-400';
    
    messageDiv.className = `fixed top-4 right-4 ${bgColor} text-white px-6 py-3 rounded-lg shadow-xl z-50 ${borderColor} border`;
    messageDiv.style.fontWeight = 'bold';
    messageDiv.textContent = message;
    document.body.appendChild(messageDiv);
    
    setTimeout(() => {
        if (messageDiv.parentNode) {
            messageDiv.remove();
        }
    }, 3000);
};

// Format number to Vietnamese locale
window.formatNumber = function(number) {
    return new Intl.NumberFormat('vi-VN').format(number);
};

// Format date to Vietnamese locale
window.formatDate = function(date) {
    return new Intl.DateTimeFormat('vi-VN', {
        year: 'numeric',
        month: 'long',
        day: 'numeric'
    }).format(new Date(date));
};