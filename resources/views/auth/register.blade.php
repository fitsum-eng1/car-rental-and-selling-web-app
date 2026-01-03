@extends('layouts.app')

@section('title', 'Register - Car Rental & Sales System')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full space-y-8">
        <div>
            <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-900">
                @if(app()->getLocale() === 'am')
                    አዲስ መለያ ይፍጠሩ
                @else
                    Create your account
                @endif
            </h2>
            <p class="mt-2 text-center text-sm text-gray-600">
                @if(app()->getLocale() === 'am')
                    ወይም
                @else
                    Or
                @endif
                <a href="{{ route('login') }}" class="font-medium text-blue-600 hover:text-blue-500">
                    @if(app()->getLocale() === 'am')
                        ወደ መለያዎ ይግቡ
                    @else
                        sign in to your account
                    @endif
                </a>
            </p>
        </div>
        
        <form class="mt-8 space-y-6" method="POST" action="{{ route('register') }}">
            @csrf
            
            <div class="space-y-4">
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700">
                        @if(app()->getLocale() === 'am')
                            ሙሉ ስም
                        @else
                            Full Name
                        @endif
                    </label>
                    <input id="name" name="name" type="text" required 
                           class="mt-1 appearance-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm @error('name') border-red-500 @enderror" 
                           placeholder="@if(app()->getLocale() === 'am') ሙሉ ስምዎን ያስገቡ @else Enter your full name @endif"
                           value="{{ old('name') }}">
                    @error('name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700">
                        @if(app()->getLocale() === 'am')
                            ኢሜይል አድራሻ
                        @else
                            Email Address
                        @endif
                    </label>
                    <input id="email" name="email" type="email" required 
                           class="mt-1 appearance-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm @error('email') border-red-500 @enderror" 
                           placeholder="@if(app()->getLocale() === 'am') ኢሜይል አድራሻዎን ያስገቡ @else Enter your email address @endif"
                           value="{{ old('email') }}">
                    @error('email')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                
                <div>
                    <label for="phone" class="block text-sm font-medium text-gray-700">
                        @if(app()->getLocale() === 'am')
                            ስልክ ቁጥር
                        @else
                            Phone Number
                        @endif
                    </label>
                    <input id="phone" name="phone" type="tel" required 
                           class="mt-1 appearance-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm @error('phone') border-red-500 @enderror" 
                           placeholder="@if(app()->getLocale() === 'am') +251911000000 @else +251911000000 @endif"
                           value="{{ old('phone') }}">
                    @error('phone')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                
                <div>
                    <label for="preferred_language" class="block text-sm font-medium text-gray-700">
                        @if(app()->getLocale() === 'am')
                            ተመራጭ ቋንቋ
                        @else
                            Preferred Language
                        @endif
                    </label>
                    <select id="preferred_language" name="preferred_language" required 
                            class="mt-1 block w-full px-3 py-2 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm @error('preferred_language') border-red-500 @enderror">
                        <option value="en" {{ old('preferred_language') === 'en' ? 'selected' : '' }}>English</option>
                        <option value="am" {{ old('preferred_language') === 'am' ? 'selected' : '' }}>አማርኛ</option>
                    </select>
                    @error('preferred_language')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700">
                        @if(app()->getLocale() === 'am')
                            የይለፍ ቃል
                        @else
                            Password
                        @endif
                    </label>
                    <input id="password" name="password" type="password" required 
                           class="mt-1 appearance-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm @error('password') border-red-500 @enderror" 
                           placeholder="@if(app()->getLocale() === 'am') ጠንካራ የይለፍ ቃል ይፍጠሩ @else Create a strong password @endif">
                    @error('password')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                
                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700">
                        @if(app()->getLocale() === 'am')
                            የይለፍ ቃል ማረጋገጫ
                        @else
                            Confirm Password
                        @endif
                    </label>
                    <input id="password_confirmation" name="password_confirmation" type="password" required 
                           class="mt-1 appearance-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm" 
                           placeholder="@if(app()->getLocale() === 'am') የይለፍ ቃሉን እንደገና ያስገቡ @else Re-enter your password @endif">
                </div>
            </div>

            <div>
                <button type="submit" class="group relative w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    @if(app()->getLocale() === 'am')
                        መለያ ፍጠር
                    @else
                        Create Account
                    @endif
                </button>
            </div>
        </form>
    </div>
</div>
@endsection