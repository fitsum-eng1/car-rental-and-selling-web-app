@extends('layouts.app')

@section('title', 'User Details - Admin Panel')

@section('content')
<div class="bg-gray-50 min-h-screen">
    <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
        <!-- Page header -->
        <div class="mb-8">
            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <a href="{{ route('admin.users.index') }}" class="text-gray-500 hover:text-gray-700 mr-4">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                        </svg>
                    </a>
                    <h2 class="text-2xl font-bold leading-7 text-gray-900 sm:text-3xl sm:truncate">
                        {{ $user->name }}
                    </h2>
                </div>
                <div class="flex space-x-3">
                    <a href="{{ route('admin.users.edit', $user) }}" 
                        class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700">
                        Edit User
                    </a>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- User Information -->
            <div class="lg:col-span-1">
                <div class="bg-white shadow rounded-lg p-6">
                    <div class="text-center">
                        <div class="h-24 w-24 rounded-full bg-blue-100 flex items-center justify-center mx-auto mb-4">
                            <span class="text-blue-600 font-bold text-2xl">
                                {{ strtoupper(substr($user->name, 0, 1)) }}
                            </span>
                        </div>
                        <h3 class="text-lg font-medium text-gray-900">{{ $user->name }}</h3>
                        <p class="text-sm text-gray-500">{{ $user->email }}</p>
                        <div class="mt-4 flex justify-center space-x-2">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                @if($user->role->name === 'super_admin') bg-red-100 text-red-800
                                @elseif($user->role->name === 'admin') bg-yellow-100 text-yellow-800
                                @else bg-green-100 text-green-800 @endif">
                                {{ ucfirst(str_replace('_', ' ', $user->role->name)) }}
                            </span>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                @if($user->status === 'active') bg-green-100 text-green-800
                                @elseif($user->status === 'suspended') bg-red-100 text-red-800
                                @else bg-gray-100 text-gray-800 @endif">
                                {{ ucfirst($user->status) }}
                            </span>
                        </div>
                    </div>

                    <div class="mt-6 border-t border-gray-200 pt-6">
                        <dl class="space-y-3">
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Phone</dt>
                                <dd class="text-sm text-gray-900">{{ $user->phone }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Preferred Language</dt>
                                <dd class="text-sm text-gray-900">
                                    {{ $user->preferred_language === 'am' ? 'አማርኛ (Amharic)' : 'English' }}
                                </dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Member Since</dt>
                                <dd class="text-sm text-gray-900">{{ $user->created_at->format('M d, Y') }}</dd>
                            </div>
                            @if($user->last_login_at)
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Last Login</dt>
                                    <dd class="text-sm text-gray-900">{{ $user->last_login_at->diffForHumans() }}</dd>
                                </div>
                            @endif
                        </dl>
                    </div>
                </div>
            </div>

            <!-- Activity and Statistics -->
            <div class="lg:col-span-2">
                <div class="space-y-6">
                    <!-- Statistics -->
                    <div class="bg-white shadow rounded-lg p-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Activity Statistics</h3>
                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                            <div class="text-center">
                                <div class="text-2xl font-bold text-blue-600">{{ $user->bookings->count() }}</div>
                                <div class="text-sm text-gray-500">Total Bookings</div>
                            </div>
                            <div class="text-center">
                                <div class="text-2xl font-bold text-green-600">{{ $user->purchases->count() }}</div>
                                <div class="text-sm text-gray-500">Total Purchases</div>
                            </div>
                            <div class="text-center">
                                <div class="text-2xl font-bold text-purple-600">{{ $user->payments->count() }}</div>
                                <div class="text-sm text-gray-500">Total Payments</div>
                            </div>
                        </div>
                    </div>

                    <!-- Recent Bookings -->
                    @if($user->bookings->count() > 0)
                        <div class="bg-white shadow rounded-lg p-6">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Recent Bookings</h3>
                            <div class="space-y-3">
                                @foreach($user->bookings->take(5) as $booking)
                                    <div class="flex items-center justify-between p-3 border rounded">
                                        <div>
                                            <p class="text-sm font-medium text-gray-900">{{ $booking->vehicle->full_name }}</p>
                                            <p class="text-sm text-gray-500">{{ $booking->booking_reference }}</p>
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
                        </div>
                    @endif

                    <!-- Recent Purchases -->
                    @if($user->purchases->count() > 0)
                        <div class="bg-white shadow rounded-lg p-6">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Recent Purchases</h3>
                            <div class="space-y-3">
                                @foreach($user->purchases->take(5) as $purchase)
                                    <div class="flex items-center justify-between p-3 border rounded">
                                        <div>
                                            <p class="text-sm font-medium text-gray-900">{{ $purchase->vehicle->full_name }}</p>
                                            <p class="text-sm text-gray-500">{{ $purchase->purchase_reference }}</p>
                                            <p class="text-xs text-gray-400">{{ $purchase->created_at->diffForHumans() }}</p>
                                        </div>
                                        <div class="text-right">
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                                @if($purchase->status === 'completed') bg-green-100 text-green-800
                                                @elseif($purchase->status === 'pending_payment') bg-yellow-100 text-yellow-800
                                                @else bg-gray-100 text-gray-800 @endif">
                                                {{ ucfirst(str_replace('_', ' ', $purchase->status)) }}
                                            </span>
                                            <p class="text-sm font-medium text-gray-900 mt-1">${{ number_format($purchase->total_amount) }}</p>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection