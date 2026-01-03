@extends('layouts.app')

@section('title', 'Purchase Checkout - Payment Submission')

@section('content')
<div class="bg-gray-50 min-h-screen">
    <div class="max-w-4xl mx-auto py-6 sm:px-6 lg:px-8">
        <!-- Progress Bar -->
        <div class="mb-8">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-4">
                    <div class="flex items-center text-sm text-green-600">
                        <span class="flex items-center justify-center w-8 h-8 bg-green-600 text-white rounded-full">✓</span>
                        <span class="ml-2">Complete</span>
                    </div>
                </div>
            </div>
            <div class="mt-4 w-full bg-gray-200 rounded-full h-2">
                <div class="bg-green-600 h-2 rounded-full" style="width: 100%"></div>
            </div>
        </div>

        <!-- Page Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">Submit Payment Proof</h1>
            <p class="mt-2 text-sm text-gray-600">Provide your transaction details to complete the purchase</p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Payment Submission Form -->
            <div class="lg:col-span-2">
                <form method="POST" action="{{ route('checkout.complete') }}">
                    @csrf
                    <div class="bg-white shadow rounded-lg">
                        <div class="px-6 py-4 border-b border-gray-200">
                            <h2 class="text-lg font-medium text-gray-900">💳 Payment Confirmation</h2>
                            <p class="mt-1 text-sm text-gray-600">Please provide your payment transaction details</p>
                        </div>

                        <div class="p-6 space-y-6">
                            <!-- Payment Status Check -->
                            <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                                <div class="flex items-start">
                                    <div class="flex-shrink-0">
                                        <svg class="h-5 w-5 text-blue-400" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                    <div class="ml-3">
                                        <h3 class="text-sm font-medium text-blue-800">✅ Payment Instructions Completed</h3>
                                        <div class="mt-2 text-sm text-blue-700">
                                            <p>If you have successfully made the payment as instructed, please provide the transaction details below to complete your purchase.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Transaction Reference -->
                            <div>
                                <label for="transaction_reference" class="block text-sm font-medium text-gray-700">
                                    Transaction Reference Number <span class="text-red-500">*</span>
                                </label>
                                <input type="text" 
                                       id="transaction_reference" 
                                       name="transaction_reference" 
                                       value="{{ old('transaction_reference') }}"
                                       placeholder="Enter the transaction reference from your payment confirmation"
                                       required
                                       class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                                @error('transaction_reference')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                                <p class="mt-2 text-sm text-gray-500">
                                    This is the reference number you received after completing your bank transfer or mobile payment.
                                </p>
                            </div>

                            <!-- Transaction Proof -->
                            <div>
                                <label for="transaction_proof" class="block text-sm font-medium text-gray-700">
                                    Additional Transaction Details
                                    <span class="text-gray-500 text-xs">(Optional but recommended)</span>
                                </label>
                                <textarea id="transaction_proof" 
                                          name="transaction_proof" 
                                          rows="4"
                                          value="{{ old('transaction_proof') }}"
                                          placeholder="Provide any additional details about your payment (e.g., time of transaction, sender name, bank branch, etc.)"
                                          class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm"></textarea>
                                @error('transaction_proof')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                                <p class="mt-2 text-sm text-gray-500">
                                    Additional details help us verify your payment faster. Include information like transaction time, sender name, or any other relevant details.
                                </p>
                            </div>

                            <!-- Payment Method Reminder -->
                            @php
                                $checkout = Session::get('checkout');
                                $paymentMethod = $checkout['payment_method'] ?? 'mobile_banking';
                                $deliveryCost = $checkout['delivery_info']['delivery_cost'] ?? 0;
                                $salePrice = $vehicle->sale_price;
                                $taxAmount = ($salePrice + $deliveryCost) * 0.15;
                                $totalAmount = $salePrice + $deliveryCost + $taxAmount;
                            @endphp

                            <div class="bg-gray-50 border border-gray-200 rounded-lg p-4">
                                <h3 class="text-sm font-medium text-gray-900 mb-3">📋 Payment Summary</h3>
                                <div class="space-y-2 text-sm">
                                    <div class="flex justify-between">
                                        <span class="text-gray-600">Payment Method:</span>
                                        <span class="font-medium text-gray-900">
                                            @if($paymentMethod === 'mobile_banking')
                                                📱 Mobile Banking
                                            @else
                                                🏦 Bank Transfer
                                            @endif
                                        </span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-gray-600">Bank:</span>
                                        <span class="font-medium text-gray-900">
                                            @if($paymentMethod === 'mobile_banking')
                                                Commercial Bank of Ethiopia
                                            @else
                                                Bank of Abyssinia
                                            @endif
                                        </span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-gray-600">Account Number:</span>
                                        <span class="font-medium text-gray-900 font-mono">
                                            @if($paymentMethod === 'mobile_banking')
                                                1000123456789
                                            @else
                                                2000987654321
                                            @endif
                                        </span>
                                    </div>
                                    <div class="flex justify-between border-t border-gray-300 pt-2">
                                        <span class="text-gray-600">Amount Paid:</span>
                                        <span class="font-bold text-green-600">${{ number_format($totalAmount, 2) }}</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Important Notice -->
                            <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                                <div class="flex items-start">
                                    <div class="flex-shrink-0">
                                        <svg class="h-5 w-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                    <div class="ml-3">
                                        <h3 class="text-sm font-medium text-yellow-800">⚠️ Important Notice</h3>
                                        <div class="mt-2 text-sm text-yellow-700">
                                            <ul class="list-disc list-inside space-y-1">
                                                <li>Only submit this form if you have actually completed the payment</li>
                                                <li>False payment claims will result in order cancellation and account suspension</li>
                                                <li>Our team will verify your payment within 2-4 hours during business hours</li>
                                                <li>You will receive email confirmation once payment is verified</li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Verification Process -->
                            <div class="bg-green-50 border border-green-200 rounded-lg p-4">
                                <h3 class="text-sm font-medium text-green-800 mb-3">🔍 What Happens Next?</h3>
                                <div class="space-y-3">
                                    <div class="flex items-start">
                                        <div class="flex-shrink-0">
                                            <span class="flex items-center justify-center w-6 h-6 bg-green-600 text-white rounded-full text-xs font-bold">1</span>
                                        </div>
                                        <div class="ml-3">
                                            <p class="text-sm text-green-700">
                                                <strong>Immediate:</strong> Your order will be marked as "Payment Submitted" and you'll receive a confirmation email
                                            </p>
                                        </div>
                                    </div>
                                    <div class="flex items-start">
                                        <div class="flex-shrink-0">
                                            <span class="flex items-center justify-center w-6 h-6 bg-green-600 text-white rounded-full text-xs font-bold">2</span>
                                        </div>
                                        <div class="ml-3">
                                            <p class="text-sm text-green-700">
                                                <strong>Within 2-4 hours:</strong> Our finance team will verify your payment with the bank
                                            </p>
                                        </div>
                                    </div>
                                    <div class="flex items-start">
                                        <div class="flex-shrink-0">
                                            <span class="flex items-center justify-center w-6 h-6 bg-green-600 text-white rounded-full text-xs font-bold">3</span>
                                        </div>
                                        <div class="ml-3">
                                            <p class="text-sm text-green-700">
                                                <strong>After verification:</strong> Your vehicle will be prepared and delivery/pickup will be scheduled
                                            </p>
                                        </div>
                                    </div>
                                    <div class="flex items-start">
                                        <div class="flex-shrink-0">
                                            <span class="flex items-center justify-center w-6 h-6 bg-green-600 text-white rounded-full text-xs font-bold">4</span>
                                        </div>
                                        <div class="ml-3">
                                            <p class="text-sm text-green-700">
                                                <strong>Final step:</strong> You'll receive your vehicle with all documentation complete
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="mt-6 flex items-center justify-between">
                        <a href="{{ route('checkout.cancel') }}" class="text-gray-500 hover:text-gray-700 text-sm font-medium">
                            ← Cancel Purchase
                        </a>
                        <div class="flex space-x-3">
                            <button type="button" onclick="history.back()" class="bg-gray-100 border border-gray-300 rounded-md py-2 px-4 text-sm font-medium text-gray-700 hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                                ← Back to Payment Instructions
                            </button>
                            <button type="submit" class="bg-green-600 border border-transparent rounded-md py-2 px-6 text-sm font-medium text-white hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                                ✅ Complete Purchase
                            </button>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Order Summary -->
            <div class="lg:col-span-1">
                <div class="bg-white shadow rounded-lg p-6 sticky top-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Final Order Summary</h3>
                    
                    <!-- Vehicle Info -->
                    <div class="flex items-center space-x-3 mb-4 pb-4 border-b border-gray-200">
                        @if($vehicle->primary_image)
                            <img class="h-12 w-12 rounded object-cover" src="{{ asset('storage/' . $vehicle->primary_image) }}" alt="{{ $vehicle->full_name }}">
                        @else
                            <div class="h-12 w-12 rounded bg-gray-200 flex items-center justify-center">
                                <svg class="h-6 w-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        @endif
                        <div>
                            <p class="text-sm font-medium text-gray-900">{{ $vehicle->full_name }}</p>
                            <p class="text-xs text-gray-500">{{ $vehicle->year }} • {{ $vehicle->fuel_type }}</p>
                        </div>
                    </div>

                    <!-- Price Breakdown -->
                    <div class="space-y-3 mb-6">
                        <div class="flex justify-between">
                            <span class="text-sm text-gray-600">Vehicle Price</span>
                            <span class="text-sm font-medium text-gray-900">${{ number_format($salePrice, 2) }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-sm text-gray-600">Delivery</span>
                            <span class="text-sm font-medium text-gray-900">
                                @if($deliveryCost == 0)
                                    FREE
                                @else
                                    ${{ number_format($deliveryCost, 2) }}
                                @endif
                            </span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-sm text-gray-600">Tax (15%)</span>
                            <span class="text-sm font-medium text-gray-900">${{ number_format($taxAmount, 2) }}</span>
                        </div>
                        <div class="border-t border-gray-200 pt-3">
                            <div class="flex justify-between">
                                <span class="text-lg font-bold text-gray-900">TOTAL PAID</span>
                                <span class="text-xl font-bold text-green-600">${{ number_format($totalAmount, 2) }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Support Contact -->
                    <div class="bg-blue-50 border border-blue-200 rounded-md p-3">
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
                                    <p class="mt-1">Available 24/7 for payment support</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.querySelector('form');
    const transactionRefInput = document.getElementById('transaction_reference');
    
    // Form validation
    form.addEventListener('submit', function(e) {
        const transactionRef = transactionRefInput.value.trim();
        
        if (!transactionRef) {
            e.preventDefault();
            transactionRefInput.classList.add('border-red-500');
            transactionRefInput.focus();
            
            if (!transactionRefInput.nextElementSibling || !transactionRefInput.nextElementSibling.classList.contains('text-red-600')) {
                const errorMsg = document.createElement('p');
                errorMsg.className = 'mt-2 text-sm text-red-600';
                errorMsg.textContent = 'Transaction reference is required.';
                transactionRefInput.parentNode.insertBefore(errorMsg, transactionRefInput.nextSibling);
            }
            return;
        }
        
        // Show confirmation dialog
        const confirmed = confirm(
            'Are you sure you want to submit your payment proof?\n\n' +
            'Please confirm that:\n' +
            '• You have actually completed the payment\n' +
            '• The transaction reference is correct\n' +
            '• The amount paid matches the total: $' + '{{ number_format($totalAmount, 2) }}' + '\n\n' +
            'Click OK to complete your purchase.'
        );
        
        if (!confirmed) {
            e.preventDefault();
        }
    });
    
    // Remove error styling when user types
    transactionRefInput.addEventListener('input', function() {
        this.classList.remove('border-red-500');
        const errorMsg = this.nextElementSibling;
        if (errorMsg && errorMsg.classList.contains('text-red-600')) {
            errorMsg.remove();
        }
    });
    
    // Format transaction reference input (remove spaces, convert to uppercase)
    transactionRefInput.addEventListener('input', function(e) {
        let value = e.target.value.replace(/\s/g, '').toUpperCase();
        e.target.value = value;
    });
});
</script>
@endsection