document.addEventListener('DOMContentLoaded', function() {
    // Initialize notifications dropdown
    const notificationIcon = document.querySelector('.notification-icon');
    if (notificationIcon) {
        notificationIcon.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            const dropdown = this.closest('.notification-dropdown').querySelector('.notification-dropdown-content');
            dropdown.classList.toggle('show');
        });
    }

    // Initialize user dropdown
    const userInfo = document.querySelector('.user-info');
    if (userInfo) {
        userInfo.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            const dropdown = this.closest('.user-dropdown').querySelector('.user-dropdown-content');
            dropdown.classList.toggle('show');
        });
    }

    // Close dropdowns when clicking outside
    document.addEventListener('click', function(e) {
        const dropdowns = document.querySelectorAll('.notification-dropdown-content.show, .user-dropdown-content.show');
        dropdowns.forEach(dropdown => {
            dropdown.classList.remove('show');
        });
    });

    // Initialize dark mode toggle
    const darkModeToggle = document.querySelector('.dark-mode-toggle');
    if (darkModeToggle) {
        darkModeToggle.addEventListener('click', function() {
            document.body.classList.toggle('dark-mode');
            const isDarkMode = document.body.classList.contains('dark-mode');
            localStorage.setItem('darkMode', isDarkMode);
            updateDarkModeIcon();
        });

        // Check if dark mode was previously enabled
        if (localStorage.getItem('darkMode') === 'true') {
            document.body.classList.add('dark-mode');
            updateDarkModeIcon();
        }

        function updateDarkModeIcon() {
            const isDarkMode = document.body.classList.contains('dark-mode');
            const iconSpan = darkModeToggle.querySelector('.nav-icon');
            if (iconSpan) {
                iconSpan.textContent = isDarkMode ? '☀️' : '🌙';
            }
        }

        // Initialize icon on load
        updateDarkModeIcon();
    }

    // Mobile sidebar toggle
    const sidebarToggle = document.querySelector('.toggle-sidebar');
    if (sidebarToggle) {
        sidebarToggle.addEventListener('click', function() {
            const sidebar = document.querySelector('.sidebar');
            sidebar.classList.toggle('show');
        });
    }

    // Add animation classes to elements on page load
    const animateElements = document.querySelectorAll('.card, .stats-card, .quick-action-card');
    animateElements.forEach((element, index) => {
        setTimeout(() => {
            element.classList.add('fade-in');
        }, index * 100);
    });

    // Create user initials for avatar if needed
    const userAvatars = document.querySelectorAll('.user-avatar');
    userAvatars.forEach(avatar => {
        if (!avatar.querySelector('img') && avatar.textContent.trim() === '') {
            const userName = avatar.getAttribute('data-name') || '';
            const nameParts = userName.split(' ');
            let initials = '';
            
            if (nameParts.length >= 2) {
                initials = nameParts[0].charAt(0) + nameParts[1].charAt(0);
            } else if (nameParts.length === 1 && nameParts[0] !== '') {
                initials = nameParts[0].charAt(0);
            } else {
                initials = 'U';
            }
            
            avatar.textContent = initials.toUpperCase();
        }
    });

    // Initialize tooltips
    const tooltipElements = document.querySelectorAll('[data-tooltip]');
    tooltipElements.forEach(element => {
        element.addEventListener('mouseenter', function() {
            const tooltipText = this.getAttribute('data-tooltip');
            const tooltip = document.createElement('div');
            tooltip.className = 'tooltip';
            tooltip.textContent = tooltipText;
            document.body.appendChild(tooltip);
            
            const rect = this.getBoundingClientRect();
            tooltip.style.top = rect.top - tooltip.offsetHeight - 10 + 'px';
            tooltip.style.left = rect.left + (rect.width / 2) - (tooltip.offsetWidth / 2) + 'px';
            tooltip.classList.add('show');
            
            this.addEventListener('mouseleave', function() {
                tooltip.remove();
            });
        });
    });

    // Add smooth scroll behavior to anchor links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function(e) {
            const targetId = this.getAttribute('href');
            if (targetId !== '#') {
                const targetElement = document.querySelector(targetId);
                if (targetElement) {
                    e.preventDefault();
                    targetElement.scrollIntoView({
                        behavior: 'smooth'
                    });
                }
            }
        });
    });

    // Handle card hover effects on touch devices
    const cards = document.querySelectorAll('.card');
    cards.forEach(card => {
        card.addEventListener('touchstart', function() {
            this.classList.add('hover-effect');
        }, {passive: true});
        
        card.addEventListener('touchend', function() {
            setTimeout(() => {
                this.classList.remove('hover-effect');
            }, 300);
        }, {passive: true});
    });
}); 