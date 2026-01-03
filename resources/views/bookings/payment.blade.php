@extends('layouts.app')

@section('title', 'Payment - Booking ' . $booking->booking_reference)

@section('content')
<div class="bg-gray-50 min-h-screen">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Header -->
        <div class="mb-8 animate__animated animate__fadeInDown">
            <h1 class="text-3xl font-bold text-gray-900">
                @if(app()->getLocale() === 'am')
                    ክፍያ ማጠናቀቂያ
                @else
                    Complete Payment
                @endif
            </h1>
            <p class="mt-2 text-gray-600">
                @if(app()->getLocale() === 'am')
                    ቦታ ማስያዝ: {{ $booking->booking_reference }}
                @else
                    Booking Reference: {{ $booking->booking_reference }}
                @endif
            </p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Payment Instructions -->
            <div class="lg:col-span-2">
                <div class="bg-white shadow rounded-lg p-6 mb-6 animate__animated animate__fadeInLeft">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">
                        @if(app()->getLocale() === 'am')
                            የክፍያ መመሪያዎች
                        @else
                            Payment Instructions
                        @endif
                    </h3>
                    
                    <!-- Payment Status -->
                    <div class="mb-6 p-4 rounded-lg {{ $payment->status === 'verified' ? 'bg-green-50 border border-green-200 animate-success-pulse' : ($payment->status === 'submitted' ? 'bg-yellow-50 border border-yellow-200 animate-pending-pulse' : 'bg-blue-50 border border-blue-200') }}">
                        <div class="flex items-center">
                            @if($payment->status === 'verified')
                                <svg class="w-5 h-5 text-green-500 mr-2 animate-checkmark" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                </svg>
                                <span class="text-green-800 font-medium">
                                    @if(app()->getLocale() === 'am')
                                        ክፍያ ተረጋግጧል!
                                    @else
                                        Payment Verified!
                                    @endif
                                </span>
                            @elseif($payment->status === 'submitted')
                                <svg class="w-5 h-5 text-yellow-500 mr-2 animate-spin-slow" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                </svg>
                                <span class="text-yellow-800 font-medium">
                                    @if(app()->getLocale() === 'am')
                                        ክፍያ በማረጋገጥ ላይ
                                    @else
                                        Payment Under Verification
                                    @endif
                                </span>
                            @else
                                <svg class="w-5 h-5 text-blue-500 mr-2 animate-pulse" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                                </svg>
                                <span class="text-blue-800 font-medium">
                                    @if(app()->getLocale() === 'am')
                                        ክፍያ በመጠባበቅ ላይ
                                    @else
                                        Payment Pending
                                    @endif
                                </span>
                            @endif
                        </div>
                        <p class="mt-2 text-sm {{ $payment->status === 'verified' ? 'text-green-700' : ($payment->status === 'submitted' ? 'text-yellow-700' : 'text-blue-700') }}">
                            @if($payment->status === 'verified')
                                @if(app()->getLocale() === 'am')
                                    ክፍያዎ ተረጋግጧል። ቦታ ማስያዝዎ ተረጋግጧል!
                                @else
                                    Your payment has been verified. Your booking is confirmed!
                                @endif
                            @elseif($payment->status === 'submitted')
                                @if(app()->getLocale() === 'am')
                                    የክፍያ ዝርዝሮችዎን ተቀብለናል። በ24 ሰዓት ውስጥ እናረጋግጣለን።
                                @else
                                    We have received your payment details. We will verify within 24 hours.
                                @endif
                            @else
                                @if(app()->getLocale() === 'am')
                                    ቦታ ማስያዝዎን ለማጠናቀቅ ክፍያ ያጠናቅቁ።
                                @else
                                    Complete payment to finalize your booking.
                                @endif
                            @endif
                        </p>
                    </div>

                    @if($payment->status === 'pending' || $payment->status === 'rejected')
                        <!-- Bank Transfer Instructions -->
                        <div class="bg-gray-50 rounded-lg p-6 mb-6">
                            <h4 class="font-medium text-gray-900 mb-4">
                                @if(app()->getLocale() === 'am')
                                    የባንክ ዝውውር መመሪያዎች
                                @else
                                    Bank Transfer Instructions
                                @endif
                            </h4>
                            
                            <div class="space-y-3">
                                <div class="flex justify-between">
                                    <span class="text-gray-600">
                                        @if(app()->getLocale() === 'am')
                                            ባንክ:
                                        @else
                                            Bank:
                                        @endif
                                    </span>
                                    <span class="font-medium">{{ $payment->bank_name }}</span>
                                </div>
                                
                                <div class="flex justify-between">
                                    <span class="text-gray-600">
                                        @if(app()->getLocale() === 'am')
                                            የሂሳብ ቁጥር:
                                        @else
                                            Account Number:
                                        @endif
                                    </span>
                                    <span class="font-medium font-mono">{{ $payment->account_number }}</span>
                                </div>
                                
                                <div class="flex justify-between">
                                    <span class="text-gray-600">
                                        @if(app()->getLocale() === 'am')
                                            መጠን:
                                        @else
                                            Amount:
                                        @endif
                                    </span>
                                    <span class="font-bold text-lg text-blue-600">${{ $payment->amount }}</span>
                                </div>
                                
                                <div class="flex justify-between">
                                    <span class="text-gray-600">
                                        @if(app()->getLocale() === 'am')
                                            ማጣቀሻ:
                                        @else
                                            Reference:
                                        @endif
                                    </span>
                                    <span class="font-medium font-mono bg-yellow-100 px-2 py-1 rounded">{{ $payment->payment_reference }}</span>
                                </div>
                            </div>
                            
                            <div class="mt-4 p-3 bg-yellow-50 border border-yellow-200 rounded">
                                <p class="text-sm text-yellow-800">
                                    <strong>
                                        @if(app()->getLocale() === 'am')
                                            አስፈላጊ:
                                        @else
                                            Important:
                                        @endif
                                    </strong>
                                    @if(app()->getLocale() === 'am')
                                        ክፍያ ሲያደርጉ የክፍያ ማጣቀሻ ቁጥሩን መጠቀም ያስታውሱ።
                                    @else
                                        Please use the payment reference number when making the transfer.
                                    @endif
                                </p>
                            </div>
                        </div>

                        <!-- Payment Submission Form -->
                        <div class="bg-white border rounded-lg p-6">
                            <h4 class="font-medium text-gray-900 mb-4">
                                @if(app()->getLocale() === 'am')
                                    የክፍያ ዝርዝሮች ያስገቡ
                                @else
                                    Submit Payment Details
                                @endif
                            </h4>
                            
                            <form method="POST" action="{{ route('payments.submit', $payment) }}">
                                @csrf
                                
                                <div class="space-y-4">
                                    <div>
                                        <label for="transaction_reference" class="block text-sm font-medium text-gray-700 mb-2">
                                            @if(app()->getLocale() === 'am')
                                                የግብይት ማጣቀሻ ቁጥር
                                            @else
                                                Transaction Reference Number
                                            @endif
                                        </label>
                                        <input type="text" 
                                               id="transaction_reference" 
                                               name="transaction_reference" 
                                               required
                                               value="{{ old('transaction_reference', $payment->transaction_reference) }}"
                                               placeholder="@if(app()->getLocale() === 'am') ከባንክዎ የተቀበሉትን ማጣቀሻ ቁጥር ያስገቡ @else Enter the reference number from your bank @endif"
                                               class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('transaction_reference') border-red-500 @enderror">
                                        @error('transaction_reference')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    
                                    <div>
                                        <label for="transaction_date" class="block text-sm font-medium text-gray-700 mb-2">
                                            @if(app()->getLocale() === 'am')
                                                የግብይት ቀን
                                            @else
                                                Transaction Date
                                            @endif
                                        </label>
                                        <input type="date" 
                                               id="transaction_date" 
                                               name="transaction_date" 
                                               required
                                               max="{{ date('Y-m-d') }}"
                                               value="{{ old('transaction_date', $payment->transaction_date?->format('Y-m-d')) }}"
                                               class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('transaction_date') border-red-500 @enderror">
                                        @error('transaction_date')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    
                                    <div>
                                        <label for="transaction_proof" class="block text-sm font-medium text-gray-700 mb-2">
                                            @if(app()->getLocale() === 'am')
                                                ተጨማሪ መረጃ
                                            @else
                                                Additional Information
                                            @endif
                                            <span class="text-gray-500">({{ __('Optional') }})</span>
                                        </label>
                                        <textarea id="transaction_proof" 
                                                  name="transaction_proof" 
                                                  rows="3"
                                                  placeholder="@if(app()->getLocale() === 'am') ማንኛውም ተጨማሪ መረጃ... @else Any additional information about the transaction... @endif"
                                                  class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('transaction_proof') border-red-500 @enderror">{{ old('transaction_proof', $payment->transaction_proof) }}</textarea>
                                        @error('transaction_proof')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                                
                                <div class="mt-6">
                                    <button type="submit" 
                                            class="w-full bg-blue-600 text-white px-4 py-3 rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 font-medium">
                                        @if(app()->getLocale() === 'am')
                                            የክፍያ ዝርዝሮች ላክ
                                        @else
                                            Submit Payment Details
                                        @endif
                                    </button>
                                </div>
                            </form>
                        </div>
                    @endif

                    @if($payment->status === 'submitted')
                        <!-- Verification Status -->
                        <div class="bg-white border rounded-lg p-6">
                            <h4 class="font-medium text-gray-900 mb-4">
                                @if(app()->getLocale() === 'am')
                                    የክፍያ ዝርዝሮች
                                @else
                                    Payment Details Submitted
                                @endif
                            </h4>
                            
                            <div class="space-y-3">
                                <div class="flex justify-between">
                                    <span class="text-gray-600">
                                        @if(app()->getLocale() === 'am')
                                            የግብይት ማጣቀሻ:
                                        @else
                                            Transaction Reference:
                                        @endif
                                    </span>
                                    <span class="font-medium">{{ $payment->transaction_reference }}</span>
                                </div>
                                
                                <div class="flex justify-between">
                                    <span class="text-gray-600">
                                        @if(app()->getLocale() === 'am')
                                            የግብይት ቀን:
                                        @else
                                            Transaction Date:
                                        @endif
                                    </span>
                                    <span class="font-medium">{{ $payment->transaction_date?->format('M d, Y') }}</span>
                                </div>
                                
                                <div class="flex justify-between">
                                    <span class="text-gray-600">
                                        @if(app()->getLocale() === 'am')
                                            የቀረበበት ቀን:
                                        @else
                                            Submitted On:
                                        @endif
                                    </span>
                                    <span class="font-medium">{{ $payment->updated_at->format('M d, Y H:i') }}</span>
                                </div>
                            </div>
                            
                            <div class="mt-4 p-3 bg-blue-50 border border-blue-200 rounded">
                                <p class="text-sm text-blue-800">
                                    @if(app()->getLocale() === 'am')
                                        የክፍያ ዝርዝሮችዎን ተቀብለናል። የእኛ ቡድን በ24 ሰዓት ውስጥ ያረጋግጣል።
                                    @else
                                        We have received your payment details. Our team will verify within 24 hours.
                                    @endif
                                </p>
                            </div>
                        </div>
                    @endif

                    @if($payment->status === 'verified')
                        <!-- Booking Confirmed -->
                        <div class="bg-green-50 border border-green-200 rounded-lg p-6">
                            <div class="flex items-center mb-4">
                                <svg class="w-6 h-6 text-green-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                </svg>
                                <h4 class="font-medium text-green-900">
                                    @if(app()->getLocale() === 'am')
                                        ቦታ ማስያዝ ተረጋግጧል!
                                    @else
                                        Booking Confirmed!
                                    @endif
                                </h4>
                            </div>
                            
                            <p class="text-green-800 mb-4">
                                @if(app()->getLocale() === 'am')
                                    ክፍያዎ ተረጋግጧል እና ቦታ ማስያዝዎ ተረጋግጧል። በቅርቡ የማረጋገጫ ኢሜይል ይደርስዎታል።
                                @else
                                    Your payment has been verified and your booking is confirmed. You will receive a confirmation email shortly.
                                @endif
                            </p>
                            
                            <div class="flex space-x-4">
                                <a href="{{ route('bookings.show', $booking) }}" 
                                   class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700 transition duration-300">
                                    @if(app()->getLocale() === 'am')
                                        ቦታ ማስያዝ ይመልከቱ
                                    @else
                                        View Booking
                                    @endif
                                </a>
                                <a href="{{ route('dashboard') }}" 
                                   class="bg-gray-600 text-white px-4 py-2 rounded hover:bg-gray-700 transition duration-300">
                                    @if(app()->getLocale() === 'am')
                                        ዳሽቦርድ
                                    @else
                                        Dashboard
                                    @endif
                                </a>
                            </div>
                        </div>
                    @endif
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
                        @if($booking->vehicle->primary_image)
                            <img src="{{ asset('storage/' . $booking->vehicle->primary_image) }}" 
                                 alt="{{ $booking->vehicle->full_name }}" 
                                 class="w-16 h-16 object-cover rounded">
                        @else
                            <div class="w-16 h-16 bg-gray-200 rounded flex items-center justify-center">
                                <svg class="w-8 h-8 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        @endif
                        <div class="ml-4">
                            <h4 class="font-medium text-gray-900">{{ $booking->vehicle->full_name }}</h4>
                            <p class="text-sm text-gray-500">{{ $booking->booking_reference }}</p>
                        </div>
                    </div>

                    <!-- Booking Details -->
                    <div class="space-y-3 mb-4">
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-600">
                                @if(app()->getLocale() === 'am')
                                    የመውሰጃ ቀን:
                                @else
                                    Pickup Date:
                                @endif
                            </span>
                            <span>{{ $booking->pickup_date->format('M d, Y') }}</span>
                        </div>
                        
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-600">
                                @if(app()->getLocale() === 'am')
                                    የመመለሻ ቀን:
                                @else
                                    Return Date:
                                @endif
                            </span>
                            <span>{{ $booking->return_date->format('M d, Y') }}</span>
                        </div>
                        
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-600">
                                @if(app()->getLocale() === 'am')
                                    የቀናት ብዛት:
                                @else
                                    Duration:
                                @endif
                            </span>
                            <span>{{ $booking->total_days }} 
                                @if(app()->getLocale() === 'am')
                                    ቀናት
                                @else
                                    days
                                @endif
                            </span>
                        </div>
                        
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-600">
                                @if(app()->getLocale() === 'am')
                                    የማሽከርከር አማራጭ:
                                @else
                                    Driving Option:
                                @endif
                            </span>
                            <span>{{ ucfirst(str_replace('_', ' ', $booking->driving_option)) }}</span>
                        </div>
                    </div>

                    <!-- Pricing Breakdown -->
                    <div class="border-t border-gray-200 pt-4">
                        <div class="space-y-2">
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-600">
                                    @if(app()->getLocale() === 'am')
                                        ንዑስ ድምር:
                                    @else
                                        Subtotal:
                                    @endif
                                </span>
                                <span>${{ $booking->subtotal }}</span>
                            </div>
                            
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-600">
                                    @if(app()->getLocale() === 'am')
                                        ታክስ:
                                    @else
                                        Tax:
                                    @endif
                                </span>
                                <span>${{ $booking->tax_amount }}</span>
                            </div>
                            
                            <div class="flex justify-between font-medium text-lg border-t pt-2">
                                <span class="text-gray-900">
                                    @if(app()->getLocale() === 'am')
                                        ጠቅላላ:
                                    @else
                                        Total:
                                    @endif
                                </span>
                                <span class="text-blue-600">${{ $booking->total_amount }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Payment Expiry -->
                    @if($payment->expires_at && $payment->status === 'pending')
                        <div class="mt-4 p-3 bg-red-50 border border-red-200 rounded">
                            <p class="text-sm text-red-800">
                                <strong>
                                    @if(app()->getLocale() === 'am')
                                        የክፍያ ጊዜ ገደብ:
                                    @else
                                        Payment Expires:
                                    @endif
                                </strong>
                                <br>
                                {{ $payment->expires_at->format('M d, Y H:i') }}
                            </p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@if($payment->status === 'submitted')
<script>
// Auto-refresh to check payment status
setTimeout(function() {
    fetch('{{ route("payments.status.api", $payment) }}')
        .then(response => response.json())
        .then(data => {
            if (data.status === 'verified') {
                location.reload();
            }
        })
        .catch(error => console.log('Status check failed'));
}, 30000); // Check every 30 seconds
</script>
@endif
@endsection