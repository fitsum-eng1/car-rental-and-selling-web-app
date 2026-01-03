@extends('layouts.app')

@section('title', 'My Purchases - Dashboard')

@section('content')
<div class="bg-gray-50 min-h-screen">
    <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
        <!-- Page header -->
        <div class="mb-8">
            <div class="flex items-center">
                <a href="{{ route('dashboard') }}" class="text-gray-500 hover:text-gray-700 mr-4">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                </a>
                <h2 class="text-2xl font-bold leading-7 text-gray-900 sm:text-3xl sm:truncate">
                    @if(app()->getLocale() === 'am')
                        የእኔ ግዢዎች
                    @else
                        My Purchases
                    @endif
                </h2>
            </div>
        </div>

        @if($purchases->count() > 0)
            <div class="bg-white shadow overflow-hidden sm:rounded-md">
                <ul class="divide-y divide-gray-200">
                    @foreach($purchases as $purchase)
                        <li class="animate__animated animate__fadeInUp" style="animation-delay: {{ $loop->index * 100 }}ms">
                            <div class="px-4 py-4 sm:px-6">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-20 w-20">
                                            @if($purchase->vehicle->primary_image)
                                                <img class="h-20 w-20 rounded-lg object-cover" src="{{ asset('storage/' . $purchase->vehicle->primary_image) }}" alt="{{ $purchase->vehicle->full_name }}">
                                            @else
                                                <div class="h-20 w-20 rounded-lg bg-gray-200 flex items-center justify-center">
                                                    <svg class="h-8 w-8 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd" d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z" clip-rule="evenodd" />
                                                    </svg>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="ml-4">
                                            <div class="flex items-center">
                                                <p class="text-lg font-medium text-indigo-600 truncate">
                                                    {{ $purchase->vehicle->full_name }}
                                                </p>
                                                <span class="ml-2 inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                                    @if($purchase->status === 'completed') bg-green-100 text-green-800
                                                    @elseif($purchase->status === 'pending') bg-yellow-100 text-yellow-800
                                                    @elseif($purchase->status === 'rejected') bg-red-100 text-red-800
                                                    @elseif($purchase->status === 'processing') bg-blue-100 text-blue-800
                                                    @elseif($purchase->status === 'verified') bg-green-100 text-green-800
                                                    @else bg-gray-100 text-gray-800 @endif">
                                                    @if($purchase->status === 'rejected')
                                                        Rejected
                                                    @else
                                                        {{ ucfirst($purchase->status) }}
                                                    @endif
                                                </span>
                                            </div>
                                            <div class="mt-2 flex items-center text-sm text-gray-500">
                                                <svg class="flex-shrink-0 mr-1.5 h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                </svg>
                                                <p>
                                                    @if(app()->getLocale() === 'am')
                                                        {{ $purchase->created_at->format('M d, Y') }}
                                                    @else
                                                        Purchased on {{ $purchase->created_at->format('M d, Y') }}
                                                    @endif
                                                </p>
                                            </div>
                                            <div class="mt-2 flex items-center text-sm text-gray-500">
                                                <svg class="flex-shrink-0 mr-1.5 h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                                                </svg>
                                                <p>{{ $purchase->purchase_reference }}</p>
                                            </div>
                                            @if($purchase->payment)
                                                <div class="mt-2 flex items-center text-sm text-gray-500">
                                                    <svg class="flex-shrink-0 mr-1.5 h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                                                    </svg>
                                                    <p>
                                                        @if(app()->getLocale() === 'am')
                                                            ክፍያ: {{ ucfirst($purchase->payment->status) }}
                                                        @else
                                                            Payment: {{ ucfirst($purchase->payment->status) }}
                                                        @endif
                                                    </p>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="flex flex-col items-end">
                                        <div class="text-lg font-medium text-gray-900">
                                            ${{ number_format($purchase->total_amount, 2) }}
                                        </div>
                                        <div class="mt-2 flex space-x-2">
                                            <a href="{{ route('purchases.show', $purchase) }}" 
                                                class="inline-flex items-center px-3 py-2 border border-gray-300 shadow-sm text-sm leading-4 font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                                @if(app()->getLocale() === 'am')
                                                    ዝርዝር
                                                @else
                                                    View Details
                                                @endif
                                            </a>
                                            @if($purchase->status === 'pending' && !$purchase->payment)
                                                <a href="{{ route('purchases.payment', $purchase) }}" 
                                                    class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                                    @if(app()->getLocale() === 'am')
                                                        ክፍያ
                                                    @else
                                                        Pay Now
                                                    @endif
                                                </a>
                                            @endif
                                            @if($purchase->status === 'completed')
                                                <span class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-white bg-green-600">
                                                    @if(app()->getLocale() === 'am')
                                                        ተጠናቅቋል
                                                    @else
                                                        Completed
                                                    @endif
                                                </span>
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
                {{ $purchases->links() }}
            </div>
        @else
            <div class="text-center py-12">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                </svg>
                <h3 class="mt-2 text-sm font-medium text-gray-900">
                    @if(app()->getLocale() === 'am')
                        ምንም ግዢ የለም
                    @else
                        No purchases found
                    @endif
                </h3>
                <p class="mt-1 text-sm text-gray-500">
                    @if(app()->getLocale() === 'am')
                        መኪና በመግዛት ይጀምሩ።
                    @else
                        Get started by purchasing a vehicle.
                    @endif
                </p>
                <div class="mt-6">
                    <a href="{{ route('vehicles.sales') }}" 
                        class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                        </svg>
                        @if(app()->getLocale() === 'am')
                            መኪና ይግዙ
                        @else
                            Buy a Vehicle
                        @endif
                    </a>
                </div>
            </div>
        @endif
    </div>
</div>
@endsection