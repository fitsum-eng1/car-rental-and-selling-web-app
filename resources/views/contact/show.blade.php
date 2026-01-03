@extends('layouts.app')

@section('title', 'Contact Us - Car Rental & Sales System')

@section('content')
<div class="bg-white">
    <div class="max-w-7xl mx-auto py-16 px-4 sm:px-6 lg:px-8">
        <div class="max-w-lg mx-auto md:max-w-none md:grid md:grid-cols-2 md:gap-8">
            <div>
                <h2 class="text-2xl font-extrabold text-gray-900 sm:text-3xl">
                    @if(app()->getLocale() === 'am')
                        ያግኙን
                    @else
                        Get in touch
                    @endif
                </h2>
                <div class="mt-3">
                    <p class="text-lg text-gray-500">
                        @if(app()->getLocale() === 'am')
                            ጥያቄዎች ወይም አስተያየቶች አሉዎት? እኛ እዚህ ነን እርስዎን ለመርዳት!
                        @else
                            Have questions or feedback? We're here to help!
                        @endif
                    </p>
                </div>
                <div class="mt-9">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-6 w-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                            </svg>
                        </div>
                        <div class="ml-3 text-base text-gray-500">
                            <p>+251-911-000-000</p>
                            <p class="mt-1">+251-911-000-001</p>
                        </div>
                    </div>
                    <div class="mt-6 flex">
                        <div class="flex-shrink-0">
                            <svg class="h-6 w-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <div class="ml-3 text-base text-gray-500">
                            <p>info@carrental.com</p>
                            <p class="mt-1">support@carrental.com</p>
                        </div>
                    </div>
                    <div class="mt-6 flex">
                        <div class="flex-shrink-0">
                            <svg class="h-6 w-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                        </div>
                        <div class="ml-3 text-base text-gray-500">
                            <p>Addis Ababa, Ethiopia</p>
                            <p class="mt-1">Bole Sub City, Woreda 03</p>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="mt-12 sm:mt-16 md:mt-0">
                <h2 class="text-2xl font-extrabold text-gray-900 sm:text-3xl">
                    @if(app()->getLocale() === 'am')
                        መልእክት ይላኩ
                    @else
                        Send us a message
                    @endif
                </h2>
                <div class="mt-3">
                    <form method="POST" action="{{ route('contact.store') }}" class="grid grid-cols-1 gap-y-6">
                        @csrf
                        
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700">
                                @if(app()->getLocale() === 'am')
                                    ሙሉ ስም
                                @else
                                    Full name
                                @endif
                            </label>
                            <div class="mt-1">
                                <input type="text" name="name" id="name" required
                                       class="py-3 px-4 block w-full shadow-sm focus:ring-blue-500 focus:border-blue-500 border-gray-300 rounded-md @error('name') border-red-500 @enderror"
                                       value="{{ old('name') }}">
                                @error('name')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        
                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700">
                                @if(app()->getLocale() === 'am')
                                    ኢሜይል
                                @else
                                    Email
                                @endif
                            </label>
                            <div class="mt-1">
                                <input id="email" name="email" type="email" required
                                       class="py-3 px-4 block w-full shadow-sm focus:ring-blue-500 focus:border-blue-500 border-gray-300 rounded-md @error('email') border-red-500 @enderror"
                                       value="{{ old('email') }}">
                                @error('email')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        
                        <div>
                            <label for="phone" class="block text-sm font-medium text-gray-700">
                                @if(app()->getLocale() === 'am')
                                    ስልክ ቁጥር
                                @else
                                    Phone number
                                @endif
                            </label>
                            <div class="mt-1">
                                <input type="tel" name="phone" id="phone"
                                       class="py-3 px-4 block w-full shadow-sm focus:ring-blue-500 focus:border-blue-500 border-gray-300 rounded-md @error('phone') border-red-500 @enderror"
                                       value="{{ old('phone') }}">
                                @error('phone')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        
                        <div>
                            <label for="subject" class="block text-sm font-medium text-gray-700">
                                @if(app()->getLocale() === 'am')
                                    ርዕስ
                                @else
                                    Subject
                                @endif
                            </label>
                            <div class="mt-1">
                                <input type="text" name="subject" id="subject" required
                                       class="py-3 px-4 block w-full shadow-sm focus:ring-blue-500 focus:border-blue-500 border-gray-300 rounded-md @error('subject') border-red-500 @enderror"
                                       value="{{ old('subject') }}">
                                @error('subject')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        
                        <div>
                            <label for="message" class="block text-sm font-medium text-gray-700">
                                @if(app()->getLocale() === 'am')
                                    መልእክት
                                @else
                                    Message
                                @endif
                            </label>
                            <div class="mt-1">
                                <textarea id="message" name="message" rows="4" required
                                          class="py-3 px-4 block w-full shadow-sm focus:ring-blue-500 focus:border-blue-500 border border-gray-300 rounded-md @error('message') border-red-500 @enderror">{{ old('message') }}</textarea>
                                @error('message')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        
                        <div>
                            <button type="submit" class="w-full inline-flex justify-center py-3 px-6 border border-transparent shadow-sm text-base font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                @if(app()->getLocale() === 'am')
                                    መልእክት ላክ
                                @else
                                    Send message
                                @endif
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection