import './bootstrap';

// Dark mode management
const darkModeManager = {
    init() {
        // Check local storage for theme preference
        const savedTheme = localStorage.getItem('theme');
        const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
        
        if (savedTheme === 'dark' || (!savedTheme && prefersDark)) {
            this.enableDarkMode();
        } else {
            this.disableDarkMode();
        }
        
        this.updateToggleIcon();
    },
    
    enableDarkMode() {
        document.documentElement.classList.add('dark');
        localStorage.setItem('theme', 'dark');
        this.updateToggleIcon();
    },
    
    disableDarkMode() {
        document.documentElement.classList.remove('dark');
        localStorage.setItem('theme', 'light');
        this.updateToggleIcon();
    },
    
    toggle() {
        if (document.documentElement.classList.contains('dark')) {
            this.disableDarkMode();
        } else {
            this.enableDarkMode();
        }
    },
    
    updateToggleIcon() {
        const toggleIcon = document.getElementById('theme-toggle-icon');
        const toggleText = document.getElementById('theme-toggle-text');
        
        if (toggleIcon) {
            if (document.documentElement.classList.contains('dark')) {
                toggleIcon.classList.remove('fa-moon');
                toggleIcon.classList.add('fa-sun');
                if (toggleText) toggleText.textContent = 'Light Mode';
            } else {
                toggleIcon.classList.remove('fa-sun');
                toggleIcon.classList.add('fa-moon');
                if (toggleText) toggleText.textContent = 'Dark Mode';
            }
        }
    }
};

// Toast notification helper
window.showToast = function(message, type = 'success') {
    const toast = document.createElement('div');
    toast.className = `fixed top-20 right-4 z-50 flex items-center w-full max-w-xs p-4 mb-4 text-gray-500 bg-white rounded-lg shadow toast-notification dark:bg-gray-800 dark:text-gray-400`;
    toast.setAttribute('role', 'alert');
    
    const bgColor = type === 'success' ? 'text-green-500' : 'text-red-500';
    const icon = type === 'success' ? 'fa-check-circle' : 'fa-exclamation-circle';
    const bgIcon = type === 'success' ? 'bg-green-100 dark:bg-green-800' : 'bg-red-100 dark:bg-red-800';
    
    toast.innerHTML = `
        <div class="inline-flex items-center justify-center flex-shrink-0 w-8 h-8 ${bgColor} ${bgIcon} rounded-lg">
            <i class="fas ${icon}"></i>
        </div>
        <div class="ms-3 text-sm font-normal">${message}</div>
        <button type="button" class="ms-auto -mx-1.5 -my-1.5 bg-white text-gray-400 hover:text-gray-900 rounded-lg focus:ring-2 focus:ring-gray-300 p-1.5 hover:bg-gray-100 inline-flex items-center justify-center h-8 w-8 dark:bg-gray-800 dark:text-gray-400 dark:hover:text-white dark:hover:bg-gray-700" onclick="this.closest('.toast-notification').remove()">
            <span class="sr-only">Close</span>
            <i class="fas fa-times"></i>
        </button>
    `;
    
    document.body.appendChild(toast);
    
    setTimeout(() => {
        toast.remove();
    }, 3000);
};

// Confirm dialog helper
window.confirmDialog = function(message) {
    return confirm(message);
};

// Toggle password function
window.togglePassword = function(inputId, iconId) {
    const passwordInput = document.getElementById(inputId);
    const icon = document.getElementById(iconId);
    
    if (passwordInput.type === 'password') {
        passwordInput.type = 'text';
        icon.classList.remove('fa-eye');
        icon.classList.add('fa-eye-slash');
    } else {
        passwordInput.type = 'password';
        icon.classList.remove('fa-eye-slash');
        icon.classList.add('fa-eye');
    }
};

// Initialize dark mode on page load
document.addEventListener('DOMContentLoaded', () => {
    darkModeManager.init();
    
    // Setup theme toggle button if exists
    const themeToggle = document.getElementById('theme-toggle');
    if (themeToggle) {
        themeToggle.addEventListener('click', () => {
            darkModeManager.toggle();
        });
    }
});

// Export for use in other files
window.darkModeManager = darkModeManager;