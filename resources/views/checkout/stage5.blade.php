@extends('layouts.app')

@section('title', 'Purchase Checkout - Payment Instructions')

@section('content')
<div class="bg-gradient-to-br from-gray-50 to-blue-50 min-h-screen">
    <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
        <!-- Enhanced Progress Bar -->
        <div class="mb-10">
            <div class="flex items-center justify-center">
                <div class="flex items-center space-x-4 md:space-x-8">
                    <div class="flex items-center text-sm text-green-600">
                        <span class="flex items-center justify-center w-12 h-12 bg-green-600 text-white rounded-full font-bold shadow-lg">✓</span>
                        <span class="ml-3 font-semibold hidden md:block">Vehicle</span>
                    </div>
                    <div class="w-8 md:w-12 h-1 bg-green-600 rounded"></div>
                    <div class="flex items-center text-sm text-green-600">
                        <span class="flex items-center justify-center w-12 h-12 bg-green-600 text-white rounded-full font-bold shadow-lg">✓</span>
                        <span class="ml-3 font-semibold hidden md:block">Buyer Info</span>
                    </div>
                    <div class="w-8 md:w-12 h-1 bg-green-600 rounded"></div>
                    <div class="flex items-center text-sm text-green-600">
                        <span class="flex items-center justify-center w-12 h-12 bg-green-600 text-white rounded-full font-bold shadow-lg">✓</span>
                        <span class="ml-3 font-semibold hidden md:block">Delivery</span>
                    </div>
                    <div class="w-8 md:w-12 h-1 bg-green-600 rounded"></div>
                    <div class="flex items-center text-sm text-green-600">
                        <span class="flex items-center justify-center w-12 h-12 bg-green-600 text-white rounded-full font-bold shadow-lg">✓</span>
                        <span class="ml-3 font-semibold hidden md:block">Payment Method</span>
                    </div>
                    <div class="w-8 md:w-12 h-1 bg-gradient-to-r from-green-600 to-blue-600 rounded"></div>
                    <div class="flex items-center text-sm text-blue-600">
                        <span class="flex items-center justify-center w-12 h-12 bg-gradient-to-br from-blue-600 to-blue-700 text-white rounded-full font-bold shadow-lg animate-pulse">5</span>
                        <span class="ml-3 font-bold hidden md:block">Payment</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Enhanced Page Header -->
        <div class="text-center mb-10">
            <div class="inline-flex items-center justify-center w-20 h-20 bg-gradient-to-br from-green-600 to-green-700 rounded-full mb-4 shadow-xl">
                <svg class="w-10 h-10 text-white" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M4 4a2 2 0 00-2 2v1h16V6a2 2 0 00-2-2H4z"/>
                    <path fill-rule="evenodd" d="M18 9H2v5a2 2 0 002 2h12a2 2 0 002-2V9zM4 13a1 1 0 011-1h1a1 1 0 110 2H5a1 1 0 01-1-1zm5-1a1 1 0 100 2h1a1 1 0 100-2H9z" clip-rule="evenodd"/>
                </svg>
            </div>
            <h1 class="text-4xl md:text-5xl font-bold text-gray-900 mb-3">Complete Your Payment</h1>
            <p class="text-xl text-gray-600 max-w-2xl mx-auto">Follow the instructions below to securely complete your vehicle purchase</p>
        </div>

        @php
            $checkout = Session::get('checkout');
            $paymentMethod = $checkout['payment_method'] ?? 'cbe_mobile';
            $deliveryCost = $checkout['delivery_info']['delivery_cost'] ?? 0;
            $salePrice = $vehicle->sale_price;
            $taxAmount = ($salePrice + $deliveryCost) * 0.15;
            $totalAmount = $salePrice + $deliveryCost + $taxAmount;
            $paymentReference = 'PAY-' . strtoupper(substr(md5(uniqid()), 0, 8));
            
            // Get bank details based on selected payment method
            $bankDetails = [
                'cbe_mobile' => [
                    'bank_name' => 'Commercial Bank of Ethiopia',
                    'account_number' => '1000123456789',
                    'account_holder' => 'Car Rental & Sales Ltd',
                    'type' => 'mobile',
                    'instructions' => 'Use CBE Birr, HelloCash, or M-Birr mobile app to send money to the account above.'
                ],
                'abyssinia_mobile' => [
                    'bank_name' => 'Bank of Abyssinia',
                    'account_number' => '2000987654321',
                    'account_holder' => 'Car Rental & Sales Ltd',
                    'type' => 'mobile',
                    'instructions' => 'Use Abyssinia Mobile Banking app to transfer money to the account above.'
                ],
                'telebirr' => [
                    'bank_name' => 'Telebirr',
                    'account_number' => '0911000000',
                    'account_holder' => 'Car Rental & Sales Ltd',
                    'type' => 'mobile',
                    'instructions' => 'Use Telebirr app to send money to the phone number above.'
                ],
                'dashen_mobile' => [
                    'bank_name' => 'Dashen Bank',
                    'account_number' => '3000456789123',
                    'account_holder' => 'Car Rental & Sales Ltd',
                    'type' => 'mobile',
                    'instructions' => 'Use Dashen Mobile Banking app to transfer money to the account above.'
                ],
                'cbe_transfer' => [
                    'bank_name' => 'Commercial Bank of Ethiopia',
                    'account_number' => '1000123456789',
                    'account_holder' => 'Car Rental & Sales Ltd',
                    'type' => 'transfer',
                    'instructions' => 'Visit any CBE branch or use online banking to transfer money to the account above.'
                ],
                'abyssinia_transfer' => [
                    'bank_name' => 'Bank of Abyssinia',
                    'account_number' => '2000987654321',
                    'account_holder' => 'Car Rental & Sales Ltd',
                    'type' => 'transfer',
                    'instructions' => 'Visit any Abyssinia Bank branch or use online banking to transfer money to the account above.'
                ],
                'dashen_transfer' => [
                    'bank_name' => 'Dashen Bank',
                    'account_number' => '3000456789123',
                    'account_holder' => 'Car Rental & Sales Ltd',
                    'type' => 'transfer',
                    'instructions' => 'Visit any Dashen Bank branch or use online banking to transfer money to the account above.'
                ]
            ];
            
            $selectedBank = $bankDetails[$paymentMethod] ?? $bankDetails['cbe_mobile'];
        @endphp

        <div class="grid grid-cols-1 xl:grid-cols-3 gap-8">
            <!-- Payment Instructions -->
            <div class="xl:col-span-2">
                <div class="bg-white shadow-2xl rounded-2xl overflow-hidden border border-gray-100">
                    <div class="px-8 py-6 bg-gradient-to-r from-green-600 via-green-700 to-emerald-700">
                        <div class="flex items-center justify-between">
                            <div>
                                <h2 class="text-2xl font-bold text-white flex items-center">
                                    @if($selectedBank['type'] === 'mobile')
                                        <svg class="w-8 h-8 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z"/>
                                        </svg>
                                        📱 Mobile Banking Payment
                                    @else
                                        <svg class="w-8 h-8 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M4 4a2 2 0 00-2 2v8a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2H4zm0 2h12v8H4V6z"/>
                                            <path d="M6 8h8v2H6V8zm0 4h8v2H6v-2z"/>
                                        </svg>
                                        🏦 Bank Transfer Payment
                                    @endif
                                </h2>
                                <p class="mt-2 text-green-100">Complete your payment using {{ $selectedBank['bank_name'] }}</p>
                            </div>
                            <div class="hidden md:flex items-center space-x-2">
                                <span class="bg-white bg-opacity-20 text-white px-3 py-1 rounded-full text-sm font-medium">🔒 Secure</span>
                                <span class="bg-white bg-opacity-20 text-white px-3 py-1 rounded-full text-sm font-medium">✅ Verified</span>
                            </div>
                        </div>
                    </div>

                    <div class="p-8">
                        <!-- Step-by-Step Instructions -->
                        <div class="mb-8">
                            <h3 class="text-2xl font-bold text-gray-900 mb-6 flex items-center">
                                <span class="bg-gradient-to-br from-blue-500 to-blue-600 text-white rounded-xl p-3 mr-4 shadow-lg">
                                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M12.316 3.051a1 1 0 01.633 1.265l-4 12a1 1 0 11-1.898-.632l4-12a1 1 0 011.265-.633zM5.707 6.293a1 1 0 010 1.414L3.414 10l2.293 2.293a1 1 0 11-1.414 1.414l-3-3a1 1 0 010-1.414l3-3a1 1 0 011.414 0zm8.586 0a1 1 0 011.414 0l3 3a1 1 0 010 1.414l-3 3a1 1 0 11-1.414-1.414L16.586 10l-2.293-2.293a1 1 0 010-1.414z" clip-rule="evenodd"/>
                                    </svg>
                                </span>
                                Payment Instructions
                            </h3>
                            
                            <div class="bg-gradient-to-r from-blue-50 to-indigo-50 rounded-2xl p-6 border border-blue-200 mb-6">
                                <p class="text-blue-800 text-lg leading-relaxed">
                                    {{ $selectedBank['instructions'] }}
                                </p>
                            </div>

                            <!-- Step by step process -->
                            <div class="space-y-4">
                                @if($selectedBank['type'] === 'mobile')
                                    <div class="flex items-start space-x-4 p-4 bg-gray-50 rounded-xl">
                                        <div class="flex-shrink-0 w-8 h-8 bg-blue-600 text-white rounded-full flex items-center justify-center font-bold">1</div>
                                        <div>
                                            <h4 class="font-bold text-gray-900">Open Your Mobile Banking App</h4>
                                            <p class="text-gray-600">Launch the {{ $selectedBank['bank_name'] }} mobile app on your phone</p>
                                        </div>
                                    </div>
                                    
                                    <div class="flex items-start space-x-4 p-4 bg-gray-50 rounded-xl">
                                        <div class="flex-shrink-0 w-8 h-8 bg-blue-600 text-white rounded-full flex items-center justify-center font-bold">2</div>
                                        <div>
                                            <h4 class="font-bold text-gray-900">Select Send Money / Transfer</h4>
                                            <p class="text-gray-600">Choose the option to send money or make a transfer</p>
                                        </div>
                                    </div>
                                    
                                    <div class="flex items-start space-x-4 p-4 bg-gray-50 rounded-xl">
                                        <div class="flex-shrink-0 w-8 h-8 bg-blue-600 text-white rounded-full flex items-center justify-center font-bold">3</div>
                                        <div>
                                            <h4 class="font-bold text-gray-900">Enter Payment Details</h4>
                                            <p class="text-gray-600">Use the account details provided below</p>
                                        </div>
                                    </div>
                                    
                                    <div class="flex items-start space-x-4 p-4 bg-gray-50 rounded-xl">
                                        <div class="flex-shrink-0 w-8 h-8 bg-blue-600 text-white rounded-full flex items-center justify-center font-bold">4</div>
                                        <div>
                                            <h4 class="font-bold text-gray-900">Add Payment Reference</h4>
                                            <p class="text-gray-600">Include the payment reference in the description/memo field</p>
                                        </div>
                                    </div>
                                @else
                                    <div class="flex items-start space-x-4 p-4 bg-gray-50 rounded-xl">
                                        <div class="flex-shrink-0 w-8 h-8 bg-blue-600 text-white rounded-full flex items-center justify-center font-bold">1</div>
                                        <div>
                                            <h4 class="font-bold text-gray-900">Visit Bank Branch or Use Online Banking</h4>
                                            <p class="text-gray-600">Go to any {{ $selectedBank['bank_name'] }} branch or log into online banking</p>
                                        </div>
                                    </div>
                                    
                                    <div class="flex items-start space-x-4 p-4 bg-gray-50 rounded-xl">
                                        <div class="flex-shrink-0 w-8 h-8 bg-blue-600 text-white rounded-full flex items-center justify-center font-bold">2</div>
                                        <div>
                                            <h4 class="font-bold text-gray-900">Fill Transfer Form</h4>
                                            <p class="text-gray-600">Complete the bank transfer form with the details below</p>
                                        </div>
                                    </div>
                                    
                                    <div class="flex items-start space-x-4 p-4 bg-gray-50 rounded-xl">
                                        <div class="flex-shrink-0 w-8 h-8 bg-blue-600 text-white rounded-full flex items-center justify-center font-bold">3</div>
                                        <div>
                                            <h4 class="font-bold text-gray-900">Include Payment Reference</h4>
                                            <p class="text-gray-600">Make sure to include the payment reference in the transfer description</p>
                                        </div>
                                    </div>
                                @endif
                                
                                <div class="flex items-start space-x-4 p-4 bg-green-50 rounded-xl border border-green-200">
                                    <div class="flex-shrink-0 w-8 h-8 bg-green-600 text-white rounded-full flex items-center justify-center font-bold">✓</div>
                                    <div>
                                        <h4 class="font-bold text-green-900">Confirm Payment</h4>
                                        <p class="text-green-700">After completing the transfer, return here to submit your transaction reference</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Bank Details -->
                        <div class="bg-gradient-to-r from-blue-50 to-indigo-50 border-2 border-blue-200 rounded-2xl p-8 mb-8">
                            <h3 class="text-2xl font-bold text-blue-900 mb-6 flex items-center">
                                <svg class="w-8 h-8 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M4 4a2 2 0 00-2 2v8a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2H4zm0 2h12v8H4V6z"/>
                                    <path d="M6 8h8v2H6V8zm0 4h8v2H6v-2z"/>
                                </svg>
                                Payment Details
                            </h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div class="space-y-4">
                                    <div>
                                        <label class="block text-sm font-bold text-blue-700 mb-2">Bank Name</label>
                                        <div class="flex items-center justify-between bg-white border-2 border-blue-300 rounded-xl px-4 py-3 shadow-sm">
                                            <span class="text-lg font-mono text-gray-900">{{ $selectedBank['bank_name'] }}</span>
                                            <button onclick="copyToClipboard('{{ $selectedBank['bank_name'] }}')" 
                                                    class="text-blue-600 hover:text-blue-800 p-2 rounded-lg hover:bg-blue-100 transition-colors">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                                                </svg>
                                            </button>
                                        </div>
                                    </div>
                                    
                                    <div>
                                        <label class="block text-sm font-bold text-blue-700 mb-2">Account Number</label>
                                        <div class="flex items-center justify-between bg-white border-2 border-blue-300 rounded-xl px-4 py-3 shadow-sm">
                                            <span class="text-lg font-mono text-gray-900">{{ $selectedBank['account_number'] }}</span>
                                            <button onclick="copyToClipboard('{{ $selectedBank['account_number'] }}')" 
                                                    class="text-blue-600 hover:text-blue-800 p-2 rounded-lg hover:bg-blue-100 transition-colors">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                                                </svg>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="space-y-4">
                                    <div>
                                        <label class="block text-sm font-bold text-blue-700 mb-2">Account Holder</label>
                                        <div class="flex items-center justify-between bg-white border-2 border-blue-300 rounded-xl px-4 py-3 shadow-sm">
                                            <span class="text-lg font-mono text-gray-900">{{ $selectedBank['account_holder'] }}</span>
                                            <button onclick="copyToClipboard('{{ $selectedBank['account_holder'] }}')" 
                                                    class="text-blue-600 hover:text-blue-800 p-2 rounded-lg hover:bg-blue-100 transition-colors">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                                                </svg>
                                            </button>
                                        </div>
                                    </div>
                                    
                                    <div>
                                        <label class="block text-sm font-bold text-blue-700 mb-2">Amount to Pay</label>
                                        <div class="flex items-center justify-between bg-white border-2 border-blue-300 rounded-xl px-4 py-3 shadow-sm">
                                            <span class="text-xl font-mono text-gray-900 font-bold">${{ number_format($totalAmount, 2) }}</span>
                                            <button onclick="copyToClipboard('{{ number_format($totalAmount, 2) }}')" 
                                                    class="text-blue-600 hover:text-blue-800 p-2 rounded-lg hover:bg-blue-100 transition-colors">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                                                </svg>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Payment Reference -->
                        <div class="bg-gradient-to-r from-yellow-50 to-orange-50 border-2 border-yellow-300 rounded-2xl p-8 mb-8">
                            <h3 class="text-2xl font-bold text-yellow-900 mb-4 flex items-center">
                                <svg class="w-8 h-8 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                                </svg>
                                ⚠️ CRITICAL: Payment Reference
                            </h3>
                            <div class="flex items-center justify-between bg-white border-2 border-yellow-400 rounded-xl px-6 py-4 shadow-lg mb-4">
                                <span class="text-2xl font-mono text-gray-900 font-bold">{{ $paymentReference }}</span>
                                <button onclick="copyToClipboard('{{ $paymentReference }}')" 
                                        class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded-lg font-bold transition-colors flex items-center">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                                    </svg>
                                    Copy Reference
                                </button>
                            </div>
                            <div class="bg-white rounded-xl p-4 border border-yellow-200">
                                <p class="text-yellow-800 font-medium leading-relaxed">
                                    <strong>IMPORTANT:</strong> You MUST include this exact reference code when making your payment. 
                                    This helps us identify your transaction and process your order quickly. 
                                    <span class="text-red-600 font-bold">Do not change or modify this reference in any way.</span>
                                </p>
                            </div>
                        </div>

                        <!-- Payment Completion Form -->
                        <form method="POST" action="{{ route('checkout.complete') }}" id="paymentCompletionForm" 
                              class="bg-gradient-to-r from-gray-50 to-blue-50 border-2 border-gray-200 rounded-2xl p-8">
                            @csrf
                            <h3 class="text-2xl font-bold text-gray-900 mb-6 flex items-center">
                                <svg class="w-8 h-8 mr-3 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                </svg>
                                ✅ Confirm Payment Completion
                            </h3>
                            
                            <div class="space-y-6">
                                <div>
                                    <label for="transaction_reference" class="block text-lg font-bold text-gray-700 mb-3">
                                        Transaction Reference Number <span class="text-red-500">*</span>
                                    </label>
                                    <input type="text" 
                                           id="transaction_reference" 
                                           name="transaction_reference" 
                                           required
                                           placeholder="Enter the transaction ID/reference from your payment confirmation"
                                           class="w-full px-4 py-4 text-lg border-2 border-gray-300 rounded-xl shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all">
                                    @error('transaction_reference')
                                        <p class="mt-2 text-sm text-red-600 font-medium">{{ $message }}</p>
                                    @enderror
                                    <p class="mt-2 text-sm text-gray-600">
                                        This is the confirmation number you received after completing your payment
                                    </p>
                                </div>

                                <div>
                                    <label for="transaction_proof" class="block text-lg font-bold text-gray-700 mb-3">
                                        Additional Notes (Optional)
                                    </label>
                                    <textarea id="transaction_proof" 
                                              name="transaction_proof" 
                                              rows="4"
                                              placeholder="Any additional information about your payment (optional)"
                                              class="w-full px-4 py-4 text-lg border-2 border-gray-300 rounded-xl shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all"></textarea>
                                    @error('transaction_proof')
                                        <p class="mt-2 text-sm text-red-600 font-medium">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="flex flex-col sm:flex-row items-center justify-between pt-6 space-y-4 sm:space-y-0">
                                    <a href="{{ route('checkout.cancel') }}" 
                                       class="text-gray-500 hover:text-red-600 font-bold flex items-center transition-colors group">
                                        <svg class="w-5 h-5 mr-2 group-hover:text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                        </svg>
                                        Cancel Purchase
                                    </a>
                                    <button type="submit" 
                                            id="completeButton"
                                            class="bg-gradient-to-r from-green-600 via-green-700 to-emerald-700 hover:from-green-700 hover:via-green-800 hover:to-emerald-800 text-white font-bold py-4 px-10 rounded-xl transition-all duration-200 transform hover:scale-105 shadow-xl hover:shadow-2xl flex items-center">
                                        <span class="mr-3">Complete Purchase</span>
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Enhanced Order Summary -->
            <div class="xl:col-span-1">
                <div class="bg-white shadow-2xl rounded-2xl overflow-hidden sticky top-6 border border-gray-100">
                    <div class="px-6 py-6 bg-gradient-to-r from-gray-800 via-gray-900 to-black">
                        <h3 class="text-2xl font-bold text-white flex items-center">
                            <svg class="w-8 h-8 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z"/>
                                <path fill-rule="evenodd" d="M4 5a2 2 0 012-2v1a2 2 0 002 2h4a2 2 0 002-2V3a2 2 0 012 2v6.5a1.5 1.5 0 01-1.5 1.5h-9A1.5 1.5 0 014 11.5V5zM7.5 6.5a1 1 0 11-2 0 1 1 0 012 0zm5 0a1 1 0 11-2 0 1 1 0 012 0zm-5 4a1 1 0 11-2 0 1 1 0 012 0zm5 0a1 1 0 11-2 0 1 1 0 012 0z" clip-rule="evenodd"/>
                            </svg>
                            Payment Summary
                        </h3>
                        <p class="text-gray-300 mt-1">Review your purchase details</p>
                    </div>
                    
                    <div class="p-8">
                        <!-- Vehicle Info -->
                        <div class="flex items-center space-x-4 mb-8 pb-6 border-b border-gray-200">
                            @if($vehicle->primary_image)
                                <img class="h-20 w-20 rounded-2xl object-cover shadow-lg border-2 border-gray-100" 
                                     src="{{ asset('storage/' . $vehicle->primary_image) }}" 
                                     alt="{{ $vehicle->full_name }}">
                            @else
                                <div class="h-20 w-20 rounded-2xl bg-gradient-to-br from-gray-200 to-gray-300 flex items-center justify-center shadow-lg border-2 border-gray-100">
                                    <svg class="h-10 w-10 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z" clip-rule="evenodd"/>
                                    </svg>
                                </div>
                            @endif
                            <div class="flex-1">
                                <p class="font-bold text-gray-900 text-lg">{{ $vehicle->full_name }}</p>
                                <p class="text-gray-600 font-medium">{{ $vehicle->year }} • {{ $vehicle->fuel_type }}</p>
                                <div class="flex items-center mt-2">
                                    <span class="bg-green-100 text-green-800 text-xs font-bold px-2 py-1 rounded-full">✅ Reserved</span>
                                </div>
                            </div>
                        </div>

                        <!-- Enhanced Price Breakdown -->
                        <div class="space-y-5 mb-8">
                            <div class="flex justify-between items-center py-2">
                                <span class="text-gray-600 font-medium">Vehicle Price</span>
                                <span class="font-bold text-gray-900 text-lg">${{ number_format($salePrice, 2) }}</span>
                            </div>
                            <div class="flex justify-between items-center py-2">
                                <span class="text-gray-600 font-medium">Delivery</span>
                                <span class="font-bold text-gray-900 text-lg">
                                    @if($deliveryCost == 0)
                                        <span class="text-green-600 font-bold bg-green-100 px-2 py-1 rounded-full text-sm">FREE</span>
                                    @else
                                        ${{ number_format($deliveryCost, 2) }}
                                    @endif
                                </span>
                            </div>
                            <div class="flex justify-between items-center py-2">
                                <span class="text-gray-600 font-medium">Tax (15%)</span>
                                <span class="font-bold text-gray-900 text-lg">${{ number_format($taxAmount, 2) }}</span>
                            </div>
                            <div class="border-t-2 border-gray-200 pt-4">
                                <div class="flex justify-between items-center">
                                    <span class="text-2xl font-bold text-gray-900">Total Amount</span>
                                    <div class="text-right">
                                        <span class="text-3xl font-bold text-green-600">${{ number_format($totalAmount, 2) }}</span>
                                        <p class="text-sm text-gray-500 mt-1">All taxes included</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Payment Status -->
                        <div class="bg-gradient-to-r from-yellow-50 to-orange-50 border-2 border-yellow-300 rounded-2xl p-6 mb-6">
                            <div class="flex items-start">
                                <div class="flex-shrink-0">
                                    <div class="w-12 h-12 bg-gradient-to-br from-yellow-500 to-yellow-600 rounded-xl flex items-center justify-center shadow-lg">
                                        <svg class="h-6 w-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/>
                                        </svg>
                                    </div>
                                </div>
                                <div class="ml-4">
                                    <h4 class="font-bold text-yellow-900 text-lg">⏰ Payment Pending</h4>
                                    <p class="text-yellow-800 text-sm mt-2 leading-relaxed">
                                        Complete your payment using the instructions provided and submit your transaction reference to finalize your purchase.
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- Customer Support -->
                        <div class="bg-gray-50 rounded-2xl p-6 border border-gray-200">
                            <h4 class="font-bold text-gray-900 mb-3 flex items-center">
                                <svg class="w-5 h-5 text-blue-600 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z"/>
                                </svg>
                                Need Help?
                            </h4>
                            <p class="text-gray-600 text-sm mb-3">
                                Our customer support team is available 24/7 to assist with your payment.
                            </p>
                            <div class="space-y-2 text-sm">
                                <div class="flex items-center text-gray-700">
                                    <span class="font-medium">📞 Phone:</span>
                                    <span class="ml-2">+251-911-123-456</span>
                                </div>
                                <div class="flex items-center text-gray-700">
                                    <span class="font-medium">📧 Email:</span>
                                    <span class="ml-2">support@vehiclerental.com</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
/* Enhanced animations and transitions */
.animate-pulse {
    animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
}

@keyframes pulse {
    0%, 100% {
        opacity: 1;
    }
    50% {
        opacity: .5;
    }
}

/* Copy button hover effects */
button:hover {
    transform: translateY(-1px);
}

/* Form input focus effects */
input:focus, textarea:focus {
    box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
}

/* Loading state for submit button */
.loading {
    pointer-events: none;
    opacity: 0.7;
}

.loading::after {
    content: '';
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    width: 1.5rem;
    height: 1.5rem;
    border: 2px solid transparent;
    border-top: 2px solid white;
    border-radius: 50%;
    animation: spin 1s linear infinite;
}

@keyframes spin {
    0% { transform: translate(-50%, -50%) rotate(0deg); }
    100% { transform: translate(-50%, -50%) rotate(360deg); }
}

/* Mobile responsiveness */
@media (max-width: 768px) {
    .grid {
        gap: 1rem;
    }
    
    .text-4xl {
        font-size: 2rem;
    }
    
    .text-5xl {
        font-size: 2.5rem;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('paymentCompletionForm');
    const completeButton = document.getElementById('completeButton');
    const transactionInput = document.getElementById('transaction_reference');
    
    // Enhanced copy to clipboard function
    window.copyToClipboard = function(text) {
        navigator.clipboard.writeText(text).then(function() {
            showToast('Copied to clipboard!', 'success');
        }).catch(function() {
            // Fallback for older browsers
            const textArea = document.createElement('textarea');
            textArea.value = text;
            document.body.appendChild(textArea);
            textArea.select();
            document.execCommand('copy');
            document.body.removeChild(textArea);
            showToast('Copied to clipboard!', 'success');
        });
    };
    
    // Enhanced toast notification
    function showToast(message, type = 'success') {
        const toast = document.createElement('div');
        const bgColor = type === 'success' ? 'bg-green-500' : 'bg-red-500';
        toast.className = `fixed top-4 right-4 ${bgColor} text-white px-6 py-3 rounded-xl shadow-2xl z-50 transform transition-all duration-300 translate-x-full`;
        toast.innerHTML = `
            <div class="flex items-center">
                <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                </svg>
                ${message}
            </div>
        `;
        document.body.appendChild(toast);
        
        // Animate in
        setTimeout(() => {
            toast.classList.remove('translate-x-full');
        }, 100);
        
        // Animate out and remove
        setTimeout(() => {
            toast.classList.add('translate-x-full');
            setTimeout(() => {
                if (toast.parentNode) {
                    document.body.removeChild(toast);
                }
            }, 300);
        }, 3000);
    }
    
    // Form validation and submission
    form.addEventListener('submit', function(e) {
        if (!transactionInput.value.trim()) {
            e.preventDefault();
            transactionInput.focus();
            showToast('Please enter your transaction reference number', 'error');
            return;
        }
        
        // Show loading state
        completeButton.classList.add('loading');
        completeButton.innerHTML = `
            <span class="opacity-0">Complete Purchase</span>
            <div class="absolute inset-0 flex items-center justify-center">
                <svg class="animate-spin h-6 w-6 text-white" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
            </div>
        `;
    });
    
    // Real-time validation feedback
    transactionInput.addEventListener('input', function() {
        if (this.value.trim()) {
            this.classList.remove('border-red-300');
            this.classList.add('border-green-300');
        } else {
            this.classList.remove('border-green-300');
            this.classList.add('border-gray-300');
        }
    });
    
    // Auto-focus on transaction input
    setTimeout(() => {
        transactionInput.focus();
    }, 1000);
});
</script>
@endsection