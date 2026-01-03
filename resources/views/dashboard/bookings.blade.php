@extends('layouts.app')

@section('title', 'My Bookings - Dashboard')

@section('content')
<div class="bg-gray-50 min-h-screen">
    <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
        <!-- Page header -->
        <div class="mb-8">
            <div class="flex items-center">
                <a href="{{ route('dashboard') }}" class="text-gray-500 hover:text-gray-700 mr-4">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                </a>
                <h2 class="text-2xl font-bold leading-7 text-gray-900 sm:text-3xl sm:truncate">
                    @if(app()->getLocale() === 'am')
                        የእኔ ቦታ ማስያዝ
                    @else
                        My Bookings
                    @endif
                </h2>
            </div>
        </div>

        @if($bookings->count() > 0)
            <div class="bg-white shadow overflow-hidden sm:rounded-md">
                <ul class="divide-y divide-gray-200">
                    @foreach($bookings as $booking)
                        <li class="animate__animated animate__fadeInUp" style="animation-delay: {{ $loop->index * 100 }}ms">
                            <div class="px-4 py-4 sm:px-6">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-20 w-20">
                                            @if($booking->vehicle->primary_image)
                                                <img class="h-20 w-20 rounded-lg object-cover" src="{{ asset('storage/' . $booking->vehicle->primary_image) }}" alt="{{ $booking->vehicle->full_name }}">
                                            @else
                                                <div class="h-20 w-20 rounded-lg bg-gray-200 flex items-center justify-center">
                                                    <svg class="h-8 w-8 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd" d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z" clip-rule="evenodd" />
                                                    </svg>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="ml-4">
                                            <div class="flex items-center">
                                                <p class="text-lg font-medium text-indigo-600 truncate">
                                                    {{ $booking->vehicle->full_name }}
                                                </p>
                                                <span class="ml-2 inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                                    @if($booking->status === 'confirmed') bg-green-100 text-green-800
                                                    @elseif($booking->status === 'pending_payment') bg-yellow-100 text-yellow-800
                                                    @elseif($booking->status === 'cancelled') bg-red-100 text-red-800
                                                    @elseif($booking->status === 'active') bg-blue-100 text-blue-800
                                                    @elseif($booking->status === 'completed') bg-gray-100 text-gray-800
                                                    @else bg-gray-100 text-gray-800 @endif">
                                                    @if($booking->status === 'cancelled')
                                                        @if($booking->cancellation_reason && str_contains($booking->cancellation_reason, 'Payment rejected'))
                                                            Payment Rejected
                                                        @else
                                                            Cancelled
                                                        @endif
                                                    @else
                                                        {{ ucfirst(str_replace('_', ' ', $booking->status)) }}
                                                    @endif
                                                </span>
                                            </div>
                                            <div class="mt-2 flex items-center text-sm text-gray-500">
                                                <svg class="flex-shrink-0 mr-1.5 h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                </svg>
                                                <p>
                                                    @if(app()->getLocale() === 'am')
                                                        {{ $booking->pickup_date->format('M d, Y') }} - {{ $booking->return_date->format('M d, Y') }}
                                                    @else
                                                        {{ $booking->pickup_date->format('M d, Y') }} - {{ $booking->return_date->format('M d, Y') }}
                                                    @endif
                                                </p>
                                            </div>
                                            <div class="mt-2 flex items-center text-sm text-gray-500">
                                                <svg class="flex-shrink-0 mr-1.5 h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                                </svg>
                                                <p>{{ $booking->pickup_location }}</p>
                                            </div>
                                            <div class="mt-2 flex items-center text-sm text-gray-500">
                                                <svg class="flex-shrink-0 mr-1.5 h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                                                </svg>
                                                <p>{{ $booking->booking_reference }}</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="flex flex-col items-end">
                                        <div class="text-lg font-medium text-gray-900">
                                            ${{ number_format($booking->total_amount, 2) }}
                                        </div>
                                        <div class="mt-2 flex space-x-2">
                                            <a href="{{ route('bookings.show', $booking) }}" 
                                                class="inline-flex items-center px-3 py-2 border border-gray-300 shadow-sm text-sm leading-4 font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                                @if(app()->getLocale() === 'am')
                                                    ዝርዝር
                                                @else
                                                    View Details
                                                @endif
                                            </a>
                                            @if($booking->status === 'pending_payment')
                                                <a href="{{ route('bookings.payment', $booking) }}" 
                                                    class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                                    @if(app()->getLocale() === 'am')
                                                        ክፍያ
                                                    @else
                                                        Pay Now
                                                    @endif
                                                </a>
                                            @endif
                                            @if(in_array($booking->status, ['pending_payment', 'confirmed']) && $booking->pickup_date->isFuture())
                                                <form action="{{ route('bookings.cancel', $booking) }}" method="POST" class="inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" 
                                                        onclick="return confirm('Are you sure you want to cancel this booking?')"
                                                        class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                                                        @if(app()->getLocale() === 'am')
                                                            ሰርዝ
                                                        @else
                                                            Cancel
                                                        @endif
                                                    </button>
                                                </form>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>

            <!-- Pagination -->
            <div class="mt-6">
                {{ $bookings->links() }}
            </div>
        @else
            <div class="text-center py-12">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
                <h3 class="mt-2 text-sm font-medium text-gray-900">
                    @if(app()->getLocale() === 'am')
                        ምንም ቦታ ማስያዝ የለም
                    @else
                        No bookings found
                    @endif
                </h3>
                <p class="mt-1 text-sm text-gray-500">
                    @if(app()->getLocale() === 'am')
                        መኪና በመከራየት ይጀምሩ።
                    @else
                        Get started by renting a vehicle.
                    @endif
                </p>
                <div class="mt-6">
                    <a href="{{ route('vehicles.rentals') }}" 
                        class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                        </svg>
                        @if(app()->getLocale() === 'am')
                            መኪና ይከራዩ
                        @else
                            Rent a Vehicle
                        @endif
                    </a>
                </div>
            </div>
        @endif
    </div>
</div>
@endsection