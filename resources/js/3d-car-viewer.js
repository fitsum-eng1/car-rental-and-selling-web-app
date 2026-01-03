/**
 * 3D Car Viewer - Enterprise Grade Implementation
 * Three.js-based automotive showroom experience
 * Designed for Car Rental & Sales Platform
 */

import * as THREE from 'three';
import { OrbitControls } from 'three/examples/jsm/controls/OrbitControls.js';
import { GLTFLoader } from 'three/examples/jsm/loaders/GLTFLoader.js';
import { DRACOLoader } from 'three/examples/jsm/loaders/DRACOLoader.js';
import { CarFallbackGenerator } from './3d-car-fallback.js';

class CarViewer3D {
    constructor(containerId, options = {}) {
        this.containerId = containerId;
        this.container = document.getElementById(containerId);
        
        if (!this.container) {
            console.error(`3D Car Viewer: Container ${containerId} not found`);
            return;
        }

        // Configuration
        this.config = {
            enableAutoRotate: options.autoRotate !== false,
            enableShadows: options.shadows !== false,
            enableControls: options.controls !== false,
            adaptiveQuality: options.adaptiveQuality !== false,
            modelPath: options.modelPath || null,
            fallbackImage: options.fallbackImage || null,
            colors: options.colors || ['#ff0000', '#0000ff', '#ffffff', '#000000'],
            ...options
        };

        // State
        this.isLoaded = false;
        this.isLoading = false;
        this.currentModel = null;
        this.currentColor = '#ffffff';
        this.autoRotateTimeout = null;
        this.isUserInteracting = false;
        this.isMobile = window.innerWidth <= 768;
        this.isLowEnd = this.detectLowEndDevice();

        // Initialize
        this.init();
    }

    detectLowEndDevice() {
        // Simple heuristic for low-end device detection
        const canvas = document.createElement('canvas');
        const gl = canvas.getContext('webgl') || canvas.getContext('experimental-webgl');
        
        if (!gl) return true;
        
        const debugInfo = gl.getExtension('WEBGL_debug_renderer_info');
        if (debugInfo) {
            const renderer = gl.getParameter(debugInfo.UNMASKED_RENDERER_WEBGL);
            // Check for integrated graphics or mobile GPUs
            return /intel|adreno|mali|powervr/i.test(renderer);
        }
        
        return navigator.hardwareConcurrency < 4;
    }

    init() {
        this.createUI();
        this.setupScene();
        this.setupCamera();
        this.setupLighting();
        this.setupRenderer();
        this.setupControls();
        this.setupLoaders();
        this.bindEvents();
        this.startRenderLoop();
        
        // Show fallback initially
        this.showFallback();
    }

    createUI() {
        this.container.innerHTML = `
            <div class="car-viewer-3d">
                <!-- Fallback Image -->
                <div class="viewer-fallback" id="${this.containerId}-fallback">
                    <img src="${this.config.fallbackImage}" alt="Car Image" class="fallback-image">
                    <div class="enable-3d-overlay">
                        <button class="enable-3d-btn" id="${this.containerId}-enable">
                            <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z" />
                            </svg>
                            Enable 3D View
                        </button>
                    </div>
                </div>

                <!-- 3D Canvas Container -->
                <div class="viewer-canvas-container" id="${this.containerId}-canvas-container" style="display: none;">
                    <canvas class="viewer-canvas" id="${this.containerId}-canvas"></canvas>
                    
                    <!-- Loading Overlay -->
                    <div class="viewer-loading" id="${this.containerId}-loading">
                        <div class="loading-spinner"></div>
                        <p>Loading 3D Model...</p>
                    </div>

                    <!-- Controls Overlay -->
                    <div class="viewer-controls" id="${this.containerId}-controls" style="opacity: 0;">
                        <!-- Top Controls -->
                        <div class="controls-top">
                            <div class="view-modes">
                                <button class="view-btn active" data-view="exterior">Exterior</button>
                                <button class="view-btn" data-view="interior">Interior</button>
                            </div>
                            <div class="color-picker">
                                ${this.config.colors.map(color => 
                                    `<button class="color-btn ${color === this.currentColor ? 'active' : ''}" 
                                             data-color="${color}" 
                                             style="background-color: ${color}"></button>`
                                ).join('')}
                            </div>
                        </div>

                        <!-- Bottom Controls -->
                        <div class="controls-bottom">
                            <div class="interaction-hints">
                                <span class="hint">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M10 12a2 2 0 100-4 2 2 0 000 4z"/>
                                        <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd"/>
                                    </svg>
                                    Drag to rotate
                                </span>
                                <span class="hint">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-11a1 1 0 10-2 0v3.586L7.707 9.293a1 1 0 00-1.414 1.414l3 3a1 1 0 001.414 0l3-3a1 1 0 00-1.414-1.414L11 10.586V7z" clip-rule="evenodd"/>
                                    </svg>
                                    Scroll to zoom
                                </span>
                                <button class="reset-btn" id="${this.containerId}-reset">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M4 2a1 1 0 011 1v2.101a7.002 7.002 0 0111.601 2.566 1 1 0 11-1.885.666A5.002 5.002 0 005.999 7H9a1 1 0 010 2H4a1 1 0 01-1-1V3a1 1 0 011-1zm.008 9.057a1 1 0 011.276.61A5.002 5.002 0 0014.001 13H11a1 1 0 110-2h5a1 1 0 011 1v5a1 1 0 11-2 0v-2.101a7.002 7.002 0 01-11.601-2.566 1 1 0 01.61-1.276z" clip-rule="evenodd"/>
                                    </svg>
                                    Reset View
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Error State -->
                    <div class="viewer-error" id="${this.containerId}-error" style="display: none;">
                        <div class="error-content">
                            <svg class="w-12 h-12 text-red-500 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.268 16.5c-.77.833.192 2.5 1.732 2.5z"/>
                            </svg>
                            <h3>3D Model Failed to Load</h3>
                            <p>Please check your connection and try again.</p>
                            <button class="retry-btn" id="${this.containerId}-retry">Retry</button>
                        </div>
                    </div>
                </div>
            </div>
        `;
    }

    setupScene() {
        this.scene = new THREE.Scene();
        
        // Background
        const gradientTexture = this.createGradientTexture();
        this.scene.background = gradientTexture;
        
        // Fog for depth
        this.scene.fog = new THREE.Fog(0x1a1a1a, 10, 50);
    }

    createGradientTexture() {
        const canvas = document.createElement('canvas');
        canvas.width = 512;
        canvas.height = 512;
        
        const context = canvas.getContext('2d');
        const gradient = context.createLinearGradient(0, 0, 0, 512);
        gradient.addColorStop(0, '#2a2a2a');
        gradient.addColorStop(1, '#0a0a0a');
        
        context.fillStyle = gradient;
        context.fillRect(0, 0, 512, 512);
        
        const texture = new THREE.CanvasTexture(canvas);
        return texture;
    }

    setupCamera() {
        const aspect = this.container.clientWidth / this.container.clientHeight;
        this.camera = new THREE.PerspectiveCamera(45, aspect, 0.1, 1000);
        this.camera.position.set(5, 2, 5);
        this.camera.lookAt(0, 0, 0);
    }

    setupLighting() {
        // Ambient light (soft overall illumination)
        const ambientLight = new THREE.AmbientLight(0x404040, 0.3);
        this.scene.add(ambientLight);

        // Key light (main directional light)
        this.keyLight = new THREE.DirectionalLight(0xffffff, 1.2);
        this.keyLight.position.set(10, 10, 5);
        this.keyLight.castShadow = this.config.enableShadows && !this.isLowEnd;
        
        if (this.keyLight.castShadow) {
            this.keyLight.shadow.mapSize.width = this.isMobile ? 1024 : 2048;
            this.keyLight.shadow.mapSize.height = this.isMobile ? 1024 : 2048;
            this.keyLight.shadow.camera.near = 0.5;
            this.keyLight.shadow.camera.far = 50;
            this.keyLight.shadow.camera.left = -10;
            this.keyLight.shadow.camera.right = 10;
            this.keyLight.shadow.camera.top = 10;
            this.keyLight.shadow.camera.bottom = -10;
        }
        
        this.scene.add(this.keyLight);

        // Fill light (softer secondary light)
        const fillLight = new THREE.DirectionalLight(0x8bb7f0, 0.4);
        fillLight.position.set(-5, 5, -5);
        this.scene.add(fillLight);

        // Rim light (edge highlighting)
        const rimLight = new THREE.DirectionalLight(0xffffff, 0.6);
        rimLight.position.set(0, 5, -10);
        this.scene.add(rimLight);

        // Ground plane for shadows
        if (this.config.enableShadows && !this.isLowEnd) {
            const groundGeometry = new THREE.PlaneGeometry(20, 20);
            const groundMaterial = new THREE.ShadowMaterial({ opacity: 0.3 });
            this.ground = new THREE.Mesh(groundGeometry, groundMaterial);
            this.ground.rotation.x = -Math.PI / 2;
            this.ground.position.y = -1;
            this.ground.receiveShadow = true;
            this.scene.add(this.ground);
        }
    }

    setupRenderer() {
        const canvas = document.getElementById(`${this.containerId}-canvas`);
        this.renderer = new THREE.WebGLRenderer({ 
            canvas: canvas,
            antialias: !this.isLowEnd,
            alpha: true,
            powerPreference: this.isLowEnd ? 'low-power' : 'high-performance'
        });
        
        this.renderer.setSize(this.container.clientWidth, this.container.clientHeight);
        this.renderer.setPixelRatio(this.isLowEnd ? 1 : Math.min(window.devicePixelRatio, 2));
        
        if (this.config.enableShadows && !this.isLowEnd) {
            this.renderer.shadowMap.enabled = true;
            this.renderer.shadowMap.type = THREE.PCFSoftShadowMap;
        }
        
        this.renderer.outputEncoding = THREE.sRGBEncoding;
        this.renderer.toneMapping = THREE.ACESFilmicToneMapping;
        this.renderer.toneMappingExposure = 1.2;
    }

    setupControls() {
        if (!this.config.enableControls) return;

        this.controls = new OrbitControls(this.camera, this.renderer.domElement);
        
        // Smooth controls
        this.controls.enableDamping = true;
        this.controls.dampingFactor = 0.05;
        
        // Limit rotation
        this.controls.minPolarAngle = Math.PI * 0.2;
        this.controls.maxPolarAngle = Math.PI * 0.8;
        
        // Zoom limits
        this.controls.minDistance = 3;
        this.controls.maxDistance = 15;
        
        // Auto rotate
        this.controls.autoRotate = false;
        this.controls.autoRotateSpeed = 0.5;
        
        // Events
        this.controls.addEventListener('start', () => {
            this.isUserInteracting = true;
            this.stopAutoRotate();
        });
        
        this.controls.addEventListener('end', () => {
            this.isUserInteracting = false;
            this.scheduleAutoRotate();
        });
    }

    setupLoaders() {
        // DRACO loader for compression
        this.dracoLoader = new DRACOLoader();
        this.dracoLoader.setDecoderPath('https://www.gstatic.com/draco/versioned/decoders/1.5.6/');
        
        // GLTF loader
        this.gltfLoader = new GLTFLoader();
        this.gltfLoader.setDRACOLoader(this.dracoLoader);
    }

    bindEvents() {
        // Enable 3D button
        const enableBtn = document.getElementById(`${this.containerId}-enable`);
        if (enableBtn) {
            enableBtn.addEventListener('click', () => this.enable3D());
        }

        // Color picker
        const colorBtns = this.container.querySelectorAll('.color-btn');
        colorBtns.forEach(btn => {
            btn.addEventListener('click', (e) => {
                const color = e.target.dataset.color;
                this.changeColor(color);
            });
        });

        // View mode buttons
        const viewBtns = this.container.querySelectorAll('.view-btn');
        viewBtns.forEach(btn => {
            btn.addEventListener('click', (e) => {
                const view = e.target.dataset.view;
                this.changeView(view);
            });
        });

        // Reset button
        const resetBtn = document.getElementById(`${this.containerId}-reset`);
        if (resetBtn) {
            resetBtn.addEventListener('click', () => this.resetView());
        }

        // Retry button
        const retryBtn = document.getElementById(`${this.containerId}-retry`);
        if (retryBtn) {
            retryBtn.addEventListener('click', () => this.loadModel(this.config.modelPath));
        }

        // Window resize
        window.addEventListener('resize', () => this.onWindowResize());

        // Intersection Observer for performance
        this.setupIntersectionObserver();
    }

    setupIntersectionObserver() {
        this.observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    this.isVisible = true;
                } else {
                    this.isVisible = false;
                    this.stopAutoRotate();
                }
            });
        }, { threshold: 0.1 });

        this.observer.observe(this.container);
    }

    enable3D() {
        if (!this.config.modelPath) {
            console.error('3D Car Viewer: No model path provided');
            return;
        }

        this.showCanvas();
        this.loadModel(this.config.modelPath);
    }

    showFallback() {
        const fallback = document.getElementById(`${this.containerId}-fallback`);
        const canvas = document.getElementById(`${this.containerId}-canvas-container`);
        
        if (fallback) fallback.style.display = 'block';
        if (canvas) canvas.style.display = 'none';
    }

    showCanvas() {
        const fallback = document.getElementById(`${this.containerId}-fallback`);
        const canvas = document.getElementById(`${this.containerId}-canvas-container`);
        
        if (fallback) fallback.style.display = 'none';
        if (canvas) canvas.style.display = 'block';
    }

    showLoading() {
        const loading = document.getElementById(`${this.containerId}-loading`);
        if (loading) loading.style.display = 'flex';
    }

    hideLoading() {
        const loading = document.getElementById(`${this.containerId}-loading`);
        if (loading) loading.style.display = 'none';
    }

    showError() {
        const error = document.getElementById(`${this.containerId}-error`);
        if (error) error.style.display = 'flex';
    }

    hideError() {
        const error = document.getElementById(`${this.containerId}-error`);
        if (error) error.style.display = 'none';
    }

    showControls() {
        const controls = document.getElementById(`${this.containerId}-controls`);
        if (controls) {
            controls.style.opacity = '1';
            controls.style.pointerEvents = 'auto';
        }
    }

    loadModel(modelPath) {
        if (this.isLoading) return;
        
        this.isLoading = true;
        this.showLoading();
        this.hideError();

        this.gltfLoader.load(
            modelPath,
            (gltf) => this.onModelLoaded(gltf),
            (progress) => this.onLoadProgress(progress),
            (error) => this.onLoadError(error)
        );
    }

    onModelLoaded(gltf) {
        this.isLoading = false;
        this.isLoaded = true;
        
        // Remove existing model
        if (this.currentModel) {
            this.scene.remove(this.currentModel);
        }

        // Add new model
        this.currentModel = gltf.scene;
        
        // Setup model
        this.setupModel();
        
        // Add to scene
        this.scene.add(this.currentModel);
        
        // Hide loading, show controls
        this.hideLoading();
        this.showControls();
        
        // Start auto rotate
        this.scheduleAutoRotate();
        
        // Fade in animation
        this.animateModelEntry();
    }

    setupModel() {
        if (!this.currentModel) return;

        // Center and scale model
        const box = new THREE.Box3().setFromObject(this.currentModel);
        const center = box.getCenter(new THREE.Vector3());
        const size = box.getSize(new THREE.Vector3());
        
        // Center the model
        this.currentModel.position.sub(center);
        
        // Scale to fit
        const maxSize = Math.max(size.x, size.y, size.z);
        const scale = 2 / maxSize;
        this.currentModel.scale.setScalar(scale);

        // Setup materials and shadows
        this.currentModel.traverse((child) => {
            if (child.isMesh) {
                child.castShadow = this.config.enableShadows && !this.isLowEnd;
                child.receiveShadow = this.config.enableShadows && !this.isLowEnd;
                
                // Store original material for color changes
                if (child.material && child.material.name === 'body') {
                    this.bodyMaterial = child.material;
                }
            }
        });
    }

    animateModelEntry() {
        if (!this.currentModel) return;

        // Start invisible
        this.currentModel.scale.setScalar(0);
        
        // Animate scale up
        const startTime = performance.now();
        const duration = 800;
        
        const animate = (currentTime) => {
            const elapsed = currentTime - startTime;
            const progress = Math.min(elapsed / duration, 1);
            
            // Ease out cubic
            const eased = 1 - Math.pow(1 - progress, 3);
            
            const box = new THREE.Box3().setFromObject(this.currentModel);
            const size = box.getSize(new THREE.Vector3());
            const maxSize = Math.max(size.x, size.y, size.z);
            const targetScale = 2 / maxSize;
            
            this.currentModel.scale.setScalar(targetScale * eased);
            
            if (progress < 1) {
                requestAnimationFrame(animate);
            }
        };
        
        requestAnimationFrame(animate);
    }

    onLoadProgress(progress) {
        // Could update loading bar here
        console.log('Loading progress:', (progress.loaded / progress.total * 100) + '%');
    }

    onLoadError(error) {
        console.error('3D Car Viewer: Model loading error:', error);
        console.log('3D Car Viewer: Loading fallback procedural car...');
        
        // Use fallback procedural car
        this.loadFallbackCar();
    }
    
    loadFallbackCar() {
        this.isLoading = false;
        
        // Remove existing model
        if (this.currentModel) {
            this.scene.remove(this.currentModel);
        }

        // Create fallback car
        this.currentModel = CarFallbackGenerator.createSimpleCar(this.currentColor);
        
        // Add to scene
        this.scene.add(this.currentModel);
        
        // Mark as loaded
        this.isLoaded = true;
        
        // Hide loading, show controls
        this.hideLoading();
        this.showControls();
        
        // Start auto rotate
        this.scheduleAutoRotate();
        
        // Fade in animation
        this.animateModelEntry();
        
        // Store reference for color changes
        this.bodyMaterial = {
            color: new THREE.Color(this.currentColor)
        };
    }

    changeColor(color) {
        // Update UI
        this.container.querySelectorAll('.color-btn').forEach(btn => {
            btn.classList.remove('active');
        });
        const colorBtn = this.container.querySelector(`[data-color="${color}"]`);
        if (colorBtn) {
            colorBtn.classList.add('active');
        }

        // Handle both GLTF models and fallback cars
        if (this.currentModel && this.currentModel.userData && this.currentModel.userData.bodyMaterial) {
            // Fallback car color change
            CarFallbackGenerator.updateCarColor(this.currentModel, color);
        } else if (this.bodyMaterial && this.bodyMaterial.color) {
            // GLTF model color change
            const startColor = new THREE.Color(this.currentColor);
            const endColor = new THREE.Color(color);
            
            const startTime = performance.now();
            const duration = 500;
            
            const animate = (currentTime) => {
                const elapsed = currentTime - startTime;
                const progress = Math.min(elapsed / duration, 1);
                
                // Ease out
                const eased = 1 - Math.pow(1 - progress, 2);
                
                const currentColor = startColor.clone().lerp(endColor, eased);
                this.bodyMaterial.color.copy(currentColor);
                
                if (progress < 1) {
                    requestAnimationFrame(animate);
                }
            };
            
            requestAnimationFrame(animate);
        }
        
        this.currentColor = color;
    }

    changeView(view) {
        if (!this.controls) return;

        // Update UI
        this.container.querySelectorAll('.view-btn').forEach(btn => {
            btn.classList.remove('active');
        });
        this.container.querySelector(`[data-view="${view}"]`).classList.add('active');

        // Animate camera
        let targetPosition, targetLookAt;
        
        if (view === 'exterior') {
            targetPosition = new THREE.Vector3(5, 2, 5);
            targetLookAt = new THREE.Vector3(0, 0, 0);
            this.controls.enableRotate = true;
        } else if (view === 'interior') {
            targetPosition = new THREE.Vector3(0, 1, 0);
            targetLookAt = new THREE.Vector3(0, 1, -1);
            this.controls.enableRotate = false;
        }

        this.animateCamera(targetPosition, targetLookAt);
    }

    animateCamera(targetPosition, targetLookAt) {
        const startPosition = this.camera.position.clone();
        const startLookAt = this.controls.target.clone();
        
        const startTime = performance.now();
        const duration = 800;
        
        const animate = (currentTime) => {
            const elapsed = currentTime - startTime;
            const progress = Math.min(elapsed / duration, 1);
            
            // Ease in-out
            const eased = progress < 0.5 
                ? 2 * progress * progress 
                : 1 - Math.pow(-2 * progress + 2, 2) / 2;
            
            this.camera.position.lerpVectors(startPosition, targetPosition, eased);
            this.controls.target.lerpVectors(startLookAt, targetLookAt, eased);
            this.controls.update();
            
            if (progress < 1) {
                requestAnimationFrame(animate);
            }
        };
        
        requestAnimationFrame(animate);
    }

    resetView() {
        if (!this.controls) return;

        const targetPosition = new THREE.Vector3(5, 2, 5);
        const targetLookAt = new THREE.Vector3(0, 0, 0);
        
        this.animateCamera(targetPosition, targetLookAt);
        
        // Reset view mode
        this.changeView('exterior');
    }

    scheduleAutoRotate() {
        if (!this.config.enableAutoRotate || this.isMobile) return;
        
        this.stopAutoRotate();
        
        this.autoRotateTimeout = setTimeout(() => {
            if (this.controls && !this.isUserInteracting && this.isVisible) {
                this.controls.autoRotate = true;
            }
        }, 5000);
    }

    stopAutoRotate() {
        if (this.autoRotateTimeout) {
            clearTimeout(this.autoRotateTimeout);
            this.autoRotateTimeout = null;
        }
        
        if (this.controls) {
            this.controls.autoRotate = false;
        }
    }

    startRenderLoop() {
        const render = () => {
            requestAnimationFrame(render);
            
            // Only render if visible and loaded
            if (this.isVisible && this.isLoaded) {
                if (this.controls) {
                    this.controls.update();
                }
                
                this.renderer.render(this.scene, this.camera);
            }
        };
        
        render();
    }

    onWindowResize() {
        if (!this.camera || !this.renderer) return;

        const width = this.container.clientWidth;
        const height = this.container.clientHeight;

        this.camera.aspect = width / height;
        this.camera.updateProjectionMatrix();
        
        this.renderer.setSize(width, height);
    }

    // Public API
    setModel(modelPath) {
        this.config.modelPath = modelPath;
        if (this.isLoaded) {
            this.loadModel(modelPath);
        }
    }

    setColors(colors) {
        this.config.colors = colors;
        // Update color picker UI
        const colorPicker = this.container.querySelector('.color-picker');
        if (colorPicker) {
            colorPicker.innerHTML = colors.map(color => 
                `<button class="color-btn ${color === this.currentColor ? 'active' : ''}" 
                         data-color="${color}" 
                         style="background-color: ${color}"></button>`
            ).join('');
        }
    }

    destroy() {
        // Clean up
        if (this.observer) {
            this.observer.disconnect();
        }
        
        this.stopAutoRotate();
        
        if (this.renderer) {
            this.renderer.dispose();
        }
        
        if (this.dracoLoader) {
            this.dracoLoader.dispose();
        }
    }
}

// Export for use
window.CarViewer3D = CarViewer3D;
export default CarViewer3D;