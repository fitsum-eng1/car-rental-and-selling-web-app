@extends('layouts.app')

@section('title', 'Payment Details - Admin Panel')

@section('content')
<div class="bg-gray-50 min-h-screen">
    <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
        <!-- Page header -->
        <div class="mb-8">
            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <a href="{{ route('admin.payments.index') }}" class="text-gray-500 hover:text-gray-700 mr-4">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                        </svg>
                    </a>
                    <h2 class="text-2xl font-bold leading-7 text-gray-900 sm:text-3xl sm:truncate">
                        Payment Details
                    </h2>
                </div>
                <div class="flex items-center space-x-2">
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium
                        @if($payment->status === 'completed') bg-green-100 text-green-800
                        @elseif($payment->status === 'verified') bg-blue-100 text-blue-800
                        @elseif($payment->status === 'submitted') bg-yellow-100 text-yellow-800
                        @elseif($payment->status === 'pending') bg-gray-100 text-gray-800
                        @elseif($payment->status === 'failed') bg-red-100 text-red-800
                        @elseif($payment->status === 'rejected') bg-red-100 text-red-800
                        @else bg-gray-100 text-gray-800 @endif">
                        {{ ucfirst($payment->status) }}
                    </span>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Payment Information -->
            <div class="lg:col-span-2">
                <div class="bg-white shadow rounded-lg">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h3 class="text-lg font-medium text-gray-900">Payment Information</h3>
                    </div>
                    <div class="px-6 py-4 space-y-4">
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Payment Reference</label>
                                <p class="mt-1 text-sm text-gray-900 font-mono">{{ $payment->payment_reference }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Amount</label>
                                <p class="mt-1 text-lg font-bold text-gray-900">${{ number_format($payment->amount, 2) }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Payment Method</label>
                                <p class="mt-1 text-sm text-gray-900">{{ ucfirst(str_replace('_', ' ', $payment->payment_method)) }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Bank Name</label>
                                <p class="mt-1 text-sm text-gray-900">{{ $payment->bank_name ?? 'N/A' }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Account Number</label>
                                <p class="mt-1 text-sm text-gray-900 font-mono">{{ $payment->account_number ?? 'N/A' }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Transaction Reference</label>
                                <p class="mt-1 text-sm text-gray-900 font-mono">{{ $payment->transaction_reference ?? 'Not provided' }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Transaction Date</label>
                                <p class="mt-1 text-sm text-gray-900">{{ $payment->transaction_date ? $payment->transaction_date->format('M d, Y g:i A') : 'Not provided' }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Created At</label>
                                <p class="mt-1 text-sm text-gray-900">{{ $payment->created_at->format('M d, Y g:i A') }}</p>
                            </div>
                        </div>

                        @if($payment->payment_instructions)
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Payment Instructions</label>
                                <div class="mt-1 p-3 bg-gray-50 rounded-md">
                                    <p class="text-sm text-gray-900">{{ $payment->payment_instructions }}</p>
                                </div>
                            </div>
                        @endif

                        @if($payment->transaction_proof)
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Transaction Proof</label>
                                <div class="mt-1 p-3 bg-gray-50 rounded-md">
                                    <p class="text-sm text-gray-900">{{ $payment->transaction_proof }}</p>
                                </div>
                            </div>
                        @endif

                        @if($payment->rejection_reason)
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Rejection Reason</label>
                                <div class="mt-1 p-3 bg-red-50 rounded-md border border-red-200">
                                    <p class="text-sm text-red-900">{{ $payment->rejection_reason }}</p>
                                </div>
                            </div>
                        @endif

                        @if($payment->verifiedBy)
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Verification Details</label>
                                <div class="mt-1 p-3 bg-blue-50 rounded-md border border-blue-200">
                                    <p class="text-sm text-blue-900">
                                        Verified by {{ $payment->verifiedBy->name }} on {{ $payment->verified_at->format('M d, Y g:i A') }}
                                    </p>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Related Booking/Purchase -->
                @if($payment->payable)
                    <div class="mt-6 bg-white shadow rounded-lg">
                        <div class="px-6 py-4 border-b border-gray-200">
                            <h3 class="text-lg font-medium text-gray-900">
                                @if($payment->payable_type === 'App\Models\Booking')
                                    Related Booking
                                @elseif($payment->payable_type === 'App\Models\Purchase')
                                    Related Purchase
                                @else
                                    Related {{ class_basename($payment->payable_type) }}
                                @endif
                            </h3>
                        </div>
                        <div class="px-6 py-4">
                            @if($payment->payable_type === 'App\Models\Booking')
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Booking Reference</label>
                                        <p class="mt-1 text-sm text-gray-900 font-mono">{{ $payment->payable->booking_reference ?? 'N/A' }}</p>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Status</label>
                                        <p class="mt-1 text-sm text-gray-900">{{ ucfirst($payment->payable->status ?? 'N/A') }}</p>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Start Date</label>
                                        <p class="mt-1 text-sm text-gray-900">{{ $payment->payable->start_date ? $payment->payable->start_date->format('M d, Y') : 'N/A' }}</p>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">End Date</label>
                                        <p class="mt-1 text-sm text-gray-900">{{ $payment->payable->end_date ? $payment->payable->end_date->format('M d, Y') : 'N/A' }}</p>
                                    </div>
                                </div>
                            @elseif($payment->payable_type === 'App\Models\Purchase')
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Purchase Reference</label>
                                        <p class="mt-1 text-sm text-gray-900 font-mono">{{ $payment->payable->purchase_reference ?? 'N/A' }}</p>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Status</label>
                                        <p class="mt-1 text-sm text-gray-900">{{ ucfirst($payment->payable->status ?? 'N/A') }}</p>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Purchase Price</label>
                                        <p class="mt-1 text-sm text-gray-900">${{ number_format($payment->payable->purchase_price ?? 0, 2) }}</p>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Total Amount</label>
                                        <p class="mt-1 text-sm text-gray-900">${{ number_format($payment->payable->total_amount ?? 0, 2) }}</p>
                                    </div>
                                </div>
                            @endif

                            @if($payment->payable->vehicle)
                                <div class="mt-4 pt-4 border-t border-gray-200">
                                    <h4 class="text-md font-medium text-gray-900 mb-3">Vehicle Details</h4>
                                    <div class="flex items-center space-x-4">
                                        @if($payment->payable->vehicle->primary_image)
                                            <img class="h-16 w-16 rounded-lg object-cover" 
                                                 src="{{ asset('storage/' . $payment->payable->vehicle->primary_image) }}" 
                                                 alt="{{ $payment->payable->vehicle->full_name }}">
                                        @else
                                            <div class="h-16 w-16 rounded-lg bg-gray-200 flex items-center justify-center">
                                                <svg class="h-8 w-8 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z" clip-rule="evenodd"/>
                                                </svg>
                                            </div>
                                        @endif
                                        <div>
                                            <p class="text-sm font-medium text-gray-900">{{ $payment->payable->vehicle->full_name }}</p>
                                            <p class="text-sm text-gray-500">{{ $payment->payable->vehicle->year }} • {{ $payment->payable->vehicle->fuel_type }}</p>
                                            <p class="text-sm text-gray-500">License: {{ $payment->payable->vehicle->license_plate }}</p>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                @endif
            </div>

            <!-- Actions Sidebar -->
            <div class="lg:col-span-1">
                <div class="bg-white shadow rounded-lg">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h3 class="text-lg font-medium text-gray-900">Customer Information</h3>
                    </div>
                    <div class="px-6 py-4 space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Name</label>
                            <p class="mt-1 text-sm text-gray-900">{{ $payment->user->name }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Email</label>
                            <p class="mt-1 text-sm text-gray-900">{{ $payment->user->email }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Phone</label>
                            <p class="mt-1 text-sm text-gray-900">{{ $payment->user->phone ?? 'Not provided' }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Member Since</label>
                            <p class="mt-1 text-sm text-gray-900">{{ $payment->user->created_at->format('M d, Y') }}</p>
                        </div>
                    </div>
                </div>

                @if($payment->status === 'submitted')
                    <div class="mt-6 bg-white shadow rounded-lg">
                        <div class="px-6 py-4 border-b border-gray-200">
                            <h3 class="text-lg font-medium text-gray-900">Actions</h3>
                        </div>
                        <div class="px-6 py-4 space-y-3">
                            <form action="{{ route('admin.payments.verify', $payment) }}" method="POST" class="w-full">
                                @csrf
                                <button type="submit" 
                                    onclick="return confirm('Are you sure you want to verify this payment?')"
                                    class="w-full inline-flex justify-center items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                                    <svg class="-ml-1 mr-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                    </svg>
                                    Verify Payment
                                </button>
                            </form>
                            <button onclick="openRejectModal({{ $payment->id }}, '{{ $payment->payment_reference }}')"
                                class="w-full inline-flex justify-center items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                                <svg class="-ml-1 mr-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                                Reject Payment
                            </button>
                        </div>
                    </div>
                @endif

                @if($payment->expires_at)
                    <div class="mt-6 bg-white shadow rounded-lg">
                        <div class="px-6 py-4 border-b border-gray-200">
                            <h3 class="text-lg font-medium text-gray-900">Payment Expiry</h3>
                        </div>
                        <div class="px-6 py-4">
                            <div class="flex items-center">
                                @if($payment->isExpired())
                                    <svg class="h-5 w-5 text-red-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                                    </svg>
                                    <div>
                                        <p class="text-sm font-medium text-red-900">Expired</p>
                                        <p class="text-sm text-red-700">{{ $payment->expires_at->format('M d, Y g:i A') }}</p>
                                    </div>
                                @else
                                    <svg class="h-5 w-5 text-yellow-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/>
                                    </svg>
                                    <div>
                                        <p class="text-sm font-medium text-yellow-900">Expires</p>
                                        <p class="text-sm text-yellow-700">{{ $payment->expires_at->format('M d, Y g:i A') }}</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Reject Payment Modal -->
<div id="reject-modal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Reject Payment</h3>
            <p class="text-sm text-gray-600 mb-4">Payment Reference: <span id="reject-payment-ref" class="font-medium"></span></p>
            <form id="reject-form" method="POST">
                @csrf
                <div class="mb-4">
                    <label for="rejection_reason" class="block text-sm font-medium text-gray-700">Rejection Reason</label>
                    <textarea name="rejection_reason" id="rejection_reason" rows="4" required
                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-red-500 focus:border-red-500"
                        placeholder="Please provide a reason for rejecting this payment..."></textarea>
                </div>
                <div class="flex justify-end space-x-3">
                    <button type="button" onclick="closeRejectModal()"
                        class="px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
                        Cancel
                    </button>
                    <button type="submit" 
                        class="px-4 py-2 border border-transparent rounded-md text-sm font-medium text-white bg-red-600 hover:bg-red-700">
                        Reject Payment
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function openRejectModal(paymentId, paymentRef) {
    document.getElementById('reject-payment-ref').textContent = paymentRef;
    document.getElementById('reject-form').action = `/admin/payments/${paymentId}/reject`;
    document.getElementById('reject-modal').classList.remove('hidden');
}

function closeRejectModal() {
    document.getElementById('reject-modal').classList.add('hidden');
    document.getElementById('rejection_reason').value = '';
}

// Close modal when clicking outside
document.getElementById('reject-modal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeRejectModal();
    }
});
</script>
@endsection