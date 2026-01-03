@extends('layouts.app')

@section('title', 'Home - Car Rental & Sales System')

@section('content')
<!-- Hero Section -->
<div class="hero-gradient text-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20">
        <div class="text-center">
            <h1 class="text-4xl md:text-6xl font-bold mb-6 animate__animated animate__fadeInUp">
                @if(app()->getLocale() === 'am')
                    የተሽከርካሪ ኪራይ እና ሽያጭ
                @else
                    Car Rental & Sales
                @endif
            </h1>
            <p class="text-xl md:text-2xl mb-8 text-blue-100 animate__animated animate__fadeInUp animate__delay-1s">
                @if(app()->getLocale() === 'am')
                    ምርጥ ተሽከርካሪዎችን በተመጣጣኝ ዋጋ ይከራዩ ወይም ይግዙ
                @else
                    Rent or buy quality vehicles at affordable prices
                @endif
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center animate__animated animate__fadeInUp animate__delay-2s">
                <a href="{{ route('vehicles.rentals') }}" class="bg-white text-blue-600 hover:bg-gray-100 px-8 py-3 rounded-lg font-semibold text-lg btn-hover transition-all">
                    @if(app()->getLocale() === 'am')
                        መኪና ይከራዩ
                    @else
                        Rent a Car
                    @endif
                </a>
                <a href="{{ route('vehicles.sales') }}" class="border-2 border-white text-white hover:bg-white hover:text-blue-600 px-8 py-3 rounded-lg font-semibold text-lg btn-hover transition-all">
                    @if(app()->getLocale() === 'am')
                        መኪና ይግዙ
                    @else
                        Buy a Car
                    @endif
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Features Section -->
<div class="py-16 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-bold text-gray-900 mb-4">
                @if(app()->getLocale() === 'am')
                    ለምን እኛን ይምረጡ?
                @else
                    Why Choose Us?
                @endif
            </h2>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="text-center animate-fade-in">
                <div class="bg-blue-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-semibold mb-2">
                    @if(app()->getLocale() === 'am')
                        ተመጣጣኝ ዋጋ
                    @else
                        Affordable Prices
                    @endif
                </h3>
                <p class="text-gray-600">
                    @if(app()->getLocale() === 'am')
                        በተመጣጣኝ ዋጋ ምርጥ አገልግሎት
                    @else
                        Best service at competitive prices
                    @endif
                </p>
            </div>
            
            <div class="text-center animate-fade-in" style="animation-delay: 0.2s;">
                <div class="bg-blue-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-semibold mb-2">
                    @if(app()->getLocale() === 'am')
                        ደህንነት
                    @else
                        Safe & Secure
                    @endif
                </h3>
                <p class="text-gray-600">
                    @if(app()->getLocale() === 'am')
                        ሙሉ ደህንነት እና ጥበቃ
                    @else
                        Complete safety and security guaranteed
                    @endif
                </p>
            </div>
            
            <div class="text-center animate-fade-in" style="animation-delay: 0.4s;">
                <div class="bg-blue-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-semibold mb-2">
                    @if(app()->getLocale() === 'am')
                        ፈጣን አገልግሎት
                    @else
                        Quick Service
                    @endif
                </h3>
                <p class="text-gray-600">
                    @if(app()->getLocale() === 'am')
                        ፈጣን እና ቀልጣፋ አገልግሎት
                    @else
                        Fast and efficient service delivery
                    @endif
                </p>
            </div>
        </div>
    </div>
</div>

<!-- Featured Rentals -->
@if($featuredRentals && $featuredRentals->count() > 0)
<div class="py-16 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-bold text-gray-900 mb-4">
                @if(app()->getLocale() === 'am')
                    ተወዳጅ የኪራይ መኪኖች
                @else
                    Featured Rental Cars
                @endif
            </h2>
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
                                @if(app()->getLocale() === 'am')
                                    ዝርዝር
                                @else
                                    View Details
                                @endif
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        
        <div class="text-center mt-8">
            <a href="{{ route('vehicles.rentals') }}" class="bg-blue-600 text-white px-8 py-3 rounded-lg hover:bg-blue-700 btn-hover transition-all">
                @if(app()->getLocale() === 'am')
                    ሁሉንም ይመልከቱ
                @else
                    View All Rentals
                @endif
            </a>
        </div>
    </div>
</div>
@endif

<!-- Featured Sales -->
@if($featuredSales && $featuredSales->count() > 0)
<div class="py-16 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-bold text-gray-900 mb-4">
                @if(app()->getLocale() === 'am')
                    ለሽያጭ የቀረቡ መኪኖች
                @else
                    Cars for Sale
                @endif
            </h2>
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
                                @if(app()->getLocale() === 'am')
                                    ዝርዝር
                                @else
                                    View Details
                                @endif
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        
        <div class="text-center mt-8">
            <a href="{{ route('vehicles.sales') }}" class="bg-green-600 text-white px-8 py-3 rounded-lg hover:bg-green-700 btn-hover transition-all">
                @if(app()->getLocale() === 'am')
                    ሁሉንም ይመልከቱ
                @else
                    View All Sales
                @endif
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

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    console.log('Car Rental Home page loaded successfully!');
    
    // Add hover effects to vehicle cards
    document.querySelectorAll('.card-hover').forEach(card => {
        card.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-4px)';
        });
        
        card.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0)';
        });
    });
});
</script>
@endpush
@endsection