@extends('layouts.app')

@section('title', 'Purchase Checkout - Buyer Information')

@section('content')
<div class="bg-gray-50 min-h-screen">
    <div class="max-w-4xl mx-auto py-6 sm:px-6 lg:px-8">
        <!-- Progress Bar -->
        <div class="mb-8">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-4">
                    <div class="flex items-center text-sm text-green-600">
                        <span class="flex items-center justify-center w-8 h-8 bg-green-600 text-white rounded-full">✓</span>
                        <span class="ml-2">Vehicle</span>
                    </div>
                    <div class="flex items-center text-sm text-blue-600">
                        <span class="flex items-center justify-center w-8 h-8 bg-blue-600 text-white rounded-full">2</span>
                        <span class="ml-2 font-medium">Buyer Information</span>
                    </div>
                    <div class="flex items-center text-sm text-gray-400">
                        <span class="flex items-center justify-center w-8 h-8 bg-gray-300 text-gray-600 rounded-full">3</span>
                        <span class="ml-2">Delivery</span>
                    </div>
                    <div class="flex items-center text-sm text-gray-400">
                        <span class="flex items-center justify-center w-8 h-8 bg-gray-300 text-gray-600 rounded-full">4</span>
                        <span class="ml-2">Payment Method</span>
                    </div>
                    <div class="flex items-center text-sm text-gray-400">
                        <span class="flex items-center justify-center w-8 h-8 bg-gray-300 text-gray-600 rounded-full">5</span>
                        <span class="ml-2">Payment</span>
                    </div>
                </div>
            </div>
            <div class="mt-4 w-full bg-gray-200 rounded-full h-2">
                <div class="bg-blue-600 h-2 rounded-full" style="width: 40%"></div>
            </div>
        </div>

        <!-- Page Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">Buyer Information</h1>
            <p class="mt-2 text-sm text-gray-600">Please provide your contact and identification details</p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Buyer Information Form -->
            <div class="lg:col-span-2">
                <form method="POST" action="{{ route('checkout.stage2.process') }}">
                    @csrf
                    <div class="bg-white shadow rounded-lg">
                        <div class="px-6 py-4 border-b border-gray-200">
                            <h2 class="text-lg font-medium text-gray-900">Personal Information</h2>
                            <p class="mt-1 text-sm text-gray-600">This information will be used for the vehicle registration and delivery</p>
                        </div>

                        <div class="p-6 space-y-6">
                            <!-- Full Name -->
                            <div>
                                <label for="full_name" class="block text-sm font-medium text-gray-700">
                                    Full Name <span class="text-red-500">*</span>
                                </label>
                                <input type="text" 
                                       id="full_name" 
                                       name="full_name" 
                                       value="{{ old('full_name', auth()->user()->name ?? '') }}"
                                       required
                                       class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                                @error('full_name')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Phone Number -->
                            <div>
                                <label for="phone" class="block text-sm font-medium text-gray-700">
                                    Phone Number <span class="text-red-500">*</span>
                                </label>
                                <div class="mt-1 relative rounded-md shadow-sm">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <span class="text-gray-500 sm:text-sm">+251</span>
                                    </div>
                                    <input type="tel" 
                                           id="phone" 
                                           name="phone" 
                                           value="{{ old('phone') }}"
                                           placeholder="911-000-000"
                                           required
                                           class="block w-full pl-12 border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                                </div>
                                @error('phone')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Email -->
                            <div>
                                <label for="email" class="block text-sm font-medium text-gray-700">
                                    Email Address <span class="text-red-500">*</span>
                                </label>
                                <input type="email" 
                                       id="email" 
                                       name="email" 
                                       value="{{ old('email', auth()->user()->email ?? '') }}"
                                       required
                                       class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                                @error('email')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- City -->
                            <div>
                                <label for="city" class="block text-sm font-medium text-gray-700">
                                    City <span class="text-red-500">*</span>
                                </label>
                                <select id="city" 
                                        name="city" 
                                        required
                                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                                    <option value="">Select your city</option>
                                    <option value="Addis Ababa" {{ old('city') === 'Addis Ababa' ? 'selected' : '' }}>Addis Ababa</option>
                                    <option value="Dire Dawa" {{ old('city') === 'Dire Dawa' ? 'selected' : '' }}>Dire Dawa</option>
                                    <option value="Mekelle" {{ old('city') === 'Mekelle' ? 'selected' : '' }}>Mekelle</option>
                                    <option value="Gondar" {{ old('city') === 'Gondar' ? 'selected' : '' }}>Gondar</option>
                                    <option value="Dessie" {{ old('city') === 'Dessie' ? 'selected' : '' }}>Dessie</option>
                                    <option value="Jimma" {{ old('city') === 'Jimma' ? 'selected' : '' }}>Jimma</option>
                                    <option value="Jijiga" {{ old('city') === 'Jijiga' ? 'selected' : '' }}>Jijiga</option>
                                    <option value="Shashamane" {{ old('city') === 'Shashamane' ? 'selected' : '' }}>Shashamane</option>
                                    <option value="Bahir Dar" {{ old('city') === 'Bahir Dar' ? 'selected' : '' }}>Bahir Dar</option>
                                    <option value="Hawassa" {{ old('city') === 'Hawassa' ? 'selected' : '' }}>Hawassa</option>
                                </select>
                                @error('city')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- National ID (Optional) -->
                            <div>
                                <label for="national_id" class="block text-sm font-medium text-gray-700">
                                    National ID Number
                                    <span class="text-gray-500 text-xs">(Optional - for faster processing)</span>
                                </label>
                                <input type="text" 
                                       id="national_id" 
                                       name="national_id" 
                                       value="{{ old('national_id') }}"
                                       placeholder="Enter your national ID number"
                                       class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                                @error('national_id')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                                <p class="mt-2 text-sm text-gray-500">
                                    Providing your National ID helps us process your purchase faster and ensures compliance with vehicle registration requirements.
                                </p>
                            </div>
                        </div>

                        <!-- Privacy Notice -->
                        <div class="px-6 py-4 bg-gray-50 border-t border-gray-200">
                            <div class="flex items-start">
                                <div class="flex-shrink-0">
                                    <svg class="h-5 w-5 text-blue-400" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <h3 class="text-sm font-medium text-gray-900">🔒 Privacy & Security</h3>
                                    <div class="mt-2 text-sm text-gray-600">
                                        <p>Your personal information is encrypted and securely stored. We only use this data for vehicle registration, delivery, and customer service purposes. We never share your information with third parties.</p>
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
                                ← Back
                            </button>
                            <button type="submit" class="bg-blue-600 border border-transparent rounded-md py-2 px-6 text-sm font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                Continue to Delivery Options →
                            </button>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Order Summary -->
            <div class="lg:col-span-1">
                <div class="bg-white shadow rounded-lg p-6 sticky top-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Order Summary</h3>
                    
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
                            <span class="text-sm font-medium text-gray-900">${{ number_format($vehicle->sale_price, 2) }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-sm text-gray-600">Delivery</span>
                            <span class="text-sm text-gray-600">To be determined</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-sm text-gray-600">Tax (15%)</span>
                            <span class="text-sm text-gray-600">To be calculated</span>
                        </div>
                        <div class="border-t border-gray-200 pt-3">
                            <div class="flex justify-between">
                                <span class="text-base font-medium text-gray-900">Starting from</span>
                                <span class="text-base font-medium text-gray-900">${{ number_format($vehicle->sale_price, 2) }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Progress Indicator -->
                    <div class="bg-blue-50 border border-blue-200 rounded-md p-3">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-blue-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-sm font-medium text-blue-800">Step 2 of 5</h3>
                                <div class="mt-2 text-sm text-blue-700">
                                    <p>Provide your contact information to continue with the purchase process.</p>
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
    // Phone number formatting
    const phoneInput = document.getElementById('phone');
    phoneInput.addEventListener('input', function(e) {
        let value = e.target.value.replace(/\D/g, '');
        if (value.length >= 3 && value.length <= 6) {
            value = value.replace(/(\d{3})(\d+)/, '$1-$2');
        } else if (value.length > 6) {
            value = value.replace(/(\d{3})(\d{3})(\d+)/, '$1-$2-$3');
        }
        e.target.value = value;
    });

    // Form validation
    const form = document.querySelector('form');
    form.addEventListener('submit', function(e) {
        const requiredFields = ['full_name', 'phone', 'email', 'city'];
        let isValid = true;

        requiredFields.forEach(fieldName => {
            const field = document.getElementById(fieldName);
            const value = field.value.trim();
            
            if (!value) {
                isValid = false;
                field.classList.add('border-red-500');
                
                // Show error message if not already present
                if (!field.nextElementSibling || !field.nextElementSibling.classList.contains('text-red-600')) {
                    const errorMsg = document.createElement('p');
                    errorMsg.className = 'mt-2 text-sm text-red-600';
                    errorMsg.textContent = 'This field is required.';
                    field.parentNode.insertBefore(errorMsg, field.nextSibling);
                }
            } else {
                field.classList.remove('border-red-500');
                // Remove error message if present
                if (field.nextElementSibling && field.nextElementSibling.classList.contains('text-red-600')) {
                    field.nextElementSibling.remove();
                }
            }
        });

        // Email validation
        const emailField = document.getElementById('email');
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (emailField.value && !emailRegex.test(emailField.value)) {
            isValid = false;
            emailField.classList.add('border-red-500');
        }

        if (!isValid) {
            e.preventDefault();
            // Scroll to first error
            const firstError = document.querySelector('.border-red-500');
            if (firstError) {
                firstError.scrollIntoView({ behavior: 'smooth', block: 'center' });
            }
        }
    });
});
</script>
@endsection