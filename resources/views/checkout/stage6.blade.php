@extends('layouts.app')

@section('title', 'Purchase Checkout - Payment Instructions')

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
            <h1 class="text-3xl font-bold text-gray-900">Payment Instructions</h1>
            <p class="mt-2 text-sm text-gray-600">Follow these instructions to complete your payment</p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Payment Instructions -->
            <div class="lg:col-span-2">
                @php
                    $checkout = Session::get('checkout');
                    $paymentMethod = $checkout['payment_method'] ?? 'cbe_mobile';
                    $deliveryCost = $checkout['delivery_info']['delivery_cost'] ?? 0;
                    $salePrice = $vehicle->sale_price;
                    $taxAmount = ($salePrice + $deliveryCost) * 0.15;
                    $totalAmount = $salePrice + $deliveryCost + $taxAmount;
                    $paymentReference = 'PAY-' . strtoupper(Str::random(8));
                    
                    // Get bank details based on selected payment method
                    $bankDetails = [
                        'cbe_mobile' => [
                            'bank_name' => 'Commercial Bank of Ethiopia',
                            'account_number' => '1000123456789',
                            'account_holder' => 'Car Rental & Sales Ltd',
                            'type' => 'mobile'
                        ],
                        'abyssinia_mobile' => [
                            'bank_name' => 'Bank of Abyssinia',
                            'account_number' => '2000987654321',
                            'account_holder' => 'Car Rental & Sales Ltd',
                            'type' => 'mobile'
                        ],
                        'telebirr' => [
                            'bank_name' => 'Telebirr',
                            'account_number' => '0911000000',
                            'account_holder' => 'Car Rental & Sales Ltd',
                            'type' => 'mobile'
                        ],
                        'dashen_mobile' => [
                            'bank_name' => 'Dashen Bank',
                            'account_number' => '3000456789123',
                            'account_holder' => 'Car Rental & Sales Ltd',
                            'type' => 'mobile'
                        ],
                        'cbe_transfer' => [
                            'bank_name' => 'Commercial Bank of Ethiopia',
                            'account_number' => '1000123456789',
                            'account_holder' => 'Car Rental & Sales Ltd',
                            'type' => 'transfer'
                        ],
                        'abyssinia_transfer' => [
                            'bank_name' => 'Bank of Abyssinia',
                            'account_number' => '2000987654321',
                            'account_holder' => 'Car Rental & Sales Ltd',
                            'type' => 'transfer'
                        ],
                        'dashen_transfer' => [
                            'bank_name' => 'Dashen Bank',
                            'account_number' => '3000456789123',
                            'account_holder' => 'Car Rental & Sales Ltd',
                            'type' => 'transfer'
                        ]
                    ];
                    
                    $selectedBank = $bankDetails[$paymentMethod] ?? $bankDetails['cbe_mobile'];
                @endphp

                <div class="bg-white shadow rounded-lg">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h2 class="text-lg font-medium text-gray-900">
                            @if($selectedBank['type'] === 'mobile')
                                📱 Mobile Banking Payment
                            @else
                                🏦 Bank Transfer Payment
                            @endif
                        </h2>
                        <p class="mt-1 text-sm text-gray-600">Complete your payment using the details below</p>
                    </div>

                    <div class="p-6">
                        <div class="space-y-6">
                            @if($selectedBank['type'] === 'mobile')
                                <!-- Mobile Banking Instructions -->
                                <div class="space-y-6">
                                    <!-- Bank Details -->
                                    <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                                        <h3 class="text-lg font-medium text-blue-900 mb-3">Bank Account Details</h3>
                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                            <div>
                                                <label class="block text-sm font-medium text-blue-700">Bank Name</label>
                                                <div class="mt-1 flex items-center justify-between bg-white border border-blue-300 rounded-md px-3 py-2">
                                                    <span class="text-sm font-mono text-gray-900">{{ $selectedBank['bank_name'] }}</span>
                                                    <button onclick="copyToClipboard('{{ $selectedBank['bank_name'] }}')" class="text-blue-600 hover:text-blue-800">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z" />
                                                        </svg>
                                                    </button>
                                                </div>
                                            </div>
                                            <div>
                                                <label class="block text-sm font-medium text-blue-700">Account Number</label>
                                                <div class="mt-1 flex items-center justify-between bg-white border border-blue-300 rounded-md px-3 py-2">
                                                    <span class="text-sm font-mono text-gray-900">{{ $selectedBank['account_number'] }}</span>
                                                    <button onclick="copyToClipboard('{{ $selectedBank['account_number'] }}')" class="text-blue-600 hover:text-blue-800">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z" />
                                                        </svg>
                                                    </button>
                                                </div>
                                            </div>
                                            <div>
                                                <label class="block text-sm font-medium text-blue-700">Account Holder</label>
                                                <div class="mt-1 flex items-center justify-between bg-white border border-blue-300 rounded-md px-3 py-2">
                                                    <span class="text-sm font-mono text-gray-900">{{ $selectedBank['account_holder'] }}</span>
                                                    <button onclick="copyToClipboard('{{ $selectedBank['account_holder'] }}')" class="text-blue-600 hover:text-blue-800">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z" />
                                                        </svg>
                                                    </button>
                                                </div>
                                            </div>
                                            <div>
                                                <label class="block text-sm font-medium text-blue-700">Amount to Pay</label>
                                                <div class="mt-1 flex items-center justify-between bg-white border border-blue-300 rounded-md px-3 py-2">
                                                    <span class="text-sm font-mono text-gray-900 font-bold">${{ number_format($totalAmount, 2) }}</span>
                                                    <button onclick="copyToClipboard('{{ number_format($totalAmount, 2) }}')" class="text-blue-600 hover:text-blue-800">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z" />
                                                        </svg>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Step-by-Step Instructions -->
                                    <div class="bg-gray-50 border border-gray-200 rounded-lg p-4">
                                        <h3 class="text-lg font-medium text-gray-900 mb-3">📋 Step-by-Step Instructions</h3>
                                        @if($paymentMethod === 'cbe_mobile')
                                            <ol class="list-decimal list-inside space-y-2 text-sm text-gray-700">
                                                <li>Open your CBE Birr, HelloCash, or M-Birr app</li>
                                                <li>Select "Send Money" or "Transfer"</li>
                                                <li>Enter the account number: <strong>{{ $selectedBank['account_number'] }}</strong></li>
                                                <li>Enter the exact amount: <strong>${{ number_format($totalAmount, 2) }}</strong></li>
                                                <li>In the reference/description field, enter: <strong>{{ $paymentReference }}</strong></li>
                                                <li>Confirm and complete the transfer</li>
                                                <li>Take a screenshot of the confirmation</li>
                                                <li>Return here and submit your payment proof</li>
                                            </ol>
                                        @elseif($paymentMethod === 'telebirr')
                                            <ol class="list-decimal list-inside space-y-2 text-sm text-gray-700">
                                                <li>Open your Telebirr app</li>
                                                <li>Select "Send Money"</li>
                                                <li>Enter the phone number: <strong>{{ $selectedBank['account_number'] }}</strong></li>
                                                <li>Enter the exact amount: <strong>${{ number_format($totalAmount, 2) }}</strong></li>
                                                <li>In the reference field, enter: <strong>{{ $paymentReference }}</strong></li>
                                                <li>Confirm and complete the transfer</li>
                                                <li>Take a screenshot of the confirmation</li>
                                                <li>Return here and submit your payment proof</li>
                                            </ol>
                                        @elseif($paymentMethod === 'abyssinia_mobile')
                                            <ol class="list-decimal list-inside space-y-2 text-sm text-gray-700">
                                                <li>Open your Abyssinia Mobile Banking app</li>
                                                <li>Select "Transfer" or "Send Money"</li>
                                                <li>Enter the account number: <strong>{{ $selectedBank['account_number'] }}</strong></li>
                                                <li>Enter the exact amount: <strong>${{ number_format($totalAmount, 2) }}</strong></li>
                                                <li>In the reference field, enter: <strong>{{ $paymentReference }}</strong></li>
                                                <li>Confirm and complete the transfer</li>
                                                <li>Take a screenshot of the confirmation</li>
                                                <li>Return here and submit your payment proof</li>
                                            </ol>
                                        @elseif($paymentMethod === 'dashen_mobile')
                                            <ol class="list-decimal list-inside space-y-2 text-sm text-gray-700">
                                                <li>Open your Dashen Mobile Banking app</li>
                                                <li>Select "Transfer" or "Send Money"</li>
                                                <li>Enter the account number: <strong>{{ $selectedBank['account_number'] }}</strong></li>
                                                <li>Enter the exact amount: <strong>${{ number_format($totalAmount, 2) }}</strong></li>
                                                <li>In the reference field, enter: <strong>{{ $paymentReference }}</strong></li>
                                                <li>Confirm and complete the transfer</li>
                                                <li>Take a screenshot of the confirmation</li>
                                                <li>Return here and submit your payment proof</li>
                                            </ol>
                                        @endif
                                    </div>
                                </div>
                            @else
                                <!-- Bank Transfer Instructions -->
                                <div class="space-y-6">
                                    <!-- Bank Details -->
                                    <div class="bg-gray-50 border border-gray-200 rounded-lg p-4">
                                        <h3 class="text-lg font-medium text-gray-900 mb-3">Bank Account Details</h3>
                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                            <div>
                                                <label class="block text-sm font-medium text-gray-700">Bank Name</label>
                                                <div class="mt-1 flex items-center justify-between bg-white border border-gray-300 rounded-md px-3 py-2">
                                                    <span class="text-sm font-mono text-gray-900">{{ $selectedBank['bank_name'] }}</span>
                                                    <button onclick="copyToClipboard('{{ $selectedBank['bank_name'] }}')" class="text-gray-600 hover:text-gray-800">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z" />
                                                        </svg>
                                                    </button>
                                                </div>
                                            </div>
                                            <div>
                                                <label class="block text-sm font-medium text-gray-700">Account Number</label>
                                                <div class="mt-1 flex items-center justify-between bg-white border border-gray-300 rounded-md px-3 py-2">
                                                    <span class="text-sm font-mono text-gray-900">{{ $selectedBank['account_number'] }}</span>
                                                    <button onclick="copyToClipboard('{{ $selectedBank['account_number'] }}')" class="text-gray-600 hover:text-gray-800">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z" />
                                                        </svg>
                                                    </button>
                                                </div>
                                            </div>
                                            <div>
                                                <label class="block text-sm font-medium text-gray-700">Account Holder</label>
                                                <div class="mt-1 flex items-center justify-between bg-white border border-gray-300 rounded-md px-3 py-2">
                                                    <span class="text-sm font-mono text-gray-900">{{ $selectedBank['account_holder'] }}</span>
                                                    <button onclick="copyToClipboard('{{ $selectedBank['account_holder'] }}')" class="text-gray-600 hover:text-gray-800">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z" />
                                                        </svg>
                                                    </button>
                                                </div>
                                            </div>
                                            <div>
                                                <label class="block text-sm font-medium text-gray-700">Amount to Pay</label>
                                                <div class="mt-1 flex items-center justify-between bg-white border border-gray-300 rounded-md px-3 py-2">
                                                    <span class="text-sm font-mono text-gray-900 font-bold">${{ number_format($totalAmount, 2) }}</span>
                                                    <button onclick="copyToClipboard('{{ number_format($totalAmount, 2) }}')" class="text-gray-600 hover:text-gray-800">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z" />
                                                        </svg>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Step-by-Step Instructions -->
                                    <div class="bg-gray-50 border border-gray-200 rounded-lg p-4">
                                        <h3 class="text-lg font-medium text-gray-900 mb-3">📋 Bank Transfer Instructions</h3>
                                        <ol class="list-decimal list-inside space-y-2 text-sm text-gray-700">
                                            <li>Visit your nearest {{ $selectedBank['bank_name'] }} branch or use online banking</li>
                                            <li>Fill out a transfer form or initiate online transfer</li>
                                            <li>Enter beneficiary account: <strong>{{ $selectedBank['account_number'] }}</strong></li>
                                            <li>Enter beneficiary name: <strong>{{ $selectedBank['account_holder'] }}</strong></li>
                                            <li>Enter the exact amount: <strong>${{ number_format($totalAmount, 2) }}</strong></li>
                                            <li>In the reference field, enter: <strong>{{ $paymentReference }}</strong></li>
                                            <li>Complete the transfer and keep the receipt</li>
                                            <li>Return here and submit your payment proof</li>
                                        </ol>
                                        <div class="mt-3 p-3 bg-yellow-50 border border-yellow-200 rounded-md">
                                            <p class="text-sm text-yellow-800">
                                                <strong>Note:</strong> Bank transfers typically take 1-2 business days to process. 
                                                Your vehicle will be reserved during this time.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            @endif

                            <!-- Payment Reference -->
                            <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                                <h3 class="text-lg font-medium text-yellow-900 mb-3">⚠️ Important: Payment Reference</h3>
                                <div class="flex items-center justify-between bg-white border border-yellow-300 rounded-md px-3 py-2">
                                    <span class="text-lg font-mono text-gray-900 font-bold">{{ $paymentReference }}</span>
                                    <button onclick="copyToClipboard('{{ $paymentReference }}')" class="text-yellow-600 hover:text-yellow-800">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z" />
                                        </svg>
                                    </button>
                                </div>
                                <p class="mt-2 text-sm text-yellow-800">
                                    <strong>CRITICAL:</strong> You MUST use this exact reference when making your payment. 
                                    Do not change or modify it in any way.
                                </p>
                            </div>

                            <!-- Timer -->
                            <div class="mt-6 bg-red-50 border border-red-200 rounded-lg p-4">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0">
                                        <svg class="h-5 w-5 text-red-400" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                    <div class="ml-3">
                                        <h3 class="text-sm font-medium text-red-800">⏰ Payment Validity</h3>
                                        <div class="mt-2 text-sm text-red-700">
                                            <p>This payment instruction is valid for <strong>24 hours</strong>. 
                                            Please complete your payment within this time to secure your vehicle.</p>
                                            <div class="mt-2 font-mono text-lg" id="countdown">23:59:59</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Continue Button -->
                <div class="mt-6 flex items-center justify-between">
                    <a href="{{ route('checkout.cancel') }}" class="text-gray-500 hover:text-gray-700 text-sm font-medium">
                        ← Cancel Purchase
                    </a>
                    <div class="flex space-x-3">
                        <button type="button" onclick="history.back()" class="bg-gray-100 border border-gray-300 rounded-md py-2 px-4 text-sm font-medium text-gray-700 hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                            ← Back
                        </button>
                        <a href="{{ route('checkout.stage7.show') }}" class="bg-blue-600 border border-transparent rounded-md py-2 px-6 text-sm font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            I've Made the Payment →
                        </a>
                    </div>
                </div>
            </div>

            <!-- Order Summary -->
            <div class="lg:col-span-1">
                <div class="bg-white shadow rounded-lg p-6 sticky top-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Payment Summary</h3>
                    
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
                            <span class="text-sm font-medium text-gray-900">${{ number_format($deliveryCost, 2) }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-sm text-gray-600">Tax (15%)</span>
                            <span class="text-sm font-medium text-gray-900">${{ number_format($taxAmount, 2) }}</span>
                        </div>
                        <div class="border-t border-gray-200 pt-3">
                            <div class="flex justify-between">
                                <span class="text-base font-medium text-gray-900">Total to Pay</span>
                                <span class="text-lg font-bold text-blue-600">${{ number_format($totalAmount, 2) }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Payment Method -->
                    <div class="bg-blue-50 border border-blue-200 rounded-md p-3 mb-4">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                @if($selectedBank['type'] === 'mobile')
                                    <svg class="h-5 w-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z" />
                                    </svg>
                                @else
                                    <svg class="h-5 w-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                    </svg>
                                @endif
                            </div>
                            <div class="ml-3">
                                <h3 class="text-sm font-medium text-blue-800">{{ $selectedBank['bank_name'] }}</h3>
                                <p class="text-sm text-blue-600">
                                    @if($selectedBank['type'] === 'mobile')
                                        Mobile Banking
                                    @else
                                        Bank Transfer
                                    @endif
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Support -->
                    <div class="text-center">
                        <p class="text-xs text-gray-500 mb-2">Need help with payment?</p>
                        <a href="{{ route('contact.show') }}" class="text-blue-600 hover:text-blue-500 text-sm font-medium">
                            Contact Support
                        </a>
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

// Countdown timer
function startCountdown() {
    let timeLeft = 24 * 60 * 60; // 24 hours in seconds
    
    function updateTimer() {
        const hours = Math.floor(timeLeft / 3600);
        const minutes = Math.floor((timeLeft % 3600) / 60);
        const seconds = timeLeft % 60;
        
        document.getElementById('countdown').textContent = 
            `${hours.toString().padStart(2, '0')}:${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;
        
        if (timeLeft > 0) {
            timeLeft--;
            setTimeout(updateTimer, 1000);
        } else {
            document.getElementById('countdown').textContent = 'EXPIRED';
            document.getElementById('countdown').className += ' text-red-600 font-bold';
        }
    }
    
    updateTimer();
}

document.addEventListener('DOMContentLoaded', startCountdown);
</script>
@endsection