@extends('layouts.app')

@section('title', 'Add New Vehicle - Admin Panel')

@section('content')
<div class="bg-gray-50 min-h-screen">
    <div class="max-w-4xl mx-auto py-6 sm:px-6 lg:px-8">
        <!-- Page header -->
        <div class="mb-8">
            <div class="flex items-center">
                <a href="{{ route('admin.vehicles.index') }}" class="text-gray-500 hover:text-gray-700 mr-4">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                </a>
                <h2 class="text-2xl font-bold leading-7 text-gray-900 sm:text-3xl sm:truncate">
                    Add New Vehicle
                </h2>
            </div>
        </div>

        <!-- Form -->
        <div class="bg-white shadow rounded-lg">
            <form action="{{ route('admin.vehicles.store') }}" method="POST" class="space-y-6 p-6">
                @csrf

                <!-- Basic Information -->
                <div>
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Basic Information</h3>
                    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                        <div>
                            <label for="make" class="block text-sm font-medium text-gray-700">Make</label>
                            <input type="text" name="make" id="make" value="{{ old('make') }}" required
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                            @error('make')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="model" class="block text-sm font-medium text-gray-700">Model</label>
                            <input type="text" name="model" id="model" value="{{ old('model') }}" required
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                            @error('model')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="year" class="block text-sm font-medium text-gray-700">Year</label>
                            <input type="number" name="year" id="year" value="{{ old('year') }}" min="1900" max="{{ date('Y') + 1 }}" required
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                            @error('year')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="color" class="block text-sm font-medium text-gray-700">Color</label>
                            <input type="text" name="color" id="color" value="{{ old('color') }}" required
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                            @error('color')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="license_plate" class="block text-sm font-medium text-gray-700">License Plate</label>
                            <input type="text" name="license_plate" id="license_plate" value="{{ old('license_plate') }}" required
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                            @error('license_plate')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="mileage" class="block text-sm font-medium text-gray-700">Mileage (km)</label>
                            <input type="number" name="mileage" id="mileage" value="{{ old('mileage') }}" min="0" required
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                            @error('mileage')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="fuel_type" class="block text-sm font-medium text-gray-700">Fuel Type</label>
                            <select name="fuel_type" id="fuel_type" required
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                                <option value="">Select Fuel Type</option>
                                <option value="petrol" {{ old('fuel_type') === 'petrol' ? 'selected' : '' }}>Petrol</option>
                                <option value="diesel" {{ old('fuel_type') === 'diesel' ? 'selected' : '' }}>Diesel</option>
                                <option value="hybrid" {{ old('fuel_type') === 'hybrid' ? 'selected' : '' }}>Hybrid</option>
                                <option value="electric" {{ old('fuel_type') === 'electric' ? 'selected' : '' }}>Electric</option>
                            </select>
                            @error('fuel_type')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="transmission" class="block text-sm font-medium text-gray-700">Transmission</label>
                            <select name="transmission" id="transmission" required
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                                <option value="">Select Transmission</option>
                                <option value="manual" {{ old('transmission') === 'manual' ? 'selected' : '' }}>Manual</option>
                                <option value="automatic" {{ old('transmission') === 'automatic' ? 'selected' : '' }}>Automatic</option>
                            </select>
                            @error('transmission')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="category" class="block text-sm font-medium text-gray-700">Category</label>
                            <select name="category" id="category" required
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                                <option value="">Select Category</option>
                                <option value="sedan" {{ old('category') === 'sedan' ? 'selected' : '' }}>Sedan</option>
                                <option value="suv" {{ old('category') === 'suv' ? 'selected' : '' }}>SUV</option>
                                <option value="pickup" {{ old('category') === 'pickup' ? 'selected' : '' }}>Pickup</option>
                                <option value="luxury" {{ old('category') === 'luxury' ? 'selected' : '' }}>Luxury</option>
                                <option value="compact" {{ old('category') === 'compact' ? 'selected' : '' }}>Compact</option>
                                <option value="van" {{ old('category') === 'van' ? 'selected' : '' }}>Van</option>
                            </select>
                            @error('category')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Description -->
                <div>
                    <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                    <textarea name="description" id="description" rows="3"
                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">{{ old('description') }}</textarea>
                    @error('description')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Features -->
                <div>
                    <label for="features" class="block text-sm font-medium text-gray-700">Features (one per line)</label>
                    <textarea name="features" id="features" rows="4" placeholder="Air Conditioning&#10;GPS Navigation&#10;Bluetooth&#10;Backup Camera"
                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">{{ old('features') }}</textarea>
                    @error('features')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Rental Options -->
                <div>
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Rental Options</h3>
                    <div class="space-y-4">
                        <div class="flex items-center">
                            <input type="checkbox" name="available_for_rent" id="available_for_rent" value="1" {{ old('available_for_rent') ? 'checked' : '' }}
                                class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                            <label for="available_for_rent" class="ml-2 block text-sm text-gray-900">
                                Available for Rent
                            </label>
                        </div>

                        <div id="rental-options" class="ml-6 space-y-4" style="display: none;">
                            <div>
                                <label for="rental_price_per_day" class="block text-sm font-medium text-gray-700">Rental Price per Day ($)</label>
                                <input type="number" name="rental_price_per_day" id="rental_price_per_day" value="{{ old('rental_price_per_day') }}" min="0" step="0.01"
                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                                @error('rental_price_per_day')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="flex items-center">
                                <input type="checkbox" name="self_drive_available" id="self_drive_available" value="1" {{ old('self_drive_available') ? 'checked' : '' }}
                                    class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                                <label for="self_drive_available" class="ml-2 block text-sm text-gray-900">
                                    Self Drive Available
                                </label>
                            </div>

                            <div class="flex items-center">
                                <input type="checkbox" name="with_driver_available" id="with_driver_available" value="1" {{ old('with_driver_available') ? 'checked' : '' }}
                                    class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                                <label for="with_driver_available" class="ml-2 block text-sm text-gray-900">
                                    With Driver Available
                                </label>
                            </div>

                            <div id="driver-cost" style="display: none;">
                                <label for="driver_cost_per_day" class="block text-sm font-medium text-gray-700">Driver Cost per Day ($)</label>
                                <input type="number" name="driver_cost_per_day" id="driver_cost_per_day" value="{{ old('driver_cost_per_day') }}" min="0" step="0.01"
                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                                @error('driver_cost_per_day')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Sale Options -->
                <div>
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Sale Options</h3>
                    <div class="space-y-4">
                        <div class="flex items-center">
                            <input type="checkbox" name="available_for_sale" id="available_for_sale" value="1" {{ old('available_for_sale') ? 'checked' : '' }}
                                class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                            <label for="available_for_sale" class="ml-2 block text-sm text-gray-900">
                                Available for Sale
                            </label>
                        </div>

                        <div id="sale-options" class="ml-6 space-y-4" style="display: none;">
                            <div>
                                <label for="sale_price" class="block text-sm font-medium text-gray-700">Sale Price ($)</label>
                                <input type="number" name="sale_price" id="sale_price" value="{{ old('sale_price') }}" min="0" step="0.01"
                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                                @error('sale_price')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="condition" class="block text-sm font-medium text-gray-700">Condition</label>
                                <select name="condition" id="condition"
                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                                    <option value="">Select Condition</option>
                                    <option value="excellent" {{ old('condition') === 'excellent' ? 'selected' : '' }}>Excellent</option>
                                    <option value="good" {{ old('condition') === 'good' ? 'selected' : '' }}>Good</option>
                                    <option value="fair" {{ old('condition') === 'fair' ? 'selected' : '' }}>Fair</option>
                                    <option value="poor" {{ old('condition') === 'poor' ? 'selected' : '' }}>Poor</option>
                                </select>
                                @error('condition')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Submit Buttons -->
                <div class="flex justify-end space-x-3">
                    <a href="{{ route('admin.vehicles.index') }}" 
                        class="bg-white py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        Cancel
                    </a>
                    <button type="submit" 
                        class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        Create Vehicle
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const availableForRent = document.getElementById('available_for_rent');
    const rentalOptions = document.getElementById('rental-options');
    const availableForSale = document.getElementById('available_for_sale');
    const saleOptions = document.getElementById('sale-options');
    const withDriverAvailable = document.getElementById('with_driver_available');
    const driverCost = document.getElementById('driver-cost');

    // Toggle rental options
    availableForRent.addEventListener('change', function() {
        rentalOptions.style.display = this.checked ? 'block' : 'none';
    });

    // Toggle sale options
    availableForSale.addEventListener('change', function() {
        saleOptions.style.display = this.checked ? 'block' : 'none';
    });

    // Toggle driver cost
    withDriverAvailable.addEventListener('change', function() {
        driverCost.style.display = this.checked ? 'block' : 'none';
    });

    // Initialize on page load
    if (availableForRent.checked) {
        rentalOptions.style.display = 'block';
    }
    if (availableForSale.checked) {
        saleOptions.style.display = 'block';
    }
    if (withDriverAvailable.checked) {
        driverCost.style.display = 'block';
    }
});
</script>
@endsection