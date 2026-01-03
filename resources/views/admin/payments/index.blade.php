@extends('layouts.app')

@section('title', 'Payment Management - Admin Panel')

@section('content')
<div class="bg-gray-50 min-h-screen">
    <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
        <!-- Page header -->
        <div class="mb-8">
            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <a href="{{ route('admin.dashboard') }}" class="text-gray-500 hover:text-gray-700 mr-4">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                        </svg>
                    </a>
                    <h2 class="text-2xl font-bold leading-7 text-gray-900 sm:text-3xl sm:truncate">
                        Payment Management
                    </h2>
                </div>
                <div class="flex items-center space-x-2">
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                        {{ $payments->where('status', 'pending')->count() }} Pending
                    </span>
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                        {{ $payments->where('status', 'submitted')->count() }} Submitted
                    </span>
                </div>
            </div>
        </div>

        <!-- Filters -->
        <div class="mb-6 bg-white shadow rounded-lg">
            <form method="GET" action="{{ route('admin.payments.index') }}" class="p-4">
                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-5">
                    <div>
                        <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                        <select name="status" id="status" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                            <option value="">All Statuses</option>
                            <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="submitted" {{ request('status') === 'submitted' ? 'selected' : '' }}>Submitted</option>
                            <option value="verified" {{ request('status') === 'verified' ? 'selected' : '' }}>Verified</option>
                            <option value="completed" {{ request('status') === 'completed' ? 'selected' : '' }}>Completed</option>
                            <option value="failed" {{ request('status') === 'failed' ? 'selected' : '' }}>Failed</option>
                            <option value="rejected" {{ request('status') === 'rejected' ? 'selected' : '' }}>Rejected</option>
                        </select>
                    </div>

                    <div>
                        <label for="payment_method" class="block text-sm font-medium text-gray-700">Payment Method</label>
                        <select name="payment_method" id="payment_method" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                            <option value="">All Methods</option>
                            <option value="telebirr" {{ request('payment_method') === 'telebirr' ? 'selected' : '' }}>TeleBirr</option>
                            <option value="cbe_birr" {{ request('payment_method') === 'cbe_birr' ? 'selected' : '' }}>CBE Birr</option>
                            <option value="awash_birr" {{ request('payment_method') === 'awash_birr' ? 'selected' : '' }}>Awash Birr</option>
                            <option value="bank_transfer" {{ request('payment_method') === 'bank_transfer' ? 'selected' : '' }}>Bank Transfer</option>
                            <option value="cash" {{ request('payment_method') === 'cash' ? 'selected' : '' }}>Cash</option>
                        </select>
                    </div>

                    <div>
                        <label for="start_date" class="block text-sm font-medium text-gray-700">Start Date</label>
                        <input type="date" name="start_date" id="start_date" value="{{ request('start_date') }}"
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                    </div>

                    <div class="flex items-end">
                        <button type="submit" 
                            class="w-full inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            Filter
                        </button>
                    </div>

                    <div class="flex items-end">
                        <a href="{{ route('admin.payments.index') }}" 
                            class="w-full inline-flex justify-center py-2 px-4 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            Clear
                        </a>
                    </div>
                </div>
            </form>
        </div>

        @if($payments->count() > 0)
            <div class="bg-white shadow overflow-hidden sm:rounded-md">
                <ul class="divide-y divide-gray-200">
                    @foreach($payments as $payment)
                        <li class="animate__animated animate__fadeInUp" style="animation-delay: {{ $loop->index * 50 }}ms">
                            <div class="px-4 py-4 sm:px-6">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0">
                                            <div class="h-10 w-10 rounded-full flex items-center justify-center
                                                @if($payment->status === 'completed') bg-green-100
                                                @elseif($payment->status === 'verified') bg-blue-100
                                                @elseif($payment->status === 'submitted') bg-yellow-100
                                                @elseif($payment->status === 'pending') bg-gray-100
                                                @elseif($payment->status === 'failed') bg-red-100
                                                @elseif($payment->status === 'rejected') bg-red-100
                                                @else bg-gray-100 @endif">
                                                @if($payment->status === 'completed')
                                                    <svg class="h-6 w-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                                    </svg>
                                                @elseif($payment->status === 'verified')
                                                    <svg class="h-6 w-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                    </svg>
                                                @elseif(in_array($payment->status, ['submitted', 'pending']))
                                                    <svg class="h-6 w-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                    </svg>
                                                @else
                                                    <svg class="h-6 w-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                                    </svg>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="ml-4">
                                            <div class="flex items-center">
                                                <p class="text-sm font-medium text-indigo-600 truncate">
                                                    {{ $payment->payment_reference }}
                                                </p>
                                                <span class="ml-2 inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
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
                                            <div class="mt-2 flex items-center text-sm text-gray-500">
                                                <svg class="flex-shrink-0 mr-1.5 h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                                </svg>
                                                <p>{{ $payment->user->name }} ({{ $payment->user->email }})</p>
                                            </div>
                                            <div class="mt-2 flex items-center text-sm text-gray-500">
                                                <svg class="flex-shrink-0 mr-1.5 h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                                                </svg>
                                                <p>{{ ucfirst(str_replace('_', ' ', $payment->payment_method)) }}</p>
                                            </div>
                                            <div class="mt-2 flex items-center text-sm text-gray-500">
                                                <svg class="flex-shrink-0 mr-1.5 h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                                </svg>
                                                <p>
                                                    @if($payment->payable_type === 'App\Models\Booking')
                                                        Booking: {{ $payment->payable->booking_reference ?? 'N/A' }}
                                                    @elseif($payment->payable_type === 'App\Models\Purchase')
                                                        Purchase: {{ $payment->payable->purchase_reference ?? 'N/A' }}
                                                    @else
                                                        {{ class_basename($payment->payable_type) }}
                                                    @endif
                                                </p>
                                            </div>
                                            @if($payment->transaction_id)
                                                <div class="mt-2 flex items-center text-sm text-gray-500">
                                                    <svg class="flex-shrink-0 mr-1.5 h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                                                    </svg>
                                                    <p>Transaction: {{ $payment->transaction_id }}</p>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="flex flex-col items-end">
                                        <div class="text-lg font-medium text-gray-900">
                                            ${{ number_format($payment->amount, 2) }}
                                        </div>
                                        <div class="mt-2 text-sm text-gray-500">
                                            {{ $payment->created_at->format('M d, Y g:i A') }}
                                        </div>
                                        <div class="mt-2 flex space-x-2">
                                            @if($payment->status === 'submitted')
                                                <form action="{{ route('admin.payments.verify', $payment) }}" method="POST" class="inline">
                                                    @csrf
                                                    <button type="submit" 
                                                        onclick="return confirm('Are you sure you want to verify this payment?')"
                                                        class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                                                        <svg class="-ml-1 mr-1 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                                        </svg>
                                                        Verify
                                                    </button>
                                                </form>
                                                <button onclick="openRejectModal({{ $payment->id }}, '{{ $payment->payment_reference }}')"
                                                    class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                                                    <svg class="-ml-1 mr-1 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                                    </svg>
                                                    Reject
                                                </button>
                                            @endif
                                            <a href="{{ route('admin.payments.show', $payment) }}" 
                                                class="inline-flex items-center px-3 py-2 border border-gray-300 shadow-sm text-sm leading-4 font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                                View Details
                                            </a>
                                        </div>
                                        @if($payment->verifiedBy)
                                            <div class="mt-2 text-xs text-gray-500">
                                                Verified by {{ $payment->verifiedBy->name }}
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>

            <!-- Pagination -->
            <div class="mt-6">
                {{ $payments->appends(request()->query())->links() }}
            </div>
        @else
            <div class="text-center py-12">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                </svg>
                <h3 class="mt-2 text-sm font-medium text-gray-900">No payments found</h3>
                <p class="mt-1 text-sm text-gray-500">No payments match your current filters.</p>
            </div>
        @endif
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