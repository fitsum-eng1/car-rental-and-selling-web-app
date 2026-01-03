/**
 * 🎬 ANIMATION CONTROLLER
 * Car Rental & Sales Platform
 * Enterprise-level animation orchestration
 */

class AnimationController {
    constructor() {
        this.init();
    }

    init() {
        this.setupScrollReveal();
        this.setupStaggeredAnimations();
        this.setupCounterAnimations();
        this.setupFormAnimations();
        this.setupButtonRipples();
        this.setupPageTransitions();
        this.checkReducedMotion();
    }

    /**
     * 1️⃣ SCROLL REVEAL ANIMATIONS
     * Trigger animations when elements enter viewport
     */
    setupScrollReveal() {
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('revealed');
                    // Unobserve after revealing (performance)
                    observer.unobserve(entry.target);
                }
            });
        }, observerOptions);

        document.querySelectorAll('.scroll-reveal').forEach(el => {
            observer.observe(el);
        });
    }

    /**
     * 2️⃣ STAGGERED LIST ANIMATIONS
     * Animate list items with delay
     */
    setupStaggeredAnimations() {
        const staggerContainers = document.querySelectorAll('.stagger-container');
        
        staggerContainers.forEach(container => {
            const items = container.querySelectorAll('.stagger-item');
            
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        items.forEach((item, index) => {
                            setTimeout(() => {
                                item.style.opacity = '1';
                                item.style.transform = 'translateY(0)';
                            }, index * 80);
                        });
                        observer.unobserve(entry.target);
                    }
                });
            }, { threshold: 0.1 });

            observer.observe(container);
        });
    }

    /**
     * 3️⃣ COUNTER ANIMATIONS
     * Animate numbers counting up
     */
    setupCounterAnimations() {
        const counters = document.querySelectorAll('.counter, .stat-counter');
        
        counters.forEach(counter => {
            const target = parseInt(counter.getAttribute('data-target') || counter.textContent);
            const duration = 2000;
            const increment = target / (duration / 16);
            let current = 0;

            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        const updateCounter = () => {
                            current += increment;
                            if (current < target) {
                                counter.textContent = Math.ceil(current);
                                requestAnimationFrame(updateCounter);
                            } else {
                                counter.textContent = target;
                            }
                        };
                        updateCounter();
                        observer.unobserve(entry.target);
                    }
                });
            }, { threshold: 0.5 });

            observer.observe(counter);
        });
    }

    /**
     * 4️⃣ FORM INPUT ANIMATIONS
     * Enhance form interactions
     */
    setupFormAnimations() {
        const inputs = document.querySelectorAll('.input-animated');
        
        inputs.forEach(input => {
            // Focus animation
            input.addEventListener('focus', () => {
                input.parentElement?.classList.add('input-focused');
            });

            input.addEventListener('blur', () => {
                input.parentElement?.classList.remove('input-focused');
            });

            // Error shake animation
            input.addEventListener('invalid', () => {
                input.classList.add('input-error');
                setTimeout(() => {
                    input.classList.remove('input-error');
                }, 300);
            });
        });
    }

    /**
     * 5️⃣ BUTTON RIPPLE EFFECT
     * Material Design ripple on click
     */
    setupButtonRipples() {
        const buttons = document.querySelectorAll('.btn-animated');
        
        buttons.forEach(button => {
            button.addEventListener('click', function(e) {
                const ripple = document.createElement('span');
                const rect = this.getBoundingClientRect();
                const size = Math.max(rect.width, rect.height);
                const x = e.clientX - rect.left - size / 2;
                const y = e.clientY - rect.top - size / 2;

                ripple.style.width = ripple.style.height = size + 'px';
                ripple.style.left = x + 'px';
                ripple.style.top = y + 'px';
                ripple.classList.add('ripple');

                this.appendChild(ripple);

                setTimeout(() => ripple.remove(), 600);
            });
        });
    }

    /**
     * 6️⃣ PAGE TRANSITION ANIMATIONS
     * Smooth transitions between pages
     */
    setupPageTransitions() {
        // Add page load animation
        document.body.classList.add('page-loaded');

        // Handle link clicks for smooth transitions
        document.querySelectorAll('a:not([target="_blank"])').forEach(link => {
            link.addEventListener('click', (e) => {
                const href = link.getAttribute('href');
                
                // Skip if it's a hash link or external
                if (!href || href.startsWith('#') || href.startsWith('http')) {
                    return;
                }

                // Skip if it's a form submission or has special attributes
                if (link.closest('form') || link.hasAttribute('data-no-transition')) {
                    return;
                }

                e.preventDefault();
                
                document.body.classList.add('page-transitioning');
                
                setTimeout(() => {
                    window.location.href = href;
                }, 300);
            });
        });
    }

    /**
     * 7️⃣ REDUCED MOTION CHECK
     * Respect user preferences
     */
    checkReducedMotion() {
        const prefersReducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)');
        
        if (prefersReducedMotion.matches) {
            document.body.classList.add('reduced-motion');
            console.log('Reduced motion enabled');
        }

        // Listen for changes
        prefersReducedMotion.addEventListener('change', () => {
            if (prefersReducedMotion.matches) {
                document.body.classList.add('reduced-motion');
            } else {
                document.body.classList.remove('reduced-motion');
            }
        });
    }

    /**
     * 8️⃣ MODAL ANIMATIONS
     * Smooth modal open/close
     */
    static openModal(modalId) {
        const modal = document.getElementById(modalId);
        if (!modal) return;

        modal.style.display = 'flex';
        requestAnimationFrame(() => {
            modal.querySelector('.modal-backdrop')?.classList.add('show');
            modal.querySelector('.modal-content')?.classList.add('show');
        });
    }

    static closeModal(modalId) {
        const modal = document.getElementById(modalId);
        if (!modal) return;

        modal.querySelector('.modal-backdrop')?.classList.remove('show');
        modal.querySelector('.modal-content')?.classList.remove('show');

        setTimeout(() => {
            modal.style.display = 'none';
        }, 300);
    }

    /**
     * 9️⃣ NOTIFICATION ANIMATIONS
     * Show toast notifications
     */
    static showNotification(message, type = 'success', duration = 3000) {
        const notification = document.createElement('div');
        notification.className = `notification ${type}`;
        notification.innerHTML = `
            <div class="notification-content">
                <span class="notification-icon">${type === 'success' ? '✓' : '✕'}</span>
                <span class="notification-message">${message}</span>
            </div>
        `;

        document.body.appendChild(notification);

        requestAnimationFrame(() => {
            notification.classList.add('show');
        });

        setTimeout(() => {
            notification.classList.remove('show');
            setTimeout(() => notification.remove(), 300);
        }, duration);
    }

    /**
     * 🔟 LOADING STATE ANIMATIONS
     * Show/hide loading indicators
     */
    static showLoading(element) {
        const loader = document.createElement('div');
        loader.className = 'spinner-3d';
        loader.setAttribute('data-loader', 'true');
        
        element.style.position = 'relative';
        element.appendChild(loader);
        element.classList.add('loading');
    }

    static hideLoading(element) {
        const loader = element.querySelector('[data-loader="true"]');
        if (loader) {
            loader.remove();
        }
        element.classList.remove('loading');
    }
}

/**
 * 🎯 3D CAR VIEWER CONTROLLER
 * Three.js integration for 3D car models
 */
class Car3DViewer {
    constructor(containerId) {
        this.container = document.getElementById(containerId);
        if (!this.container) return;

        this.isLoading = true;
        this.autoRotate = true;
        this.init();
    }

    async init() {
        // Show loading state
        this.showLoading();

        try {
            // Import Three.js dynamically
            const THREE = await import('three');
            const { OrbitControls } = await import('three/examples/jsm/controls/OrbitControls.js');
            const { GLTFLoader } = await import('three/examples/jsm/loaders/GLTFLoader.js');

            this.THREE = THREE;
            this.setupScene();
            this.setupCamera();
            this.setupRenderer();
            this.setupLights();
            this.setupControls(OrbitControls);
            
            // Load 3D model (placeholder for now)
            // await this.loadModel(GLTFLoader);
            
            this.animate();
            this.hideLoading();
        } catch (error) {
            console.error('Failed to initialize 3D viewer:', error);
            this.showError();
        }
    }

    setupScene() {
        this.scene = new this.THREE.Scene();
        this.scene.background = new this.THREE.Color(0xf0f0f0);
    }

    setupCamera() {
        const width = this.container.clientWidth;
        const height = this.container.clientHeight;
        
        this.camera = new this.THREE.PerspectiveCamera(45, width / height, 0.1, 1000);
        this.camera.position.set(5, 3, 5);
    }

    setupRenderer() {
        this.renderer = new this.THREE.WebGLRenderer({ antialias: true });
        this.renderer.setSize(this.container.clientWidth, this.container.clientHeight);
        this.renderer.setPixelRatio(window.devicePixelRatio);
        this.container.appendChild(this.renderer.domElement);
    }

    setupLights() {
        const ambientLight = new this.THREE.AmbientLight(0xffffff, 0.6);
        this.scene.add(ambientLight);

        const directionalLight = new this.THREE.DirectionalLight(0xffffff, 0.8);
        directionalLight.position.set(10, 10, 5);
        this.scene.add(directionalLight);
    }

    setupControls(OrbitControls) {
        this.controls = new OrbitControls(this.camera, this.renderer.domElement);
        this.controls.enableDamping = true;
        this.controls.dampingFactor = 0.05;
        this.controls.autoRotate = this.autoRotate;
        this.controls.autoRotateSpeed = 2.0;
    }

    animate() {
        requestAnimationFrame(() => this.animate());
        
        if (this.controls) {
            this.controls.update();
        }
        
        this.renderer.render(this.scene, this.camera);
    }

    showLoading() {
        this.container.innerHTML = '<div class="car-3d-loading"><div class="spinner-3d"></div></div>';
    }

    hideLoading() {
        const loading = this.container.querySelector('.car-3d-loading');
        if (loading) {
            loading.style.opacity = '0';
            setTimeout(() => loading.remove(), 300);
        }
        this.isLoading = false;
    }

    showError() {
        this.container.innerHTML = '<div class="car-3d-error">Failed to load 3D model</div>';
    }

    toggleAutoRotate() {
        this.autoRotate = !this.autoRotate;
        if (this.controls) {
            this.controls.autoRotate = this.autoRotate;
        }
    }
}

/**
 * 🚀 INITIALIZE ON DOM READY
 */
document.addEventListener('DOMContentLoaded', () => {
    // Initialize animation controller
    window.animationController = new AnimationController();

    // Initialize 3D viewers if present
    document.querySelectorAll('[data-3d-viewer]').forEach(container => {
        new Car3DViewer(container.id);
    });

    console.log('🎬 Animation system initialized');
});

/**
 * 📤 EXPORT FOR GLOBAL USE
 */
window.AnimationController = AnimationController;
window.Car3DViewer = Car3DViewer;