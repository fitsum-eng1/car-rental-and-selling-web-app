@extends('layouts.app')

@section('title', 'Edit Vehicle - Admin Panel')

@section('content')
<div class="bg-gray-50 min-h-screen">
    <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
        <!-- Page header -->
        <div class="mb-8">
            <div class="flex items-center">
                <a href="{{ route('admin.vehicles.index') }}" class="text-gray-500 hover:text-gray-700 mr-4">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                </a>
                <h2 class="text-2xl font-bold leading-7 text-gray-900 sm:text-3xl sm:truncate">
                    Edit Vehicle: {{ $vehicle->full_name }}
                </h2>
            </div>
        </div>

        <div class="bg-white shadow rounded-lg">
            <form action="{{ route('admin.vehicles.update', $vehicle) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                
                <div class="px-4 py-5 sm:p-6">
                    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                        <!-- Basic Information -->
                        <div class="sm:col-span-2">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Basic Information</h3>
                        </div>

                        <div>
                            <label for="make" class="block text-sm font-medium text-gray-700">Make</label>
                            <input type="text" name="make" id="make" value="{{ old('make', $vehicle->make) }}" required
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                            @error('make')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="model" class="block text-sm font-medium text-gray-700">Model</label>
                            <input type="text" name="model" id="model" value="{{ old('model', $vehicle->model) }}" required
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                            @error('model')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="year" class="block text-sm font-medium text-gray-700">Year</label>
                            <input type="number" name="year" id="year" value="{{ old('year', $vehicle->year) }}" required min="1900" max="{{ date('Y') + 1 }}"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                            @error('year')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="type" class="block text-sm font-medium text-gray-700">Type</label>
                            <select name="type" id="type" required
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                                <option value="">Select Type</option>
                                <option value="sedan" {{ old('type', $vehicle->type) === 'sedan' ? 'selected' : '' }}>Sedan</option>
                                <option value="suv" {{ old('type', $vehicle->type) === 'suv' ? 'selected' : '' }}>SUV</option>
                                <option value="hatchback" {{ old('type', $vehicle->type) === 'hatchback' ? 'selected' : '' }}>Hatchback</option>
                                <option value="coupe" {{ old('type', $vehicle->type) === 'coupe' ? 'selected' : '' }}>Coupe</option>
                                <option value="convertible" {{ old('type', $vehicle->type) === 'convertible' ? 'selected' : '' }}>Convertible</option>
                                <option value="wagon" {{ old('type', $vehicle->type) === 'wagon' ? 'selected' : '' }}>Wagon</option>
                                <option value="truck" {{ old('type', $vehicle->type) === 'truck' ? 'selected' : '' }}>Truck</option>
                                <option value="van" {{ old('type', $vehicle->type) === 'van' ? 'selected' : '' }}>Van</option>
                            </select>
                            @error('type')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="fuel_type" class="block text-sm font-medium text-gray-700">Fuel Type</label>
                            <select name="fuel_type" id="fuel_type" required
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                                <option value="">Select Fuel Type</option>
                                <option value="gasoline" {{ old('fuel_type', $vehicle->fuel_type) === 'gasoline' ? 'selected' : '' }}>Gasoline</option>
                                <option value="diesel" {{ old('fuel_type', $vehicle->fuel_type) === 'diesel' ? 'selected' : '' }}>Diesel</option>
                                <option value="hybrid" {{ old('fuel_type', $vehicle->fuel_type) === 'hybrid' ? 'selected' : '' }}>Hybrid</option>
                                <option value="electric" {{ old('fuel_type', $vehicle->fuel_type) === 'electric' ? 'selected' : '' }}>Electric</option>
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
                                <option value="manual" {{ old('transmission', $vehicle->transmission) === 'manual' ? 'selected' : '' }}>Manual</option>
                                <option value="automatic" {{ old('transmission', $vehicle->transmission) === 'automatic' ? 'selected' : '' }}>Automatic</option>
                                <option value="cvt" {{ old('transmission', $vehicle->transmission) === 'cvt' ? 'selected' : '' }}>CVT</option>
                            </select>
                            @error('transmission')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="seats" class="block text-sm font-medium text-gray-700">Number of Seats</label>
                            <input type="number" name="seats" id="seats" value="{{ old('seats', $vehicle->seats) }}" required min="1" max="50"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                            @error('seats')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="color" class="block text-sm font-medium text-gray-700">Color</label>
                            <input type="text" name="color" id="color" value="{{ old('color', $vehicle->color) }}" required
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                            @error('color')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Pricing -->
                        <div class="sm:col-span-2">
                            <h3 class="text-lg font-medium text-gray-900 mb-4 mt-6">Pricing</h3>
                        </div>

                        <div>
                            <label for="daily_rate" class="block text-sm font-medium text-gray-700">Daily Rental Rate ($)</label>
                            <input type="number" name="daily_rate" id="daily_rate" value="{{ old('daily_rate', $vehicle->daily_rate) }}" step="0.01" min="0"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                            @error('daily_rate')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="sale_price" class="block text-sm font-medium text-gray-700">Sale Price ($)</label>
                            <input type="number" name="sale_price" id="sale_price" value="{{ old('sale_price', $vehicle->sale_price) }}" step="0.01" min="0"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                            @error('sale_price')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Availability -->
                        <div class="sm:col-span-2">
                            <h3 class="text-lg font-medium text-gray-900 mb-4 mt-6">Availability</h3>
                        </div>

                        <div>
                            <label for="available_for_rent" class="flex items-center">
                                <input type="checkbox" name="available_for_rent" id="available_for_rent" value="1" 
                                    {{ old('available_for_rent', $vehicle->available_for_rent) ? 'checked' : '' }}
                                    class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                <span class="ml-2 text-sm text-gray-700">Available for Rent</span>
                            </label>
                        </div>

                        <div>
                            <label for="available_for_sale" class="flex items-center">
                                <input type="checkbox" name="available_for_sale" id="available_for_sale" value="1" 
                                    {{ old('available_for_sale', $vehicle->available_for_sale) ? 'checked' : '' }}
                                    class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                <span class="ml-2 text-sm text-gray-700">Available for Sale</span>
                            </label>
                        </div>

                        <!-- Description -->
                        <div class="sm:col-span-2">
                            <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                            <textarea name="description" id="description" rows="4"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">{{ old('description', $vehicle->description) }}</textarea>
                            @error('description')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Features -->
                        <div class="sm:col-span-2">
                            <label for="features" class="block text-sm font-medium text-gray-700">Features (one per line)</label>
                            <textarea name="features" id="features" rows="4" placeholder="Air Conditioning&#10;GPS Navigation&#10;Bluetooth&#10;Backup Camera"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">{{ old('features', is_array($vehicle->features) ? implode("\n", $vehicle->features) : '') }}</textarea>
                            @error('features')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
                    <div class="flex justify-end space-x-3">
                        <a href="{{ route('admin.vehicles.show', $vehicle) }}" 
                            class="bg-white py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            Cancel
                        </a>
                        <button type="submit" 
                            class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            Update Vehicle
                        </button>
                    </div>
                </div>
            </form>
        </div>

        <!-- Current Images -->
        @if($vehicle->images->count() > 0)
            <div class="mt-8 bg-white shadow rounded-lg">
                <div class="px-4 py-5 sm:p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Current Images</h3>
                    <div class="grid grid-cols-2 gap-4 sm:grid-cols-3 lg:grid-cols-4">
                        @foreach($vehicle->images as $image)
                            <div class="relative">
                                <img src="{{ asset('storage/' . $image->image_path) }}" alt="Vehicle Image" 
                                    class="h-24 w-full object-cover rounded-lg">
                                <form action="{{ route('admin.vehicles.delete-image', $image) }}" method="POST" 
                                    class="absolute top-1 right-1">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                        onclick="return confirm('Are you sure you want to delete this image?')"
                                        class="bg-red-600 text-white rounded-full p-1 hover:bg-red-700">
                                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        @endif

        <!-- Upload New Images -->
        <div class="mt-8 bg-white shadow rounded-lg">
            <form action="{{ route('admin.vehicles.upload-images', $vehicle) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="px-4 py-5 sm:p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Upload New Images</h3>
                    <div>
                        <label for="images" class="block text-sm font-medium text-gray-700">Select Images</label>
                        <input type="file" name="images[]" id="images" multiple accept="image/*"
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                        <p class="mt-1 text-sm text-gray-500">You can select multiple images. Supported formats: JPG, PNG, GIF</p>
                    </div>
                </div>
                <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
                    <button type="submit" 
                        class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                        Upload Images
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection