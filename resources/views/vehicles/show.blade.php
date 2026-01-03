@extends('layouts.app')

@section('title', $vehicle->full_name . ' - Car Rental & Sales System')

@section('content')
<div class="bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Breadcrumb -->
        <nav class="flex mb-8 animate__animated animate__fadeInLeft" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 md:space-x-3">
                <li class="inline-flex items-center">
                    <a href="{{ route('home') }}" class="text-gray-700 hover:text-blue-600">
                        @if(app()->getLocale() === 'am')
                            ቤት
                        @else
                            Home
                        @endif
                    </a>
                </li>
                <li>
                    <div class="flex items-center">
                        <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                        </svg>
                        @if($vehicle->available_for_rent)
                            <a href="{{ route('vehicles.rentals') }}" class="ml-1 text-gray-700 hover:text-blue-600 md:ml-2">
                                @if(app()->getLocale() === 'am')
                                    ኪራይ
                                @else
                                    Rentals
                                @endif
                            </a>
                        @endif
                        @if($vehicle->available_for_sale)
                            <a href="{{ route('vehicles.sales') }}" class="ml-1 text-gray-700 hover:text-blue-600 md:ml-2">
                                @if(app()->getLocale() === 'am')
                                    ሽያጭ
                                @else
                                    Sales
                                @endif
                            </a>
                        @endif
                    </div>
                </li>
                <li aria-current="page">
                    <div class="flex items-center">
                        <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                        </svg>
                        <span class="ml-1 text-gray-500 md:ml-2">{{ $vehicle->full_name }}</span>
                    </div>
                </li>
            </ol>
        </nav>

        <div class="lg:grid lg:grid-cols-2 lg:gap-x-8 lg:items-start">
            <!-- Image Gallery -->
            <div class="flex flex-col-reverse animate__animated animate__fadeInLeft">
                <!-- 3D Car Viewer -->
                <div class="mt-6">
                    <div class="flex justify-between items-center mb-4">
                        <h4 class="text-sm font-medium text-gray-900">
                            @if(app()->getLocale() === 'am')
                                3D እይታ
                            @else
                                3D Interactive View
                            @endif
                        </h4>
                        <div class="flex items-center space-x-2">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                @if(app()->getLocale() === 'am')
                                    አዲስ
                                @else
                                    New
                                @endif
                            </span>
                        </div>
                    </div>
                    <!-- 3D Viewer Container -->
                    <div id="car-3d-viewer-{{ $vehicle->id }}" class="w-full"></div>
                </div>
                <!-- Image selector -->
                <div class="hidden mt-6 w-full max-w-2xl mx-auto sm:block lg:max-w-none">
                    <div class="grid grid-cols-4 gap-6" aria-orientation="horizontal" role="tablist">
                        @if($vehicle->images->count() > 0)
                            @foreach($vehicle->images as $index => $image)
                                <button id="tabs-{{ $index }}-tab" 
                                        class="relative h-24 bg-white rounded-md flex items-center justify-center text-sm font-medium uppercase text-gray-900 cursor-pointer hover:bg-gray-50 focus:outline-none focus:ring focus:ring-offset-4 focus:ring-blue-500"
                                        aria-controls="tabs-{{ $index }}" 
                                        role="tab" 
                                        type="button"
                                        onclick="showImage({{ $index }})">
                                    <span class="sr-only">{{ $image->alt_text ?? $vehicle->full_name }}</span>
                                    <span class="absolute inset-0 rounded-md overflow-hidden">
                                        <img src="{{ asset('storage/' . $image->image_path) }}" 
                                             alt="{{ $image->alt_text ?? $vehicle->full_name }}" 
                                             class="w-full h-full object-center object-cover">
                                    </span>
                                    <span class="absolute inset-0 rounded-md ring-2 ring-offset-2 pointer-events-none" 
                                          aria-hidden="true"></span>
                                </button>
                            @endforeach
                        @else
                            <div class="relative h-24 bg-gray-200 rounded-md flex items-center justify-center">
                                <svg class="w-8 h-8 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Main image -->
                <div class="w-full aspect-w-1 aspect-h-1">
                    @if($vehicle->images->count() > 0)
                        @foreach($vehicle->images as $index => $image)
                            <div id="tabs-{{ $index }}" 
                                 class="w-full h-96 {{ $index === 0 ? '' : 'hidden' }}" 
                                 aria-labelledby="tabs-{{ $index }}-tab" 
                                 role="tabpanel" 
                                 tabindex="0">
                                <img src="{{ asset('storage/' . $image->image_path) }}" 
                                     alt="{{ $image->alt_text ?? $vehicle->full_name }}" 
                                     class="w-full h-full object-center object-cover sm:rounded-lg">
                            </div>
                        @endforeach
                    @else
                        <div class="w-full h-96 bg-gray-200 flex items-center justify-center sm:rounded-lg">
                            <svg class="w-24 h-24 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z" clip-rule="evenodd" />
                            </svg>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Vehicle info -->
            <div class="mt-10 px-4 sm:px-0 sm:mt-16 lg:mt-0 animate__animated animate__fadeInRight">
                <h1 class="text-3xl font-extrabold tracking-tight text-gray-900 animate-text-glow">{{ $vehicle->full_name }}</h1>

                <!-- Pricing -->
                <div class="mt-3">
                    @if($vehicle->available_for_rent)
                        <div class="mb-4">
                            <h2 class="sr-only">Rental Price</h2>
                            <p class="text-3xl text-blue-600 font-bold">
                                ${{ $vehicle->rental_price_per_day }}
                                <span class="text-lg text-gray-500 font-normal">/
                                    @if(app()->getLocale() === 'am')
                                        ቀን
                                    @else
                                        day
                                    @endif
                                </span>
                            </p>
                            @if($vehicle->with_driver_available && $vehicle->driver_cost_per_day)
                                <p class="text-sm text-gray-600 mt-1">
                                    +${{ $vehicle->driver_cost_per_day }}/day 
                                    @if(app()->getLocale() === 'am')
                                        ለሹፌር
                                    @else
                                        for driver
                                    @endif
                                </p>
                            @endif
                        </div>
                    @endif

                    @if($vehicle->available_for_sale)
                        <div class="mb-4">
                            <h2 class="sr-only">Sale Price</h2>
                            <p class="text-3xl text-green-600 font-bold">
                                ${{ number_format($vehicle->sale_price) }}
                                <span class="text-lg text-gray-500 font-normal">
                                    @if(app()->getLocale() === 'am')
                                        ታክስ ጨምሮ
                                    @else
                                        tax included
                                    @endif
                                </span>
                            </p>
                        </div>
                    @endif
                </div>

                <!-- Vehicle Details -->
                <div class="mt-6">
                    <h3 class="text-lg font-medium text-gray-900">
                        @if(app()->getLocale() === 'am')
                            ዝርዝር መረጃ
                        @else
                            Vehicle Details
                        @endif
                    </h3>
                    
                    <div class="mt-4 grid grid-cols-1 gap-4 sm:grid-cols-2">
                        <div class="border rounded-lg p-4">
                            <dt class="text-sm font-medium text-gray-500">
                                @if(app()->getLocale() === 'am')
                                    ዓመት
                                @else
                                    Year
                                @endif
                            </dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $vehicle->year }}</dd>
                        </div>
                        
                        <div class="border rounded-lg p-4">
                            <dt class="text-sm font-medium text-gray-500">
                                @if(app()->getLocale() === 'am')
                                    ኪሎሜትር
                                @else
                                    Mileage
                                @endif
                            </dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ number_format($vehicle->mileage) }} km</dd>
                        </div>
                        
                        <div class="border rounded-lg p-4">
                            <dt class="text-sm font-medium text-gray-500">
                                @if(app()->getLocale() === 'am')
                                    ምድብ
                                @else
                                    Category
                                @endif
                            </dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ ucfirst($vehicle->category) }}</dd>
                        </div>
                        
                        <div class="border rounded-lg p-4">
                            <dt class="text-sm font-medium text-gray-500">
                                @if(app()->getLocale() === 'am')
                                    ማስተላለፊያ
                                @else
                                    Transmission
                                @endif
                            </dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ ucfirst($vehicle->transmission) }}</dd>
                        </div>
                        
                        <div class="border rounded-lg p-4">
                            <dt class="text-sm font-medium text-gray-500">
                                @if(app()->getLocale() === 'am')
                                    ነዳጅ አይነት
                                @else
                                    Fuel Type
                                @endif
                            </dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ ucfirst($vehicle->fuel_type) }}</dd>
                        </div>
                        
                        <div class="border rounded-lg p-4">
                            <dt class="text-sm font-medium text-gray-500">
                                @if(app()->getLocale() === 'am')
                                    ቀለም
                                @else
                                    Color
                                @endif
                            </dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $vehicle->color }}</dd>
                        </div>

                        @if($vehicle->available_for_sale)
                            <div class="border rounded-lg p-4">
                                <dt class="text-sm font-medium text-gray-500">
                                    @if(app()->getLocale() === 'am')
                                        ሁኔታ
                                    @else
                                        Condition
                                    @endif
                                </dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ ucfirst($vehicle->condition) }}</dd>
                            </div>
                        @endif

                        <div class="border rounded-lg p-4">
                            <dt class="text-sm font-medium text-gray-500">
                                @if(app()->getLocale() === 'am')
                                    ሰሌዳ ቁጥር
                                @else
                                    License Plate
                                @endif
                            </dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $vehicle->license_plate }}</dd>
                        </div>
                    </div>
                </div>

                <!-- Features -->
                @if($vehicle->features && count($vehicle->features) > 0)
                    <div class="mt-6">
                        <h3 class="text-lg font-medium text-gray-900">
                            @if(app()->getLocale() === 'am')
                                ባህሪያት
                            @else
                                Features
                            @endif
                        </h3>
                        <div class="mt-4 flex flex-wrap gap-2">
                            @foreach($vehicle->features as $feature)
                                <span class="bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-sm">
                                    {{ $feature }}
                                </span>
                            @endforeach
                        </div>
                    </div>
                @endif

                <!-- Description -->
                @if($vehicle->description)
                    <div class="mt-6">
                        <h3 class="text-lg font-medium text-gray-900">
                            @if(app()->getLocale() === 'am')
                                መግለጫ
                            @else
                                Description
                            @endif
                        </h3>
                        <div class="mt-4 prose prose-sm text-gray-500">
                            <p>{{ $vehicle->description }}</p>
                        </div>
                    </div>
                @endif

                <!-- Driving Options for Rentals -->
                @if($vehicle->available_for_rent)
                    <div class="mt-6">
                        <h3 class="text-lg font-medium text-gray-900">
                            @if(app()->getLocale() === 'am')
                                የማሽከርከር አማራጮች
                            @else
                                Driving Options
                            @endif
                        </h3>
                        <div class="mt-4 space-y-2">
                            @if($vehicle->self_drive_available)
                                <div class="flex items-center">
                                    <svg class="w-5 h-5 text-green-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                    </svg>
                                    <span class="text-sm text-gray-700">
                                        @if(app()->getLocale() === 'am')
                                            ራስዎ ይንዱ
                                        @else
                                            Self Drive Available
                                        @endif
                                    </span>
                                </div>
                            @endif
                            @if($vehicle->with_driver_available)
                                <div class="flex items-center">
                                    <svg class="w-5 h-5 text-green-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                    </svg>
                                    <span class="text-sm text-gray-700">
                                        @if(app()->getLocale() === 'am')
                                            ከሹፌር ጋር
                                        @else
                                            With Driver Available
                                        @endif
                                    </span>
                                </div>
                            @endif
                        </div>
                    </div>
                @endif

                <!-- Action Buttons -->
                <div class="mt-8 space-y-4">
                    @if($vehicle->available_for_rent)
                        @auth
                            <a href="{{ route('bookings.create', $vehicle) }}" 
                               class="w-full bg-blue-600 border border-transparent rounded-md py-3 px-8 flex items-center justify-center text-base font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 animate-ripple animate-scale-on-hover">
                                @if(app()->getLocale() === 'am')
                                    አሁን ይከራዩ
                                @else
                                    Rent Now
                                @endif
                            </a>
                        @else
                            <a href="{{ route('login') }}" 
                               class="w-full bg-blue-600 border border-transparent rounded-md py-3 px-8 flex items-center justify-center text-base font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 animate-ripple">
                                @if(app()->getLocale() === 'am')
                                    ለመከራየት ይግቡ
                                @else
                                    Login to Rent
                                @endif
                            </a>
                        @endauth
                    @endif

                    @if($vehicle->available_for_sale)
                        @auth
                            <a href="{{ route('checkout.stage1', $vehicle) }}" 
                               class="w-full bg-green-600 border border-transparent rounded-md py-3 px-8 flex items-center justify-center text-base font-medium text-white hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 animate-ripple animate-scale-on-hover">
                                @if(app()->getLocale() === 'am')
                                    አሁን ይግዙ
                                @else
                                    Buy Now
                                @endif
                            </a>
                            </form>
                        @else
                            <a href="{{ route('login') }}" 
                               class="w-full bg-green-600 border border-transparent rounded-md py-3 px-8 flex items-center justify-center text-base font-medium text-white hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 animate-ripple">
                                @if(app()->getLocale() === 'am')
                                    ለመግዛት ይግቡ
                                @else
                                    Login to Buy
                                @endif
                            </a>
                        @endauth
                    @endif
                </div>

                <!-- Contact Info -->
                <div class="mt-8 border-t border-gray-200 pt-8">
                    <h3 class="text-lg font-medium text-gray-900">
                        @if(app()->getLocale() === 'am')
                            ጥያቄዎች አሉዎት?
                        @else
                            Have Questions?
                        @endif
                    </h3>
                    <div class="mt-4 space-y-2">
                        <p class="text-sm text-gray-600">
                            📞 +251-911-000-000
                        </p>
                        <p class="text-sm text-gray-600">
                            ✉️ info@carrental.com
                        </p>
                        <a href="{{ route('contact.show') }}" class="text-sm text-blue-600 hover:text-blue-500">
                            @if(app()->getLocale() === 'am')
                                መልእክት ይላኩ →
                            @else
                                Send us a message →
                            @endif
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Similar Vehicles -->
        @if($similarVehicles->count() > 0)
            <div class="mt-16">
                <h2 class="text-2xl font-bold text-gray-900 mb-8">
                    @if(app()->getLocale() === 'am')
                        ተመሳሳይ ተሽከርካሪዎች
                    @else
                        Similar Vehicles
                    @endif
                </h2>
                
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                    @foreach($similarVehicles as $similar)
                        <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition duration-300">
                            <div class="h-32 bg-gray-200">
                                @if($similar->primary_image)
                                    <img src="{{ asset('storage/' . $similar->primary_image) }}" 
                                         alt="{{ $similar->full_name }}" 
                                         class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full flex items-center justify-center text-gray-400">
                                        <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z" clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                @endif
                            </div>
                            <div class="p-4">
                                <h3 class="font-semibold text-gray-900 text-sm">{{ $similar->full_name }}</h3>
                                <div class="mt-2">
                                    @if($similar->available_for_rent)
                                        <p class="text-blue-600 font-bold text-sm">${{ $similar->rental_price_per_day }}/day</p>
                                    @endif
                                    @if($similar->available_for_sale)
                                        <p class="text-green-600 font-bold text-sm">${{ number_format($similar->sale_price) }}</p>
                                    @endif
                                </div>
                                <a href="{{ route('vehicles.show', $similar) }}" 
                                   class="mt-2 block bg-gray-100 text-gray-700 px-3 py-1 rounded text-center hover:bg-gray-200 transition duration-300 text-xs">
                                    @if(app()->getLocale() === 'am')
                                        ዝርዝር
                                    @else
                                        View Details
                                    @endif
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    </div>
</div>

<script>
function showImage(index) {
    // Hide all images
    const images = document.querySelectorAll('[id^="tabs-"]');
    images.forEach(img => {
        if (img.id.includes('-tab')) return; // Skip tab buttons
        img.classList.add('hidden');
    });
    
    // Show selected image
    document.getElementById(`tabs-${index}`).classList.remove('hidden');
    
    // Update tab states
    const tabs = document.querySelectorAll('[id$="-tab"]');
    tabs.forEach(tab => {
        tab.classList.remove('ring-blue-500');
        tab.querySelector('span:last-child').classList.remove('ring-blue-500');
    });
    
    // Highlight active tab
    const activeTab = document.getElementById(`tabs-${index}-tab`);
    activeTab.classList.add('ring-blue-500');
    activeTab.querySelector('span:last-child').classList.add('ring-blue-500');
}

// 3D Car Viewer
let scene, camera, renderer, car;
let is3DEnabled = false;

document.getElementById('toggle-3d').addEventListener('click', function() {
    const viewer = document.getElementById('car-3d-viewer');
    const button = document.getElementById('toggle-3d');
    
    if (!is3DEnabled) {
        viewer.classList.remove('hidden');
        button.textContent = 'Disable 3D View';
        init3DViewer();
        is3DEnabled = true;
    } else {
        viewer.classList.add('hidden');
        button.textContent = 'Enable 3D View';
        cleanup3DViewer();
        is3DEnabled = false;
    }
});

function init3DViewer() {
    const container = document.getElementById('car-3d-viewer');
    
    // Scene setup
    scene = new THREE.Scene();
    scene.background = new THREE.Color(0xf0f0f0);
    
    // Camera setup
    camera = new THREE.PerspectiveCamera(75, container.offsetWidth / container.offsetHeight, 0.1, 1000);
    camera.position.set(5, 3, 5);
    
    // Renderer setup
    renderer = new THREE.WebGLRenderer({ antialias: true });
    renderer.setSize(container.offsetWidth, container.offsetHeight);
    renderer.shadowMap.enabled = true;
    renderer.shadowMap.type = THREE.PCFSoftShadowMap;
    
    // Clear loading content and add renderer
    container.innerHTML = '';
    container.appendChild(renderer.domElement);
    
    // Lighting
    const ambientLight = new THREE.AmbientLight(0x404040, 0.6);
    scene.add(ambientLight);
    
    const directionalLight = new THREE.DirectionalLight(0xffffff, 0.8);
    directionalLight.position.set(10, 10, 5);
    directionalLight.castShadow = true;
    scene.add(directionalLight);
    
    // Create a simple car representation (box for demo)
    const carGeometry = new THREE.BoxGeometry(4, 1.5, 2);
    const carMaterial = new THREE.MeshLambertMaterial({ color: 0x3b82f6 });
    car = new THREE.Mesh(carGeometry, carMaterial);
    car.castShadow = true;
    scene.add(car);
    
    // Add wheels
    const wheelGeometry = new THREE.CylinderGeometry(0.4, 0.4, 0.2, 16);
    const wheelMaterial = new THREE.MeshLambertMaterial({ color: 0x333333 });
    
    const positions = [
        [-1.5, -0.75, 0.8],
        [1.5, -0.75, 0.8],
        [-1.5, -0.75, -0.8],
        [1.5, -0.75, -0.8]
    ];
    
    positions.forEach(pos => {
        const wheel = new THREE.Mesh(wheelGeometry, wheelMaterial);
        wheel.position.set(pos[0], pos[1], pos[2]);
        wheel.rotation.z = Math.PI / 2;
        wheel.castShadow = true;
        scene.add(wheel);
    });
    
    // Ground plane
    const planeGeometry = new THREE.PlaneGeometry(20, 20);
    const planeMaterial = new THREE.MeshLambertMaterial({ color: 0xffffff });
    const plane = new THREE.Mesh(planeGeometry, planeMaterial);
    plane.rotation.x = -Math.PI / 2;
    plane.position.y = -1.5;
    plane.receiveShadow = true;
    scene.add(plane);
    
    // Controls
    let isDragging = false;
    let previousMousePosition = { x: 0, y: 0 };
    
    container.addEventListener('mousedown', (e) => {
        isDragging = true;
        previousMousePosition = { x: e.clientX, y: e.clientY };
    });
    
    container.addEventListener('mousemove', (e) => {
        if (isDragging) {
            const deltaMove = {
                x: e.clientX - previousMousePosition.x,
                y: e.clientY - previousMousePosition.y
            };
            
            const deltaRotationQuaternion = new THREE.Quaternion()
                .setFromEuler(new THREE.Euler(
                    toRadians(deltaMove.y * 1),
                    toRadians(deltaMove.x * 1),
                    0,
                    'XYZ'
                ));
            
            car.quaternion.multiplyQuaternions(deltaRotationQuaternion, car.quaternion);
            previousMousePosition = { x: e.clientX, y: e.clientY };
        }
    });
    
    container.addEventListener('mouseup', () => {
        isDragging = false;
    });
    
    // Zoom with mouse wheel
    container.addEventListener('wheel', (e) => {
        e.preventDefault();
        const zoomSpeed = 0.1;
        camera.position.multiplyScalar(1 + (e.deltaY > 0 ? zoomSpeed : -zoomSpeed));
        camera.position.clampLength(3, 15);
    });
    
    // Auto rotation when not dragging
    function animate() {
        if (!isDragging && is3DEnabled) {
            car.rotation.y += 0.005;
        }
        
        camera.lookAt(car.position);
        renderer.render(scene, camera);
        
        if (is3DEnabled) {
            requestAnimationFrame(animate);
        }
    }
    
    animate();
}

function cleanup3DViewer() {
    if (renderer) {
        renderer.dispose();
        renderer = null;
    }
    scene = null;
    camera = null;
    car = null;
}

<!-- 3D Car Viewer Initialization -->
<script type="module">
import CarViewer3D from '/js/3d-car-viewer.js';

document.addEventListener('DOMContentLoaded', function() {
    // Vehicle data
    const vehicleData = {
        id: {{ $vehicle->id }},
        name: '{{ $vehicle->full_name }}',
        colors: [
            '#ffffff', // White
            '#000000', // Black  
            '#c0392b', // Red
            '#2980b9', // Blue
            '#27ae60', // Green
            '#f39c12', // Orange
            '#9b59b6', // Purple
            '#34495e'  // Dark Gray
        ],
        fallbackImage: '{{ $vehicle->primary_image ? asset("storage/" . $vehicle->primary_image) : asset("images/car-placeholder.jpg") }}',
        // For demo purposes, using a placeholder 3D model
        // In production, you would have actual GLTF/GLB models for each vehicle
        modelPath: '/models/cars/generic-car.glb' // This would be vehicle-specific
    };

    // Initialize 3D Car Viewer
    const viewer3D = new CarViewer3D(`car-3d-viewer-{{ $vehicle->id }}`, {
        modelPath: vehicleData.modelPath,
        fallbackImage: vehicleData.fallbackImage,
        colors: vehicleData.colors,
        autoRotate: true,
        shadows: true,
        controls: true,
        adaptiveQuality: true
    });

    // Store viewer instance globally for debugging
    window.carViewer3D = viewer3D;

    // Optional: Update viewer when vehicle data changes
    window.updateCarViewer = function(newModelPath, newColors) {
        if (viewer3D) {
            if (newModelPath) {
                viewer3D.setModel(newModelPath);
            }
            if (newColors) {
                viewer3D.setColors(newColors);
            }
        }
    };
});
</script>

<!-- Legacy image gallery script -->
<script>
function showImage(index) {
    // Hide all images
    const images = document.querySelectorAll('[id^="tabs-"]');
    images.forEach(img => {
        if (img.id.includes('-tab')) return; // Skip tab buttons
        img.classList.add('hidden');
    });
    
    // Show selected image
    const selectedImage = document.getElementById(`tabs-${index}`);
    if (selectedImage) {
        selectedImage.classList.remove('hidden');
    }
    
    // Update tab states
    const tabs = document.querySelectorAll('[id$="-tab"]');
    tabs.forEach(tab => {
        tab.classList.remove('ring-blue-500');
        tab.querySelector('span:last-child').classList.remove('ring-blue-500');
    });
    
    const selectedTab = document.getElementById(`tabs-${index}-tab`);
    if (selectedTab) {
        selectedTab.classList.add('ring-blue-500');
        selectedTab.querySelector('span:last-child').classList.add('ring-blue-500');
    }
}

// Initialize first image as active
document.addEventListener('DOMContentLoaded', function() {
    const firstTab = document.getElementById('tabs-0-tab');
    if (firstTab) {
        showImage(0);
    }
});
</script>
@endsection