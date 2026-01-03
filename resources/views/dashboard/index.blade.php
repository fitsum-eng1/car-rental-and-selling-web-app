@extends('layouts.app')

@section('title', 'Dashboard - Car Rental & Sales System')

@section('content')
<div class="bg-gray-50 min-h-screen">
    <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
        <!-- Page header -->
        <div class="md:flex md:items-center md:justify-between mb-8 animate__animated animate__fadeInDown">
            <div class="flex-1 min-w-0">
                <h2 class="text-2xl font-bold leading-7 text-gray-900 sm:text-3xl sm:truncate">
                    @if(app()->getLocale() === 'am')
                        እንኳን ደህና መጡ, {{ auth()->user()->name }}
                    @else
                        Welcome back, {{ auth()->user()->name }}
                    @endif
                </h2>
                @if(config('app.debug'))
                <div class="mt-2 text-sm text-gray-600">
                    Debug: User ID {{ auth()->user()->id }} ({{ auth()->user()->email }})
                </div>
                @endif
            </div>
        </div>

        <!-- Stats -->
        <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-4 mb-8">
            <div class="bg-white overflow-hidden shadow rounded-lg animate-card-entrance" style="animation-delay: 0ms">
                <div class="p-5">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <svg class="h-6 w-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 truncate">
                                    @if(app()->getLocale() === 'am')
                                        ጠቅላላ ቦታ ማስያዝ
                                    @else
                                        Total Bookings
                                    @endif
                                </dt>
                                <dd class="text-lg font-medium text-gray-900 counter" data-target="{{ $stats['total_bookings'] }}">0</dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow rounded-lg animate-card-entrance" style="animation-delay: 100ms">
                <div class="p-5">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <svg class="h-6 w-6 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 truncate">
                                    @if(app()->getLocale() === 'am')
                                        ንቁ ቦታ ማስያዝ
                                    @else
                                        Active Bookings
                                    @endif
                                </dt>
                                <dd class="text-lg font-medium text-gray-900 counter" data-target="{{ $stats['active_bookings'] }}">0</dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow rounded-lg animate-card-entrance" style="animation-delay: 200ms">
                <div class="p-5">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <svg class="h-6 w-6 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                            </svg>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 truncate">
                                    @if(app()->getLocale() === 'am')
                                        ጠቅላላ ግዢዎች
                                    @else
                                        Total Purchases
                                    @endif
                                </dt>
                                <dd class="text-lg font-medium text-gray-900 counter" data-target="{{ $stats['total_purchases'] }}">0</dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow rounded-lg animate-card-entrance" style="animation-delay: 300ms">
                <div class="p-5">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <svg class="h-6 w-6 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z" />
                            </svg>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 truncate">
                                    @if(app()->getLocale() === 'am')
                                        የተጠናቀቁ ግዢዎች
                                    @else
                                        Completed Purchases
                                    @endif
                                </dt>
                                <dd class="text-lg font-medium text-gray-900 counter" data-target="{{ $stats['completed_purchases'] }}">0</dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Activity -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <!-- Recent Bookings -->
            <div class="bg-white shadow rounded-lg animate__animated animate__fadeInLeft">
                <div class="px-4 py-5 sm:p-6">
                    <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">
                        @if(app()->getLocale() === 'am')
                            የቅርብ ጊዜ ቦታ ማስያዝ
                        @else
                            Recent Bookings
                        @endif
                    </h3>
                    @if($bookings->count() > 0)
                        <div class="space-y-4">
                            @foreach($bookings as $index => $booking)
                                <div class="flex items-center justify-between p-4 border rounded-lg animate-list-item" style="animation-delay: {{ $index * 100 }}ms">
                                    <div class="flex items-center space-x-4">
                                        <div class="flex-shrink-0">
                                            @if($booking->vehicle->primary_image)
                                                <img class="h-12 w-12 rounded object-cover" src="{{ asset('storage/' . $booking->vehicle->primary_image) }}" alt="{{ $booking->vehicle->full_name }}">
                                            @else
                                                <div class="h-12 w-12 rounded bg-gray-200 flex items-center justify-center">
                                                    <svg class="h-6 w-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd" d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z" clip-rule="evenodd" />
                                                    </svg>
                                                </div>
                                            @endif
                                        </div>
                                        <div>
                                            <p class="text-sm font-medium text-gray-900">{{ $booking->vehicle->full_name }}</p>
                                            <p class="text-sm text-gray-500">{{ $booking->booking_reference }}</p>
                                            <p class="text-xs text-gray-400">{{ $booking->pickup_date->format('M d, Y') }} - {{ $booking->return_date->format('M d, Y') }}</p>
                                        </div>
                                    </div>
                                    <div class="text-right">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                            @if($booking->status === 'confirmed') bg-green-100 text-green-800
                                            @elseif($booking->status === 'pending_payment') bg-yellow-100 text-yellow-800
                                            @elseif($booking->status === 'cancelled') bg-red-100 text-red-800
                                            @else bg-gray-100 text-gray-800 @endif">
                                            {{ ucfirst(str_replace('_', ' ', $booking->status)) }}
                                        </span>
                                        <p class="text-sm font-medium text-gray-900 mt-1">${{ $booking->total_amount }}</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <div class="mt-4">
                            <a href="{{ route('dashboard.bookings') }}" class="text-blue-600 hover:text-blue-500 text-sm font-medium">
                                @if(app()->getLocale() === 'am')
                                    ሁሉንም ይመልከቱ →
                                @else
                                    View all bookings →
                                @endif
                            </a>
                        </div>
                    @else
                        <p class="text-gray-500 text-center py-8">
                            @if(app()->getLocale() === 'am')
                                ገና ምንም ቦታ አላስያዙም።
                            @else
                                No bookings yet.
                            @endif
                        </p>
                    @endif
                </div>
            </div>

            <!-- Recent Purchases -->
            <div class="bg-white shadow rounded-lg animate__animated animate__fadeInRight">
                <div class="px-4 py-5 sm:p-6">
                    <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">
                        @if(app()->getLocale() === 'am')
                            የቅርብ ጊዜ ግዢዎች
                        @else
                            Recent Purchases
                        @endif
                    </h3>
                    @if($purchases->count() > 0)
                        <div class="space-y-4">
                            @foreach($purchases as $index => $purchase)
                                <div class="flex items-center justify-between p-4 border rounded-lg animate-list-item" style="animation-delay: {{ $index * 100 }}ms">
                                    <div class="flex items-center space-x-4">
                                        <div class="flex-shrink-0">
                                            @if($purchase->vehicle->primary_image)
                                                <img class="h-12 w-12 rounded object-cover" src="{{ asset('storage/' . $purchase->vehicle->primary_image) }}" alt="{{ $purchase->vehicle->full_name }}">
                                            @else
                                                <div class="h-12 w-12 rounded bg-gray-200 flex items-center justify-center">
                                                    <svg class="h-6 w-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd" d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z" clip-rule="evenodd" />
                                                    </svg>
                                                </div>
                                            @endif
                                        </div>
                                        <div>
                                            <p class="text-sm font-medium text-gray-900">{{ $purchase->vehicle->full_name }}</p>
                                            <p class="text-sm text-gray-500">{{ $purchase->purchase_reference }}</p>
                                            <p class="text-xs text-gray-400">{{ $purchase->created_at->format('M d, Y') }}</p>
                                        </div>
                                    </div>
                                    <div class="text-right">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                            @if($purchase->status === 'completed') bg-green-100 text-green-800
                                            @elseif($purchase->status === 'pending') bg-yellow-100 text-yellow-800
                                            @elseif($purchase->status === 'rejected') bg-red-100 text-red-800
                                            @else bg-gray-100 text-gray-800 @endif">
                                            {{ ucfirst($purchase->status) }}
                                        </span>
                                        <p class="text-sm font-medium text-gray-900 mt-1">${{ number_format($purchase->total_amount) }}</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <div class="mt-4">
                            <a href="{{ route('dashboard.purchases') }}" class="text-blue-600 hover:text-blue-500 text-sm font-medium">
                                @if(app()->getLocale() === 'am')
                                    ሁሉንም ይመልከቱ →
                                @else
                                    View all purchases →
                                @endif
                            </a>
                        </div>
                    @else
                        <p class="text-gray-500 text-center py-8">
                            @if(app()->getLocale() === 'am')
                                ገና ምንም አልገዙም።
                            @else
                                No purchases yet.
                            @endif
                        </p>
                    @endif
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="mt-8 bg-white shadow rounded-lg animate__animated animate__fadeInUp">
            <div class="px-4 py-5 sm:p-6">
                <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">
                    @if(app()->getLocale() === 'am')
                        ፈጣን እርምጃዎች
                    @else
                        Quick Actions
                    @endif
                </h3>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                    <a href="{{ route('vehicles.rentals') }}" class="bg-blue-50 hover:bg-blue-100 p-4 rounded-lg text-center transition duration-300 animate-button-hover animate-scale-on-hover">
                        <svg class="mx-auto h-8 w-8 text-blue-600 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        <p class="text-sm font-medium text-blue-600">
                            @if(app()->getLocale() === 'am')
                                መኪና ይከራዩ
                            @else
                                Rent a Car
                            @endif
                        </p>
                    </a>
                    
                    <a href="{{ route('vehicles.sales') }}" class="bg-green-50 hover:bg-green-100 p-4 rounded-lg text-center transition duration-300 animate-button-hover animate-scale-on-hover">
                        <svg class="mx-auto h-8 w-8 text-green-600 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                        </svg>
                        <p class="text-sm font-medium text-green-600">
                            @if(app()->getLocale() === 'am')
                                መኪና ይግዙ
                            @else
                                Buy a Car
                            @endif
                        </p>
                    </a>
                    
                    <a href="{{ route('dashboard.profile') }}" class="bg-purple-50 hover:bg-purple-100 p-4 rounded-lg text-center transition duration-300 animate-button-hover animate-scale-on-hover">
                        <svg class="mx-auto h-8 w-8 text-purple-600 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                        <p class="text-sm font-medium text-purple-600">
                            @if(app()->getLocale() === 'am')
                                መገለጫ
                            @else
                                Profile
                            @endif
                        </p>
                    </a>
                    
                    <a href="{{ route('contact.show') }}" class="bg-orange-50 hover:bg-orange-100 p-4 rounded-lg text-center transition duration-300 animate-button-hover animate-scale-on-hover">
                        <svg class="mx-auto h-8 w-8 text-orange-600 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                        </svg>
                        <p class="text-sm font-medium text-orange-600">
                            @if(app()->getLocale() === 'am')
                                ድጋፍ
                            @else
                                Support
                            @endif
                        </p>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection