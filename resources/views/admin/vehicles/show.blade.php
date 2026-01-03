@extends('layouts.app')

@section('title', 'Vehicle Details - Admin Panel')

@section('content')
<div class="bg-gray-50 min-h-screen">
    <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
        <!-- Page header -->
        <div class="mb-8">
            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <a href="{{ route('admin.vehicles.index') }}" class="text-gray-500 hover:text-gray-700 mr-4">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                        </svg>
                    </a>
                    <h2 class="text-2xl font-bold leading-7 text-gray-900 sm:text-3xl sm:truncate">
                        {{ $vehicle->full_name }}
                    </h2>
                </div>
                <div class="flex space-x-3">
                    <a href="{{ route('admin.vehicles.edit', $vehicle) }}" 
                        class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                        </svg>
                        Edit Vehicle
                    </a>
                    <form action="{{ route('admin.vehicles.toggle-status', $vehicle) }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" 
                            class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white {{ $vehicle->status === 'active' ? 'bg-red-600 hover:bg-red-700' : 'bg-green-600 hover:bg-green-700' }} focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-{{ $vehicle->status === 'active' ? 'red' : 'green' }}-500">
                            {{ $vehicle->status === 'active' ? 'Deactivate' : 'Activate' }}
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Vehicle Images -->
            <div class="lg:col-span-2">
                @if($vehicle->images->count() > 0)
                    <div class="bg-white shadow rounded-lg overflow-hidden">
                        <div class="aspect-w-16 aspect-h-9">
                            <img src="{{ asset('storage/' . $vehicle->primary_image) }}" alt="{{ $vehicle->full_name }}" 
                                class="w-full h-64 object-cover">
                        </div>
                        @if($vehicle->images->count() > 1)
                            <div class="p-4">
                                <div class="grid grid-cols-4 gap-2">
                                    @foreach($vehicle->images->take(8) as $image)
                                        <img src="{{ asset('storage/' . $image->image_path) }}" alt="Vehicle Image" 
                                            class="h-16 w-full object-cover rounded cursor-pointer hover:opacity-75">
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    </div>
                @else
                    <div class="bg-white shadow rounded-lg p-6">
                        <div class="text-center">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            <h3 class="mt-2 text-sm font-medium text-gray-900">No images</h3>
                            <p class="mt-1 text-sm text-gray-500">Upload images for this vehicle.</p>
                        </div>
                    </div>
                @endif

                <!-- Vehicle Details -->
                <div class="mt-6 bg-white shadow rounded-lg">
                    <div class="px-4 py-5 sm:p-6">
                        <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">Vehicle Details</h3>
                        
                        <dl class="grid grid-cols-1 gap-x-4 gap-y-6 sm:grid-cols-2">
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Make & Model</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $vehicle->make }} {{ $vehicle->model }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Year</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $vehicle->year }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Type</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ ucfirst($vehicle->type) }}</dd>
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
                                <dt class="text-sm font-medium text-gray-500">Seats</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $vehicle->seats }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Color</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $vehicle->color }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Status</dt>
                                <dd class="mt-1">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                        {{ $vehicle->status === 'active' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                        {{ ucfirst($vehicle->status) }}
                                    </span>
                                </dd>
                            </div>
                        </dl>

                        @if($vehicle->description)
                            <div class="mt-6">
                                <dt class="text-sm font-medium text-gray-500">Description</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $vehicle->description }}</dd>
                            </div>
                        @endif

                        @if($vehicle->features && count($vehicle->features) > 0)
                            <div class="mt-6">
                                <dt class="text-sm font-medium text-gray-500">Features</dt>
                                <dd class="mt-1">
                                    <div class="flex flex-wrap gap-2">
                                        @foreach($vehicle->features as $feature)
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                                {{ $feature }}
                                            </span>
                                        @endforeach
                                    </div>
                                </dd>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="lg:col-span-1">
                <!-- Pricing -->
                <div class="bg-white shadow rounded-lg">
                    <div class="px-4 py-5 sm:p-6">
                        <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">Pricing</h3>
                        
                        @if($vehicle->available_for_rent && $vehicle->daily_rate)
                            <div class="mb-4">
                                <div class="flex items-center justify-between">
                                    <span class="text-sm font-medium text-gray-500">Daily Rental Rate</span>
                                    <span class="text-lg font-bold text-green-600">${{ number_format($vehicle->daily_rate, 2) }}</span>
                                </div>
                            </div>
                        @endif

                        @if($vehicle->available_for_sale && $vehicle->sale_price)
                            <div class="mb-4">
                                <div class="flex items-center justify-between">
                                    <span class="text-sm font-medium text-gray-500">Sale Price</span>
                                    <span class="text-lg font-bold text-blue-600">${{ number_format($vehicle->sale_price, 2) }}</span>
                                </div>
                            </div>
                        @endif

                        <div class="border-t pt-4">
                            <div class="space-y-2">
                                <div class="flex items-center">
                                    <svg class="h-5 w-5 {{ $vehicle->available_for_rent ? 'text-green-500' : 'text-gray-400' }}" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                    </svg>
                                    <span class="ml-2 text-sm text-gray-700">Available for Rent</span>
                                </div>
                                <div class="flex items-center">
                                    <svg class="h-5 w-5 {{ $vehicle->available_for_sale ? 'text-green-500' : 'text-gray-400' }}" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                    </svg>
                                    <span class="ml-2 text-sm text-gray-700">Available for Sale</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Statistics -->
                <div class="mt-6 bg-white shadow rounded-lg">
                    <div class="px-4 py-5 sm:p-6">
                        <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">Statistics</h3>
                        
                        <dl class="space-y-4">
                            <div class="flex justify-between">
                                <dt class="text-sm font-medium text-gray-500">Total Bookings</dt>
                                <dd class="text-sm text-gray-900">{{ $vehicle->bookings->count() }}</dd>
                            </div>
                            <div class="flex justify-between">
                                <dt class="text-sm font-medium text-gray-500">Active Bookings</dt>
                                <dd class="text-sm text-gray-900">{{ $vehicle->bookings->where('status', 'active')->count() }}</dd>
                            </div>
                            <div class="flex justify-between">
                                <dt class="text-sm font-medium text-gray-500">Total Revenue</dt>
                                <dd class="text-sm text-gray-900">
                                    ${{ number_format($vehicle->bookings->where('status', 'completed')->sum('total_amount'), 2) }}
                                </dd>
                            </div>
                            <div class="flex justify-between">
                                <dt class="text-sm font-medium text-gray-500">Created</dt>
                                <dd class="text-sm text-gray-900">{{ $vehicle->created_at->format('M d, Y') }}</dd>
                            </div>
                            <div class="flex justify-between">
                                <dt class="text-sm font-medium text-gray-500">Last Updated</dt>
                                <dd class="text-sm text-gray-900">{{ $vehicle->updated_at->diffForHumans() }}</dd>
                            </div>
                        </dl>
                    </div>
                </div>

                <!-- Quick Actions -->
                <div class="mt-6 bg-white shadow rounded-lg">
                    <div class="px-4 py-5 sm:p-6">
                        <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">Quick Actions</h3>
                        
                        <div class="space-y-3">
                            <a href="{{ route('vehicles.show', $vehicle) }}" target="_blank"
                                class="w-full inline-flex justify-center items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                                </svg>
                                View Public Page
                            </a>
                            
                            @if($vehicle->bookings->count() > 0)
                                <a href="{{ route('admin.bookings.index', ['vehicle' => $vehicle->id]) }}"
                                    class="w-full inline-flex justify-center items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                    <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                    View Bookings
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection