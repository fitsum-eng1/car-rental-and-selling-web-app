@extends('layouts.app')

@section('title', 'Payment Status - Car Rental & Sales System')

@section('content')
<div class="bg-gray-50 min-h-screen">
    <div class="max-w-4xl mx-auto py-6 sm:px-6 lg:px-8">
        <!-- Page header -->
        <div class="mb-8">
            <nav class="flex" aria-label="Breadcrumb">
                <ol class="flex items-center space-x-4">
                    <li>
                        <div>
                            <a href="{{ route('dashboard') }}" class="text-gray-400 hover:text-gray-500">
                                <svg class="flex-shrink-0 h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-3a1 1 0 011-1h2a1 1 0 011 1v3a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z" />
                                </svg>
                                <span class="sr-only">Home</span>
                            </a>
                        </div>
                    </li>
                    <li>
                        <div class="flex items-center">
                            <svg class="flex-shrink-0 h-5 w-5 text-gray-300" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                            </svg>
                            <span class="ml-4 text-sm font-medium text-gray-500">Payment Status</span>
                        </div>
                    </li>
                </ol>
            </nav>
            <h1 class="mt-4 text-3xl font-bold text-gray-900">Payment Status</h1>
            <p class="mt-2 text-sm text-gray-600">View your payment details and current status</p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Payment Details -->
            <div class="lg:col-span-2">
                <div class="bg-white shadow rounded-lg">
                    <div class="px-4 py-5 sm:p-6">
                        <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">Payment Information</h3>
                        
                        <!-- Payment Status Badge -->
                        <div class="mb-6">
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium
                                @if($payment->status === 'verified') bg-green-100 text-green-800
                                @elseif($payment->status === 'submitted') bg-blue-100 text-blue-800
                                @elseif($payment->status === 'pending') bg-yellow-100 text-yellow-800
                                @elseif($payment->status === 'rejected') bg-red-100 text-red-800
                                @elseif($payment->status === 'expired') bg-gray-100 text-gray-800
                                @else bg-gray-100 text-gray-800 @endif">
                                @if($payment->status === 'verified')
                                    <svg class="-ml-1 mr-1.5 h-4 w-4" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                    </svg>
                                @elseif($payment->status === 'submitted')
                                    <svg class="-ml-1 mr-1.5 h-4 w-4" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd" />
                                    </svg>
                                @elseif($payment->status === 'pending')
                                    <svg class="-ml-1 mr-1.5 h-4 w-4" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                    </svg>
                                @elseif($payment->status === 'rejected')
                                    <svg class="-ml-1 mr-1.5 h-4 w-4" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                                    </svg>
                                @endif
                                {{ ucfirst($payment->status) }}
                            </span>
                        </div>

                        <!-- Payment Details -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Payment ID</dt>
                                <dd class="mt-1 text-sm text-gray-900 font-mono">{{ $payment->id }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Amount</dt>
                                <dd class="mt-1 text-sm text-gray-900 font-semibold">${{ number_format($payment->amount, 2) }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Payment Method</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ ucfirst(str_replace('_', ' ', $payment->payment_method)) }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Created</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $payment->created_at->format('M d, Y H:i') }}</dd>
                            </div>
                            @if($payment->transaction_reference)
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Transaction Reference</dt>
                                <dd class="mt-1 text-sm text-gray-900 font-mono">{{ $payment->transaction_reference }}</dd>
                            </div>
                            @endif
                            @if($payment->transaction_date)
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Transaction Date</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $payment->transaction_date->format('M d, Y') }}</dd>
                            </div>
                            @endif
                            @if($payment->verified_at)
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Verified At</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $payment->verified_at->format('M d, Y H:i') }}</dd>
                            </div>
                            @endif
                        </div>

                        @if($payment->transaction_proof)
                        <div class="mt-6">
                            <dt class="text-sm font-medium text-gray-500">Transaction Proof</dt>
                            <dd class="mt-2 text-sm text-gray-900 bg-gray-50 p-3 rounded-md">{{ $payment->transaction_proof }}</dd>
                        </div>
                        @endif

                        @if($payment->admin_notes)
                        <div class="mt-6">
                            <dt class="text-sm font-medium text-gray-500">Admin Notes</dt>
                            <dd class="mt-2 text-sm text-gray-900 bg-gray-50 p-3 rounded-md">{{ $payment->admin_notes }}</dd>
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Related Item (Booking or Purchase) -->
                @if($payment->payable)
                <div class="mt-6 bg-white shadow rounded-lg">
                    <div class="px-4 py-5 sm:p-6">
                        <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">
                            @if($payment->payable_type === 'App\Models\Booking')
                                Related Booking
                            @else
                                Related Purchase
                            @endif
                        </h3>
                        
                        <div class="flex items-center space-x-4">
                            @if($payment->payable->vehicle->primary_image)
                                <img class="h-16 w-16 rounded-lg object-cover" src="{{ asset('storage/' . $payment->payable->vehicle->primary_image) }}" alt="{{ $payment->payable->vehicle->full_name }}">
                            @else
                                <div class="h-16 w-16 rounded-lg bg-gray-200 flex items-center justify-center">
                                    <svg class="h-8 w-8 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                            @endif
                            <div>
                                <h4 class="text-lg font-medium text-gray-900">{{ $payment->payable->vehicle->full_name }}</h4>
                                <p class="text-sm text-gray-500">
                                    @if($payment->payable_type === 'App\Models\Booking')
                                        Booking: {{ $payment->payable->booking_reference }}
                                    @else
                                        Purchase: {{ $payment->payable->purchase_reference }}
                                    @endif
                                </p>
                                <p class="text-sm text-gray-500">Total: ${{ number_format($payment->payable->total_amount, 2) }}</p>
                            </div>
                        </div>
                    </div>
                </div>
                @endif
            </div>

            <!-- Status Information -->
            <div class="lg:col-span-1">
                <div class="bg-white shadow rounded-lg">
                    <div class="px-4 py-5 sm:p-6">
                        <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">Status Information</h3>
                        
                        @if($payment->status === 'pending')
                            <div class="p-4 bg-yellow-50 rounded-md">
                                <div class="flex">
                                    <div class="flex-shrink-0">
                                        <svg class="h-5 w-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                    <div class="ml-3">
                                        <h3 class="text-sm font-medium text-yellow-800">Payment Pending</h3>
                                        <div class="mt-2 text-sm text-yellow-700">
                                            <p>Payment is pending. Please complete the bank transfer and submit your payment details.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @elseif($payment->status === 'submitted')
                            <div class="p-4 bg-blue-50 rounded-md">
                                <div class="flex">
                                    <div class="flex-shrink-0">
                                        <svg class="h-5 w-5 text-blue-400" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                    <div class="ml-3">
                                        <h3 class="text-sm font-medium text-blue-800">Payment Submitted</h3>
                                        <div class="mt-2 text-sm text-blue-700">
                                            <p>Payment details submitted. Awaiting verification from our team.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @elseif($payment->status === 'verified')
                            <div class="p-4 bg-green-50 rounded-md">
                                <div class="flex">
                                    <div class="flex-shrink-0">
                                        <svg class="h-5 w-5 text-green-400" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                    <div class="ml-3">
                                        <h3 class="text-sm font-medium text-green-800">Payment Verified</h3>
                                        <div class="mt-2 text-sm text-green-700">
                                            <p>Payment verified successfully! Your transaction is complete.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @elseif($payment->status === 'rejected')
                            <div class="p-4 bg-red-50 rounded-md">
                                <div class="flex">
                                    <div class="flex-shrink-0">
                                        <svg class="h-5 w-5 text-red-400" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                    <div class="ml-3">
                                        <h3 class="text-sm font-medium text-red-800">Payment Rejected</h3>
                                        <div class="mt-2 text-sm text-red-700">
                                            <p>Payment was rejected. Please contact support for assistance.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @elseif($payment->status === 'expired')
                            <div class="p-4 bg-gray-50 rounded-md">
                                <div class="flex">
                                    <div class="flex-shrink-0">
                                        <svg class="h-5 w-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                    <div class="ml-3">
                                        <h3 class="text-sm font-medium text-gray-800">Payment Expired</h3>
                                        <div class="mt-2 text-sm text-gray-700">
                                            <p>Payment has expired. Please create a new booking/purchase.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Actions -->
                <div class="mt-6 bg-white shadow rounded-lg">
                    <div class="px-4 py-5 sm:p-6">
                        <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">Actions</h3>
                        <div class="space-y-3">
                            @if($payment->payable_type === 'App\Models\Booking')
                                <a href="{{ route('bookings.show', $payment->payable) }}" class="w-full inline-flex justify-center items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                    <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                                    </svg>
                                    Back to Booking
                                </a>
                            @else
                                <a href="{{ route('purchases.show', $payment->payable) }}" class="w-full inline-flex justify-center items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                    <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                                    </svg>
                                    Back to Purchase
                                </a>
                            @endif
                            <a href="{{ route('dashboard') }}" class="w-full inline-flex justify-center items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                                </svg>
                                Dashboard
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection