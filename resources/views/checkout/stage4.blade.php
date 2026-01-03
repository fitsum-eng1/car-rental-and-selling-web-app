@extends('layouts.app')

@section('title', 'Purchase Checkout - Payment Method')

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
                    <div class="w-8 md:w-12 h-1 bg-gradient-to-r from-green-600 to-blue-600 rounded"></div>
                    <div class="flex items-center text-sm text-blue-600">
                        <span class="flex items-center justify-center w-12 h-12 bg-gradient-to-br from-blue-600 to-blue-700 text-white rounded-full font-bold shadow-lg animate-pulse">4</span>
                        <span class="ml-3 font-bold hidden md:block">Payment Method</span>
                    </div>
                    <div class="w-8 md:w-12 h-1 bg-gray-300 rounded"></div>
                    <div class="flex items-center text-sm text-gray-400">
                        <span class="flex items-center justify-center w-12 h-12 bg-gray-300 text-gray-600 rounded-full font-semibold">5</span>
                        <span class="ml-3 hidden md:block">Complete</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Enhanced Page Header -->
        <div class="text-center mb-10">
            <div class="inline-flex items-center justify-center w-20 h-20 bg-gradient-to-br from-blue-600 to-blue-700 rounded-full mb-4 shadow-xl">
                <svg class="w-10 h-10 text-white" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M4 4a2 2 0 00-2 2v1h16V6a2 2 0 00-2-2H4z"/>
                    <path fill-rule="evenodd" d="M18 9H2v5a2 2 0 002 2h12a2 2 0 002-2V9zM4 13a1 1 0 011-1h1a1 1 0 110 2H5a1 1 0 01-1-1zm5-1a1 1 0 100 2h1a1 1 0 100-2H9z" clip-rule="evenodd"/>
                </svg>
            </div>
            <h1 class="text-4xl md:text-5xl font-bold text-gray-900 mb-3">Secure Payment Method</h1>
            <p class="text-xl text-gray-600 max-w-2xl mx-auto">Choose your preferred payment method to complete your vehicle purchase safely and securely</p>
            
            <!-- Trust Indicators -->
            <div class="flex items-center justify-center space-x-6 mt-6">
                <div class="flex items-center text-green-600">
                    <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"/>
                    </svg>
                    <span class="font-semibold">Bank-Level Security</span>
                </div>
                <div class="flex items-center text-blue-600">
                    <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                    <span class="font-semibold">Verified Banks</span>
                </div>
                <div class="flex items-center text-purple-600">
                    <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <span class="font-semibold">Instant Processing</span>
                </div>
            </div>
        </div>

        <form method="POST" action="{{ route('checkout.stage4.process') }}" id="paymentForm">
            @csrf
            <div class="grid grid-cols-1 xl:grid-cols-4 gap-8">
                <!-- Payment Method Selection -->
                <div class="xl:col-span-3">
                    <div class="bg-white shadow-xl rounded-2xl overflow-hidden border border-gray-100">
                        <div class="px-8 py-6 bg-gradient-to-r from-blue-600 via-blue-700 to-indigo-700">
                            <div class="flex items-center justify-between">
                                <div>
                                    <h2 class="text-2xl font-bold text-white flex items-center">
                                        <svg class="w-8 h-8 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M4 4a2 2 0 00-2 2v1h16V6a2 2 0 00-2-2H4z"/>
                                            <path fill-rule="evenodd" d="M18 9H2v5a2 2 0 002 2h12a2 2 0 002-2V9zM4 13a1 1 0 011-1h1a1 1 0 110 2H5a1 1 0 01-1-1zm5-1a1 1 0 100 2h1a1 1 0 100-2H9z" clip-rule="evenodd"/>
                                        </svg>
                                        Payment Options
                                    </h2>
                                    <p class="mt-2 text-blue-100">Select your preferred payment method from trusted Ethiopian banks</p>
                                </div>
                                <div class="hidden md:flex items-center space-x-2">
                                    <span class="bg-white bg-opacity-20 text-white px-3 py-1 rounded-full text-sm font-medium">🔒 Secure</span>
                                    <span class="bg-white bg-opacity-20 text-white px-3 py-1 rounded-full text-sm font-medium">✅ Verified</span>
                                </div>
                            </div>
                        </div>

                        <div class="p-8">
                            <!-- Mobile Banking Section -->
                            <div class="mb-10">
                                <div class="flex items-center justify-between mb-6">
                                    <h3 class="text-2xl font-bold text-gray-900 flex items-center">
                                        <span class="bg-gradient-to-br from-green-500 to-green-600 text-white rounded-xl p-3 mr-4 shadow-lg">
                                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z"/>
                                            </svg>
                                        </span>
                                        Mobile Banking & Digital Payments
                                    </h3>
                                    <div class="flex items-center space-x-2">
                                        <span class="bg-green-100 text-green-800 text-sm font-bold px-3 py-1 rounded-full">⚡ Instant Processing</span>
                                        <span class="bg-blue-100 text-blue-800 text-sm font-bold px-3 py-1 rounded-full">📱 Mobile Friendly</span>
                                    </div>
                                </div>
                                
                                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                                    <!-- Commercial Bank of Ethiopia -->
                                    <div class="payment-option group">
                                        <input type="radio" id="cbe_mobile" name="payment_method" value="cbe_mobile" class="sr-only" checked>
                                        <label for="cbe_mobile" class="payment-label selected cursor-pointer">
                                            <div class="flex items-center justify-between">
                                                <div class="flex items-center">
                                                    <div class="w-20 h-20 bg-gradient-to-br from-green-500 to-green-600 rounded-2xl flex items-center justify-center shadow-xl group-hover:shadow-2xl transition-all duration-300">
                                                        <span class="text-white font-bold text-xl">CBE</span>
                                                    </div>
                                                    <div class="ml-5">
                                                        <h4 class="text-xl font-bold text-gray-900">Commercial Bank</h4>
                                                        <p class="text-gray-600 font-medium">CBE Birr • HelloCash • M-Birr</p>
                                                        <div class="flex items-center mt-3 space-x-2">
                                                            <span class="bg-green-100 text-green-800 text-xs font-bold px-2.5 py-1 rounded-full">🏆 Most Popular</span>
                                                            <span class="bg-blue-100 text-blue-800 text-xs font-bold px-2.5 py-1 rounded-full">⚡ Instant</span>
                                                        </div>
                                                        <p class="text-sm text-gray-500 mt-2">Processing: <strong class="text-green-600">Immediate</strong></p>
                                                    </div>
                                                </div>
                                                <div class="radio-indicator"></div>
                                            </div>
                                        </label>
                                    </div>

                                    <!-- Telebirr -->
                                    <div class="payment-option group">
                                        <input type="radio" id="telebirr" name="payment_method" value="telebirr" class="sr-only">
                                        <label for="telebirr" class="payment-label cursor-pointer">
                                            <div class="flex items-center justify-between">
                                                <div class="flex items-center">
                                                    <div class="w-20 h-20 bg-gradient-to-br from-orange-500 to-orange-600 rounded-2xl flex items-center justify-center shadow-xl group-hover:shadow-2xl transition-all duration-300">
                                                        <span class="text-white font-bold text-xl">TB</span>
                                                    </div>
                                                    <div class="ml-5">
                                                        <h4 class="text-xl font-bold text-gray-900">Telebirr</h4>
                                                        <p class="text-gray-600 font-medium">Ethio Telecom Mobile Payment</p>
                                                        <div class="flex items-center mt-3">
                                                            <span class="bg-orange-100 text-orange-800 text-xs font-bold px-2.5 py-1 rounded-full">🔒 Fast & Secure</span>
                                                        </div>
                                                        <p class="text-sm text-gray-500 mt-2">Processing: <strong class="text-green-600">Immediate</strong></p>
                                                    </div>
                                                </div>
                                                <div class="radio-indicator"></div>
                                            </div>
                                        </label>
                                    </div>

                                    <!-- Bank of Abyssinia -->
                                    <div class="payment-option group">
                                        <input type="radio" id="abyssinia_mobile" name="payment_method" value="abyssinia_mobile" class="sr-only">
                                        <label for="abyssinia_mobile" class="payment-label cursor-pointer">
                                            <div class="flex items-center justify-between">
                                                <div class="flex items-center">
                                                    <div class="w-20 h-20 bg-gradient-to-br from-red-500 to-red-600 rounded-2xl flex items-center justify-center shadow-xl group-hover:shadow-2xl transition-all duration-300">
                                                        <span class="text-white font-bold text-xl">BOA</span>
                                                    </div>
                                                    <div class="ml-5">
                                                        <h4 class="text-xl font-bold text-gray-900">Bank of Abyssinia</h4>
                                                        <p class="text-gray-600 font-medium">Abyssinia Mobile Banking</p>
                                                        <div class="flex items-center mt-3">
                                                            <span class="bg-red-100 text-red-800 text-xs font-bold px-2.5 py-1 rounded-full">🏦 Trusted</span>
                                                        </div>
                                                        <p class="text-sm text-gray-500 mt-2">Processing: <strong class="text-green-600">Immediate</strong></p>
                                                    </div>
                                                </div>
                                                <div class="radio-indicator"></div>
                                            </div>
                                        </label>
                                    </div>

                                    <!-- Dashen Bank -->
                                    <div class="payment-option group">
                                        <input type="radio" id="dashen_mobile" name="payment_method" value="dashen_mobile" class="sr-only">
                                        <label for="dashen_mobile" class="payment-label cursor-pointer">
                                            <div class="flex items-center justify-between">
                                                <div class="flex items-center">
                                                    <div class="w-20 h-20 bg-gradient-to-br from-purple-500 to-purple-600 rounded-2xl flex items-center justify-center shadow-xl group-hover:shadow-2xl transition-all duration-300">
                                                        <span class="text-white font-bold text-xl">DB</span>
                                                    </div>
                                                    <div class="ml-5">
                                                        <h4 class="text-xl font-bold text-gray-900">Dashen Bank</h4>
                                                        <p class="text-gray-600 font-medium">Dashen Mobile Banking</p>
                                                        <div class="flex items-center mt-3">
                                                            <span class="bg-purple-100 text-purple-800 text-xs font-bold px-2.5 py-1 rounded-full">💎 Premium</span>
                                                        </div>
                                                        <p class="text-sm text-gray-500 mt-2">Processing: <strong class="text-green-600">Immediate</strong></p>
                                                    </div>
                                                </div>
                                                <div class="radio-indicator"></div>
                                            </div>
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <!-- Bank Transfer Section -->
                            <div class="mb-10">
                                <div class="flex items-center justify-between mb-6">
                                    <h3 class="text-2xl font-bold text-gray-900 flex items-center">
                                        <span class="bg-gradient-to-br from-blue-500 to-blue-600 text-white rounded-xl p-3 mr-4 shadow-lg">
                                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M4 4a2 2 0 00-2 2v8a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2H4zm0 2h12v8H4V6z"/>
                                                <path d="M6 8h8v2H6V8zm0 4h8v2H6v-2z"/>
                                            </svg>
                                        </span>
                                        Bank Transfer Options
                                    </h3>
                                    <div class="flex items-center space-x-2">
                                        <span class="bg-yellow-100 text-yellow-800 text-sm font-bold px-3 py-1 rounded-full">⏱️ 1-2 Business Days</span>
                                        <span class="bg-gray-100 text-gray-800 text-sm font-bold px-3 py-1 rounded-full">🏦 Traditional</span>
                                    </div>
                                </div>
                                
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                                    <!-- CBE Transfer -->
                                    <div class="payment-option group">
                                        <input type="radio" id="cbe_transfer" name="payment_method" value="cbe_transfer" class="sr-only">
                                        <label for="cbe_transfer" class="payment-label cursor-pointer">
                                            <div class="text-center">
                                                <div class="w-20 h-20 bg-gradient-to-br from-green-500 to-green-600 rounded-2xl flex items-center justify-center shadow-xl mx-auto mb-4 group-hover:shadow-2xl transition-all duration-300">
                                                    <span class="text-white font-bold text-xl">CBE</span>
                                                </div>
                                                <h4 class="text-lg font-bold text-gray-900 mb-2">CBE Transfer</h4>
                                                <p class="text-gray-600 font-medium mb-3">Direct Bank Transfer</p>
                                                <div class="space-y-2">
                                                    <span class="inline-block bg-green-100 text-green-800 text-xs font-bold px-2 py-1 rounded-full">🏦 Reliable</span>
                                                    <p class="text-sm text-gray-500">Processing: <strong class="text-yellow-600">1-2 Days</strong></p>
                                                </div>
                                                <div class="radio-indicator mx-auto mt-4"></div>
                                            </div>
                                        </label>
                                    </div>

                                    <!-- Abyssinia Transfer -->
                                    <div class="payment-option group">
                                        <input type="radio" id="abyssinia_transfer" name="payment_method" value="abyssinia_transfer" class="sr-only">
                                        <label for="abyssinia_transfer" class="payment-label cursor-pointer">
                                            <div class="text-center">
                                                <div class="w-20 h-20 bg-gradient-to-br from-red-500 to-red-600 rounded-2xl flex items-center justify-center shadow-xl mx-auto mb-4 group-hover:shadow-2xl transition-all duration-300">
                                                    <span class="text-white font-bold text-xl">BOA</span>
                                                </div>
                                                <h4 class="text-lg font-bold text-gray-900 mb-2">Abyssinia Transfer</h4>
                                                <p class="text-gray-600 font-medium mb-3">Direct Bank Transfer</p>
                                                <div class="space-y-2">
                                                    <span class="inline-block bg-red-100 text-red-800 text-xs font-bold px-2 py-1 rounded-full">🏦 Secure</span>
                                                    <p class="text-sm text-gray-500">Processing: <strong class="text-yellow-600">1-2 Days</strong></p>
                                                </div>
                                                <div class="radio-indicator mx-auto mt-4"></div>
                                            </div>
                                        </label>
                                    </div>

                                    <!-- Dashen Transfer -->
                                    <div class="payment-option group">
                                        <input type="radio" id="dashen_transfer" name="payment_method" value="dashen_transfer" class="sr-only">
                                        <label for="dashen_transfer" class="payment-label cursor-pointer">
                                            <div class="text-center">
                                                <div class="w-20 h-20 bg-gradient-to-br from-purple-500 to-purple-600 rounded-2xl flex items-center justify-center shadow-xl mx-auto mb-4 group-hover:shadow-2xl transition-all duration-300">
                                                    <span class="text-white font-bold text-xl">DB</span>
                                                </div>
                                                <h4 class="text-lg font-bold text-gray-900 mb-2">Dashen Transfer</h4>
                                                <p class="text-gray-600 font-medium mb-3">Direct Bank Transfer</p>
                                                <div class="space-y-2">
                                                    <span class="inline-block bg-purple-100 text-purple-800 text-xs font-bold px-2 py-1 rounded-full">💎 Premium</span>
                                                    <p class="text-sm text-gray-500">Processing: <strong class="text-yellow-600">1-2 Days</strong></p>
                                                </div>
                                                <div class="radio-indicator mx-auto mt-4"></div>
                                            </div>
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <!-- Payment Method Information -->
                            <div class="mb-8 bg-gradient-to-r from-blue-50 to-indigo-50 rounded-2xl p-6 border border-blue-100">
                                <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center">
                                    <svg class="w-6 h-6 text-blue-600 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                                    </svg>
                                    Payment Method Information
                                </h3>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 text-sm">
                                    <div>
                                        <h4 class="font-bold text-blue-900 mb-2">📱 Mobile Banking Benefits:</h4>
                                        <ul class="space-y-1 text-blue-800">
                                            <li>• Instant payment confirmation</li>
                                            <li>• 24/7 availability</li>
                                            <li>• No additional fees</li>
                                            <li>• Secure authentication</li>
                                        </ul>
                                    </div>
                                    <div>
                                        <h4 class="font-bold text-blue-900 mb-2">🏦 Bank Transfer Benefits:</h4>
                                        <ul class="space-y-1 text-blue-800">
                                            <li>• Traditional and reliable</li>
                                            <li>• Large amount transfers</li>
                                            <li>• Bank-to-bank security</li>
                                            <li>• Official transaction records</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>

                            <!-- Enhanced Terms and Conditions -->
                            <div class="bg-gradient-to-r from-gray-50 to-blue-50 rounded-2xl p-8 mb-8 border border-gray-200">
                                <div class="flex items-start">
                                    <div class="flex-shrink-0 mt-1">
                                        <input id="terms_accepted" 
                                               name="terms_accepted" 
                                               type="checkbox" 
                                               required
                                               class="h-6 w-6 text-blue-600 border-2 border-gray-300 rounded-lg focus:ring-blue-500 focus:ring-2 transition-all duration-200">
                                    </div>
                                    <div class="ml-6">
                                        <label for="terms_accepted" class="text-xl font-bold text-gray-900 cursor-pointer flex items-center">
                                            <svg class="w-6 h-6 text-blue-600 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M6 2a2 2 0 00-2 2v12a2 2 0 002 2h8a2 2 0 002-2V4a2 2 0 00-2-2H6zm1 2a1 1 0 000 2h6a1 1 0 100-2H7zM7 8a1 1 0 000 2h6a1 1 0 100-2H7zm0 4a1 1 0 100 2h6a1 1 0 100-2H7z" clip-rule="evenodd"/>
                                            </svg>
                                            I agree to the Terms and Conditions 
                                            <span class="text-red-500 ml-2 text-2xl">*</span>
                                        </label>
                                        <div class="mt-4 p-4 bg-white rounded-xl border border-gray-200">
                                            <p class="text-gray-700 leading-relaxed">
                                                By checking this box, I confirm that I understand and accept all terms and conditions 
                                                for this vehicle purchase. I agree to pay the total amount shown and understand 
                                                the payment processing times for my selected payment method.
                                            </p>
                                            <div class="flex items-center justify-between mt-4">
                                                <button type="button" 
                                                        class="text-blue-600 hover:text-blue-800 font-bold underline flex items-center transition-colors" 
                                                        onclick="toggleTermsModal()">
                                                    <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4zm2 6a1 1 0 011-1h6a1 1 0 110 2H7a1 1 0 01-1-1zm1 3a1 1 0 100 2h6a1 1 0 100-2H7z" clip-rule="evenodd"/>
                                                    </svg>
                                                    📄 Read Full Terms and Conditions
                                                </button>
                                                <div class="flex items-center text-sm text-gray-500">
                                                    <svg class="w-4 h-4 mr-1 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"/>
                                                    </svg>
                                                    Legally binding agreement
                                                </div>
                                            </div>
                                        </div>
                                        @error('terms_accepted')
                                            <div class="mt-3 p-3 bg-red-50 border border-red-200 rounded-lg">
                                                <p class="text-red-600 font-medium flex items-center">
                                                    <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                                    </svg>
                                                    {{ $message }}
                                                </p>
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <!-- Enhanced Security Notice -->
                            <div class="bg-gradient-to-r from-green-50 to-emerald-50 border-2 border-green-200 rounded-2xl p-8 shadow-lg">
                                <div class="flex items-start">
                                    <div class="flex-shrink-0">
                                        <div class="w-16 h-16 bg-gradient-to-br from-green-500 to-green-600 rounded-2xl flex items-center justify-center shadow-xl">
                                            <svg class="h-8 w-8 text-white" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"/>
                                            </svg>
                                        </div>
                                    </div>
                                    <div class="ml-6">
                                        <h3 class="text-2xl font-bold text-green-800 flex items-center mb-3">
                                            🔒 100% Secure Payment Guarantee
                                        </h3>
                                        <div class="space-y-3 text-green-700">
                                            <p class="text-lg leading-relaxed">
                                                All payments are processed securely through verified Ethiopian banking systems. 
                                                Your financial information is protected with military-grade encryption and security protocols.
                                            </p>
                                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-6">
                                                <div class="flex items-center bg-white bg-opacity-60 rounded-lg p-3">
                                                    <svg class="w-6 h-6 text-green-600 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd" d="M2.166 4.999A11.954 11.954 0 0010 1.944 11.954 11.954 0 0017.834 5c.11.65.166 1.32.166 2.001 0 5.225-3.34 9.67-8 11.317C5.34 16.67 2 12.225 2 7c0-.682.057-1.35.166-2.001zm11.541 3.708a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                                    </svg>
                                                    <span class="font-semibold">Bank Verified</span>
                                                </div>
                                                <div class="flex items-center bg-white bg-opacity-60 rounded-lg p-3">
                                                    <svg class="w-6 h-6 text-green-600 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"/>
                                                    </svg>
                                                    <span class="font-semibold">SSL Encrypted</span>
                                                </div>
                                                <div class="flex items-center bg-white bg-opacity-60 rounded-lg p-3">
                                                    <svg class="w-6 h-6 text-green-600 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                                        <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                                    </svg>
                                                    <span class="font-semibold">Fraud Protected</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Enhanced Action Buttons -->
                    <div class="mt-10 bg-white rounded-2xl p-6 shadow-lg border border-gray-100">
                        <div class="flex flex-col sm:flex-row items-center justify-between space-y-4 sm:space-y-0">
                            <a href="{{ route('checkout.cancel') }}" 
                               class="text-gray-500 hover:text-red-600 font-bold flex items-center transition-colors group">
                                <svg class="w-5 h-5 mr-2 group-hover:text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                                Cancel Purchase
                            </a>
                            <div class="flex space-x-4">
                                <button type="button" 
                                        onclick="history.back()" 
                                        class="bg-gray-100 hover:bg-gray-200 border-2 border-gray-300 rounded-xl py-4 px-8 font-bold text-gray-700 transition-all duration-200 flex items-center shadow-md hover:shadow-lg">
                                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                                    </svg>
                                    Back to Delivery
                                </button>
                                <button type="submit" 
                                        id="continueButton"
                                        class="bg-gradient-to-r from-blue-600 via-blue-700 to-indigo-700 hover:from-blue-700 hover:via-blue-800 hover:to-indigo-800 text-white font-bold py-4 px-10 rounded-xl transition-all duration-200 transform hover:scale-105 shadow-xl hover:shadow-2xl flex items-center disabled:opacity-50 disabled:cursor-not-allowed disabled:transform-none">
                                    <span class="mr-3">Continue to Payment Instructions</span>
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                    </svg>
                                </button>
                            </div>
                        </div>
                        
                        <!-- Payment Method Summary -->
                        <div id="paymentSummary" class="mt-6 p-4 bg-blue-50 rounded-xl border border-blue-200 hidden">
                            <div class="flex items-center">
                                <svg class="w-6 h-6 text-blue-600 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                </svg>
                                <div>
                                    <p class="font-bold text-blue-900">Selected Payment Method:</p>
                                    <p id="selectedMethodText" class="text-blue-700"></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Enhanced Order Summary Sidebar -->
                <div class="xl:col-span-1">
                    <div class="bg-white shadow-2xl rounded-2xl overflow-hidden sticky top-6 border border-gray-100">
                        <div class="px-6 py-6 bg-gradient-to-r from-gray-800 via-gray-900 to-black">
                            <h3 class="text-2xl font-bold text-white flex items-center">
                                <svg class="w-8 h-8 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z"/>
                                    <path fill-rule="evenodd" d="M4 5a2 2 0 012-2v1a2 2 0 002 2h4a2 2 0 002-2V3a2 2 0 012 2v6.5a1.5 1.5 0 01-1.5 1.5h-9A1.5 1.5 0 014 11.5V5zM7.5 6.5a1 1 0 11-2 0 1 1 0 012 0zm5 0a1 1 0 11-2 0 1 1 0 012 0zm-5 4a1 1 0 11-2 0 1 1 0 012 0zm5 0a1 1 0 11-2 0 1 1 0 012 0z" clip-rule="evenodd"/>
                                </svg>
                                Order Summary
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
                                            <path fill-rule="evenodd" d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z" clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                @endif
                                <div class="flex-1">
                                    <p class="font-bold text-gray-900 text-lg">{{ $vehicle->full_name }}</p>
                                    <p class="text-gray-600 font-medium">{{ $vehicle->year }} • {{ $vehicle->fuel_type }}</p>
                                    <div class="flex items-center mt-2">
                                        <span class="bg-green-100 text-green-800 text-xs font-bold px-2 py-1 rounded-full">✅ Available</span>
                                    </div>
                                </div>
                            </div>

                            @php
                                $checkout = Session::get('checkout');
                                $deliveryCost = $checkout['delivery_info']['delivery_cost'] ?? 0;
                                $salePrice = $vehicle->sale_price;
                                $taxAmount = ($salePrice + $deliveryCost) * 0.15;
                                $totalAmount = $salePrice + $deliveryCost + $taxAmount;
                            @endphp

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

                            <!-- Payment Security Info -->
                            <div class="bg-gradient-to-r from-blue-50 to-indigo-50 border-2 border-blue-200 rounded-2xl p-6 mb-6">
                                <div class="flex items-start">
                                    <div class="flex-shrink-0">
                                        <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl flex items-center justify-center shadow-lg">
                                            <svg class="h-6 w-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                            </svg>
                                        </div>
                                    </div>
                                    <div class="ml-4">
                                        <h4 class="font-bold text-blue-900 text-lg">Secure Payment</h4>
                                        <p class="text-blue-800 text-sm mt-2 leading-relaxed">
                                            All payment methods are secure and verified by Ethiopian banking authorities. 
                                            Your transaction is protected with advanced encryption.
                                        </p>
                                        <div class="flex items-center mt-3 space-x-3">
                                            <span class="bg-blue-100 text-blue-800 text-xs font-bold px-2 py-1 rounded-full">🔒 SSL</span>
                                            <span class="bg-blue-100 text-blue-800 text-xs font-bold px-2 py-1 rounded-full">🏦 Bank Verified</span>
                                        </div>
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
                                    Our customer support team is available 24/7 to assist with your purchase.
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
        </form>

        <!-- Terms and Conditions Modal -->
        <div id="termsModal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50 flex items-center justify-center p-4">
            <div class="bg-white rounded-xl max-w-4xl w-full max-h-[90vh] overflow-hidden">
                <div class="px-6 py-4 bg-gradient-to-r from-blue-600 to-blue-700 flex justify-between items-center">
                    <h3 class="text-xl font-bold text-white">📜 Terms and Conditions</h3>
                    <button type="button" onclick="toggleTermsModal()" class="text-white hover:text-gray-200">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
                <div class="p-6 overflow-y-auto max-h-[70vh]">
                    <div class="space-y-6 text-sm text-gray-700">
                        <div>
                            <h4 class="font-bold text-gray-900 text-lg mb-2">1. Vehicle Purchase Agreement</h4>
                            <p>By proceeding with this purchase, you agree to buy the specified vehicle at the agreed price. This agreement is binding once payment is confirmed.</p>
                        </div>
                        
                        <div>
                            <h4 class="font-bold text-gray-900 text-lg mb-2">2. Payment Terms</h4>
                            <p>Full payment is required before vehicle delivery. Payment must be made within 24 hours of completing this checkout process. Failure to complete payment may result in cancellation.</p>
                        </div>
                        
                        <div>
                            <h4 class="font-bold text-gray-900 text-lg mb-2">3. Vehicle Condition</h4>
                            <p>The vehicle is sold in its current condition as described. A thorough inspection will be conducted during handover. Any concerns must be raised at the time of delivery.</p>
                        </div>
                        
                        <div>
                            <h4 class="font-bold text-gray-900 text-lg mb-2">4. Delivery Terms</h4>
                            <p>Delivery dates are estimates and may vary due to circumstances beyond our control. We will notify you of any delays. Delivery fees are non-refundable once the vehicle is dispatched.</p>
                        </div>
                        
                        <div>
                            <h4 class="font-bold text-gray-900 text-lg mb-2">5. Documentation</h4>
                            <p>All necessary documentation including registration, insurance, and ownership transfer will be provided. You are responsible for updating registration details with local authorities.</p>
                        </div>
                        
                        <div>
                            <h4 class="font-bold text-gray-900 text-lg mb-2">6. Warranty</h4>
                            <p>Used vehicles are sold with a 30-day limited warranty covering major mechanical issues. Warranty does not cover normal wear and tear, accidents, or misuse.</p>
                        </div>
                        
                        <div>
                            <h4 class="font-bold text-gray-900 text-lg mb-2">7. Cancellation Policy</h4>
                            <p>Cancellations are allowed within 2 hours of completing this checkout process. After payment verification begins, cancellations may incur processing fees.</p>
                        </div>
                        
                        <div>
                            <h4 class="font-bold text-gray-900 text-lg mb-2">8. Liability</h4>
                            <p>Our liability is limited to the purchase price of the vehicle. We are not responsible for any indirect or consequential damages.</p>
                        </div>
                    </div>
                </div>
                <div class="px-6 py-4 bg-gray-50 border-t flex justify-end">
                    <button type="button" onclick="toggleTermsModal()" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded-lg">
                        Close
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.payment-option {
    position: relative;
    transition: all 0.3s ease;
}

.payment-label {
    display: block;
    padding: 2rem;
    border: 3px solid #e5e7eb;
    border-radius: 1rem;
    cursor: pointer;
    transition: all 0.3s ease;
    background: white;
    position: relative;
    overflow: hidden;
}

.payment-label::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(59, 130, 246, 0.1), transparent);
    transition: left 0.5s ease;
}

.payment-label:hover {
    border-color: #9ca3af;
    box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
    transform: translateY(-2px);
}

.payment-label:hover::before {
    left: 100%;
}

.payment-label.selected {
    border-color: #3b82f6;
    background: linear-gradient(135deg, #eff6ff 0%, #dbeafe 100%);
    box-shadow: 0 20px 25px -5px rgba(59, 130, 246, 0.1), 0 10px 10px -5px rgba(59, 130, 246, 0.04);
    transform: translateY(-2px);
}

.payment-label.selected::after {
    content: '';
    position: absolute;
    top: 1rem;
    right: 1rem;
    width: 2rem;
    height: 2rem;
    background: linear-gradient(135deg, #3b82f6, #1d4ed8);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
}

.payment-label.selected::after {
    background-image: url("data:image/svg+xml,%3csvg viewBox='0 0 16 16' fill='white' xmlns='http://www.w3.org/2000/svg'%3e%3cpath d='m13.854 3.646-7.5 7.5a.5.5 0 0 1-.708 0l-3.5-3.5a.5.5 0 1 1 .708-.708L6 10.293l7.146-7.147a.5.5 0 0 1 .708.708z'/%3e%3c/svg%3e");
    background-repeat: no-repeat;
    background-position: center;
    background-size: 1rem;
}

.radio-indicator {
    width: 1.5rem;
    height: 1.5rem;
    border: 3px solid #d1d5db;
    border-radius: 50%;
    position: relative;
    transition: all 0.3s ease;
    background: white;
}

.payment-label.selected .radio-indicator {
    border-color: #3b82f6;
    background: linear-gradient(135deg, #3b82f6, #1d4ed8);
    box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.2);
}

.payment-label.selected .radio-indicator::after {
    content: '';
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    width: 0.5rem;
    height: 0.5rem;
    background: white;
    border-radius: 50%;
}

/* Enhanced checkbox styling */
#terms_accepted {
    appearance: none;
    background-color: white;
    border: 3px solid #d1d5db;
    border-radius: 0.5rem;
    cursor: pointer;
    position: relative;
    transition: all 0.3s ease;
}

#terms_accepted:checked {
    background: linear-gradient(135deg, #3b82f6, #1d4ed8);
    border-color: #3b82f6;
    box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.2);
}

#terms_accepted:checked::after {
    content: '';
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    width: 0.75rem;
    height: 0.75rem;
    background-image: url("data:image/svg+xml,%3csvg viewBox='0 0 16 16' fill='white' xmlns='http://www.w3.org/2000/svg'%3e%3cpath d='m13.854 3.646-7.5 7.5a.5.5 0 0 1-.708 0l-3.5-3.5a.5.5 0 1 1 .708-.708L6 10.293l7.146-7.147a.5.5 0 0 1 .708.708z'/%3e%3c/svg%3e");
    background-repeat: no-repeat;
    background-position: center;
    background-size: contain;
}

/* Button animations */
button[type="submit"] {
    position: relative;
    overflow: hidden;
}

button[type="submit"]:not(:disabled):hover {
    animation: pulse 2s infinite;
}

@keyframes pulse {
    0%, 100% { transform: scale(1); }
    50% { transform: scale(1.05); }
}

/* Loading state */
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
    .payment-label {
        padding: 1.5rem;
    }
    
    .payment-label.selected::after {
        top: 0.75rem;
        right: 0.75rem;
        width: 1.5rem;
        height: 1.5rem;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('paymentForm');
    const termsCheckbox = document.getElementById('terms_accepted');
    const radioButtons = document.querySelectorAll('input[name="payment_method"]');
    const continueButton = document.getElementById('continueButton');
    const paymentSummary = document.getElementById('paymentSummary');
    const selectedMethodText = document.getElementById('selectedMethodText');
    
    // Payment method descriptions
    const paymentMethods = {
        'cbe_mobile': {
            name: 'Commercial Bank of Ethiopia - Mobile Banking',
            processing: 'Instant',
            description: 'Pay instantly using CBE Birr, HelloCash, or M-Birr'
        },
        'telebirr': {
            name: 'Telebirr Mobile Payment',
            processing: 'Instant', 
            description: 'Fast and secure payment via Ethio Telecom'
        },
        'abyssinia_mobile': {
            name: 'Bank of Abyssinia - Mobile Banking',
            processing: 'Instant',
            description: 'Secure mobile banking payment'
        },
        'dashen_mobile': {
            name: 'Dashen Bank - Mobile Banking',
            processing: 'Instant',
            description: 'Premium mobile banking experience'
        },
        'cbe_transfer': {
            name: 'CBE Bank Transfer',
            processing: '1-2 Business Days',
            description: 'Traditional bank transfer method'
        },
        'abyssinia_transfer': {
            name: 'Abyssinia Bank Transfer',
            processing: '1-2 Business Days',
            description: 'Secure bank-to-bank transfer'
        },
        'dashen_transfer': {
            name: 'Dashen Bank Transfer',
            processing: '1-2 Business Days',
            description: 'Premium bank transfer service'
        }
    };
    
    // Handle radio button selection with enhanced feedback
    radioButtons.forEach(radio => {
        radio.addEventListener('change', function() {
            // Remove selected class from all labels
            document.querySelectorAll('.payment-label').forEach(label => {
                label.classList.remove('selected');
            });
            
            // Add selected class to chosen option with animation
            const selectedLabel = document.querySelector(`label[for="${this.id}"]`);
            selectedLabel.classList.add('selected');
            
            // Update payment summary
            const methodInfo = paymentMethods[this.value];
            if (methodInfo) {
                selectedMethodText.innerHTML = `
                    <strong>${methodInfo.name}</strong><br>
                    <span class="text-sm">${methodInfo.description}</span><br>
                    <span class="text-xs bg-blue-100 text-blue-800 px-2 py-1 rounded-full mt-1 inline-block">
                        Processing: ${methodInfo.processing}
                    </span>
                `;
                paymentSummary.classList.remove('hidden');
                
                // Animate the summary appearance
                paymentSummary.style.opacity = '0';
                paymentSummary.style.transform = 'translateY(10px)';
                setTimeout(() => {
                    paymentSummary.style.transition = 'all 0.3s ease';
                    paymentSummary.style.opacity = '1';
                    paymentSummary.style.transform = 'translateY(0)';
                }, 10);
            }
            
            // Update button state
            updateButtonState();
            
            // Scroll to show the selection (mobile friendly)
            if (window.innerWidth < 768) {
                selectedLabel.scrollIntoView({ 
                    behavior: 'smooth', 
                    block: 'center' 
                });
            }
        });
    });
    
    // Initialize with CBE selected
    document.getElementById('cbe_mobile').dispatchEvent(new Event('change'));
    
    // Enhanced terms checkbox handling
    termsCheckbox.addEventListener('change', function() {
        updateButtonState();
        
        if (this.checked) {
            // Remove any existing error messages
            const errorMsg = document.querySelector('.terms-error');
            if (errorMsg) {
                errorMsg.remove();
            }
            
            const checkboxContainer = this.closest('.bg-gradient-to-r');
            checkboxContainer.classList.remove('bg-red-50', 'border-red-300');
            
            // Add success animation
            this.style.transform = 'scale(1.1)';
            setTimeout(() => {
                this.style.transform = 'scale(1)';
            }, 200);
        }
    });
    
    // Update button state based on form validity
    function updateButtonState() {
        const isValid = termsCheckbox.checked && document.querySelector('input[name="payment_method"]:checked');
        
        if (isValid) {
            continueButton.disabled = false;
            continueButton.classList.remove('opacity-50', 'cursor-not-allowed');
            continueButton.classList.add('hover:scale-105');
        } else {
            continueButton.disabled = true;
            continueButton.classList.add('opacity-50', 'cursor-not-allowed');
            continueButton.classList.remove('hover:scale-105');
        }
    }
    
    // Enhanced form validation with better UX
    form.addEventListener('submit', function(e) {
        const selectedPaymentMethod = document.querySelector('input[name="payment_method"]:checked');
        
        if (!termsCheckbox.checked) {
            e.preventDefault();
            showTermsError();
            return;
        }
        
        if (!selectedPaymentMethod) {
            e.preventDefault();
            showPaymentMethodError();
            return;
        }
        
        // Show loading state
        showLoadingState();
        
        // Add a small delay to show the loading state
        setTimeout(() => {
            // Form will submit naturally after this
        }, 500);
    });
    
    function showTermsError() {
        termsCheckbox.focus();
        
        // Highlight the checkbox area
        const checkboxContainer = termsCheckbox.closest('.bg-gradient-to-r');
        checkboxContainer.classList.add('bg-red-50', 'border-red-300');
        
        // Remove existing error message
        const existingError = document.querySelector('.terms-error');
        if (existingError) {
            existingError.remove();
        }
        
        // Show enhanced error message
        const errorMsg = document.createElement('div');
        errorMsg.className = 'mt-4 p-4 bg-red-50 border-2 border-red-200 rounded-xl terms-error animate-pulse';
        errorMsg.innerHTML = `
            <div class="flex items-center">
                <svg class="w-6 h-6 text-red-600 mr-3" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                </svg>
                <div>
                    <p class="text-red-800 font-bold">Terms and Conditions Required</p>
                    <p class="text-red-600 text-sm mt-1">You must accept the terms and conditions to continue with your purchase.</p>
                </div>
            </div>
        `;
        checkboxContainer.appendChild(errorMsg);
        
        // Auto-remove error after 5 seconds
        setTimeout(() => {
            if (errorMsg.parentNode) {
                errorMsg.remove();
                checkboxContainer.classList.remove('bg-red-50', 'border-red-300');
            }
        }, 5000);
        
        // Scroll to error
        checkboxContainer.scrollIntoView({ 
            behavior: 'smooth', 
            block: 'center' 
        });
    }
    
    function showPaymentMethodError() {
        // Scroll to payment methods
        document.querySelector('.payment-option').scrollIntoView({ 
            behavior: 'smooth', 
            block: 'start' 
        });
        
        // Highlight all payment options briefly
        document.querySelectorAll('.payment-label').forEach(label => {
            label.style.borderColor = '#ef4444';
            setTimeout(() => {
                if (!label.classList.contains('selected')) {
                    label.style.borderColor = '#e5e7eb';
                }
            }, 2000);
        });
    }
    
    function showLoadingState() {
        continueButton.classList.add('loading');
        continueButton.innerHTML = `
            <span class="opacity-0">Continue to Payment Instructions</span>
            <div class="absolute inset-0 flex items-center justify-center">
                <svg class="animate-spin h-6 w-6 text-white" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
            </div>
        `;
    }
    
    // Initialize button state
    updateButtonState();
    
    // Add keyboard navigation
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Enter' && e.target.type === 'radio') {
            e.target.dispatchEvent(new Event('change'));
        }
    });
    
    // Add smooth scrolling for mobile
    if (window.innerWidth < 768) {
        radioButtons.forEach(radio => {
            radio.addEventListener('focus', function() {
                this.closest('.payment-option').scrollIntoView({ 
                    behavior: 'smooth', 
                    block: 'center' 
                });
            });
        });
    }
});

function toggleTermsModal() {
    const modal = document.getElementById('termsModal');
    modal.classList.toggle('hidden');
    
    // Add/remove body scroll lock
    if (modal.classList.contains('hidden')) {
        document.body.style.overflow = '';
    } else {
        document.body.style.overflow = 'hidden';
    }
}

// Close modal on escape key
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        const modal = document.getElementById('termsModal');
        if (!modal.classList.contains('hidden')) {
            toggleTermsModal();
        }
    }
});
</script>
@endsection