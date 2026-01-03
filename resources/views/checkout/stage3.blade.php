@extends('layouts.app')

@section('title', 'Purchase Checkout - Delivery Options')

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
                    <div class="flex items-center text-sm text-green-600">
                        <span class="flex items-center justify-center w-8 h-8 bg-green-600 text-white rounded-full">✓</span>
                        <span class="ml-2">Buyer Info</span>
                    </div>
                    <div class="flex items-center text-sm text-blue-600">
                        <span class="flex items-center justify-center w-8 h-8 bg-blue-600 text-white rounded-full">3</span>
                        <span class="ml-2 font-medium">Delivery Options</span>
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
                <div class="bg-blue-600 h-2 rounded-full" style="width: 60%"></div>
            </div>
        </div>

        <!-- Page Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">Delivery & Pickup Options</h1>
            <p class="mt-2 text-sm text-gray-600">Choose how you would like to receive your vehicle</p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Delivery Options Form -->
            <div class="lg:col-span-2">
                <form method="POST" action="{{ route('checkout.stage3.process') }}">
                    @csrf
                    <div class="bg-white shadow rounded-lg">
                        <div class="px-6 py-4 border-b border-gray-200">
                            <h2 class="text-lg font-medium text-gray-900">Delivery Method</h2>
                            <p class="mt-1 text-sm text-gray-600">Select your preferred delivery option</p>
                        </div>

                        <div class="p-6 space-y-6">
                            <!-- Delivery Options -->
                            <div class="space-y-4">
                                <!-- Pickup Option -->
                                <div class="relative">
                                    <input type="radio" id="pickup" name="delivery_option" value="pickup" class="sr-only" checked>
                                    <label for="pickup" class="flex items-center p-4 border-2 border-green-200 bg-green-50 rounded-lg cursor-pointer hover:bg-green-100 transition-colors">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0">
                                                <div class="w-12 h-12 bg-green-600 rounded-lg flex items-center justify-center">
                                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                                    </svg>
                                                </div>
                                            </div>
                                            <div class="ml-4">
                                                <h3 class="text-lg font-medium text-gray-900">🏢 Pickup from Showroom</h3>
                                                <p class="text-sm text-gray-600">Come to our showroom to collect your vehicle</p>
                                                <div class="mt-2 flex items-center space-x-2">
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                        ✅ FREE
                                                    </span>
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                                        Recommended
                                                    </span>
                                                </div>
                                                <p class="mt-2 text-xs text-gray-500">
                                                    📍 Location: Bole Road, Addis Ababa<br>
                                                    🕒 Hours: Mon-Sat 8:00 AM - 6:00 PM
                                                </p>
                                            </div>
                                        </div>
                                        <div class="ml-auto">
                                            <div class="w-4 h-4 border-2 border-green-600 rounded-full bg-green-600 flex items-center justify-center">
                                                <div class="w-2 h-2 bg-white rounded-full"></div>
                                            </div>
                                        </div>
                                    </label>
                                </div>

                                <!-- Company Delivery -->
                                <div class="relative">
                                    <input type="radio" id="company_delivery" name="delivery_option" value="company_delivery" class="sr-only">
                                    <label for="company_delivery" class="flex items-center p-4 border-2 border-gray-200 rounded-lg cursor-pointer hover:bg-gray-50 transition-colors">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0">
                                                <div class="w-12 h-12 bg-blue-600 rounded-lg flex items-center justify-center">
                                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4" />
                                                    </svg>
                                                </div>
                                            </div>
                                            <div class="ml-4">
                                                <h3 class="text-lg font-medium text-gray-900">🚚 Company Delivery</h3>
                                                <p class="text-sm text-gray-600">We deliver to your location within Addis Ababa</p>
                                                <div class="mt-2">
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                                        $500 delivery fee
                                                    </span>
                                                </div>
                                                <p class="mt-2 text-xs text-gray-500">
                                                    📦 Delivery within 2-3 business days<br>
                                                    🛡️ Fully insured transport
                                                </p>
                                            </div>
                                        </div>
                                        <div class="ml-auto">
                                            <div class="w-4 h-4 border-2 border-gray-300 rounded-full"></div>
                                        </div>
                                    </label>
                                </div>

                                <!-- Custom Delivery -->
                                <div class="relative">
                                    <input type="radio" id="custom_delivery" name="delivery_option" value="custom_delivery" class="sr-only">
                                    <label for="custom_delivery" class="flex items-center p-4 border-2 border-gray-200 rounded-lg cursor-pointer hover:bg-gray-50 transition-colors">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0">
                                                <div class="w-12 h-12 bg-purple-600 rounded-lg flex items-center justify-center">
                                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                                    </svg>
                                                </div>
                                            </div>
                                            <div class="ml-4">
                                                <h3 class="text-lg font-medium text-gray-900">🎯 Custom Location Delivery</h3>
                                                <p class="text-sm text-gray-600">Delivery to any location in Ethiopia</p>
                                                <div class="mt-2">
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-purple-100 text-purple-800">
                                                        $1,000 delivery fee
                                                    </span>
                                                </div>
                                                <p class="mt-2 text-xs text-gray-500">
                                                    🌍 Nationwide delivery available<br>
                                                    📅 Delivery within 5-7 business days
                                                </p>
                                            </div>
                                        </div>
                                        <div class="ml-auto">
                                            <div class="w-4 h-4 border-2 border-gray-300 rounded-full"></div>
                                        </div>
                                    </label>
                                </div>
                            </div>

                            <!-- Custom Delivery Address (Hidden by default) -->
                            <div id="custom_address_section" class="hidden">
                                <label for="delivery_address" class="block text-sm font-medium text-gray-700">
                                    Delivery Address <span class="text-red-500">*</span>
                                </label>
                                <textarea id="delivery_address" 
                                          name="delivery_address" 
                                          rows="3"
                                          placeholder="Enter the complete delivery address including city, region, and landmarks"
                                          class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm"></textarea>
                                @error('delivery_address')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Preferred Date -->
                            <div>
                                <label for="preferred_date" class="block text-sm font-medium text-gray-700">
                                    Preferred Date <span class="text-red-500">*</span>
                                </label>
                                <input type="date" 
                                       id="preferred_date" 
                                       name="preferred_date" 
                                       min="{{ date('Y-m-d', strtotime('+1 day')) }}"
                                       value="{{ old('preferred_date') }}"
                                       required
                                       class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                                @error('preferred_date')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                                <p class="mt-2 text-sm text-gray-500">
                                    Select your preferred pickup or delivery date. We'll contact you to confirm availability.
                                </p>
                            </div>

                            <!-- Contact Person -->
                            <div>
                                <label for="contact_person" class="block text-sm font-medium text-gray-700">
                                    Contact Person
                                    <span class="text-gray-500 text-xs">(Optional - if different from buyer)</span>
                                </label>
                                <input type="text" 
                                       id="contact_person" 
                                       name="contact_person" 
                                       value="{{ old('contact_person') }}"
                                       placeholder="Name and phone number of person who will receive the vehicle"
                                       class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                                @error('contact_person')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Delivery Information -->
                        <div class="px-6 py-4 bg-gray-50 border-t border-gray-200">
                            <div class="flex items-start">
                                <div class="flex-shrink-0">
                                    <svg class="h-5 w-5 text-blue-400" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <h3 class="text-sm font-medium text-gray-900">📋 Important Delivery Information</h3>
                                    <div class="mt-2 text-sm text-gray-600">
                                        <ul class="list-disc list-inside space-y-1">
                                            <li>All vehicles are delivered with full documentation and registration</li>
                                            <li>A representative will contact you 24 hours before delivery/pickup</li>
                                            <li>Valid ID and proof of payment required at time of delivery</li>
                                            <li>Vehicle inspection and handover process takes approximately 30 minutes</li>
                                        </ul>
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
                                Continue to Payment Method →
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
                            <span class="text-sm text-gray-600" id="delivery-cost">FREE</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-sm text-gray-600">Tax (15%)</span>
                            <span class="text-sm text-gray-600" id="tax-amount">${{ number_format($vehicle->sale_price * 0.15, 2) }}</span>
                        </div>
                        <div class="border-t border-gray-200 pt-3">
                            <div class="flex justify-between">
                                <span class="text-base font-medium text-gray-900">Total Estimate</span>
                                <span class="text-base font-medium text-gray-900" id="total-amount">${{ number_format($vehicle->sale_price * 1.15, 2) }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Delivery Options Summary -->
                    <div class="bg-blue-50 border border-blue-200 rounded-md p-3">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-blue-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-sm font-medium text-blue-800">Delivery Options</h3>
                                <div class="mt-2 text-sm text-blue-700">
                                    <p>Choose your preferred delivery method. Pickup is free, while delivery options include additional fees.</p>
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
    const radioButtons = document.querySelectorAll('input[name="delivery_option"]');
    const customAddressSection = document.getElementById('custom_address_section');
    const deliveryCostElement = document.getElementById('delivery-cost');
    const taxAmountElement = document.getElementById('tax-amount');
    const totalAmountElement = document.getElementById('total-amount');
    
    const vehiclePrice = {{ $vehicle->sale_price }};
    
    function updatePricing(deliveryCost) {
        const taxAmount = (vehiclePrice + deliveryCost) * 0.15;
        const totalAmount = vehiclePrice + deliveryCost + taxAmount;
        
        deliveryCostElement.textContent = deliveryCost === 0 ? 'FREE' : '$' + deliveryCost.toFixed(2);
        taxAmountElement.textContent = '$' + taxAmount.toFixed(2);
        totalAmountElement.textContent = '$' + totalAmount.toFixed(2);
    }
    
    radioButtons.forEach(radio => {
        radio.addEventListener('change', function() {
            // Remove selected styling from all labels
            document.querySelectorAll('label[for^="pickup"], label[for^="company_delivery"], label[for^="custom_delivery"]').forEach(label => {
                label.classList.remove('border-green-200', 'bg-green-50', 'border-blue-200', 'bg-blue-50', 'border-purple-200', 'bg-purple-50');
                label.classList.add('border-gray-200');
                label.querySelector('.ml-auto div').classList.remove('border-green-600', 'bg-green-600', 'border-blue-600', 'bg-blue-600', 'border-purple-600', 'bg-purple-600');
                label.querySelector('.ml-auto div').classList.add('border-gray-300');
                const innerDot = label.querySelector('.ml-auto div div');
                if (innerDot) innerDot.remove();
            });
            
            // Add selected styling to chosen option
            const selectedLabel = document.querySelector(`label[for="${this.id}"]`);
            selectedLabel.classList.remove('border-gray-200');
            
            const radioCircle = selectedLabel.querySelector('.ml-auto div');
            radioCircle.classList.remove('border-gray-300');
            
            // Add inner dot
            const innerDot = document.createElement('div');
            innerDot.className = 'w-2 h-2 bg-white rounded-full';
            radioCircle.appendChild(innerDot);
            
            // Update styling and pricing based on selection
            let deliveryCost = 0;
            
            if (this.value === 'pickup') {
                selectedLabel.classList.add('border-green-200', 'bg-green-50');
                radioCircle.classList.add('border-green-600', 'bg-green-600');
                customAddressSection.classList.add('hidden');
                deliveryCost = 0;
            } else if (this.value === 'company_delivery') {
                selectedLabel.classList.add('border-blue-200', 'bg-blue-50');
                radioCircle.classList.add('border-blue-600', 'bg-blue-600');
                customAddressSection.classList.add('hidden');
                deliveryCost = 500;
            } else if (this.value === 'custom_delivery') {
                selectedLabel.classList.add('border-purple-200', 'bg-purple-50');
                radioCircle.classList.add('border-purple-600', 'bg-purple-600');
                customAddressSection.classList.remove('hidden');
                deliveryCost = 1000;
            }
            
            updatePricing(deliveryCost);
        });
    });
    
    // Form validation
    const form = document.querySelector('form');
    form.addEventListener('submit', function(e) {
        const selectedOption = document.querySelector('input[name="delivery_option"]:checked');
        const preferredDate = document.getElementById('preferred_date');
        const deliveryAddress = document.getElementById('delivery_address');
        
        let isValid = true;
        
        // Check preferred date
        if (!preferredDate.value) {
            isValid = false;
            preferredDate.classList.add('border-red-500');
        } else {
            preferredDate.classList.remove('border-red-500');
        }
        
        // Check delivery address for custom delivery
        if (selectedOption && selectedOption.value === 'custom_delivery') {
            if (!deliveryAddress.value.trim()) {
                isValid = false;
                deliveryAddress.classList.add('border-red-500');
                
                if (!deliveryAddress.nextElementSibling || !deliveryAddress.nextElementSibling.classList.contains('text-red-600')) {
                    const errorMsg = document.createElement('p');
                    errorMsg.className = 'mt-2 text-sm text-red-600';
                    errorMsg.textContent = 'Delivery address is required for custom delivery.';
                    deliveryAddress.parentNode.insertBefore(errorMsg, deliveryAddress.nextSibling);
                }
            } else {
                deliveryAddress.classList.remove('border-red-500');
                if (deliveryAddress.nextElementSibling && deliveryAddress.nextElementSibling.classList.contains('text-red-600')) {
                    deliveryAddress.nextElementSibling.remove();
                }
            }
        }
        
        if (!isValid) {
            e.preventDefault();
            const firstError = document.querySelector('.border-red-500');
            if (firstError) {
                firstError.scrollIntoView({ behavior: 'smooth', block: 'center' });
            }
        }
    });
    
    // Initialize with pickup selected
    updatePricing(0);
});
</script>
@endsection