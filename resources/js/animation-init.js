/**
 * Animation Initialization Script
 * Initializes all animations when the page loads
 */

document.addEventListener('DOMContentLoaded', function() {
    // Initialize counter animations
    initCounterAnimations();
    
    // Initialize scroll reveal animations
    initScrollRevealAnimations();
    
    // Initialize form animations
    initFormAnimations();
    
    // Initialize button ripple effects
    initRippleEffects();
    
    // Initialize card hover effects
    initCardHoverEffects();
    
    // Initialize list stagger animations
    initListStaggerAnimations();
    
    // Initialize reduced motion support
    initReducedMotionSupport();
});

/**
 * Counter Animation for Dashboard Stats
 */
function initCounterAnimations() {
    const counters = document.querySelectorAll('.counter');
    
    const observerOptions = {
        threshold: 0.5,
        rootMargin: '0px 0px -50px 0px'
    };
    
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                animateCounter(entry.target);
                observer.unobserve(entry.target);
            }
        });
    }, observerOptions);
    
    counters.forEach(counter => {
        observer.observe(counter);
    });
}

function animateCounter(element) {
    const target = parseInt(element.getAttribute('data-target'));
    const duration = 2000; // 2 seconds
    const increment = target / (duration / 16); // 60fps
    let current = 0;
    
    const timer = setInterval(() => {
        current += increment;
        if (current >= target) {
            current = target;
            clearInterval(timer);
        }
        element.textContent = Math.floor(current);
    }, 16);
}

/**
 * Scroll Reveal Animations
 */
function initScrollRevealAnimations() {
    const elements = document.querySelectorAll('[data-aos]');
    
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };
    
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const element = entry.target;
                const animation = element.getAttribute('data-aos');
                const delay = element.getAttribute('data-aos-delay') || 0;
                
                setTimeout(() => {
                    element.classList.add('animate__animated', `animate__${animation}`);
                }, delay);
                
                observer.unobserve(element);
            }
        });
    }, observerOptions);
    
    elements.forEach(element => {
        observer.observe(element);
    });
}

/**
 * Form Input Animations
 */
function initFormAnimations() {
    const inputs = document.querySelectorAll('input, select, textarea');
    
    inputs.forEach(input => {
        // Focus animation
        input.addEventListener('focus', function() {
            this.classList.add('animate-input-focus');
        });
        
        // Blur animation
        input.addEventListener('blur', function() {
            this.classList.remove('animate-input-focus');
        });
        
        // Error shake animation
        if (input.classList.contains('border-red-500')) {
            input.classList.add('animate-shake');
        }
    });
}

/**
 * Button Ripple Effects
 */
function initRippleEffects() {
    const rippleButtons = document.querySelectorAll('.animate-ripple');
    
    rippleButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            const ripple = document.createElement('span');
            const rect = this.getBoundingClientRect();
            const size = Math.max(rect.width, rect.height);
            const x = e.clientX - rect.left - size / 2;
            const y = e.clientY - rect.top - size / 2;
            
            ripple.style.width = ripple.style.height = size + 'px';
            ripple.style.left = x + 'px';
            ripple.style.top = y + 'px';
            ripple.classList.add('ripple-effect');
            
            this.appendChild(ripple);
            
            setTimeout(() => {
                ripple.remove();
            }, 600);
        });
    });
}

/**
 * Card Hover Effects
 */
function initCardHoverEffects() {
    const cards = document.querySelectorAll('.animate-card-entrance');
    
    cards.forEach(card => {
        card.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-4px) scale(1.02)';
            this.style.boxShadow = '0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04)';
        });
        
        card.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0) scale(1)';
            this.style.boxShadow = '0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06)';
        });
    });
}

/**
 * List Stagger Animations
 */
function initListStaggerAnimations() {
    const listItems = document.querySelectorAll('.animate-list-item');
    
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('animate__animated', 'animate__fadeInUp');
                observer.unobserve(entry.target);
            }
        });
    }, { threshold: 0.1 });
    
    listItems.forEach(item => {
        observer.observe(item);
    });
}

/**
 * Reduced Motion Support
 */
function initReducedMotionSupport() {
    const prefersReducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)');
    
    if (prefersReducedMotion.matches) {
        // Disable animations for users who prefer reduced motion
        const style = document.createElement('style');
        style.textContent = `
            *, *::before, *::after {
                animation-duration: 0.01ms !important;
                animation-iteration-count: 1 !important;
                transition-duration: 0.01ms !important;
                scroll-behavior: auto !important;
            }
        `;
        document.head.appendChild(style);
    }
}

/**
 * Page Transition Effects
 */
function initPageTransitions() {
    // Add page load animation
    document.body.classList.add('animate__animated', 'animate__fadeIn');
    
    // Handle link clicks for smooth transitions
    const links = document.querySelectorAll('a[href^="/"], a[href^="' + window.location.origin + '"]');
    
    links.forEach(link => {
        link.addEventListener('click', function(e) {
            if (this.target !== '_blank') {
                e.preventDefault();
                const href = this.href;
                
                document.body.classList.add('animate__animated', 'animate__fadeOut');
                
                setTimeout(() => {
                    window.location.href = href;
                }, 300);
            }
        });
    });
}

/**
 * 3D Car Viewer Enhancement
 */
function enhance3DViewer() {
    const viewer3D = document.getElementById('car-3d-viewer');
    if (viewer3D) {
        // Add loading animation
        viewer3D.addEventListener('loadstart', function() {
            this.classList.add('animate-pulse');
        });
        
        viewer3D.addEventListener('loadend', function() {
            this.classList.remove('animate-pulse');
            this.classList.add('animate__animated', 'animate__zoomIn');
        });
    }
}

/**
 * Payment Status Animations
 */
function initPaymentStatusAnimations() {
    const statusElements = document.querySelectorAll('.animate-success-pulse, .animate-pending-pulse');
    
    statusElements.forEach(element => {
        if (element.classList.contains('animate-success-pulse')) {
            element.style.animation = 'successPulse 2s ease-in-out infinite';
        } else if (element.classList.contains('animate-pending-pulse')) {
            element.style.animation = 'pendingPulse 1.5s ease-in-out infinite';
        }
    });
}

/**
 * Filter Animation Effects
 */
function initFilterAnimations() {
    const filterForm = document.querySelector('.animate-slide-in-down');
    if (filterForm) {
        filterForm.classList.add('animate__animated', 'animate__slideInDown');
    }
    
    // Animate filter results
    const vehicleGrid = document.getElementById('vehicle-grid');
    if (vehicleGrid) {
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const cards = entry.target.querySelectorAll('.animate-card-entrance');
                    cards.forEach((card, index) => {
                        setTimeout(() => {
                            card.classList.add('animate__animated', 'animate__fadeInUp');
                        }, index * 100);
                    });
                    observer.unobserve(entry.target);
                }
            });
        }, { threshold: 0.1 });
        
        observer.observe(vehicleGrid);
    }
}

// Initialize all animations
document.addEventListener('DOMContentLoaded', function() {
    initCounterAnimations();
    initScrollRevealAnimations();
    initFormAnimations();
    initRippleEffects();
    initCardHoverEffects();
    initListStaggerAnimations();
    initReducedMotionSupport();
    initPaymentStatusAnimations();
    initFilterAnimations();
    enhance3DViewer();
});

// Export for use in other modules
window.AnimationController = {
    initCounterAnimations,
    initScrollRevealAnimations,
    initFormAnimations,
    initRippleEffects,
    initCardHoverEffects,
    initListStaggerAnimations,
    initReducedMotionSupport,
    initPaymentStatusAnimations,
    initFilterAnimations,
    enhance3DViewer
};