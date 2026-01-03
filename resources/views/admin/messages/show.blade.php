@extends('layouts.app')

@section('title', 'Message Details - Admin Panel')

@section('content')
<div class="bg-gray-50 min-h-screen">
    <div class="max-w-4xl mx-auto py-6 sm:px-6 lg:px-8">
        <!-- Page header -->
        <div class="mb-8">
            <div class="flex items-center">
                <a href="{{ route('admin.messages.index') }}" class="text-gray-500 hover:text-gray-700 mr-4">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                </a>
                <h2 class="text-2xl font-bold leading-7 text-gray-900 sm:text-3xl sm:truncate">
                    Message from {{ $message->name }}
                </h2>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Message Content -->
            <div class="lg:col-span-2">
                <div class="bg-white shadow rounded-lg">
                    <div class="px-4 py-5 sm:p-6">
                        <!-- Message Header -->
                        <div class="border-b border-gray-200 pb-4 mb-6">
                            <div class="flex items-center justify-between">
                                <div>
                                    <h3 class="text-lg font-medium text-gray-900">{{ $message->subject }}</h3>
                                    <p class="mt-1 text-sm text-gray-500">
                                        From: {{ $message->name }} &lt;{{ $message->email }}&gt;
                                    </p>
                                    @if($message->phone)
                                        <p class="text-sm text-gray-500">
                                            Phone: {{ $message->phone }}
                                        </p>
                                    @endif
                                </div>
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                    @if($message->status === 'new') bg-red-100 text-red-800
                                    @elseif($message->status === 'read') bg-yellow-100 text-yellow-800
                                    @elseif($message->status === 'replied') bg-green-100 text-green-800
                                    @else bg-gray-100 text-gray-800 @endif">
                                    {{ ucfirst($message->status) }}
                                </span>
                            </div>
                            <p class="mt-2 text-sm text-gray-500">
                                Received {{ $message->created_at->format('M d, Y \a\t g:i A') }}
                            </p>
                        </div>

                        <!-- Message Body -->
                        <div class="prose max-w-none">
                            <div class="whitespace-pre-wrap text-gray-900">{{ $message->message }}</div>
                        </div>

                        @if($message->replied_at)
                            <!-- Previous Reply -->
                            <div class="mt-8 border-t border-gray-200 pt-6">
                                <h4 class="text-md font-medium text-gray-900 mb-4">Previous Reply</h4>
                                <div class="bg-gray-50 rounded-lg p-4">
                                    <div class="flex items-center justify-between mb-2">
                                        <p class="text-sm font-medium text-gray-900">
                                            {{ $message->repliedBy->name ?? 'Admin' }}
                                        </p>
                                        <p class="text-sm text-gray-500">
                                            {{ $message->replied_at->format('M d, Y \a\t g:i A') }}
                                        </p>
                                    </div>
                                    <div class="whitespace-pre-wrap text-gray-700">{{ $message->reply_message }}</div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Reply Form -->
                @if($message->status !== 'replied')
                    <div class="mt-6 bg-white shadow rounded-lg">
                        <form action="{{ route('admin.messages.reply', $message) }}" method="POST">
                            @csrf
                            <div class="px-4 py-5 sm:p-6">
                                <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">
                                    Send Reply
                                </h3>
                                
                                <div>
                                    <label for="reply_message" class="block text-sm font-medium text-gray-700">Reply Message</label>
                                    <textarea name="reply_message" id="reply_message" rows="6" required
                                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                                        placeholder="Type your reply here...">{{ old('reply_message') }}</textarea>
                                    @error('reply_message')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="mt-4 flex items-center">
                                    <input type="checkbox" name="send_email" id="send_email" value="1" checked
                                        class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                    <label for="send_email" class="ml-2 text-sm text-gray-700">
                                        Send reply via email to {{ $message->email }}
                                    </label>
                                </div>
                            </div>

                            <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
                                <button type="submit" 
                                    class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                    Send Reply
                                </button>
                            </div>
                        </form>
                    </div>
                @endif
            </div>

            <!-- Sidebar -->
            <div class="lg:col-span-1">
                <!-- Message Info -->
                <div class="bg-white shadow rounded-lg">
                    <div class="px-4 py-5 sm:p-6">
                        <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">Message Information</h3>
                        
                        <dl class="space-y-4">
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Status</dt>
                                <dd class="mt-1">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                        @if($message->status === 'new') bg-red-100 text-red-800
                                        @elseif($message->status === 'read') bg-yellow-100 text-yellow-800
                                        @elseif($message->status === 'replied') bg-green-100 text-green-800
                                        @else bg-gray-100 text-gray-800 @endif">
                                        {{ ucfirst($message->status) }}
                                    </span>
                                </dd>
                            </div>
                            
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Received</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $message->created_at->format('M d, Y \a\t g:i A') }}</dd>
                            </div>
                            
                            @if($message->read_at)
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Read</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $message->read_at->format('M d, Y \a\t g:i A') }}</dd>
                                </div>
                            @endif
                            
                            @if($message->replied_at)
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Replied</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $message->replied_at->format('M d, Y \a\t g:i A') }}</dd>
                                </div>
                                
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Replied By</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $message->repliedBy->name ?? 'Admin' }}</dd>
                                </div>
                            @endif
                        </dl>
                    </div>
                </div>

                <!-- Contact Info -->
                <div class="mt-6 bg-white shadow rounded-lg">
                    <div class="px-4 py-5 sm:p-6">
                        <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">Contact Information</h3>
                        
                        <dl class="space-y-4">
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Name</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $message->name }}</dd>
                            </div>
                            
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Email</dt>
                                <dd class="mt-1 text-sm text-gray-900">
                                    <a href="mailto:{{ $message->email }}" class="text-blue-600 hover:text-blue-500">
                                        {{ $message->email }}
                                    </a>
                                </dd>
                            </div>
                            
                            @if($message->phone)
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Phone</dt>
                                    <dd class="mt-1 text-sm text-gray-900">
                                        <a href="tel:{{ $message->phone }}" class="text-blue-600 hover:text-blue-500">
                                            {{ $message->phone }}
                                        </a>
                                    </dd>
                                </div>
                            @endif
                        </dl>
                    </div>
                </div>

                <!-- Quick Actions -->
                <div class="mt-6 bg-white shadow rounded-lg">
                    <div class="px-4 py-5 sm:p-6">
                        <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">Quick Actions</h3>
                        
                        <div class="space-y-3">
                            <a href="mailto:{{ $message->email }}?subject=Re: {{ $message->subject }}" 
                                class="w-full inline-flex justify-center items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                </svg>
                                Reply via Email Client
                            </a>
                            
                            @if($message->phone)
                                <a href="tel:{{ $message->phone }}" 
                                    class="w-full inline-flex justify-center items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                    <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                    </svg>
                                    Call {{ $message->phone }}
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection