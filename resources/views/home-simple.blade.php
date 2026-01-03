@extends('layouts.simple')

@section('title', 'Home - Car Rental & Sales System')

@section('content')
<!-- Hero Section -->
<div class="hero-gradient text-white">
    <div class="max-w-7xl mx-auto px-4 py-20">
        <div class="text-center">
            <h1 class="text-4xl md:text-6xl font-bold mb-6 animate__animated animate__fadeInUp">
                Car Rental & Sales
            </h1>
            <p class="text-xl md:text-2xl mb-8 text-blue-100 animate__animated animate__fadeInUp animate__delay-1s">
                Rent or buy quality vehicles at affordable prices
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center animate__animated animate__fadeInUp animate__delay-2s">
                <a href="{{ route('vehicles.rentals') }}" class="bg-white text-blue-600 hover:bg-gray-100 px-8 py-3 rounded-lg font-semibold text-lg btn-hover transition-all">
                    Rent a Car
                </a>
                <a href="{{ route('vehicles.sales') }}" class="border-2 border-white text-white hover:bg-white hover:text-blue-600 px-8 py-3 rounded-lg font-semibold text-lg btn-hover transition-all">
                    Buy a Car
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Features Section -->
<div class="py-16 bg-white">
    <div class="max-w-7xl mx-auto px-4">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-bold text-gray-900 mb-4">Why Choose Us?</h2>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="text-center">
                <div class="bg-blue-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-semibold mb-2">Affordable Prices</h3>
                <p class="text-gray-600">Best service at competitive prices</p>
            </div>
            
            <div class="text-center">
                <div class="bg-blue-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-semibold mb-2">Safe & Secure</h3>
                <p class="text-gray-600">Complete safety and security guaranteed</p>
            </div>
            
            <div class="text-center">
                <div class="bg-blue-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-semibold mb-2">Quick Service</h3>
                <p class="text-gray-600">Fast and efficient service delivery</p>
            </div>
        </div>
    </div>
</div>

<!-- Featured Rentals -->
@if($featuredRentals && $featuredRentals->count() > 0)
<div class="py-16 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-bold text-gray-900 mb-4">Featured Rental Cars</h2>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($featuredRentals as $vehicle)
                <div class="bg-white rounded-lg shadow-md overflow-hidden card-hover transition-all">
                    <div class="h-48 bg-gray-200 flex items-center justify-center">
                        @if($vehicle->primary_image)
                            <img src="{{ asset('storage/' . $vehicle->primary_image) }}" alt="{{ $vehicle->full_name }}" class="w-full h-full object-cover">
                        @else
                            <svg class="w-16 h-16 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z" clip-rule="evenodd" />
                            </svg>
                        @endif
                    </div>
                    <div class="p-6">
                        <h3 class="text-xl font-semibold mb-2">{{ $vehicle->full_name }}</h3>
                        <p class="text-gray-600 mb-4">{{ ucfirst($vehicle->category) }} • {{ ucfirst($vehicle->transmission) }}</p>
                        <div class="flex justify-between items-center">
                            <span class="text-2xl font-bold text-blue-600">${{ $vehicle->rental_price_per_day }}/day</span>
                            <a href="{{ route('vehicles.show', $vehicle) }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 btn-hover transition-all">
                                View Details
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        
        <div class="text-center mt-8">
            <a href="{{ route('vehicles.rentals') }}" class="bg-blue-600 text-white px-8 py-3 rounded-lg hover:bg-blue-700 btn-hover transition-all">
                View All Rentals
            </a>
        </div>
    </div>
</div>
@endif

<!-- Featured Sales -->
@if($featuredSales && $featuredSales->count() > 0)
<div class="py-16 bg-white">
    <div class="max-w-7xl mx-auto px-4">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-bold text-gray-900 mb-4">Cars for Sale</h2>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($featuredSales as $vehicle)
                <div class="bg-white rounded-lg shadow-md overflow-hidden card-hover transition-all">
                    <div class="h-48 bg-gray-200 flex items-center justify-center">
                        @if($vehicle->primary_image)
                            <img src="{{ asset('storage/' . $vehicle->primary_image) }}" alt="{{ $vehicle->full_name }}" class="w-full h-full object-cover">
                        @else
                            <svg class="w-16 h-16 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z" clip-rule="evenodd" />
                            </svg>
                        @endif
                    </div>
                    <div class="p-6">
                        <h3 class="text-xl font-semibold mb-2">{{ $vehicle->full_name }}</h3>
                        <p class="text-gray-600 mb-4">{{ number_format($vehicle->mileage) }} km • {{ ucfirst($vehicle->condition) }}</p>
                        <div class="flex justify-between items-center">
                            <span class="text-2xl font-bold text-green-600">${{ number_format($vehicle->sale_price) }}</span>
                            <a href="{{ route('vehicles.show', $vehicle) }}" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700 btn-hover transition-all">
                                View Details
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        
        <div class="text-center mt-8">
            <a href="{{ route('vehicles.sales') }}" class="bg-green-600 text-white px-8 py-3 rounded-lg hover:bg-green-700 btn-hover transition-all">
                View All Sales
            </a>
        </div>
    </div>
</div>
@endif

<!-- No Data Message -->
@if((!$featuredRentals || $featuredRentals->count() == 0) && (!$featuredSales || $featuredSales->count() == 0))
<div class="py-16 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 text-center">
        <h2 class="text-2xl font-bold text-gray-900 mb-4">No Vehicles Available</h2>
        <p class="text-gray-600 mb-8">We're currently updating our inventory. Please check back soon!</p>
        <a href="{{ route('contact.show') }}" class="bg-blue-600 text-white px-8 py-3 rounded-lg hover:bg-blue-700 btn-hover transition-all">
            Contact Us
        </a>
    </div>
</div>
@endif
@endsection