@extends('layouts.app')

@section('title', 'Bookings Management - Admin Panel')

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
                        Bookings Management
                    </h2>
                </div>
            </div>
        </div>

        <!-- Filters -->
        <div class="mb-6 bg-white shadow rounded-lg">
            <form method="GET" action="{{ route('admin.bookings.index') }}" class="p-4">
                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-5">
                    <div>
                        <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                        <select name="status" id="status" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                            <option value="">All Statuses</option>
                            <option value="pending_payment" {{ request('status') === 'pending_payment' ? 'selected' : '' }}>Pending Payment</option>
                            <option value="stuck" {{ request('status') === 'stuck' ? 'selected' : '' }}>Stuck Bookings</option>
                            <option value="pending_approval" {{ request('status') === 'pending_approval' ? 'selected' : '' }}>Pending Approval</option>
                            <option value="confirmed" {{ request('status') === 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                            <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Active</option>
                            <option value="completed" {{ request('status') === 'completed' ? 'selected' : '' }}>Completed</option>
                            <option value="cancelled" {{ request('status') === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                            <option value="rejected" {{ request('status') === 'rejected' ? 'selected' : '' }}>Rejected</option>
                        </select>
                    </div>

                    <div>
                        <label for="start_date" class="block text-sm font-medium text-gray-700">Start Date</label>
                        <input type="date" name="start_date" id="start_date" value="{{ request('start_date') }}"
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                    </div>

                    <div>
                        <label for="end_date" class="block text-sm font-medium text-gray-700">End Date</label>
                        <input type="date" name="end_date" id="end_date" value="{{ request('end_date') }}"
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                    </div>

                    <div class="flex items-end">
                        <button type="submit" 
                            class="w-full inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            Filter
                        </button>
                    </div>

                    <div class="flex items-end">
                        <a href="{{ route('admin.bookings.index') }}" 
                            class="w-full inline-flex justify-center py-2 px-4 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            Clear
                        </a>
                    </div>
                </div>
            </form>
        </div>

        @if($bookings->count() > 0)
            <div class="bg-white shadow overflow-hidden sm:rounded-md">
                <ul class="divide-y divide-gray-200">
                    @foreach($bookings as $booking)
                        <li class="animate__animated animate__fadeInUp {{ $booking->isStuck() ? 'bg-red-50 border-l-4 border-red-400' : '' }}" style="animation-delay: {{ $loop->index * 50 }}ms">
                            @if($booking->isStuck())
                                <!-- Stuck Booking Warning Banner -->
                                <div class="px-4 py-2 bg-red-100 border-b border-red-200">
                                    <div class="flex items-center">
                                        <svg class="h-5 w-5 text-red-400 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                        </svg>
                                        <span class="text-sm font-medium text-red-800">
                                            Stuck Booking - No payment record ({{ round($booking->getStuckAge() / 24, 1) }} days old)
                                        </span>
                                        <span class="ml-2 inline-flex items-center px-2 py-0.5 rounded text-xs font-medium
                                            @if($booking->getUrgencyLevel() === 'critical') bg-red-200 text-red-900
                                            @elseif($booking->getUrgencyLevel() === 'urgent') bg-orange-200 text-orange-900
                                            @elseif($booking->getUrgencyLevel() === 'warning') bg-yellow-200 text-yellow-900
                                            @else bg-gray-200 text-gray-900 @endif">
                                            {{ ucfirst($booking->getUrgencyLevel()) }}
                                        </span>
                                    </div>
                                </div>
                            @endif
                            <div class="px-4 py-4 sm:px-6">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-16 w-16">
                                            @if($booking->vehicle->primary_image)
                                                <img class="h-16 w-16 rounded-lg object-cover" src="{{ asset('storage/' . $booking->vehicle->primary_image) }}" alt="{{ $booking->vehicle->full_name }}">
                                            @else
                                                <div class="h-16 w-16 rounded-lg bg-gray-200 flex items-center justify-center">
                                                    <svg class="h-6 w-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd" d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z" clip-rule="evenodd" />
                                                    </svg>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="ml-4">
                                            <div class="flex items-center">
                                                <p class="text-sm font-medium text-indigo-600 truncate">
                                                    {{ $booking->booking_reference }}
                                                </p>
                                                <span class="ml-2 inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                                    @if($booking->status === 'confirmed') bg-green-100 text-green-800
                                                    @elseif($booking->status === 'pending_payment') bg-yellow-100 text-yellow-800
                                                    @elseif($booking->status === 'pending_approval') bg-blue-100 text-blue-800
                                                    @elseif($booking->status === 'cancelled') bg-red-100 text-red-800
                                                    @elseif($booking->status === 'rejected') bg-red-100 text-red-800
                                                    @elseif($booking->status === 'active') bg-purple-100 text-purple-800
                                                    @elseif($booking->status === 'completed') bg-gray-100 text-gray-800
                                                    @else bg-gray-100 text-gray-800 @endif">
                                                    {{ ucfirst(str_replace('_', ' ', $booking->status)) }}
                                                </span>
                                            </div>
                                            <div class="mt-2 flex items-center text-sm text-gray-500">
                                                <svg class="flex-shrink-0 mr-1.5 h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                                </svg>
                                                <p>{{ $booking->user->name }} ({{ $booking->user->email }})</p>
                                            </div>
                                            <div class="mt-2 flex items-center text-sm text-gray-500">
                                                <svg class="flex-shrink-0 mr-1.5 h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                                </svg>
                                                <p>{{ $booking->vehicle->full_name }}</p>
                                            </div>
                                            <div class="mt-2 flex items-center text-sm text-gray-500">
                                                <svg class="flex-shrink-0 mr-1.5 h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                </svg>
                                                <p>{{ $booking->pickup_date->format('M d, Y') }} - {{ $booking->return_date->format('M d, Y') }}</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="flex flex-col items-end">
                                        <div class="text-lg font-medium text-gray-900">
                                            ${{ number_format($booking->total_amount, 2) }}
                                        </div>
                                        <div class="mt-2 text-sm text-gray-500">
                                            {{ $booking->created_at->format('M d, Y') }}
                                        </div>
                                        <div class="mt-2 flex space-x-2">
                                            <a href="{{ route('admin.bookings.show', $booking) }}" 
                                                class="inline-flex items-center px-3 py-2 border border-gray-300 shadow-sm text-sm leading-4 font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                                View Details
                                            </a>
                                            @if($booking->status === 'pending_approval')
                                                <form action="{{ route('admin.bookings.approve', $booking) }}" method="POST" class="inline">
                                                    @csrf
                                                    <button type="submit" 
                                                        class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                                                        Approve
                                                    </button>
                                                </form>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>

            <!-- Pagination -->
            <div class="mt-6">
                {{ $bookings->appends(request()->query())->links() }}
            </div>
        @else
            <div class="text-center py-12">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
                <h3 class="mt-2 text-sm font-medium text-gray-900">No bookings found</h3>
                <p class="mt-1 text-sm text-gray-500">No bookings match your current filters.</p>
            </div>
        @endif
    </div>
</div>
@endsection