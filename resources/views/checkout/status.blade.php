@extends('layouts.app')

@section('title', 'Purchase Status - Order Confirmation')

@section('content')
<div class="bg-gray-50 min-h-screen">
    <div class="max-w-4xl mx-auto py-6 sm:px-6 lg:px-8">
        <!-- Success Header -->
        <div class="text-center mb-8">
            <div class="mx-auto flex items-center justify-center h-16 w-16 rounded-full bg-green-100 mb-4">
                <svg class="h-8 w-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>
            </div>
            <h1 class="text-3xl font-bold text-gray-900">🎉 Purchase Submitted Successfully!</h1>
            <p class="mt-2 text-lg text-gray-600">Your order has been received and is being processed</p>
            
            <!-- Success Message Alert -->
            @if(session('success'))
                <div class="mt-4 mx-auto max-w-md">
                    <div class="bg-green-50 border border-green-200 rounded-md p-4">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-green-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm font-medium text-green-800">{{ session('success') }}</p>
                                <p class="mt-1 text-sm text-green-700">A confirmation email has been sent to {{ $purchase->user->email }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Order Details -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Order Status -->
                <div class="bg-white shadow rounded-lg">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h2 class="text-lg font-medium text-gray-900">📋 Order Status</h2>
                    </div>
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-4">
                            <div>
                                <h3 class="text-lg font-medium text-gray-900">Order #{{ $purchase->purchase_reference }}</h3>
                                <p class="text-sm text-gray-500">Placed on {{ $purchase->created_at->format('F j, Y \a\t g:i A') }}</p>
                            </div>
                            <div class="text-right">
                                @if($purchase->status === 'pending')
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-yellow-100 text-yellow-800">
                                        🕐 Payment Verification Pending
                                    </span>
                                @elseif($purchase->status === 'confirmed')
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                                        ✅ Payment Confirmed
                                    </span>
                                @elseif($purchase->status === 'completed')
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                                        🚗 Vehicle Delivered
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-red-100 text-red-800">
                                        ❌ {{ ucfirst($purchase->status) }}
                                    </span>
                                @endif
                            </div>
                        </div>

                        <!-- Progress Steps -->
                        <div class="mt-6">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center">
                                    <div class="flex items-center justify-center w-8 h-8 bg-green-600 text-white rounded-full">
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                    <span class="ml-2 text-sm font-medium text-green-600">Order Placed</span>
                                </div>
                                
                                <div class="flex items-center">
                                    @if(in_array($purchase->status, ['pending']))
                                        <div class="flex items-center justify-center w-8 h-8 bg-yellow-500 text-white rounded-full animate-pulse">
                                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd" />
                                            </svg>
                                        </div>
                                        <span class="ml-2 text-sm font-medium text-yellow-600">Payment Verification</span>
                                    @else
                                        <div class="flex items-center justify-center w-8 h-8 bg-green-600 text-white rounded-full">
                                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                            </svg>
                                        </div>
                                        <span class="ml-2 text-sm font-medium text-green-600">Payment Verified</span>
                                    @endif
                                </div>
                                
                                <div class="flex items-center">
                                    @if(in_array($purchase->status, ['pending', 'confirmed']))
                                        <div class="flex items-center justify-center w-8 h-8 bg-gray-300 text-gray-600 rounded-full">
                                            <span class="text-xs font-bold">3</span>
                                        </div>
                                        <span class="ml-2 text-sm text-gray-500">Vehicle Preparation</span>
                                    @else
                                        <div class="flex items-center justify-center w-8 h-8 bg-green-600 text-white rounded-full">
                                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                            </svg>
                                        </div>
                                        <span class="ml-2 text-sm font-medium text-green-600">Vehicle Ready</span>
                                    @endif
                                </div>
                                
                                <div class="flex items-center">
                                    @if($purchase->status === 'completed')
                                        <div class="flex items-center justify-center w-8 h-8 bg-green-600 text-white rounded-full">
                                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                            </svg>
                                        </div>
                                        <span class="ml-2 text-sm font-medium text-green-600">Delivered</span>
                                    @else
                                        <div class="flex items-center justify-center w-8 h-8 bg-gray-300 text-gray-600 rounded-full">
                                            <span class="text-xs font-bold">4</span>
                                        </div>
                                        <span class="ml-2 text-sm text-gray-500">Delivery</span>
                                    @endif
                                </div>
                            </div>
                            
                            <!-- Progress Line -->
                            <div class="mt-4 w-full bg-gray-200 rounded-full h-2">
                                @if($purchase->status === 'pending')
                                    <div class="bg-yellow-500 h-2 rounded-full" style="width: 50%"></div>
                                @elseif($purchase->status === 'confirmed')
                                    <div class="bg-green-600 h-2 rounded-full" style="width: 75%"></div>
                                @elseif($purchase->status === 'completed')
                                    <div class="bg-green-600 h-2 rounded-full" style="width: 100%"></div>
                                @else
                                    <div class="bg-red-500 h-2 rounded-full" style="width: 25%"></div>
                                @endif
                            </div>
                        </div>

                        <!-- Current Status Message -->
                        <div class="mt-6 p-4 rounded-lg {{ $purchase->status === 'pending' ? 'bg-yellow-50 border border-yellow-200' : 'bg-green-50 border border-green-200' }}">
                            @if($purchase->status === 'pending')
                                <h4 class="text-sm font-medium text-yellow-800">⏳ What's happening now?</h4>
                                <p class="mt-1 text-sm text-yellow-700">
                                    Our finance team is verifying your payment with the bank. This typically takes 2-4 hours during business hours. 
                                    You'll receive an email confirmation once your payment is verified.
                                </p>
                            @elseif($purchase->status === 'confirmed')
                                <h4 class="text-sm font-medium text-green-800">🔧 Vehicle Preparation</h4>
                                <p class="mt-1 text-sm text-green-700">
                                    Your payment has been confirmed! Our team is now preparing your vehicle and will contact you within 24 hours to schedule delivery or pickup.
                                </p>
                            @elseif($purchase->status === 'completed')
                                <h4 class="text-sm font-medium text-green-800">🎉 Purchase Complete!</h4>
                                <p class="mt-1 text-sm text-green-700">
                                    Congratulations! Your vehicle has been successfully delivered. We hope you enjoy your new car!
                                </p>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Vehicle Details -->
                <div class="bg-white shadow rounded-lg">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h2 class="text-lg font-medium text-gray-900">🚗 Vehicle Details</h2>
                    </div>
                    <div class="p-6">
                        <div class="flex items-center space-x-4 mb-4">
                            @if($purchase->vehicle->primary_image)
                                <img class="h-20 w-20 rounded-lg object-cover" src="{{ asset('storage/' . $purchase->vehicle->primary_image) }}" alt="{{ $purchase->vehicle->full_name }}">
                            @else
                                <div class="h-20 w-20 rounded-lg bg-gray-200 flex items-center justify-center">
                                    <svg class="h-8 w-8 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                            @endif
                            <div>
                                <h3 class="text-lg font-medium text-gray-900">{{ $purchase->vehicle->full_name }}</h3>
                                <p class="text-sm text-gray-500">{{ $purchase->vehicle->year }} • {{ $purchase->vehicle->fuel_type }} • {{ number_format($purchase->vehicle->mileage) }} km</p>
                                <p class="text-sm text-gray-500">License Plate: {{ $purchase->vehicle->license_plate }}</p>
                            </div>
                        </div>
                        
                        <a href="{{ route('vehicles.show', $purchase->vehicle) }}" class="text-blue-600 hover:text-blue-500 text-sm font-medium">
                            View Full Vehicle Details →
                        </a>
                    </div>
                </div>

                <!-- Payment Information -->
                @if($purchase->payment)
                <div class="bg-white shadow rounded-lg">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h2 class="text-lg font-medium text-gray-900">💳 Payment Information</h2>
                    </div>
                    <div class="p-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <span class="text-sm text-gray-600">Payment Method:</span>
                                <span class="text-sm font-medium text-gray-900 ml-2">
                                    @if($purchase->payment->payment_method === 'mobile_banking')
                                        📱 Mobile Banking
                                    @else
                                        🏦 Bank Transfer
                                    @endif
                                </span>
                            </div>
                            <div>
                                <span class="text-sm text-gray-600">Bank:</span>
                                <span class="text-sm font-medium text-gray-900 ml-2">{{ $purchase->payment->bank_name }}</span>
                            </div>
                            <div>
                                <span class="text-sm text-gray-600">Transaction Reference:</span>
                                <span class="text-sm font-medium text-gray-900 ml-2 font-mono">{{ $purchase->payment->transaction_reference }}</span>
                            </div>
                            <div>
                                <span class="text-sm text-gray-600">Status:</span>
                                <span class="text-sm font-medium ml-2 {{ $purchase->payment->status === 'verified' ? 'text-green-600' : 'text-yellow-600' }}">
                                    {{ ucfirst($purchase->payment->status) }}
                                </span>
                            </div>
                        </div>
                        
                        @if($purchase->payment->verified_at)
                        <div class="mt-4 p-3 bg-green-50 border border-green-200 rounded-md">
                            <p class="text-sm text-green-700">
                                ✅ Payment verified on {{ $purchase->payment->verified_at->format('F j, Y \a\t g:i A') }}
                            </p>
                        </div>
                        @endif
                    </div>
                </div>
                @endif

                <!-- Next Steps -->
                <div class="bg-white shadow rounded-lg">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h2 class="text-lg font-medium text-gray-900">📋 Next Steps</h2>
                    </div>
                    <div class="p-6">
                        @if($purchase->status === 'pending')
                            <div class="space-y-3">
                                <div class="flex items-start">
                                    <div class="flex-shrink-0">
                                        <span class="flex items-center justify-center w-6 h-6 bg-yellow-500 text-white rounded-full text-xs font-bold">1</span>
                                    </div>
                                    <div class="ml-3">
                                        <p class="text-sm text-gray-700">
                                            <strong>Wait for payment verification</strong> - Our team is currently verifying your payment with the bank
                                        </p>
                                    </div>
                                </div>
                                <div class="flex items-start">
                                    <div class="flex-shrink-0">
                                        <span class="flex items-center justify-center w-6 h-6 bg-gray-300 text-gray-600 rounded-full text-xs font-bold">2</span>
                                    </div>
                                    <div class="ml-3">
                                        <p class="text-sm text-gray-500">
                                            <strong>Receive confirmation email</strong> - You'll get an email once payment is verified
                                        </p>
                                    </div>
                                </div>
                                <div class="flex items-start">
                                    <div class="flex-shrink-0">
                                        <span class="flex items-center justify-center w-6 h-6 bg-gray-300 text-gray-600 rounded-full text-xs font-bold">3</span>
                                    </div>
                                    <div class="ml-3">
                                        <p class="text-sm text-gray-500">
                                            <strong>Schedule delivery/pickup</strong> - Our team will contact you to arrange delivery
                                        </p>
                                    </div>
                                </div>
                            </div>
                        @elseif($purchase->status === 'confirmed')
                            <div class="space-y-3">
                                <div class="flex items-start">
                                    <div class="flex-shrink-0">
                                        <span class="flex items-center justify-center w-6 h-6 bg-blue-500 text-white rounded-full text-xs font-bold">1</span>
                                    </div>
                                    <div class="ml-3">
                                        <p class="text-sm text-gray-700">
                                            <strong>Expect our call</strong> - We'll contact you within 24 hours to schedule delivery or pickup
                                        </p>
                                    </div>
                                </div>
                                <div class="flex items-start">
                                    <div class="flex-shrink-0">
                                        <span class="flex items-center justify-center w-6 h-6 bg-gray-300 text-gray-600 rounded-full text-xs font-bold">2</span>
                                    </div>
                                    <div class="ml-3">
                                        <p class="text-sm text-gray-500">
                                            <strong>Prepare required documents</strong> - Have your ID and any other requested documents ready
                                        </p>
                                    </div>
                                </div>
                                <div class="flex items-start">
                                    <div class="flex-shrink-0">
                                        <span class="flex items-center justify-center w-6 h-6 bg-gray-300 text-gray-600 rounded-full text-xs font-bold">3</span>
                                    </div>
                                    <div class="ml-3">
                                        <p class="text-sm text-gray-500">
                                            <strong>Vehicle handover</strong> - Complete the final inspection and receive your vehicle
                                        </p>
                                    </div>
                                </div>
                            </div>
                        @else
                            <div class="text-center py-4">
                                <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-green-100 mb-4">
                                    <svg class="h-6 w-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                    </svg>
                                </div>
                                <h3 class="text-lg font-medium text-gray-900">🎉 Purchase Complete!</h3>
                                <p class="mt-2 text-sm text-gray-500">
                                    Thank you for your purchase. Enjoy your new vehicle!
                                </p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Order Summary Sidebar -->
            <div class="lg:col-span-1">
                <div class="bg-white shadow rounded-lg p-6 sticky top-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Order Summary</h3>
                    
                    <!-- Price Breakdown -->
                    <div class="space-y-3 mb-6">
                        <div class="flex justify-between">
                            <span class="text-sm text-gray-600">Vehicle Price</span>
                            <span class="text-sm font-medium text-gray-900">${{ number_format($purchase->purchase_price, 2) }}</span>
                        </div>
                        @php
                            $deliveryCost = $purchase->total_amount - $purchase->purchase_price - $purchase->tax_amount;
                        @endphp
                        <div class="flex justify-between">
                            <span class="text-sm text-gray-600">Delivery</span>
                            <span class="text-sm font-medium text-gray-900">
                                @if($deliveryCost <= 0)
                                    FREE
                                @else
                                    ${{ number_format($deliveryCost, 2) }}
                                @endif
                            </span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-sm text-gray-600">Tax (15%)</span>
                            <span class="text-sm font-medium text-gray-900">${{ number_format($purchase->tax_amount, 2) }}</span>
                        </div>
                        <div class="border-t border-gray-200 pt-3">
                            <div class="flex justify-between">
                                <span class="text-lg font-bold text-gray-900">Total Paid</span>
                                <span class="text-xl font-bold text-green-600">${{ number_format($purchase->total_amount, 2) }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Contact Support -->
                    <div class="bg-blue-50 border border-blue-200 rounded-md p-3 mb-4">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-blue-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z" />
                                </svg>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-sm font-medium text-blue-800">Need Help?</h3>
                                <div class="mt-2 text-sm text-blue-700">
                                    <p>📞 +251-911-000-000</p>
                                    <p>✉️ support@carrental.com</p>
                                    <p class="mt-1">Reference: {{ $purchase->purchase_reference }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="space-y-3">
                        <a href="{{ route('dashboard.purchases') }}" class="w-full bg-blue-600 border border-transparent rounded-md py-2 px-4 text-sm font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 text-center block">
                            View All Purchases
                        </a>
                        <a href="{{ route('vehicles.sales') }}" class="w-full bg-gray-100 border border-gray-300 rounded-md py-2 px-4 text-sm font-medium text-gray-700 hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 text-center block">
                            Browse More Vehicles
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Auto-refresh page every 30 seconds if payment is still pending
@if($purchase->status === 'pending')
setTimeout(function() {
    location.reload();
}, 30000);
@endif

// Show notification if payment was just submitted
@if(session('success'))
// Create a toast notification
const toast = document.createElement('div');
toast.className = 'fixed top-4 right-4 bg-green-500 text-white px-6 py-3 rounded-md shadow-lg z-50 max-w-sm';
toast.innerHTML = `
    <div class="flex items-center">
        <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
        </svg>
        <span>{{ session('success') }}</span>
    </div>
`;
document.body.appendChild(toast);

// Remove toast after 5 seconds
setTimeout(() => {
    toast.remove();
}, 5000);
@endif
</script>
@endsection