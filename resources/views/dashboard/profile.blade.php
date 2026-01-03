@extends('layouts.app')

@section('title', 'Profile - Dashboard')

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
                    My Profile
                </h2>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Profile Information -->
            <div class="lg:col-span-2">
                <div class="bg-white shadow rounded-lg">
                    <div class="px-4 py-5 sm:p-6">
                        <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">
                            Profile Information
                        </h3>
                        
                        <form action="{{ route('dashboard.profile.update') }}" method="POST">
                            @csrf
                            @method('PUT')
                            
                            <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                                <div>
                                    <label for="name" class="block text-sm font-medium text-gray-700">Full Name</label>
                                    <input type="text" name="name" id="name" value="{{ old('name', auth()->user()->name) }}" required
                                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                                    @error('name')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="email" class="block text-sm font-medium text-gray-700">Email Address</label>
                                    <input type="email" value="{{ auth()->user()->email }}" disabled
                                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm bg-gray-50 text-gray-500">
                                    <p class="mt-1 text-xs text-gray-500">Email cannot be changed. Contact support if needed.</p>
                                </div>

                                <div>
                                    <label for="phone" class="block text-sm font-medium text-gray-700">Phone Number</label>
                                    <input type="text" name="phone" id="phone" value="{{ old('phone', auth()->user()->phone) }}" required
                                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                                    @error('phone')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="preferred_language" class="block text-sm font-medium text-gray-700">Preferred Language</label>
                                    <select name="preferred_language" id="preferred_language" required
                                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                                        <option value="en" {{ auth()->user()->preferred_language === 'en' ? 'selected' : '' }}>English</option>
                                        <option value="am" {{ auth()->user()->preferred_language === 'am' ? 'selected' : '' }}>አማርኛ (Amharic)</option>
                                    </select>
                                    @error('preferred_language')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="mt-6">
                                <button type="submit" 
                                    class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                    Update Profile
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Change Password -->
                <div class="bg-white shadow rounded-lg mt-6">
                    <div class="px-4 py-5 sm:p-6">
                        <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">
                            Change Password
                        </h3>
                        
                        <form action="{{ route('dashboard.password.change') }}" method="POST">
                            @csrf
                            @method('PUT')
                            
                            <div class="grid grid-cols-1 gap-6">
                                <div>
                                    <label for="current_password" class="block text-sm font-medium text-gray-700">Current Password</label>
                                    <input type="password" name="current_password" id="current_password" required
                                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                                    @error('current_password')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                                    <div>
                                        <label for="password" class="block text-sm font-medium text-gray-700">New Password</label>
                                        <input type="password" name="password" id="password" required
                                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                                        @error('password')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div>
                                        <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Confirm New Password</label>
                                        <input type="password" name="password_confirmation" id="password_confirmation" required
                                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                                    </div>
                                </div>
                            </div>

                            <div class="mt-6">
                                <button type="submit" 
                                    class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                                    Change Password
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Profile Summary -->
            <div class="lg:col-span-1">
                <div class="bg-white shadow rounded-lg p-6">
                    <div class="text-center">
                        <div class="h-24 w-24 rounded-full bg-blue-100 flex items-center justify-center mx-auto mb-4">
                            <span class="text-blue-600 font-bold text-2xl">
                                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                            </span>
                        </div>
                        <h3 class="text-lg font-medium text-gray-900">{{ auth()->user()->name }}</h3>
                        <p class="text-sm text-gray-500">{{ auth()->user()->email }}</p>
                        <div class="mt-4">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                @if(auth()->user()->role->name === 'super_admin') bg-red-100 text-red-800
                                @elseif(auth()->user()->role->name === 'admin') bg-yellow-100 text-yellow-800
                                @else bg-green-100 text-green-800 @endif">
                                {{ ucfirst(str_replace('_', ' ', auth()->user()->role->name)) }}
                            </span>
                        </div>
                    </div>

                    <div class="mt-6 border-t border-gray-200 pt-6">
                        <dl class="space-y-3">
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Phone</dt>
                                <dd class="text-sm text-gray-900">{{ auth()->user()->phone }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Language</dt>
                                <dd class="text-sm text-gray-900">
                                    {{ auth()->user()->preferred_language === 'am' ? 'አማርኛ (Amharic)' : 'English' }}
                                </dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Member Since</dt>
                                <dd class="text-sm text-gray-900">{{ auth()->user()->created_at->format('M d, Y') }}</dd>
                            </div>
                            @if(auth()->user()->last_login_at)
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Last Login</dt>
                                    <dd class="text-sm text-gray-900">{{ auth()->user()->last_login_at->diffForHumans() }}</dd>
                                </div>
                            @endif
                        </dl>
                    </div>
                </div>

                <!-- Account Statistics -->
                <div class="bg-white shadow rounded-lg p-6 mt-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Account Statistics</h3>
                    <div class="space-y-3">
                        <div class="flex justify-between">
                            <span class="text-sm text-gray-500">Total Bookings</span>
                            <span class="text-sm font-medium text-gray-900">{{ auth()->user()->bookings->count() }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-sm text-gray-500">Total Purchases</span>
                            <span class="text-sm font-medium text-gray-900">{{ auth()->user()->purchases->count() }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-sm text-gray-500">Account Status</span>
                            <span class="text-sm font-medium {{ auth()->user()->status === 'active' ? 'text-green-600' : 'text-red-600' }}">
                                {{ ucfirst(auth()->user()->status) }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection