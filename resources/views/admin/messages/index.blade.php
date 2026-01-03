@extends('layouts.app')

@section('title', 'Messages - Admin Panel')

@section('content')
<div class="bg-gray-50 min-h-screen">
    <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
        <!-- Page header -->
        <div class="mb-8">
            <div class="flex items-center">
                <a href="{{ route('admin.dashboard') }}" class="text-gray-500 hover:text-gray-700 mr-4">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                </a>
                <h2 class="text-2xl font-bold leading-7 text-gray-900 sm:text-3xl sm:truncate">
                    Contact Messages
                </h2>
            </div>
        </div>

        @if($messages->count() > 0)
            <div class="bg-white shadow overflow-hidden sm:rounded-md">
                <ul class="divide-y divide-gray-200">
                    @foreach($messages as $message)
                        <li class="animate__animated animate__fadeInUp" style="animation-delay: {{ $loop->index * 50 }}ms">
                            <a href="{{ route('admin.messages.show', $message) }}" class="block hover:bg-gray-50">
                                <div class="px-4 py-4 sm:px-6">
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0">
                                                <div class="h-10 w-10 rounded-full bg-gray-200 flex items-center justify-center">
                                                    <svg class="h-5 w-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                                    </svg>
                                                </div>
                                            </div>
                                            <div class="ml-4">
                                                <div class="flex items-center">
                                                    <p class="text-sm font-medium text-indigo-600 truncate">
                                                        {{ $message->name }}
                                                    </p>
                                                    <span class="ml-2 inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                                        @if($message->status === 'new') bg-red-100 text-red-800
                                                        @elseif($message->status === 'read') bg-yellow-100 text-yellow-800
                                                        @elseif($message->status === 'replied') bg-green-100 text-green-800
                                                        @else bg-gray-100 text-gray-800 @endif">
                                                        {{ ucfirst($message->status) }}
                                                    </span>
                                                </div>
                                                <div class="mt-2 flex items-center text-sm text-gray-500">
                                                    <svg class="flex-shrink-0 mr-1.5 h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                                    </svg>
                                                    <p>{{ $message->email }}</p>
                                                </div>
                                                <div class="mt-2 flex items-center text-sm text-gray-500">
                                                    <svg class="flex-shrink-0 mr-1.5 h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                                                    </svg>
                                                    <p>{{ $message->subject }}</p>
                                                </div>
                                                <div class="mt-2">
                                                    <p class="text-sm text-gray-600 line-clamp-2">
                                                        {{ Str::limit($message->message, 150) }}
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="flex flex-col items-end">
                                            <div class="text-sm text-gray-500">
                                                {{ $message->created_at->diffForHumans() }}
                                            </div>
                                            @if($message->status === 'new')
                                                <div class="mt-2">
                                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                                        New
                                                    </span>
                                                </div>
                                            @endif
                                            @if($message->replied_by)
                                                <div class="mt-2 text-xs text-gray-500">
                                                    Replied by {{ $message->repliedBy->name }}
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>

            <!-- Pagination -->
            <div class="mt-6">
                {{ $messages->links() }}
            </div>
        @else
            <div class="text-center py-12">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                </svg>
                <h3 class="mt-2 text-sm font-medium text-gray-900">No messages</h3>
                <p class="mt-1 text-sm text-gray-500">No contact messages have been received yet.</p>
            </div>
        @endif
    </div>
</div>
@endsection