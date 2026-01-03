@extends('layouts.app')

@section('title', 'Purchase Checkout - Vehicle Confirmation')

@section('content')
<div class="bg-gray-50 min-h-screen">
    <div class="max-w-4xl mx-auto py-6 sm:px-6 lg:px-8">
        <!-- Progress Bar -->
        <div class="mb-8">
            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <div class="flex items-center text-sm text-blue-600">
                        <span class="flex items-center justify-center w-8 h-8 bg-blue-600 text-white rounded-full">1</span>
                        <span class="ml-2 font-medium">Vehicle Confirmation</span>
                    </div>
                </div>
                <div class="hidden sm:flex items-center space-x-4">
                    <div class="flex items-center text-sm text-gray-400">
                        <span class="flex items-center justify-center w-8 h-8 bg-gray-300 text-gray-600 rounded-full">2</span>
                        <span class="ml-2">Buyer Info</span>
                    </div>
                    <div class="flex items-center text-sm text-gray-400">
                        <span class="flex items-center justify-center w-8 h-8 bg-gray-300 text-gray-600 rounded-full">3</span>
                        <span class="ml-2">Delivery</span>
                    </div>
                    <div class="flex items-center text-sm text-gray-400">
                        <span class="flex items-center justify-center w-8 h-8 bg-gray-300 text-gray-600 rounded-full">4</span>
                        <span class="ml-2">Agreement</span>
                    </div>
                    <div class="flex items-center text-sm text-gray-400">
                        <span class="flex items-center justify-center w-8 h-8 bg-gray-300 text-gray-600 rounded-full">5</span>
                        <span class="ml-2">Payment</span>
                    </div>
                </div>
            </div>
            <div class="mt-4 w-full bg-gray-200 rounded-full h-2">
                <div class="bg-blue-600 h-2 rounded-full" style="width: 20%"></div>
            </div>
        </div>

        <!-- Page Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">Confirm Your Vehicle Selection</h1>
            <p class="mt-2 text-sm text-gray-600">Please review the vehicle details before proceeding with your purchase</p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Vehicle Details -->
            <div class="lg:col-span-2">
                <div class="bg-white shadow rounded-lg overflow-hidden">
                    <!-- Vehicle Images -->
                    <div class="aspect-w-16 aspect-h-9">
                        @if($vehicle->primary_image)
                            <img class="w-full h-64 object-cover" src="{{ asset('storage/' . $vehicle->primary_image) }}" alt="{{ $vehicle->full_name }}">
                        @else
                            <div class="w-full h-64 bg-gray-200 flex items-center justify-center">
                                <svg class="h-16 w-16 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        @endif
                    </div>

                    <div class="p-6">
                        <h2 class="text-2xl font-bold text-gray-900 mb-4">{{ $vehicle->full_name }}</h2>
                        
                        <!-- Vehicle Specifications -->
                        <div class="grid grid-cols-2 gap-4 mb-6">
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Year</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $vehicle->year }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Fuel Type</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ ucfirst($vehicle->fuel_type) }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Transmission</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ ucfirst($vehicle->transmission) }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Mileage</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ number_format($vehicle->mileage) }} km</dd>
                            </div>
                            @if($vehicle->vin)
                            <div>
                                <dt class="text-sm font-medium text-gray-500">VIN</dt>
                                <dd class="mt-1 text-sm text-gray-900 font-mono">{{ $vehicle->vin }}</dd>
                            </div>
                            @endif
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Status</dt>
                                <dd class="mt-1">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                        Available for Sale
                                    </span>
                                </dd>
                            </div>
                        </div>

                        @if($vehicle->description)
                        <div class="mb-6">
                            <h3 class="text-lg font-medium text-gray-900 mb-2">Description</h3>
                            <p class="text-gray-600">{{ $vehicle->description }}</p>
                        </div>
                        @endif

                        <!-- Features -->
                        @if($vehicle->features && count($vehicle->features) > 0)
                        <div>
                            <h3 class="text-lg font-medium text-gray-900 mb-2">Features</h3>
                            <div class="flex flex-wrap gap-2">
                                @foreach($vehicle->features as $feature)
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                        {{ $feature }}
                                    </span>
                                @endforeach
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Purchase Summary -->
            <div class="lg:col-span-1">
                <div class="bg-white shadow rounded-lg p-6 sticky top-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Purchase Summary</h3>
                    
                    <div class="space-y-3 mb-6">
                        <div class="flex justify-between">
                            <span class="text-sm text-gray-600">Vehicle Price</span>
                            <span class="text-sm font-medium text-gray-900">${{ number_format($vehicle->sale_price, 2) }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-sm text-gray-600">Delivery</span>
                            <span class="text-sm text-gray-600">To be determined</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-sm text-gray-600">Tax (15%)</span>
                            <span class="text-sm text-gray-600">To be calculated</span>
                        </div>
                        <div class="border-t border-gray-200 pt-3">
                            <div class="flex justify-between">
                                <span class="text-base font-medium text-gray-900">Starting from</span>
                                <span class="text-base font-medium text-gray-900">${{ number_format($vehicle->sale_price, 2) }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Important Notice -->
                    <div class="bg-yellow-50 border border-yellow-200 rounded-md p-4 mb-6">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-sm font-medium text-yellow-800">Important</h3>
                                <div class="mt-2 text-sm text-yellow-700">
                                    <p>This vehicle will be reserved for you during the checkout process. Final price includes delivery and taxes.</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="space-y-3">
                        <a href="{{ route('checkout.stage2.show') }}" class="w-full bg-blue-600 border border-transparent rounded-md py-3 px-4 text-sm font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 text-center block">
                            ✅ Confirm Selection & Continue
                        </a>
                        
                        <a href="{{ route('vehicles.show', $vehicle) }}" class="w-full bg-gray-100 border border-gray-300 rounded-md py-3 px-4 text-sm font-medium text-gray-700 hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 text-center block">
                            ← Back to Vehicle Details
                        </a>
                        
                        <a href="{{ route('checkout.cancel') }}" class="w-full text-center text-sm text-gray-500 hover:text-gray-700">
                            Cancel Purchase
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection