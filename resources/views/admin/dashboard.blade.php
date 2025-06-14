@extends('layouts.admin')

@section('header')
    <div class="bg-white shadow">
        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    {{ __('Admin Dashboard') }}
                </h2>
                <button @click="sidebarOpen = !sidebarOpen" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out md:hidden">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': sidebarOpen, 'inline-flex': ! sidebarOpen }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! sidebarOpen, 'inline-flex': sidebarOpen }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>
@endsection

@section('content')
    {{-- Toast Notification --}}
    @if (session('success'))
        <div x-data="{ show: true }"
             x-init="setTimeout(() => show = false, 3000)"
             x-show="show"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 transform translate-y-[-100%]"
             x-transition:enter-end="opacity-100 transform translate-y-0"
             x-transition:leave="transition ease-in duration-300"
             x-transition:leave-start="opacity-100 transform translate-y-0"
             x-transition:leave-end="opacity-0 transform translate-y-[-100%]"
             class="fixed top-4 right-4 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg z-50 flex items-center space-x-2"
             style="background-color: #008C51;">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    <div class="py-12 bg-gray-50">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            {{-- Statistics Overview --}}
            <div class="grid grid-cols-1 gap-6 mb-8 md:grid-cols-2 lg:grid-cols-5">
                {{-- Total Elections Card --}}
                <div class="p-6 bg-blue-100 rounded-lg shadow border-2 border-blue-500 flex flex-col justify-between">
                    <div>
                        <h3 class="text-lg font-medium text-blue-800">{{ __('Total Elections') }}</h3>
                        <p class="text-3xl font-bold text-blue-700">{{ $stats['elections'] ?? 0 }}</p>
                    </div>
                    <div class="mt-4 text-right">
                        <a href="{{ route('elections.index') }}" class="text-blue-600 hover:text-blue-800 font-semibold text-sm">
                            {{ __('More info') }} &rarr;
                        </a>
                    </div>
                </div>
                {{-- Ongoing Elections Card --}}
                <div class="p-6 bg-green-100 rounded-lg shadow border-2 border-green-500 flex flex-col justify-between">
                    <div>
                        <h3 class="text-lg font-medium text-green-800">{{ __('Ongoing Elections') }}</h3>
                        <p class="text-3xl font-bold text-green-700">{{ $stats['ongoingElections'] ?? 0 }}</p>
                    </div>
                    <div class="mt-4 text-right">
                    <a href="{{ route('elections.index', ['status' => 'ongoing']) }}" class="text-green-600 hover:text-green-800 font-semibold text-sm">
                        {{ __('More info') }} &rarr;
                   </a>
                    </div>
                </div>
                {{-- Total Candidates Card --}}
                <div class="p-6 bg-yellow-100 rounded-lg shadow border-2 border-yellow-500 flex flex-col justify-between">
                    <div>
                        <h3 class="text-lg font-medium text-yellow-800">{{ __('Total Candidates') }}</h3>
                        <p class="text-3xl font-bold text-yellow-700">{{ $stats['candidates'] ?? 0 }}</p>
                    </div>
                    <div class="mt-4 text-right">
                        <a href="{{ route('admin.candidates.index') }}" class="text-yellow-600 hover:text-yellow-800 font-semibold text-sm">
                            {{ __('More info') }} &rarr;
                        </a>
                    </div>
                </div>
                {{-- Total Voters Card --}}
                <div class="p-6 bg-purple-100 rounded-lg shadow border-2 border-purple-500 flex flex-col justify-between">
                    <div>
                        <h3 class="text-lg font-medium text-purple-800">{{ __('Total Voters') }}</h3>
                        <p class="text-3xl font-bold text-purple-700">{{ $stats['users'] ?? 0 }}</p> {{-- This value comes from the controller --}}
                    </div>
                    <div class="mt-4 text-right">
                        {{-- UPDATED: Link to the new route for voters only --}}
                        <a href="{{ route('admin.voters.index') }}" class="text-purple-600 hover:text-purple-800 font-semibold text-sm">
                            {{ __('More info') }} &rarr;
                        </a>
                    </div>
                </div>
                {{-- Total Votes Cast Card --}}
                <div class="p-6 bg-red-100 rounded-lg shadow border-2 border-red-500 flex flex-col justify-between">
                    <div>
                        <h3 class="text-lg font-medium text-red-800">{{ __('Total Votes Cast') }}</h3>
                        <p class="text-3xl font-bold text-red-700">{{ $stats['votes'] ?? 0 }}</p>
                    </div>
                    <div class="mt-4 text-right">
                        <a href="{{ route('admin.votes.index') }}" class="text-red-600 hover:text-red-800 font-semibold text-sm">
                            {{ __('More info') }} &rarr;
                        </a>
                    </div>
                </div>
            </div>

            {{-- Recent Activity Section --}}
            <div class="mt-8 bg-white overflow-hidden shadow-sm sm:rounded-lg border-l-4 border-red-600">
                <div class="p-6">
                    <h2 class="mb-4 text-xl font-semibold text-gray-900 border-b pb-2 text-red-600">{{ __('Recent Activity') }}</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <h3 class="mb-2 font-semibold text-gray-700 border-b pb-1 text-green-600">{{ __('Recent Elections') }}</h3>
                            @forelse ($recentElections as $election)
                                <p class="text-gray-600 py-1">- <span class="font-medium text-black">{{ $election->title }}</span> <span class="text-sm text-gray-500">({{ $election->created_at->diffForHumans() }})</span></p>
                            @empty
                                <p class="text-gray-600">{{ __('No recent elections created.') }}</p>
                            @endforelse
                        </div>
                        <div>
                            <h3 class="mb-2 font-semibold text-gray-700 border-b pb-1 text-green-600">{{ __('Recent Candidates') }}</h3>
                            @forelse ($recentCandidates as $candidate)
                                <p class="text-gray-600 py-1">- <span class="font-medium text-black">{{ $candidate->name }}</span> <span class="text-sm text-gray-500">({{ $candidate->created_at->diffForHumans() }})</span></p>
                            @empty
                                <p class="text-gray-600">{{ __('No recent candidates added.') }}</p>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <footer class="fixed bottom-0 w-full bg-gray-100 text-center py-4 text-sm text-gray-500">
        © 2025 Your Voting System. All rights reserved.
    </footer>
@endsection
