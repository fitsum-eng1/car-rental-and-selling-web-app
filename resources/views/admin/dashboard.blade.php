@extends('layouts.app')

@section('title', 'Admin Dashboard - Car Rental & Sales System')

@section('content')
<div class="bg-gray-50 min-h-screen">
    <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
        <!-- Page header -->
        <div class="md:flex md:items-center md:justify-between mb-8">
            <div class="flex-1 min-w-0">
                <h2 class="text-2xl font-bold leading-7 text-gray-900 sm:text-3xl sm:truncate">
                    Admin Dashboard
                </h2>
            </div>
            <div class="mt-4 flex md:mt-0 md:ml-4">
                <a href="{{ route('admin.reports') }}" class="ml-3 inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700">
                    View Reports
                </a>
            </div>
        </div>

        <!-- Stats -->
        <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-4 mb-8">
            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="p-5">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <svg class="h-6 w-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z" />
                            </svg>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 truncate">Total Users</dt>
                                <dd class="text-lg font-medium text-gray-900">{{ $stats['total_users'] }}</dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="p-5">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <svg class="h-6 w-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                            </svg>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 truncate">Total Vehicles</dt>
                                <dd class="text-lg font-medium text-gray-900">{{ $stats['total_vehicles'] }}</dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="p-5">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <svg class="h-6 w-6 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 truncate">Total Bookings</dt>
                                <dd class="text-lg font-medium text-gray-900">{{ $stats['total_bookings'] }}</dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="p-5">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <svg class="h-6 w-6 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 truncate">Monthly Revenue</dt>
                                <dd class="text-lg font-medium text-gray-900">${{ number_format($stats['monthly_revenue'], 2) }}</dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Stuck Bookings Alert -->
        @if($stats['stuck_bookings'] > 0)
            <div class="mb-8 bg-red-50 border border-red-200 rounded-md p-4">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-red-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-sm font-medium text-red-800">Stuck Bookings Detected</h3>
                        <div class="mt-2 text-sm text-red-700">
                            <p>
                                <strong>{{ $stats['stuck_bookings'] }}</strong> booking{{ $stats['stuck_bookings'] > 1 ? 's' : '' }} 
                                {{ $stats['stuck_bookings'] > 1 ? 'are' : 'is' }} stuck in "pending payment" status without payment records.
                                @if($stats['critical_stuck_bookings'] > 0)
                                    <strong class="text-red-900">{{ $stats['critical_stuck_bookings'] }} critical</strong> (over 7 days old).
                                @endif
                            </p>
                            @if($stats['oldest_stuck_booking_days'] > 0)
                                <p class="mt-1">
                                    <strong>Oldest stuck booking:</strong> {{ $stats['oldest_stuck_booking_days'] }} days old
                                </p>
                            @endif
                        </div>
                        <div class="mt-4">
                            <div class="flex space-x-3">
                                <a href="{{ route('admin.bookings.index', ['filter' => 'stuck']) }}" 
                                    class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                                    <svg class="-ml-1 mr-1 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z" />
                                    </svg>
                                    View Stuck Bookings
                                </a>
                                @if($stats['critical_stuck_bookings'] > 0)
                                    <a href="{{ route('admin.bookings.index', ['filter' => 'critical']) }}" 
                                        class="inline-flex items-center px-3 py-2 border border-red-300 text-sm leading-4 font-medium rounded-md text-red-700 bg-white hover:bg-red-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                                        <svg class="-ml-1 mr-1 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        Critical Only
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <!-- Quick Stats Row -->
        <div class="grid grid-cols-1 gap-5 sm:grid-cols-4 mb-8">
            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="p-5">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <svg class="h-6 w-6 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 truncate">Pending Payments</dt>
                                <dd class="text-lg font-medium text-gray-900">{{ $stats['pending_payments'] }}</dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="p-5">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <svg class="h-6 w-6 {{ $stats['stuck_bookings'] > 0 ? 'text-red-400' : 'text-gray-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z" />
                            </svg>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 truncate">Stuck Bookings</dt>
                                <dd class="text-lg font-medium {{ $stats['stuck_bookings'] > 0 ? 'text-red-900' : 'text-gray-900' }}">{{ $stats['stuck_bookings'] }}</dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="p-5">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <svg class="h-6 w-6 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                            </svg>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 truncate">New Messages</dt>
                                <dd class="text-lg font-medium text-gray-900">{{ $stats['new_messages'] }}</dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="p-5">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <svg class="h-6 w-6 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                            </svg>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 truncate">Active Bookings</dt>
                                <dd class="text-lg font-medium text-gray-900">{{ $stats['active_bookings'] }}</dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Activity -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-8">
            <!-- Recent Bookings -->
            <div class="bg-white shadow rounded-lg">
                <div class="px-4 py-5 sm:p-6">
                    <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">Recent Bookings</h3>
                    @if($recentBookings->count() > 0)
                        <div class="space-y-4">
                            @foreach($recentBookings as $booking)
                                <div class="flex items-center justify-between p-3 border rounded">
                                    <div>
                                        <p class="text-sm font-medium text-gray-900">{{ $booking->vehicle->full_name }}</p>
                                        <p class="text-sm text-gray-500">{{ $booking->user->name }} • {{ $booking->booking_reference }}</p>
                                        <p class="text-xs text-gray-400">{{ $booking->created_at->diffForHumans() }}</p>
                                    </div>
                                    <div class="text-right">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                            @if($booking->status === 'confirmed') bg-green-100 text-green-800
                                            @elseif($booking->status === 'pending_payment') bg-yellow-100 text-yellow-800
                                            @else bg-gray-100 text-gray-800 @endif">
                                            {{ ucfirst(str_replace('_', ' ', $booking->status)) }}
                                        </span>
                                        <p class="text-sm font-medium text-gray-900 mt-1">${{ $booking->total_amount }}</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <div class="mt-4">
                            <a href="{{ route('admin.bookings.index') }}" class="text-blue-600 hover:text-blue-500 text-sm font-medium">
                                View all bookings →
                            </a>
                        </div>
                    @else
                        <p class="text-gray-500 text-center py-4">No recent bookings</p>
                    @endif
                </div>
            </div>

            <!-- Pending Payments -->
            <div class="bg-white shadow rounded-lg">
                <div class="px-4 py-5 sm:p-6">
                    <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">Pending Payments</h3>
                    @if($pendingPayments->count() > 0)
                        <div class="space-y-4">
                            @foreach($pendingPayments->take(5) as $payment)
                                <div class="flex items-center justify-between p-3 border rounded">
                                    <div>
                                        <p class="text-sm font-medium text-gray-900">{{ $payment->user->name }}</p>
                                        <p class="text-sm text-gray-500">{{ $payment->payment_reference }}</p>
                                        <p class="text-xs text-gray-400">{{ $payment->created_at->diffForHumans() }}</p>
                                    </div>
                                    <div class="text-right">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                            @if($payment->status === 'submitted') bg-yellow-100 text-yellow-800
                                            @else bg-gray-100 text-gray-800 @endif">
                                            {{ ucfirst($payment->status) }}
                                        </span>
                                        <p class="text-sm font-medium text-gray-900 mt-1">${{ $payment->amount }}</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <div class="mt-4">
                            <a href="{{ route('admin.payments.index') }}" class="text-blue-600 hover:text-blue-500 text-sm font-medium">
                                View all payments →
                            </a>
                        </div>
                    @else
                        <p class="text-gray-500 text-center py-4">No pending payments</p>
                    @endif
                </div>
            </div>

            <!-- Stuck Bookings -->
            <div class="bg-white shadow rounded-lg">
                <div class="px-4 py-5 sm:p-6">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg leading-6 font-medium text-gray-900">Stuck Bookings</h3>
                        @if($stats['stuck_bookings'] > 0)
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                {{ $stats['stuck_bookings'] }} stuck
                            </span>
                        @endif
                    </div>
                    @if($stuckBookings->count() > 0)
                        <div class="space-y-4">
                            @foreach($stuckBookings as $booking)
                                <div class="p-3 border border-red-200 rounded bg-red-50">
                                    <div class="flex items-center justify-between">
                                        <div>
                                            <p class="text-sm font-medium text-gray-900">{{ $booking->vehicle->full_name }}</p>
                                            <p class="text-sm text-gray-600">{{ $booking->user->name }} • {{ $booking->booking_reference }}</p>
                                            <p class="text-xs text-red-600">
                                                Stuck for {{ round($booking->getStuckAge() / 24, 1) }} days
                                                • {{ ucfirst($booking->getUrgencyLevel()) }} priority
                                            </p>
                                        </div>
                                        <div class="text-right">
                                            <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium
                                                @if($booking->getUrgencyLevel() === 'critical') bg-red-200 text-red-900
                                                @elseif($booking->getUrgencyLevel() === 'urgent') bg-orange-200 text-orange-900
                                                @elseif($booking->getUrgencyLevel() === 'warning') bg-yellow-200 text-yellow-900
                                                @else bg-gray-200 text-gray-900 @endif">
                                                {{ ucfirst($booking->getUrgencyLevel()) }}
                                            </span>
                                            <p class="text-sm font-medium text-gray-900 mt-1">${{ $booking->total_amount }}</p>
                                        </div>
                                    </div>
                                    <div class="mt-2">
                                        <a href="{{ route('admin.bookings.show', $booking) }}" 
                                            class="text-xs text-red-700 hover:text-red-600 font-medium">
                                            Take Action →
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <div class="mt-4">
                            <a href="{{ route('admin.bookings.index', ['filter' => 'stuck']) }}" class="text-red-600 hover:text-red-500 text-sm font-medium">
                                View all stuck bookings →
                            </a>
                        </div>
                    @else
                        <div class="text-center py-4">
                            <svg class="mx-auto h-8 w-8 text-green-400 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <p class="text-green-600 text-sm font-medium">No stuck bookings</p>
                            <p class="text-gray-500 text-xs">All bookings are processing normally</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="bg-white shadow rounded-lg">
            <div class="px-4 py-5 sm:p-6">
                <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">Quick Actions</h3>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4">
                    <a href="{{ route('admin.vehicles.create') }}" class="bg-blue-50 hover:bg-blue-100 p-4 rounded-lg text-center transition duration-300">
                        <svg class="mx-auto h-8 w-8 text-blue-600 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                        </svg>
                        <p class="text-sm font-medium text-blue-600">Add Vehicle</p>
                    </a>
                    
                    <a href="{{ route('admin.users.index') }}" class="bg-green-50 hover:bg-green-100 p-4 rounded-lg text-center transition duration-300">
                        <svg class="mx-auto h-8 w-8 text-green-600 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z" />
                        </svg>
                        <p class="text-sm font-medium text-green-600">Manage Users</p>
                    </a>
                    
                    <a href="{{ route('admin.payments.index') }}" class="bg-yellow-50 hover:bg-yellow-100 p-4 rounded-lg text-center transition duration-300">
                        <svg class="mx-auto h-8 w-8 text-yellow-600 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <p class="text-sm font-medium text-yellow-600">Verify Payments</p>
                    </a>
                    
                    <a href="{{ route('admin.bookings.index', ['filter' => 'stuck']) }}" class="bg-red-50 hover:bg-red-100 p-4 rounded-lg text-center transition duration-300 {{ $stats['stuck_bookings'] > 0 ? 'ring-2 ring-red-200' : '' }}">
                        <div class="relative">
                            <svg class="mx-auto h-8 w-8 text-red-600 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z" />
                            </svg>
                            @if($stats['stuck_bookings'] > 0)
                                <span class="absolute -top-1 -right-1 inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-red-100 bg-red-600 rounded-full">{{ $stats['stuck_bookings'] }}</span>
                            @endif
                        </div>
                        <p class="text-sm font-medium text-red-600">Stuck Bookings</p>
                    </a>
                    
                    <a href="{{ route('admin.messages.index') }}" class="bg-purple-50 hover:bg-purple-100 p-4 rounded-lg text-center transition duration-300">
                        <svg class="mx-auto h-8 w-8 text-purple-600 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                        </svg>
                        <p class="text-sm font-medium text-purple-600">Messages</p>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection