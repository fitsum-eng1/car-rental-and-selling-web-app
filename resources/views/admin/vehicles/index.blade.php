@extends('layouts.app')

@section('title', 'Manage Vehicles - Admin Panel')

@section('content')
<div class="bg-gray-50 min-h-screen">
    <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
        <!-- Page header -->
        <div class="md:flex md:items-center md:justify-between mb-8">
            <div class="flex-1 min-w-0">
                <h2 class="text-2xl font-bold leading-7 text-gray-900 sm:text-3xl sm:truncate">
                    Manage Vehicles
                </h2>
            </div>
            <div class="mt-4 flex md:mt-0 md:ml-4">
                <a href="{{ route('admin.vehicles.create') }}" class="ml-3 inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700">
                    Add New Vehicle
                </a>
            </div>
        </div>

        <!-- Vehicles List -->
        <div class="bg-white shadow overflow-hidden sm:rounded-md">
            <ul class="divide-y divide-gray-200">
                @forelse($vehicles as $vehicle)
                    <li>
                        <div class="px-4 py-4 flex items-center justify-between">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 h-16 w-16">
                                    @if($vehicle->primary_image)
                                        <img class="h-16 w-16 rounded-lg object-cover" src="{{ asset('storage/' . $vehicle->primary_image) }}" alt="{{ $vehicle->full_name }}">
                                    @else
                                        <div class="h-16 w-16 rounded-lg bg-gray-200 flex items-center justify-center">
                                            <svg class="h-8 w-8 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z" clip-rule="evenodd" />
                                            </svg>
                                        </div>
                                    @endif
                                </div>
                                <div class="ml-4">
                                    <div class="text-sm font-medium text-gray-900">
                                        {{ $vehicle->full_name }}
                                    </div>
                                    <div class="text-sm text-gray-500">
                                        {{ $vehicle->license_plate }} • {{ ucfirst($vehicle->category) }} • {{ number_format($vehicle->mileage) }} km
                                    </div>
                                    <div class="text-sm text-gray-500">
                                        @if($vehicle->available_for_rent)
                                            <span class="text-blue-600">Rental: ${{ $vehicle->rental_price_per_day }}/day</span>
                                        @endif
                                        @if($vehicle->available_for_sale)
                                            <span class="text-green-600 ml-2">Sale: ${{ number_format($vehicle->sale_price) }}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="flex items-center space-x-2">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                    @if($vehicle->status === 'available') bg-green-100 text-green-800
                                    @elseif($vehicle->status === 'rented') bg-blue-100 text-blue-800
                                    @elseif($vehicle->status === 'maintenance') bg-yellow-100 text-yellow-800
                                    @elseif($vehicle->status === 'sold') bg-purple-100 text-purple-800
                                    @else bg-gray-100 text-gray-800 @endif">
                                    {{ ucfirst($vehicle->status) }}
                                </span>
                                <a href="{{ route('admin.vehicles.show', $vehicle) }}" class="text-blue-600 hover:text-blue-900 text-sm font-medium">
                                    View
                                </a>
                                <a href="{{ route('admin.vehicles.edit', $vehicle) }}" class="text-indigo-600 hover:text-indigo-900 text-sm font-medium">
                                    Edit
                                </a>
                            </div>
                        </div>
                    </li>
                @empty
                    <li class="px-4 py-8 text-center text-gray-500">
                        No vehicles found. <a href="{{ route('admin.vehicles.create') }}" class="text-blue-600 hover:text-blue-500">Add the first vehicle</a>
                    </li>
                @endforelse
            </ul>
        </div>

        <!-- Pagination -->
        @if($vehicles->hasPages())
            <div class="mt-6">
                {{ $vehicles->links() }}
            </div>
        @endif
    </div>
</div>
@endsection