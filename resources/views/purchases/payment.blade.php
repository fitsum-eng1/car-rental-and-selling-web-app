@extends('layouts.app')

@section('title', 'Purchase Payment - ' . $purchase->purchase_reference)

@section('content')
<div class="bg-gray-50 min-h-screen">
    <div class="max-w-4xl mx-auto py-6 sm:px-6 lg:px-8">
        <!-- Page Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">Complete Your Payment</h1>
            <p class="mt-2 text-sm text-gray-600">Purchase Reference: {{ $purchase->purchase_reference }}</p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Payment Instructions -->
            <div class="lg:col-span-2">
                <div class="bg-white shadow rounded-lg">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h2 class="text-lg font-medium text-gray-900">💳 Payment Instructions</h2>
                        <p class="mt-1 text-sm text-gray-600">Follow these instructions to complete your payment</p>
                    </div>

                    <div class="p-6">
                        @if($payment)
                            @if($payment->status === 'pending')
                                <!-- Payment Pending -->
                                <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4 mb-6">
                                    <div class="flex items-start">
                                        <div class="flex-shrink-0">
                                            <svg class="h-5 w-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd" />
                                            </svg>
                                        </div>
                                        <div class="ml-3">
                                            <h3 class="text-sm font-medium text-yellow-800">⏳ Payment Required</h3>
                                            <div class="mt-2 text-sm text-yellow-700">
                                                <p>Your purchase is pending payment. Please complete the payment using the instructions below.</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Bank Details -->
                                <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-6">
                                    <h3 class="text-lg font-medium text-blue-900 mb-3">Bank Account Details</h3>
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                        <div>
                                            <label class="block text-sm font-medium text-blue-700">Bank Name</label>
                                            <div class="mt-1 flex items-center justify-between bg-white border border-blue-300 rounded-md px-3 py-2">
                                                <span class="text-sm font-mono text-gray-900">{{ $payment->bank_name }}</span>
                                                <button onclick="copyToClipboard('{{ $payment->bank_name }}')" class="text-blue-600 hover:text-blue-800">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z" />
                                                    </svg>
                                                </button>
                                            </div>
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium text-blue-700">Account Number</label>
                                            <div class="mt-1 flex items-center justify-between bg-white border border-blue-300 rounded-md px-3 py-2">
                                                <span class="text-sm font-mono text-gray-900">{{ $payment->account_number }}</span>
                                                <button onclick="copyToClipboard('{{ $payment->account_number }}')" class="text-blue-600 hover:text-blue-800">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z" />
                                                    </svg>
                                                </button>
                                            </div>
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium text-blue-700">Account Holder</label>
                                            <div class="mt-1 flex items-center justify-between bg-white border border-blue-300 rounded-md px-3 py-2">
                                                <span class="text-sm font-mono text-gray-900">Car Rental & Sales Ltd</span>
                                                <button onclick="copyToClipboard('Car Rental & Sales Ltd')" class="text-blue-600 hover:text-blue-800">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z" />
                                                    </svg>
                                                </button>
                                            </div>
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium text-blue-700">Amount to Pay</label>
                                            <div class="mt-1 flex items-center justify-between bg-white border border-blue-300 rounded-md px-3 py-2">
                                                <span class="text-sm font-mono text-gray-900 font-bold">${{ number_format($payment->amount, 2) }}</span>
                                                <button onclick="copyToClipboard('{{ number_format($payment->amount, 2) }}')" class="text-blue-600 hover:text-blue-800">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z" />
                                                    </svg>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Payment Instructions -->
                                <div class="bg-gray-50 border border-gray-200 rounded-lg p-4 mb-6">
                                    <h3 class="text-lg font-medium text-gray-900 mb-3">📋 Payment Instructions</h3>
                                    <div class="text-sm text-gray-700">
                                        <p class="mb-2">{{ $payment->payment_instructions }}</p>
                                        <ol class="list-decimal list-inside space-y-1 mt-4">
                                            <li>Use your mobile banking app or visit a bank branch</li>
                                            <li>Transfer the exact amount: <strong>${{ number_format($payment->amount, 2) }}</strong></li>
                                            <li>Use the reference: <strong>{{ $purchase->purchase_reference }}</strong></li>
                                            <li>Keep your transaction receipt</li>
                                            <li>Submit your payment proof using the form below</li>
                                        </ol>
                                    </div>
                                </div>

                                <!-- Payment Submission Form -->
                                <form method="POST" action="{{ route('payments.submit', $payment) }}">
                                    @csrf
                                    <div class="bg-white border border-gray-200 rounded-lg p-4">
                                        <h3 class="text-lg font-medium text-gray-900 mb-3">📤 Submit Payment Proof</h3>
                                        
                                        <div class="space-y-4">
                                            <div>
                                                <label for="transaction_reference" class="block text-sm font-medium text-gray-700">
                                                    Transaction Reference <span class="text-red-500">*</span>
                                                </label>
                                                <input type="text" 
                                                       id="transaction_reference" 
                                                       name="transaction_reference" 
                                                       required
                                                       placeholder="Enter your transaction reference number"
                                                       class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                                            </div>
                                            
                                            <div>
                                                <label for="transaction_proof" class="block text-sm font-medium text-gray-700">
                                                    Additional Details (Optional)
                                                </label>
                                                <textarea id="transaction_proof" 
                                                          name="transaction_proof" 
                                                          rows="3"
                                                          placeholder="Any additional information about your payment"
                                                          class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm"></textarea>
                                            </div>
                                            
                                            <button type="submit" class="w-full bg-green-600 border border-transparent rounded-md py-2 px-4 text-sm font-medium text-white hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                                                Submit Payment Proof
                                            </button>
                                        </div>
                                    </div>
                                </form>

                            @elseif($payment->status === 'submitted')
                                <!-- Payment Submitted -->
                                <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-6">
                                    <div class="flex items-start">
                                        <div class="flex-shrink-0">
                                            <svg class="h-5 w-5 text-blue-400" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                            </svg>
                                        </div>
                                        <div class="ml-3">
                                            <h3 class="text-sm font-medium text-blue-800">📤 Payment Submitted</h3>
                                            <div class="mt-2 text-sm text-blue-700">
                                                <p>Your payment proof has been submitted and is being verified. You'll receive an email confirmation once verified.</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="text-center py-8">
                                    <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-blue-100 mb-4">
                                        <svg class="h-6 w-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                    </div>
                                    <h3 class="text-lg font-medium text-gray-900">Verification in Progress</h3>
                                    <p class="mt-2 text-sm text-gray-500">
                                        Our team is verifying your payment. This typically takes 2-4 hours during business hours.
                                    </p>
                                </div>

                            @elseif($payment->status === 'verified')
                                <!-- Payment Verified -->
                                <div class="bg-green-50 border border-green-200 rounded-lg p-4 mb-6">
                                    <div class="flex items-start">
                                        <div class="flex-shrink-0">
                                            <svg class="h-5 w-5 text-green-400" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                            </svg>
                                        </div>
                                        <div class="ml-3">
                                            <h3 class="text-sm font-medium text-green-800">✅ Payment Verified</h3>
                                            <div class="mt-2 text-sm text-green-700">
                                                <p>Your payment has been successfully verified! Your vehicle is being prepared for delivery.</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="text-center py-8">
                                    <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-green-100 mb-4">
                                        <svg class="h-6 w-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                        </svg>
                                    </div>
                                    <h3 class="text-lg font-medium text-gray-900">Payment Complete!</h3>
                                    <p class="mt-2 text-sm text-gray-500">
                                        Your payment was verified on {{ $payment->verified_at->format('F j, Y \a\t g:i A') }}
                                    </p>
                                </div>

                            @else
                                <!-- Payment Rejected or Other Status -->
                                <div class="bg-red-50 border border-red-200 rounded-lg p-4 mb-6">
                                    <div class="flex items-start">
                                        <div class="flex-shrink-0">
                                            <svg class="h-5 w-5 text-red-400" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                                            </svg>
                                        </div>
                                        <div class="ml-3">
                                            <h3 class="text-sm font-medium text-red-800">❌ Payment Issue</h3>
                                            <div class="mt-2 text-sm text-red-700">
                                                <p>There was an issue with your payment. Please contact support for assistance.</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @else
                            <!-- No Payment Record -->
                            <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                                <div class="flex items-start">
                                    <div class="flex-shrink-0">
                                        <svg class="h-5 w-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                    <div class="ml-3">
                                        <h3 class="text-sm font-medium text-yellow-800">⚠️ Payment Not Initialized</h3>
                                        <div class="mt-2 text-sm text-yellow-700">
                                            <p>Payment has not been set up for this purchase. Please contact support.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Purchase Summary -->
            <div class="lg:col-span-1">
                <div class="bg-white shadow rounded-lg p-6 sticky top-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Purchase Summary</h3>
                    
                    <!-- Vehicle Info -->
                    <div class="flex items-center space-x-3 mb-4 pb-4 border-b border-gray-200">
                        @if($purchase->vehicle->primary_image)
                            <img class="h-12 w-12 rounded object-cover" src="{{ asset('storage/' . $purchase->vehicle->primary_image) }}" alt="{{ $purchase->vehicle->full_name }}">
                        @else
                            <div class="h-12 w-12 rounded bg-gray-200 flex items-center justify-center">
                                <svg class="h-6 w-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        @endif
                        <div>
                            <p class="text-sm font-medium text-gray-900">{{ $purchase->vehicle->full_name }}</p>
                            <p class="text-xs text-gray-500">{{ $purchase->vehicle->year }} • {{ $purchase->vehicle->fuel_type }}</p>
                        </div>
                    </div>

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
                                <span class="text-base font-medium text-gray-900">Total Amount</span>
                                <span class="text-base font-medium text-gray-900">${{ number_format($purchase->total_amount, 2) }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Status -->
                    <div class="mb-4">
                        <span class="text-sm text-gray-600">Status:</span>
                        <span class="ml-2 inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                            @if($purchase->status === 'pending') bg-yellow-100 text-yellow-800
                            @elseif($purchase->status === 'confirmed') bg-green-100 text-green-800
                            @elseif($purchase->status === 'completed') bg-blue-100 text-blue-800
                            @else bg-red-100 text-red-800 @endif">
                            {{ ucfirst($purchase->status) }}
                        </span>
                    </div>

                    <!-- Actions -->
                    <div class="space-y-3">
                        <a href="{{ route('purchases.show', $purchase) }}" class="w-full bg-blue-600 border border-transparent rounded-md py-2 px-4 text-sm font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 text-center block">
                            View Purchase Details
                        </a>
                        
                        @if($payment)
                            <a href="{{ route('payments.status', $payment) }}" class="w-full bg-gray-100 border border-gray-300 rounded-md py-2 px-4 text-sm font-medium text-gray-700 hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 text-center block">
                                Check Payment Status
                            </a>
                        @endif
                    </div>

                    <!-- Support -->
                    <div class="mt-6 pt-6 border-t border-gray-200">
                        <h4 class="text-sm font-medium text-gray-900 mb-2">Need Help?</h4>
                        <div class="text-sm text-gray-600">
                            <p>📞 +251-911-000-000</p>
                            <p>✉️ support@carrental.com</p>
                            <p class="mt-1">Reference: {{ $purchase->purchase_reference }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Copy to clipboard function
function copyToClipboard(text) {
    navigator.clipboard.writeText(text).then(function() {
        // Show success message
        const toast = document.createElement('div');
        toast.className = 'fixed top-4 right-4 bg-green-500 text-white px-4 py-2 rounded-md shadow-lg z-50';
        toast.textContent = 'Copied to clipboard!';
        document.body.appendChild(toast);
        
        setTimeout(() => {
            toast.remove();
        }, 2000);
    });
}

// Auto-refresh if payment is submitted but not verified
@if($payment && $payment->status === 'submitted')
setTimeout(function() {
    location.reload();
}, 60000); // Refresh every minute
@endif
</script>
@endsection