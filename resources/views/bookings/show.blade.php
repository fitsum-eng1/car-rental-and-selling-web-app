@extends('layouts.app')

@section('title', 'Booking Details - ' . $booking->booking_reference)

@section('content')
<div class="bg-gray-50 min-h-screen">
    <div class="max-w-4xl mx-auto py-6 sm:px-6 lg:px-8">
        <!-- Page header -->
        <div class="mb-8">
            <div class="flex items-center">
                <a href="{{ route('dashboard.bookings') }}" class="text-gray-500 hover:text-gray-700 mr-4">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                </a>
                <div>
                    <h2 class="text-2xl font-bold leading-7 text-gray-900 sm:text-3xl sm:truncate">
                        @if(app()->getLocale() === 'am')
                            ቦታ ማስያዝ ዝርዝር
                        @else
                            Booking Details
                        @endif
                    </h2>
                    <p class="mt-1 text-sm text-gray-500">{{ $booking->booking_reference }}</p>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Main Content -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Booking Status -->
                <div class="bg-white shadow rounded-lg p-6">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-medium text-gray-900">
                            @if(app()->getLocale() === 'am')
                                ሁኔታ
                            @else
                                Booking Status
                            @endif
                        </h3>
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium
                            @if($booking->status === 'confirmed') bg-green-100 text-green-800
                            @elseif($booking->status === 'pending_payment') bg-yellow-100 text-yellow-800
                            @elseif($booking->status === 'cancelled') bg-red-100 text-red-800
                            @elseif($booking->status === 'active') bg-blue-100 text-blue-800
                            @elseif($booking->status === 'completed') bg-gray-100 text-gray-800
                            @else bg-gray-100 text-gray-800 @endif">
                            @if(app()->getLocale() === 'am')
                                @switch($booking->status)
                                    @case('confirmed') ተረጋግጧል @break
                                    @case('pending_payment') ክፍያ በመጠባበቅ ላይ @break
                                    @case('cancelled') ተሰርዟል @break
                                    @case('active') ንቁ @break
                                    @case('completed') ተጠናቅቋል @break
                                    @default {{ ucfirst(str_replace('_', ' ', $booking->status)) }}
                                @endswitch
                            @else
                                {{ ucfirst(str_replace('_', ' ', $booking->status)) }}
                            @endif
                        </span>
                    </div>
                    
                    @if($booking->status === 'pending_payment' && $booking->payment)
                        <div class="bg-yellow-50 border border-yellow-200 rounded-md p-4">
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <svg class="h-5 w-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <h3 class="text-sm font-medium text-yellow-800">
                                        @if(app()->getLocale() === 'am')
                                            ክፍያ ያስፈልጋል
                                        @else
                                            Payment Required
                                        @endif
                                    </h3>
                                    <div class="mt-2 text-sm text-yellow-700">
                                        <p>
                                            @if(app()->getLocale() === 'am')
                                                ይህንን ቦታ ማስያዝ ለማጠናቀቅ ክፍያ ያስፈልጋል።
                                            @else
                                                Payment is required to complete this booking.
                                            @endif
                                        </p>
                                    </div>
                                    <div class="mt-4">
                                        <a href="{{ route('bookings.payment', $booking) }}" 
                                            class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-yellow-600 hover:bg-yellow-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500">
                                            @if(app()->getLocale() === 'am')
                                                አሁን ይክፈሉ
                                            @else
                                                Pay Now
                                            @endif
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>

                <!-- Vehicle Information -->
                <div class="bg-white shadow rounded-lg p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">
                        @if(app()->getLocale() === 'am')
                            የተመረጠ ተሽከርካሪ
                        @else
                            Selected Vehicle
                        @endif
                    </h3>
                    
                    <div class="flex items-start space-x-4">
                        <div class="flex-shrink-0">
                            @if($booking->vehicle->primary_image)
                                <img class="h-24 w-24 rounded-lg object-cover" src="{{ asset('storage/' . $booking->vehicle->primary_image) }}" alt="{{ $booking->vehicle->full_name }}">
                            @else
                                <div class="h-24 w-24 rounded-lg bg-gray-200 flex items-center justify-center">
                                    <svg class="h-8 w-8 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                            @endif
                        </div>
                        <div class="flex-1">
                            <h4 class="text-lg font-medium text-gray-900">{{ $booking->vehicle->full_name }}</h4>
                            <div class="mt-2 grid grid-cols-2 gap-4 text-sm text-gray-500">
                                <div>
                                    @if(app()->getLocale() === 'am')
                                        አይነት: {{ ucfirst($booking->vehicle->type) }}
                                    @else
                                        Type: {{ ucfirst($booking->vehicle->type) }}
                                    @endif
                                </div>
                                <div>
                                    @if(app()->getLocale() === 'am')
                                        ነዳጅ: {{ ucfirst($booking->vehicle->fuel_type) }}
                                    @else
                                        Fuel: {{ ucfirst($booking->vehicle->fuel_type) }}
                                    @endif
                                </div>
                                <div>
                                    @if(app()->getLocale() === 'am')
                                        ማስተላለፊያ: {{ ucfirst($booking->vehicle->transmission) }}
                                    @else
                                        Transmission: {{ ucfirst($booking->vehicle->transmission) }}
                                    @endif
                                </div>
                                <div>
                                    @if(app()->getLocale() === 'am')
                                        መቀመጫዎች: {{ $booking->vehicle->seats }}
                                    @else
                                        Seats: {{ $booking->vehicle->seats }}
                                    @endif
                                </div>
                            </div>
                            <div class="mt-4">
                                <a href="{{ route('vehicles.show', $booking->vehicle) }}" 
                                    class="text-indigo-600 hover:text-indigo-500 text-sm font-medium">
                                    @if(app()->getLocale() === 'am')
                                        ተሽከርካሪ ዝርዝር ይመልከቱ →
                                    @else
                                        View Vehicle Details →
                                    @endif
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Booking Details -->
                <div class="bg-white shadow rounded-lg p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">
                        @if(app()->getLocale() === 'am')
                            ቦታ ማስያዝ ዝርዝሮች
                        @else
                            Booking Details
                        @endif
                    </h3>
                    
                    <dl class="grid grid-cols-1 gap-x-4 gap-y-6 sm:grid-cols-2">
                        <div>
                            <dt class="text-sm font-medium text-gray-500">
                                @if(app()->getLocale() === 'am')
                                    የመውሰጃ ቀን
                                @else
                                    Pickup Date
                                @endif
                            </dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $booking->pickup_date->format('M d, Y \a\t g:i A') }}</dd>
                        </div>
                        
                        <div>
                            <dt class="text-sm font-medium text-gray-500">
                                @if(app()->getLocale() === 'am')
                                    የመመለሻ ቀን
                                @else
                                    Return Date
                                @endif
                            </dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $booking->return_date->format('M d, Y \a\t g:i A') }}</dd>
                        </div>
                        
                        <div>
                            <dt class="text-sm font-medium text-gray-500">
                                @if(app()->getLocale() === 'am')
                                    የመውሰጃ ቦታ
                                @else
                                    Pickup Location
                                @endif
                            </dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $booking->pickup_location }}</dd>
                        </div>
                        
                        <div>
                            <dt class="text-sm font-medium text-gray-500">
                                @if(app()->getLocale() === 'am')
                                    የመመለሻ ቦታ
                                @else
                                    Return Location
                                @endif
                            </dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $booking->return_location }}</dd>
                        </div>
                        
                        <div>
                            <dt class="text-sm font-medium text-gray-500">
                                @if(app()->getLocale() === 'am')
                                    የመንዳት አማራጭ
                                @else
                                    Driving Option
                                @endif
                            </dt>
                            <dd class="mt-1 text-sm text-gray-900">
                                @if($booking->driving_option === 'self_drive')
                                    @if(app()->getLocale() === 'am')
                                        በራስ መንዳት
                                    @else
                                        Self Drive
                                    @endif
                                @else
                                    @if(app()->getLocale() === 'am')
                                        ከአሽከርካሪ ጋር
                                    @else
                                        With Driver
                                    @endif
                                @endif
                            </dd>
                        </div>
                        
                        <div>
                            <dt class="text-sm font-medium text-gray-500">
                                @if(app()->getLocale() === 'am')
                                    ጠቅላላ ቀናት
                                @else
                                    Total Days
                                @endif
                            </dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $booking->total_days }} {{ app()->getLocale() === 'am' ? 'ቀናት' : 'days' }}</dd>
                        </div>
                    </dl>
                    
                    @if($booking->special_requests)
                        <div class="mt-6">
                            <dt class="text-sm font-medium text-gray-500">
                                @if(app()->getLocale() === 'am')
                                    ልዩ ጥያቄዎች
                                @else
                                    Special Requests
                                @endif
                            </dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $booking->special_requests }}</dd>
                        </div>
                    @endif
                </div>

                <!-- Payment Information -->
                @if($booking->payment)
                    <div class="bg-white shadow rounded-lg p-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">
                            @if(app()->getLocale() === 'am')
                                የክፍያ መረጃ
                            @else
                                Payment Information
                            @endif
                        </h3>
                        
                        <dl class="grid grid-cols-1 gap-x-4 gap-y-6 sm:grid-cols-2">
                            <div>
                                <dt class="text-sm font-medium text-gray-500">
                                    @if(app()->getLocale() === 'am')
                                        የክፍያ ማጣቀሻ
                                    @else
                                        Payment Reference
                                    @endif
                                </dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $booking->payment->payment_reference }}</dd>
                            </div>
                            
                            <div>
                                <dt class="text-sm font-medium text-gray-500">
                                    @if(app()->getLocale() === 'am')
                                        የክፍያ ሁኔታ
                                    @else
                                        Payment Status
                                    @endif
                                </dt>
                                <dd class="mt-1">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                        @if($booking->payment->status === 'completed') bg-green-100 text-green-800
                                        @elseif($booking->payment->status === 'pending') bg-yellow-100 text-yellow-800
                                        @elseif($booking->payment->status === 'failed') bg-red-100 text-red-800
                                        @else bg-gray-100 text-gray-800 @endif">
                                        {{ ucfirst($booking->payment->status) }}
                                    </span>
                                </dd>
                            </div>
                            
                            <div>
                                <dt class="text-sm font-medium text-gray-500">
                                    @if(app()->getLocale() === 'am')
                                        የክፍያ ዘዴ
                                    @else
                                        Payment Method
                                    @endif
                                </dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ ucfirst(str_replace('_', ' ', $booking->payment->payment_method)) }}</dd>
                            </div>
                            
                            <div>
                                <dt class="text-sm font-medium text-gray-500">
                                    @if(app()->getLocale() === 'am')
                                        የክፍያ ቀን
                                    @else
                                        Payment Date
                                    @endif
                                </dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $booking->payment->created_at->format('M d, Y \a\t g:i A') }}</dd>
                            </div>
                        </dl>
                        
                        @if($booking->payment->status === 'pending' || $booking->payment->status === 'failed')
                            <div class="mt-6">
                                <a href="{{ route('payments.status', $booking->payment) }}" 
                                    class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                    @if(app()->getLocale() === 'am')
                                        የክፍያ ሁኔታ ይመልከቱ
                                    @else
                                        View Payment Status
                                    @endif
                                </a>
                            </div>
                        @endif
                    </div>
                @endif
            </div>

            <!-- Sidebar -->
            <div class="lg:col-span-1">
                <!-- Booking Summary -->
                <div class="bg-white shadow rounded-lg p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">
                        @if(app()->getLocale() === 'am')
                            ቦታ ማስያዝ ማጠቃለያ
                        @else
                            Booking Summary
                        @endif
                    </h3>
                    
                    <div class="space-y-4">
                        <div class="flex justify-between">
                            <span class="text-sm text-gray-500">
                                @if(app()->getLocale() === 'am')
                                    የቀን ተመን
                                @else
                                    Daily Rate
                                @endif
                            </span>
                            <span class="text-sm font-medium text-gray-900">${{ number_format($booking->daily_rate, 2) }}</span>
                        </div>
                        
                        <div class="flex justify-between">
                            <span class="text-sm text-gray-500">
                                @if(app()->getLocale() === 'am')
                                    ቀናት
                                @else
                                    Days
                                @endif
                            </span>
                            <span class="text-sm font-medium text-gray-900">{{ $booking->total_days }}</span>
                        </div>
                        
                        @if($booking->driver_cost > 0)
                            <div class="flex justify-between">
                                <span class="text-sm text-gray-500">
                                    @if(app()->getLocale() === 'am')
                                        የአሽከርካሪ ወጪ
                                    @else
                                        Driver Cost
                                    @endif
                                </span>
                                <span class="text-sm font-medium text-gray-900">${{ number_format($booking->driver_cost, 2) }}</span>
                            </div>
                        @endif
                        
                        <div class="flex justify-between">
                            <span class="text-sm text-gray-500">
                                @if(app()->getLocale() === 'am')
                                    ንዑስ ድምር
                                @else
                                    Subtotal
                                @endif
                            </span>
                            <span class="text-sm font-medium text-gray-900">${{ number_format($booking->subtotal, 2) }}</span>
                        </div>
                        
                        <div class="flex justify-between">
                            <span class="text-sm text-gray-500">
                                @if(app()->getLocale() === 'am')
                                    ታክስ
                                @else
                                    Tax
                                @endif
                            </span>
                            <span class="text-sm font-medium text-gray-900">${{ number_format($booking->tax_amount, 2) }}</span>
                        </div>
                        
                        <div class="border-t pt-4">
                            <div class="flex justify-between">
                                <span class="text-base font-medium text-gray-900">
                                    @if(app()->getLocale() === 'am')
                                        ጠቅላላ
                                    @else
                                        Total
                                    @endif
                                </span>
                                <span class="text-base font-medium text-gray-900">${{ number_format($booking->total_amount, 2) }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Actions -->
                <div class="mt-6 bg-white shadow rounded-lg p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">
                        @if(app()->getLocale() === 'am')
                            እርምጃዎች
                        @else
                            Actions
                        @endif
                    </h3>
                    
                    <div class="space-y-3">
                        @if($booking->status === 'pending_payment')
                            <a href="{{ route('bookings.payment', $booking) }}" 
                                class="w-full inline-flex justify-center items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                @if(app()->getLocale() === 'am')
                                    ክፍያ ያጠናቅቁ
                                @else
                                    Complete Payment
                                @endif
                            </a>
                        @endif
                        
                        @if(in_array($booking->status, ['pending_payment', 'confirmed']) && $booking->pickup_date->isFuture())
                            <form action="{{ route('bookings.cancel', $booking) }}" method="POST" class="w-full">
                                @csrf
                                @method('DELETE')
                                <button type="submit" 
                                    onclick="return confirm('{{ app()->getLocale() === 'am' ? 'ይህንን ቦታ ማስያዝ መሰረዝ እርግጠኛ ነዎት?' : 'Are you sure you want to cancel this booking?' }}')"
                                    class="w-full inline-flex justify-center items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                                    @if(app()->getLocale() === 'am')
                                        ቦታ ማስያዝ ሰርዝ
                                    @else
                                        Cancel Booking
                                    @endif
                                </button>
                            </form>
                        @endif
                        
                        <a href="{{ route('dashboard.bookings') }}" 
                            class="w-full inline-flex justify-center items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            @if(app()->getLocale() === 'am')
                                ሁሉንም ቦታ ማስያዝ ይመልከቱ
                            @else
                                View All Bookings
                            @endif
                        </a>
                    </div>
                </div>

                <!-- Booking Timeline -->
                <div class="mt-6 bg-white shadow rounded-lg p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">
                        @if(app()->getLocale() === 'am')
                            የቦታ ማስያዝ ታሪክ
                        @else
                            Booking Timeline
                        @endif
                    </h3>
                    
                    <div class="flow-root">
                        <ul class="-mb-8">
                            <li>
                                <div class="relative pb-8">
                                    <div class="relative flex space-x-3">
                                        <div>
                                            <span class="h-8 w-8 rounded-full bg-blue-500 flex items-center justify-center ring-8 ring-white">
                                                <svg class="h-5 w-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                                </svg>
                                            </span>
                                        </div>
                                        <div class="min-w-0 flex-1 pt-1.5">
                                            <div>
                                                <p class="text-sm text-gray-500">
                                                    @if(app()->getLocale() === 'am')
                                                        ቦታ ማስያዝ ተፈጥሯል
                                                    @else
                                                        Booking created
                                                    @endif
                                                </p>
                                                <p class="text-xs text-gray-400">{{ $booking->created_at->format('M d, Y \a\t g:i A') }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>

                            @if($booking->payment)
                                <li>
                                    <div class="relative pb-8">
                                        <div class="relative flex space-x-3">
                                            <div>
                                                <span class="h-8 w-8 rounded-full bg-green-500 flex items-center justify-center ring-8 ring-white">
                                                    <svg class="h-5 w-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                                                        <path d="M4 4a2 2 0 00-2 2v4a2 2 0 002 2V6h10a2 2 0 00-2-2H4zm2 6a2 2 0 012-2h8a2 2 0 012 2v4a2 2 0 01-2 2H8a2 2 0 01-2-2v-4zm6 4a2 2 0 100-4 2 2 0 000 4z" />
                                                    </svg>
                                                </span>
                                            </div>
                                            <div class="min-w-0 flex-1 pt-1.5">
                                                <div>
                                                    <p class="text-sm text-gray-500">
                                                        @if(app()->getLocale() === 'am')
                                                            ክፍያ ተጀመረ
                                                        @else
                                                            Payment initiated
                                                        @endif
                                                    </p>
                                                    <p class="text-xs text-gray-400">{{ $booking->payment->created_at->format('M d, Y \a\t g:i A') }}</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            @endif

                            @if($booking->status === 'confirmed')
                                <li>
                                    <div class="relative">
                                        <div class="relative flex space-x-3">
                                            <div>
                                                <span class="h-8 w-8 rounded-full bg-purple-500 flex items-center justify-center ring-8 ring-white">
                                                    <svg class="h-5 w-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                                    </svg>
                                                </span>
                                            </div>
                                            <div class="min-w-0 flex-1 pt-1.5">
                                                <div>
                                                    <p class="text-sm text-gray-500">
                                                        @if(app()->getLocale() === 'am')
                                                            ቦታ ማስያዝ ተረጋግጧል
                                                        @else
                                                            Booking confirmed
                                                        @endif
                                                    </p>
                                                    <p class="text-xs text-gray-400">{{ $booking->updated_at->format('M d, Y \a\t g:i A') }}</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            @endif
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection