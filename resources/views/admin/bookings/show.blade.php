@extends('layouts.app')

@section('title', 'Booking Details - Admin Panel')

@section('content')
<div class="bg-gray-50 min-h-screen">
    <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
        <!-- Page header -->
        <div class="mb-8">
            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <a href="{{ route('admin.bookings.index') }}" class="text-gray-500 hover:text-gray-700 mr-4">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                        </svg>
                    </a>
                    <h2 class="text-2xl font-bold leading-7 text-gray-900 sm:text-3xl sm:truncate">
                        Booking {{ $booking->booking_reference }}
                    </h2>
                </div>
                <div class="flex space-x-3">
                    @if($booking->status === 'pending_approval')
                        <form action="{{ route('admin.bookings.approve', $booking) }}" method="POST" class="inline">
                            @csrf
                            <button type="submit" 
                                class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                                <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                                Approve Booking
                            </button>
                        </form>
                    @endif
                    @if(in_array($booking->status, ['pending_approval', 'confirmed']))
                        <button onclick="document.getElementById('reject-modal').classList.remove('hidden')" 
                            class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                            <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                            Reject Booking
                        </button>
                    @endif
                </div>
            </div>
        </div>

        @if($booking->isStuck())
            <!-- Stuck Booking Alert -->
            <div class="mb-6 bg-red-50 border border-red-200 rounded-md p-4">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-red-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-sm font-medium text-red-800">Stuck Booking Detected</h3>
                        <div class="mt-2 text-sm text-red-700">
                            <p>This booking has been in "pending payment" status for <strong>{{ round($booking->getStuckAge() / 24, 1) }} days</strong> without any payment record.</p>
                            <p class="mt-1">
                                <strong>Urgency Level:</strong> 
                                <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium ml-1
                                    @if($booking->getUrgencyLevel() === 'critical') bg-red-200 text-red-900
                                    @elseif($booking->getUrgencyLevel() === 'urgent') bg-orange-200 text-orange-900
                                    @elseif($booking->getUrgencyLevel() === 'warning') bg-yellow-200 text-yellow-900
                                    @else bg-gray-200 text-gray-900 @endif">
                                    {{ ucfirst($booking->getUrgencyLevel()) }}
                                </span>
                            </p>
                            <p class="mt-2">
                                <strong>Recommended Actions:</strong> Send payment reminder, generate payment link, or cancel booking if appropriate.
                            </p>
                        </div>
                        <div class="mt-4">
                            <div class="flex space-x-3">
                                @if($booking->canSendReminder())
                                    <form action="{{ route('admin.bookings.send-reminder', $booking) }}" method="POST" class="inline">
                                        @csrf
                                        <button type="submit" 
                                            onclick="return confirm('Send payment reminder to {{ $booking->user->email }}?')"
                                            class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                            <svg class="-ml-1 mr-1 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                            </svg>
                                            Send Payment Reminder
                                        </button>
                                    </form>
                                @else
                                    <button disabled class="inline-flex items-center px-3 py-2 border border-gray-300 text-sm leading-4 font-medium rounded-md text-gray-400 bg-gray-100 cursor-not-allowed">
                                        <svg class="-ml-1 mr-1 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                        </svg>
                                        Reminder Sent Recently
                                    </button>
                                @endif
                                
                                <button onclick="document.getElementById('payment-link-modal').classList.remove('hidden')"
                                    class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                                    <svg class="-ml-1 mr-1 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1" />
                                    </svg>
                                    Generate Payment Link
                                </button>
                                
                                <button onclick="document.getElementById('mark-paid-modal').classList.remove('hidden')"
                                    class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-white bg-purple-600 hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500">
                                    <svg class="-ml-1 mr-1 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    Mark as Paid
                                </button>
                                
                                <button onclick="document.getElementById('cancel-booking-modal').classList.remove('hidden')"
                                    class="inline-flex items-center px-3 py-2 border border-gray-300 text-sm leading-4 font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                                    <svg class="-ml-1 mr-1 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                    Cancel Booking
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Booking Details -->
            <div class="lg:col-span-2">
                <!-- Vehicle Information -->
                <div class="bg-white shadow rounded-lg mb-6">
                    <div class="px-4 py-5 sm:p-6">
                        <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">Vehicle Information</h3>
                        
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
                                    <div>Type: {{ ucfirst($booking->vehicle->type) }}</div>
                                    <div>Fuel: {{ ucfirst($booking->vehicle->fuel_type) }}</div>
                                    <div>Transmission: {{ ucfirst($booking->vehicle->transmission) }}</div>
                                    <div>Seats: {{ $booking->vehicle->seats }}</div>
                                </div>
                                <div class="mt-2">
                                    <a href="{{ route('admin.vehicles.show', $booking->vehicle) }}" 
                                        class="text-indigo-600 hover:text-indigo-500 text-sm font-medium">
                                        View Vehicle Details →
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Booking Information -->
                <div class="bg-white shadow rounded-lg mb-6">
                    <div class="px-4 py-5 sm:p-6">
                        <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">Booking Information</h3>
                        
                        <dl class="grid grid-cols-1 gap-x-4 gap-y-6 sm:grid-cols-2">
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Booking Reference</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $booking->booking_reference }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Status</dt>
                                <dd class="mt-1">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                        @if($booking->status === 'confirmed') bg-green-100 text-green-800
                                        @elseif($booking->status === 'pending_payment') bg-yellow-100 text-yellow-800
                                        @elseif($booking->status === 'pending_approval') bg-blue-100 text-blue-800
                                        @elseif($booking->status === 'cancelled') bg-red-100 text-red-800
                                        @elseif($booking->status === 'rejected') bg-red-100 text-red-800
                                        @elseif($booking->status === 'active') bg-purple-100 text-purple-800
                                        @elseif($booking->status === 'completed') bg-gray-100 text-gray-800
                                        @else bg-gray-100 text-gray-800 @endif">
                                        {{ ucfirst(str_replace('_', ' ', $booking->status)) }}
                                    </span>
                                </dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Pickup Date</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $booking->pickup_date->format('M d, Y \a\t g:i A') }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Return Date</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $booking->return_date->format('M d, Y \a\t g:i A') }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Pickup Location</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $booking->pickup_location }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Return Location</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $booking->return_location }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Duration</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $booking->pickup_date->diffInDays($booking->return_date) }} days</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Total Amount</dt>
                                <dd class="mt-1 text-lg font-medium text-gray-900">${{ number_format($booking->total_amount, 2) }}</dd>
                            </div>
                        </dl>

                        @if($booking->special_requests)
                            <div class="mt-6">
                                <dt class="text-sm font-medium text-gray-500">Special Requests</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $booking->special_requests }}</dd>
                            </div>
                        @endif

                        @if($booking->rejection_reason)
                            <div class="mt-6">
                                <dt class="text-sm font-medium text-gray-500">Rejection Reason</dt>
                                <dd class="mt-1 text-sm text-red-600">{{ $booking->rejection_reason }}</dd>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Payment Information -->
                @if($booking->payment)
                    <div class="bg-white shadow rounded-lg">
                        <div class="px-4 py-5 sm:p-6">
                            <div class="flex items-center justify-between mb-4">
                                <h3 class="text-lg leading-6 font-medium text-gray-900">Payment Information</h3>
                                @if($booking->payment->status === 'submitted' && $booking->status === 'pending_payment')
                                    <div class="flex space-x-2">
                                        <form action="{{ route('admin.payments.verify', $booking->payment) }}" method="POST" class="inline">
                                            @csrf
                                            <button type="submit" 
                                                onclick="return confirm('Are you sure you want to verify this payment?')"
                                                class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                                                <svg class="-ml-1 mr-1 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                                </svg>
                                                Verify Payment
                                            </button>
                                        </form>
                                        <a href="{{ route('admin.payments.show', $booking->payment) }}" 
                                            class="inline-flex items-center px-3 py-2 border border-gray-300 shadow-sm text-sm leading-4 font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                            View Payment Details
                                        </a>
                                    </div>
                                @elseif($booking->payment)
                                    <a href="{{ route('admin.payments.show', $booking->payment) }}" 
                                        class="inline-flex items-center px-3 py-2 border border-gray-300 shadow-sm text-sm leading-4 font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                        View Payment Details
                                    </a>
                                @endif
                            </div>
                            
                            <dl class="grid grid-cols-1 gap-x-4 gap-y-6 sm:grid-cols-2">
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Payment Reference</dt>
                                    <dd class="mt-1 text-sm text-gray-900 font-mono">{{ $booking->payment->payment_reference }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Payment Status</dt>
                                    <dd class="mt-1">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                            @if($booking->payment->status === 'verified') bg-green-100 text-green-800
                                            @elseif($booking->payment->status === 'submitted') bg-yellow-100 text-yellow-800
                                            @elseif($booking->payment->status === 'pending') bg-gray-100 text-gray-800
                                            @elseif($booking->payment->status === 'rejected') bg-red-100 text-red-800
                                            @else bg-gray-100 text-gray-800 @endif">
                                            {{ ucfirst($booking->payment->status) }}
                                        </span>
                                    </dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Payment Method</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ ucfirst(str_replace('_', ' ', $booking->payment->payment_method)) }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Amount</dt>
                                    <dd class="mt-1 text-sm text-gray-900">${{ number_format($booking->payment->amount, 2) }}</dd>
                                </div>
                                @if($booking->payment->bank_name)
                                    <div>
                                        <dt class="text-sm font-medium text-gray-500">Bank</dt>
                                        <dd class="mt-1 text-sm text-gray-900">{{ $booking->payment->bank_name }}</dd>
                                    </div>
                                @endif
                                @if($booking->payment->transaction_reference)
                                    <div>
                                        <dt class="text-sm font-medium text-gray-500">Transaction Reference</dt>
                                        <dd class="mt-1 text-sm text-gray-900 font-mono">{{ $booking->payment->transaction_reference }}</dd>
                                    </div>
                                @endif
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Payment Date</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $booking->payment->created_at->format('M d, Y \a\t g:i A') }}</dd>
                                </div>
                                @if($booking->payment->verified_at)
                                    <div>
                                        <dt class="text-sm font-medium text-gray-500">Verified At</dt>
                                        <dd class="mt-1 text-sm text-gray-900">{{ $booking->payment->verified_at->format('M d, Y \a\t g:i A') }}</dd>
                                    </div>
                                @endif
                            </dl>

                            @if($booking->payment->transaction_proof)
                                <div class="mt-6">
                                    <dt class="text-sm font-medium text-gray-500">Transaction Proof</dt>
                                    <dd class="mt-1 p-3 bg-gray-50 rounded-md">
                                        <p class="text-sm text-gray-900">{{ $booking->payment->transaction_proof }}</p>
                                    </dd>
                                </div>
                            @endif

                            @if($booking->payment->rejection_reason)
                                <div class="mt-6">
                                    <dt class="text-sm font-medium text-gray-500">Rejection Reason</dt>
                                    <dd class="mt-1 p-3 bg-red-50 rounded-md border border-red-200">
                                        <p class="text-sm text-red-900">{{ $booking->payment->rejection_reason }}</p>
                                    </dd>
                                </div>
                            @endif

                            @if($booking->payment->status === 'submitted' && $booking->status === 'pending_payment')
                                <div class="mt-6 p-4 bg-yellow-50 border border-yellow-200 rounded-md">
                                    <div class="flex">
                                        <div class="flex-shrink-0">
                                            <svg class="h-5 w-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                            </svg>
                                        </div>
                                        <div class="ml-3">
                                            <h3 class="text-sm font-medium text-yellow-800">Payment Verification Required</h3>
                                            <div class="mt-2 text-sm text-yellow-700">
                                                <p>This booking has a submitted payment that requires verification. Please review the payment details and verify or reject the payment to proceed with the booking.</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                @else
                    <div class="bg-white shadow rounded-lg">
                        <div class="px-4 py-5 sm:p-6">
                            <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">Payment Information</h3>
                            <div class="text-center py-6">
                                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                                </svg>
                                <h3 class="mt-2 text-sm font-medium text-gray-900">No payment information</h3>
                                <p class="mt-1 text-sm text-gray-500">Payment has not been submitted for this booking yet.</p>
                            </div>
                        </div>
                    </div>
                @endif
            </div>

            <!-- Sidebar -->
            <div class="lg:col-span-1">
                <!-- Customer Information -->
                <div class="bg-white shadow rounded-lg">
                    <div class="px-4 py-5 sm:p-6">
                        <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">Customer Information</h3>
                        
                        <div class="text-center mb-4">
                            <div class="h-16 w-16 rounded-full bg-gray-200 flex items-center justify-center mx-auto mb-2">
                                <span class="text-gray-600 font-bold text-xl">
                                    {{ strtoupper(substr($booking->user->name, 0, 1)) }}
                                </span>
                            </div>
                            <h4 class="text-lg font-medium text-gray-900">{{ $booking->user->name }}</h4>
                            <p class="text-sm text-gray-500">{{ $booking->user->email }}</p>
                        </div>

                        <dl class="space-y-4">
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Phone</dt>
                                <dd class="mt-1 text-sm text-gray-900">
                                    <a href="tel:{{ $booking->user->phone }}" class="text-blue-600 hover:text-blue-500">
                                        {{ $booking->user->phone }}
                                    </a>
                                </dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Member Since</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $booking->user->created_at->format('M d, Y') }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Total Bookings</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $booking->user->bookings->count() }}</dd>
                            </div>
                        </dl>

                        <div class="mt-6">
                            <a href="{{ route('admin.users.show', $booking->user) }}" 
                                class="w-full inline-flex justify-center items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                View Customer Profile
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Booking Timeline -->
                <div class="mt-6 bg-white shadow rounded-lg">
                    <div class="px-4 py-5 sm:p-6">
                        <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">Booking Timeline</h3>
                        
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
                                                    <p class="text-sm text-gray-500">Booking created</p>
                                                    <p class="text-xs text-gray-400">{{ $booking->created_at->format('M d, Y \a\t g:i A') }}</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </li>

                                @if($booking->payment && $booking->payment->created_at)
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
                                                        <p class="text-sm text-gray-500">Payment submitted</p>
                                                        <p class="text-xs text-gray-400">{{ $booking->payment->created_at->format('M d, Y \a\t g:i A') }}</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                @endif

                                @if($booking->approved_at)
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
                                                        <p class="text-sm text-gray-500">Booking approved</p>
                                                        <p class="text-xs text-gray-400">{{ $booking->approved_at->format('M d, Y \a\t g:i A') }}</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                @endif

                                @if($booking->rejected_at)
                                    <li>
                                        <div class="relative">
                                            <div class="relative flex space-x-3">
                                                <div>
                                                    <span class="h-8 w-8 rounded-full bg-red-500 flex items-center justify-center ring-8 ring-white">
                                                        <svg class="h-5 w-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                                                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                                                        </svg>
                                                    </span>
                                                </div>
                                                <div class="min-w-0 flex-1 pt-1.5">
                                                    <div>
                                                        <p class="text-sm text-gray-500">Booking rejected</p>
                                                        <p class="text-xs text-gray-400">{{ $booking->rejected_at->format('M d, Y \a\t g:i A') }}</p>
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
</div>

<!-- Reject Modal -->
<div id="reject-modal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Reject Booking</h3>
            <form action="{{ route('admin.bookings.reject', $booking) }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label for="rejection_reason" class="block text-sm font-medium text-gray-700">Rejection Reason</label>
                    <textarea name="rejection_reason" id="rejection_reason" rows="4" required
                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-red-500 focus:border-red-500"
                        placeholder="Please provide a reason for rejecting this booking..."></textarea>
                </div>
                <div class="flex justify-end space-x-3">
                    <button type="button" onclick="document.getElementById('reject-modal').classList.add('hidden')"
                        class="px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
                        Cancel
                    </button>
                    <button type="submit" 
                        class="px-4 py-2 border border-transparent rounded-md text-sm font-medium text-white bg-red-600 hover:bg-red-700">
                        Reject Booking
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Generate Payment Link Modal -->
<div id="payment-link-modal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Generate Payment Link</h3>
            <form action="{{ route('admin.bookings.generate-link', $booking) }}" method="POST">
                @csrf
                <div class="mb-4">
                    <p class="text-sm text-gray-600">
                        This will generate a secure payment link for the customer that expires in 48 hours.
                    </p>
                    <div class="mt-3 p-3 bg-blue-50 rounded-md">
                        <p class="text-sm text-blue-800">
                            <strong>Customer:</strong> {{ $booking->user->name }} ({{ $booking->user->email }})<br>
                            <strong>Amount:</strong> ${{ number_format($booking->total_amount, 2) }}
                        </p>
                    </div>
                </div>
                <div class="flex justify-end space-x-3">
                    <button type="button" onclick="document.getElementById('payment-link-modal').classList.add('hidden')"
                        class="px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
                        Cancel
                    </button>
                    <button type="submit" 
                        class="px-4 py-2 border border-transparent rounded-md text-sm font-medium text-white bg-green-600 hover:bg-green-700">
                        Generate Link
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Mark as Paid Modal -->
<div id="mark-paid-modal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Mark Booking as Paid</h3>
            <form action="{{ route('admin.bookings.mark-paid', $booking) }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label for="payment_amount" class="block text-sm font-medium text-gray-700">Payment Amount</label>
                    <div class="mt-1 relative rounded-md shadow-sm">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <span class="text-gray-500 sm:text-sm">$</span>
                        </div>
                        <input type="number" name="payment_amount" id="payment_amount" step="0.01" min="0.01" 
                            value="{{ $booking->total_amount }}" required
                            class="pl-7 block w-full border-gray-300 rounded-md shadow-sm focus:ring-purple-500 focus:border-purple-500"
                            placeholder="0.00">
                    </div>
                    <p class="mt-1 text-xs text-gray-500">This will create an offline payment record and confirm the booking.</p>
                </div>
                <div class="flex justify-end space-x-3">
                    <button type="button" onclick="document.getElementById('mark-paid-modal').classList.add('hidden')"
                        class="px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
                        Cancel
                    </button>
                    <button type="submit" 
                        class="px-4 py-2 border border-transparent rounded-md text-sm font-medium text-white bg-purple-600 hover:bg-purple-700">
                        Mark as Paid
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Cancel Booking Modal -->
<div id="cancel-booking-modal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Cancel Booking</h3>
            <form action="{{ route('admin.bookings.cancel', $booking) }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label for="cancellation_reason" class="block text-sm font-medium text-gray-700">Cancellation Reason</label>
                    <textarea name="cancellation_reason" id="cancellation_reason" rows="4" required
                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-red-500 focus:border-red-500"
                        placeholder="Please provide a reason for cancelling this booking..."></textarea>
                </div>
                <div class="flex justify-end space-x-3">
                    <button type="button" onclick="document.getElementById('cancel-booking-modal').classList.add('hidden')"
                        class="px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
                        Cancel
                    </button>
                    <button type="submit" 
                        class="px-4 py-2 border border-transparent rounded-md text-sm font-medium text-white bg-red-600 hover:bg-red-700">
                        Cancel Booking
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@if(session('payment_link'))
<!-- Payment Link Success Modal -->
<div id="payment-link-success-modal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3">
            <div class="flex items-center mb-4">
                <svg class="h-6 w-6 text-green-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
                <h3 class="text-lg font-medium text-gray-900">Payment Link Generated</h3>
            </div>
            <div class="mb-4">
                <p class="text-sm text-gray-600 mb-3">Payment link has been generated successfully:</p>
                <div class="p-3 bg-gray-50 rounded-md border">
                    <input type="text" value="{{ session('payment_link') }}" readonly
                        class="w-full text-sm font-mono bg-transparent border-none focus:ring-0 p-0"
                        onclick="this.select()">
                </div>
                <button onclick="copyToClipboard('{{ session('payment_link') }}')" 
                    class="mt-2 text-sm text-blue-600 hover:text-blue-500">
                    📋 Copy to clipboard
                </button>
            </div>
            <div class="flex justify-end">
                <button type="button" onclick="document.getElementById('payment-link-success-modal').classList.add('hidden')"
                    class="px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
                    Close
                </button>
            </div>
        </div>
    </div>
</div>

<script>
function copyToClipboard(text) {
    navigator.clipboard.writeText(text).then(function() {
        alert('Payment link copied to clipboard!');
    });
}
</script>
@endif
@endsection