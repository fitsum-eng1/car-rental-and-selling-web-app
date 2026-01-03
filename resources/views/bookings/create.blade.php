@extends('layouts.app')

@section('title', 'Book ' . $vehicle->full_name . ' - Car Rental & Sales System')

@section('content')
<div class="bg-gray-50 min-h-screen">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Header -->
        <div class="mb-8 animate__animated animate__fadeInDown">
            <h1 class="text-3xl font-bold text-gray-900">
                @if(app()->getLocale() === 'am')
                    ቦታ ያስያዙ
                @else
                    Book Your Rental
                @endif
            </h1>
            <p class="mt-2 text-gray-600">
                @if(app()->getLocale() === 'am')
                    {{ $vehicle->full_name }} ን ይከራዩ
                @else
                    Complete your booking for {{ $vehicle->full_name }}
                @endif
            </p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Booking Form -->
            <div class="lg:col-span-2">
                <div class="bg-white shadow rounded-lg p-6 animate__animated animate__fadeInLeft">
                    <form method="POST" action="{{ route('bookings.store', $vehicle) }}" id="booking-form">
                        @csrf
                        
                        <!-- Rental Dates -->
                        <div class="mb-6">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">
                                @if(app()->getLocale() === 'am')
                                    የኪራይ ቀናት
                                @else
                                    Rental Dates
                                @endif
                            </h3>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label for="pickup_date" class="block text-sm font-medium text-gray-700 mb-2">
                                        @if(app()->getLocale() === 'am')
                                            የመውሰጃ ቀን
                                        @else
                                            Pickup Date
                                        @endif
                                    </label>
                                    <input type="date" 
                                           id="pickup_date" 
                                           name="pickup_date" 
                                           required
                                           min="{{ date('Y-m-d') }}"
                                           value="{{ old('pickup_date') }}"
                                           class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('pickup_date') border-red-500 @enderror"
                                           onchange="updateDates()">
                                    @error('pickup_date')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                                
                                <div>
                                    <label for="return_date" class="block text-sm font-medium text-gray-700 mb-2">
                                        @if(app()->getLocale() === 'am')
                                            የመመለሻ ቀን
                                        @else
                                            Return Date
                                        @endif
                                    </label>
                                    <input type="date" 
                                           id="return_date" 
                                           name="return_date" 
                                           required
                                           min="{{ date('Y-m-d', strtotime('+1 day')) }}"
                                           value="{{ old('return_date') }}"
                                           class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('return_date') border-red-500 @enderror"
                                           onchange="updateDates()">
                                    @error('return_date')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Driving Option -->
                        <div class="mb-6">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">
                                @if(app()->getLocale() === 'am')
                                    የማሽከርከር አማራጭ
                                @else
                                    Driving Option
                                @endif
                            </h3>
                            
                            <div class="space-y-4">
                                @if($vehicle->self_drive_available)
                                    <div class="flex items-center">
                                        <input id="self_drive" 
                                               name="driving_option" 
                                               type="radio" 
                                               value="self_drive"
                                               {{ old('driving_option', 'self_drive') === 'self_drive' ? 'checked' : '' }}
                                               class="focus:ring-blue-500 h-4 w-4 text-blue-600 border-gray-300"
                                               onchange="updatePricing()">
                                        <label for="self_drive" class="ml-3 block text-sm font-medium text-gray-700">
                                            @if(app()->getLocale() === 'am')
                                                ራስዎ ይንዱ
                                            @else
                                                Self Drive
                                            @endif
                                            <span class="text-gray-500">
                                                (${{ $vehicle->rental_price_per_day }}/day)
                                            </span>
                                        </label>
                                    </div>
                                @endif
                                
                                @if($vehicle->with_driver_available)
                                    <div class="flex items-center">
                                        <input id="with_driver" 
                                               name="driving_option" 
                                               type="radio" 
                                               value="with_driver"
                                               {{ old('driving_option') === 'with_driver' ? 'checked' : '' }}
                                               class="focus:ring-blue-500 h-4 w-4 text-blue-600 border-gray-300"
                                               onchange="updatePricing()">
                                        <label for="with_driver" class="ml-3 block text-sm font-medium text-gray-700">
                                            @if(app()->getLocale() === 'am')
                                                ከሹፌር ጋር
                                            @else
                                                With Driver
                                            @endif
                                            <span class="text-gray-500">
                                                (${{ $vehicle->rental_price_per_day }} + ${{ $vehicle->driver_cost_per_day ?? 0 }}/day)
                                            </span>
                                        </label>
                                    </div>
                                @endif
                            </div>
                            @error('driving_option')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Location Details -->
                        <div class="mb-6">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">
                                @if(app()->getLocale() === 'am')
                                    የአካባቢ ዝርዝሮች
                                @else
                                    Location Details
                                @endif
                            </h3>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label for="pickup_location" class="block text-sm font-medium text-gray-700 mb-2">
                                        @if(app()->getLocale() === 'am')
                                            የመውሰጃ ቦታ
                                        @else
                                            Pickup Location
                                        @endif
                                    </label>
                                    <input type="text" 
                                           id="pickup_location" 
                                           name="pickup_location" 
                                           required
                                           value="{{ old('pickup_location') }}"
                                           placeholder="@if(app()->getLocale() === 'am') አድራሻ ያስገቡ @else Enter pickup address @endif"
                                           class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('pickup_location') border-red-500 @enderror">
                                    @error('pickup_location')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                                
                                <div>
                                    <label for="return_location" class="block text-sm font-medium text-gray-700 mb-2">
                                        @if(app()->getLocale() === 'am')
                                            የመመለሻ ቦታ
                                        @else
                                            Return Location
                                        @endif
                                    </label>
                                    <input type="text" 
                                           id="return_location" 
                                           name="return_location" 
                                           required
                                           value="{{ old('return_location') }}"
                                           placeholder="@if(app()->getLocale() === 'am') አድራሻ ያስገቡ @else Enter return address @endif"
                                           class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('return_location') border-red-500 @enderror">
                                    @error('return_location')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            
                            <!-- Hidden GPS coordinates (can be populated by map integration) -->
                            <input type="hidden" name="pickup_latitude" id="pickup_latitude" value="{{ old('pickup_latitude') }}">
                            <input type="hidden" name="pickup_longitude" id="pickup_longitude" value="{{ old('pickup_longitude') }}">
                            <input type="hidden" name="return_latitude" id="return_latitude" value="{{ old('return_latitude') }}">
                            <input type="hidden" name="return_longitude" id="return_longitude" value="{{ old('return_longitude') }}">
                        </div>

                        <!-- Special Requests -->
                        <div class="mb-6">
                            <label for="special_requests" class="block text-sm font-medium text-gray-700 mb-2">
                                @if(app()->getLocale() === 'am')
                                    ልዩ ጥያቄዎች
                                @else
                                    Special Requests
                                @endif
                                <span class="text-gray-500">({{ __('Optional') }})</span>
                            </label>
                            <textarea id="special_requests" 
                                      name="special_requests" 
                                      rows="3"
                                      placeholder="@if(app()->getLocale() === 'am') ማንኛውም ልዩ ጥያቄ ወይም መመሪያ... @else Any special requests or instructions... @endif"
                                      class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('special_requests') border-red-500 @enderror">{{ old('special_requests') }}</textarea>
                            @error('special_requests')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Submit Button -->
                        <div class="flex justify-end">
                            <button type="submit" 
                                    class="bg-blue-600 text-white px-6 py-3 rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 font-medium animate-ripple animate-scale-on-hover">
                                @if(app()->getLocale() === 'am')
                                    ቦታ ያስያዙ
                                @else
                                    Complete Booking
                                @endif
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Booking Summary -->
            <div class="lg:col-span-1">
                <div class="bg-white shadow rounded-lg p-6 sticky top-8 animate__animated animate__fadeInRight">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">
                        @if(app()->getLocale() === 'am')
                            የቦታ ማስያዝ ማጠቃለያ
                        @else
                            Booking Summary
                        @endif
                    </h3>
                    
                    <!-- Vehicle Info -->
                    <div class="flex items-center mb-4">
                        @if($vehicle->primary_image)
                            <img src="{{ asset('storage/' . $vehicle->primary_image) }}" 
                                 alt="{{ $vehicle->full_name }}" 
                                 class="w-16 h-16 object-cover rounded">
                        @else
                            <div class="w-16 h-16 bg-gray-200 rounded flex items-center justify-center">
                                <svg class="w-8 h-8 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        @endif
                        <div class="ml-4">
                            <h4 class="font-medium text-gray-900">{{ $vehicle->full_name }}</h4>
                            <p class="text-sm text-gray-500">{{ ucfirst($vehicle->category) }} • {{ ucfirst($vehicle->transmission) }}</p>
                        </div>
                    </div>

                    <!-- Pricing Breakdown -->
                    <div class="border-t border-gray-200 pt-4">
                        <div class="space-y-2">
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-600">
                                    @if(app()->getLocale() === 'am')
                                        የቀን ዋጋ
                                    @else
                                        Daily Rate
                                    @endif
                                </span>
                                <span id="daily-rate">${{ $vehicle->rental_price_per_day }}</span>
                            </div>
                            
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-600">
                                    @if(app()->getLocale() === 'am')
                                        የቀናት ብዛት
                                    @else
                                        Number of Days
                                    @endif
                                </span>
                                <span id="total-days">1</span>
                            </div>
                            
                            <div class="flex justify-between text-sm" id="driver-cost-row" style="display: none;">
                                <span class="text-gray-600">
                                    @if(app()->getLocale() === 'am')
                                        የሹፌር ወጪ
                                    @else
                                        Driver Cost
                                    @endif
                                </span>
                                <span id="driver-cost">$0</span>
                            </div>
                            
                            <div class="flex justify-between text-sm border-t pt-2">
                                <span class="text-gray-600">
                                    @if(app()->getLocale() === 'am')
                                        ንዑስ ድምር
                                    @else
                                        Subtotal
                                    @endif
                                </span>
                                <span id="subtotal">${{ $vehicle->rental_price_per_day }}</span>
                            </div>
                            
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-600">
                                    @if(app()->getLocale() === 'am')
                                        ታክስ (15%)
                                    @else
                                        Tax (15%)
                                    @endif
                                </span>
                                <span id="tax-amount">${{ number_format($vehicle->rental_price_per_day * 0.15, 2) }}</span>
                            </div>
                            
                            <div class="flex justify-between font-medium text-lg border-t pt-2">
                                <span class="text-gray-900">
                                    @if(app()->getLocale() === 'am')
                                        ጠቅላላ
                                    @else
                                        Total
                                    @endif
                                </span>
                                <span id="total-amount" class="text-blue-600">${{ number_format($vehicle->rental_price_per_day * 1.15, 2) }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Important Notes -->
                    <div class="mt-6 p-4 bg-blue-50 rounded-lg">
                        <h4 class="text-sm font-medium text-blue-900 mb-2">
                            @if(app()->getLocale() === 'am')
                                አስፈላጊ ማስታወሻዎች
                            @else
                                Important Notes
                            @endif
                        </h4>
                        <ul class="text-xs text-blue-800 space-y-1">
                            <li>
                                @if(app()->getLocale() === 'am')
                                    • ክፍያ ከመጠናቀቁ በፊት ቦታ ማስያዝ አይረጋገጥም
                                @else
                                    • Booking is not confirmed until payment is completed
                                @endif
                            </li>
                            <li>
                                @if(app()->getLocale() === 'am')
                                    • የመንጃ ፈቃድ እና መታወቂያ ያስፈልጋል
                                @else
                                    • Valid driver's license and ID required
                                @endif
                            </li>
                            <li>
                                @if(app()->getLocale() === 'am')
                                    • የመሰረዝ ፖሊሲ ይተገበራል
                                @else
                                    • Cancellation policy applies
                                @endif
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
const vehicleData = {
    dailyRate: {{ $vehicle->rental_price_per_day }},
    driverCost: {{ $vehicle->driver_cost_per_day ?? 0 }}
};

function updateDates() {
    const pickupDate = document.getElementById('pickup_date').value;
    const returnDate = document.getElementById('return_date').value;
    
    if (pickupDate && returnDate) {
        const pickup = new Date(pickupDate);
        const returnD = new Date(returnDate);
        const timeDiff = returnD.getTime() - pickup.getTime();
        const daysDiff = Math.ceil(timeDiff / (1000 * 3600 * 24)) + 1;
        
        if (daysDiff > 0) {
            document.getElementById('total-days').textContent = daysDiff;
            updatePricing();
        }
    }
    
    // Update minimum return date
    if (pickupDate) {
        const minReturn = new Date(pickupDate);
        minReturn.setDate(minReturn.getDate() + 1);
        document.getElementById('return_date').min = minReturn.toISOString().split('T')[0];
    }
}

function updatePricing() {
    const totalDays = parseInt(document.getElementById('total-days').textContent) || 1;
    const drivingOption = document.querySelector('input[name="driving_option"]:checked')?.value || 'self_drive';
    
    const dailyRate = vehicleData.dailyRate;
    const driverCostPerDay = drivingOption === 'with_driver' ? vehicleData.driverCost : 0;
    
    const rentalCost = dailyRate * totalDays;
    const totalDriverCost = driverCostPerDay * totalDays;
    const subtotal = rentalCost + totalDriverCost;
    const taxAmount = subtotal * 0.15;
    const total = subtotal + taxAmount;
    
    // Update display
    document.getElementById('daily-rate').textContent = `$${dailyRate}`;
    
    const driverCostRow = document.getElementById('driver-cost-row');
    if (driverCostPerDay > 0) {
        driverCostRow.style.display = 'flex';
        document.getElementById('driver-cost').textContent = `$${totalDriverCost}`;
    } else {
        driverCostRow.style.display = 'none';
    }
    
    document.getElementById('subtotal').textContent = `$${subtotal.toFixed(2)}`;
    document.getElementById('tax-amount').textContent = `$${taxAmount.toFixed(2)}`;
    document.getElementById('total-amount').textContent = `$${total.toFixed(2)}`;
}

// Initialize
document.addEventListener('DOMContentLoaded', function() {
    updateDates();
    updatePricing();
});
</script>
@endsection