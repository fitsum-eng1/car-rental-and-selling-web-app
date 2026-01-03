@extends('layouts.app')

@section('title', 'Reports - Admin Panel')

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
                        Reports & Analytics
                    </h2>
                </div>
                <div class="flex space-x-3">
                    <form method="GET" action="{{ route('admin.reports') }}" class="flex items-center space-x-2">
                        <select name="date_range" onchange="this.form.submit()" 
                            class="border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                            <option value="this_month" {{ $dateRange === 'this_month' ? 'selected' : '' }}>This Month</option>
                            <option value="last_month" {{ $dateRange === 'last_month' ? 'selected' : '' }}>Last Month</option>
                            <option value="this_year" {{ $dateRange === 'this_year' ? 'selected' : '' }}>This Year</option>
                            <option value="last_year" {{ $dateRange === 'last_year' ? 'selected' : '' }}>Last Year</option>
                        </select>
                    </form>
                    <button onclick="window.print()" 
                        class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                        </svg>
                        Print Report
                    </button>
                </div>
            </div>
            <p class="mt-2 text-sm text-gray-600">
                Report period: {{ $startDate->format('M d, Y') }} - {{ $endDate->format('M d, Y') }}
            </p>
        </div>

        <!-- Summary Cards -->
        <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-4 mb-8">
            <!-- Bookings Summary -->
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
                                <dd class="text-lg font-medium text-gray-900">{{ number_format($reports['bookings']['total']) }}</dd>
                            </dl>
                        </div>
                    </div>
                    <div class="mt-3">
                        <div class="text-sm text-gray-500">
                            Completed: {{ number_format($reports['bookings']['completed']) }}
                        </div>
                        <div class="text-sm font-medium text-green-600">
                            Revenue: ${{ number_format($reports['bookings']['revenue'], 2) }}
                        </div>
                    </div>
                </div>
            </div>

            <!-- Purchases Summary -->
            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="p-5">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <svg class="h-6 w-6 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                            </svg>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 truncate">Total Purchases</dt>
                                <dd class="text-lg font-medium text-gray-900">{{ number_format($reports['purchases']['total']) }}</dd>
                            </dl>
                        </div>
                    </div>
                    <div class="mt-3">
                        <div class="text-sm text-gray-500">
                            Completed: {{ number_format($reports['purchases']['completed']) }}
                        </div>
                        <div class="text-sm font-medium text-green-600">
                            Revenue: ${{ number_format($reports['purchases']['revenue'], 2) }}
                        </div>
                    </div>
                </div>
            </div>

            <!-- Users Summary -->
            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="p-5">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <svg class="h-6 w-6 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z" />
                            </svg>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 truncate">New Users</dt>
                                <dd class="text-lg font-medium text-gray-900">{{ number_format($reports['users']['new_registrations']) }}</dd>
                            </dl>
                        </div>
                    </div>
                    <div class="mt-3">
                        <div class="text-sm text-gray-500">
                            Active Users: {{ number_format($reports['users']['active_users']) }}
                        </div>
                    </div>
                </div>
            </div>

            <!-- Vehicles Summary -->
            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="p-5">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <svg class="h-6 w-6 text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                            </svg>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 truncate">Total Vehicles</dt>
                                <dd class="text-lg font-medium text-gray-900">{{ number_format($reports['vehicles']['total']) }}</dd>
                            </dl>
                        </div>
                    </div>
                    <div class="mt-3">
                        <div class="text-sm text-gray-500">
                            For Rent: {{ number_format($reports['vehicles']['available_for_rent']) }}
                        </div>
                        <div class="text-sm text-gray-500">
                            For Sale: {{ number_format($reports['vehicles']['available_for_sale']) }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <!-- Popular Vehicles -->
            <div class="bg-white shadow rounded-lg">
                <div class="px-4 py-5 sm:p-6">
                    <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">
                        Most Popular Rentals
                    </h3>
                    @if($popularRentals->count() > 0)
                        <div class="space-y-4">
                            @foreach($popularRentals as $vehicle)
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-10 w-10">
                                            @if($vehicle->primary_image)
                                                <img class="h-10 w-10 rounded object-cover" src="{{ asset('storage/' . $vehicle->primary_image) }}" alt="{{ $vehicle->full_name }}">
                                            @else
                                                <div class="h-10 w-10 rounded bg-gray-200 flex items-center justify-center">
                                                    <svg class="h-5 w-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd" d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z" clip-rule="evenodd" />
                                                    </svg>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="ml-4">
                                            <p class="text-sm font-medium text-gray-900">{{ $vehicle->full_name }}</p>
                                            <p class="text-sm text-gray-500">${{ number_format($vehicle->daily_rate, 2) }}/day</p>
                                        </div>
                                    </div>
                                    <div class="text-right">
                                        <p class="text-sm font-medium text-gray-900">{{ $vehicle->bookings_count }} bookings</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-gray-500 text-center py-4">No rental data available for this period.</p>
                    @endif
                </div>
            </div>

            <!-- Revenue Breakdown -->
            <div class="bg-white shadow rounded-lg">
                <div class="px-4 py-5 sm:p-6">
                    <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">
                        Revenue Breakdown
                    </h3>
                    <div class="space-y-4">
                        <div class="flex items-center justify-between p-4 bg-blue-50 rounded-lg">
                            <div>
                                <p class="text-sm font-medium text-blue-900">Rental Revenue</p>
                                <p class="text-xs text-blue-700">From {{ $reports['bookings']['completed'] }} completed bookings</p>
                            </div>
                            <p class="text-lg font-bold text-blue-900">${{ number_format($reports['bookings']['revenue'], 2) }}</p>
                        </div>
                        
                        <div class="flex items-center justify-between p-4 bg-green-50 rounded-lg">
                            <div>
                                <p class="text-sm font-medium text-green-900">Sales Revenue</p>
                                <p class="text-xs text-green-700">From {{ $reports['purchases']['completed'] }} completed purchases</p>
                            </div>
                            <p class="text-lg font-bold text-green-900">${{ number_format($reports['purchases']['revenue'], 2) }}</p>
                        </div>
                        
                        <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg border-2 border-gray-200">
                            <div>
                                <p class="text-sm font-medium text-gray-900">Total Revenue</p>
                                <p class="text-xs text-gray-700">Combined revenue for this period</p>
                            </div>
                            <p class="text-xl font-bold text-gray-900">${{ number_format($reports['bookings']['revenue'] + $reports['purchases']['revenue'], 2) }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Detailed Statistics -->
        <div class="mt-8 bg-white shadow rounded-lg">
            <div class="px-4 py-5 sm:p-6">
                <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">
                    Detailed Statistics
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                    <div class="text-center">
                        <dt class="text-sm font-medium text-gray-500">Booking Completion Rate</dt>
                        <dd class="mt-1 text-2xl font-semibold text-gray-900">
                            {{ $reports['bookings']['total'] > 0 ? number_format(($reports['bookings']['completed'] / $reports['bookings']['total']) * 100, 1) : 0 }}%
                        </dd>
                    </div>
                    
                    <div class="text-center">
                        <dt class="text-sm font-medium text-gray-500">Purchase Completion Rate</dt>
                        <dd class="mt-1 text-2xl font-semibold text-gray-900">
                            {{ $reports['purchases']['total'] > 0 ? number_format(($reports['purchases']['completed'] / $reports['purchases']['total']) * 100, 1) : 0 }}%
                        </dd>
                    </div>
                    
                    <div class="text-center">
                        <dt class="text-sm font-medium text-gray-500">Average Booking Value</dt>
                        <dd class="mt-1 text-2xl font-semibold text-gray-900">
                            ${{ $reports['bookings']['completed'] > 0 ? number_format($reports['bookings']['revenue'] / $reports['bookings']['completed'], 2) : '0.00' }}
                        </dd>
                    </div>
                    
                    <div class="text-center">
                        <dt class="text-sm font-medium text-gray-500">Average Purchase Value</dt>
                        <dd class="mt-1 text-2xl font-semibold text-gray-900">
                            ${{ $reports['purchases']['completed'] > 0 ? number_format($reports['purchases']['revenue'] / $reports['purchases']['completed'], 2) : '0.00' }}
                        </dd>
                    </div>
                </div>
            </div>
        </div>

        <!-- Export Options -->
        <div class="mt-8 bg-white shadow rounded-lg">
            <div class="px-4 py-5 sm:p-6">
                <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">
                    Export Reports
                </h3>
                <div class="flex space-x-4">
                    <a href="{{ route('admin.reports.export', 'csv') }}?date_range={{ $dateRange }}" 
                        class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                        <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        Export CSV
                    </a>
                    
                    <a href="{{ route('admin.reports.export', 'pdf') }}?date_range={{ $dateRange }}" 
                        class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                        <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                        </svg>
                        Export PDF
                    </a>
                </div>
                <p class="mt-2 text-sm text-gray-500">
                    Export comprehensive reports in CSV format for data analysis or PDF format for presentations and printing.
                </p>
            </div>
        </div>
    </div>
</div>

<style>
@media print {
    .no-print {
        display: none !important;
    }
    
    body {
        background: white !important;
    }
    
    .bg-gray-50 {
        background: white !important;
    }
}
</style>
@endsection