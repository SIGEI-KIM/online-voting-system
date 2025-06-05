@extends('layouts.candidate')

@section('content')
    <div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100 pb-20">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 pt-8">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Profile Overview Card -->
                <div class="bg-white overflow-hidden shadow-lg rounded-xl transition-all duration-300 hover:shadow-xl">
                    <div class="p-6">
                        <div class="flex items-center mb-6">
                            <div class="bg-indigo-100 p-3 rounded-full">
                                <svg class="w-6 h-6 text-indigo-600" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path>
                                </svg>
                            </div>
                            <h2 class="ml-4 text-xl font-bold text-gray-800">{{ __('Profile Overview') }}</h2>
                        </div>
                        <div class="pl-10">
                            <div class="flex items-center">
                                <strong class="text-gray-700 mr-2">{{ __('Status:') }}</strong>
                                @if ($profile && $profile->bio)
                                    <span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                                        {{ __('Complete') }}
                                    </span>
                                @else
                                    <span class="px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">
                                        {{ __('Incomplete') }}
                                    </span>
                                @endif
                            </div>
                            <p class="mt-2 text-sm text-gray-600">
                                @if ($profile && $profile->bio)
                                    {{ __('Your public profile is ready.') }}
                                @else
                                    {{ __('Please complete your profile to engage with voters.') }}
                                @endif
                            </p>
                            @unless ($profile && $profile->bio)
                                <a href="{{ route('candidate.profile.create') }}" class="mt-4 inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:border-indigo-900 focus:ring ring-indigo-300 disabled:opacity-25 transition ease-in-out duration-150">
                                    {{ __('Complete Profile') }}
                                </a>
                            @endunless
                        </div>
                    </div>
                </div>

                <!-- Election Applications Card -->
                <div class="bg-white overflow-hidden shadow-lg rounded-xl transition-all duration-300 hover:shadow-xl">
                    <div class="p-6">
                        <div class="flex items-center mb-6">
                            <div class="bg-green-100 p-3 rounded-full">
                                <svg class="w-6 h-6 text-green-600" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M10 2a6 6 0 00-6 6v3.586l-.707.707A1 1 0 004 14h12a1 1 0 00.707-1.707L16 11.586V8a6 6 0 00-6-6zM10 18a3 3 0 01-3-3h6a3 3 0 01-3 3z"></path>
                                </svg>
                            </div>
                            <h2 class="ml-4 text-xl font-bold text-gray-800">{{ __('Your Election Applications') }}</h2>
                        </div>
                        <div class="pl-10">
                            @if ($applications->count() > 0)
                                <ul class="space-y-3">
                                    @foreach ($applications as $application)
                                        <li class="bg-gray-50 rounded-lg p-4 border border-gray-100 hover:bg-gray-50 transition-colors duration-200">
                                            <p class="font-semibold text-gray-800">{{ $application->election->title }}</p>
                                            <div class="flex items-center mt-1">
                                                <span class="text-sm text-gray-600 mr-2">{{ __('Status:') }}</span>
                                                @php
                                                    $statusClass = '';
                                                    switch ($application->status) {
                                                        case 'pending':
                                                            $statusClass = 'bg-yellow-100 text-yellow-800';
                                                            break;
                                                        case 'approved':
                                                            $statusClass = 'bg-green-100 text-green-800';
                                                            break;
                                                        case 'rejected':
                                                            $statusClass = 'bg-red-100 text-red-800';
                                                            break;
                                                        default:
                                                            $statusClass = 'bg-gray-100 text-gray-800';
                                                            break;
                                                    }
                                                @endphp
                                                <span class="px-2 py-1 text-xs font-semibold rounded-full {{ $statusClass }}">
                                                    {{ ucfirst($application->status) }}
                                                </span>
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
                                <a href="{{ route('candidate.elections') }}" class="mt-4 inline-flex items-center text-indigo-600 hover:text-indigo-800 transition-colors duration-200">
                                    {{ __('View All Elections') }}
                                    <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                    </svg>
                                </a>
                            @else
                                <p class="text-gray-600 mb-4">{{ __('You have not applied for any elections yet.') }}</p>
                                <a href="{{ route('candidate.apply') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:border-indigo-900 focus:ring ring-indigo-300 disabled:opacity-25 transition ease-in-out duration-150">
                                    {{ __('Apply for a New Election') }}
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <footer class="bg-white border-t border-gray-200 py-4">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <p class="text-center text-sm text-gray-500">
                © 2025 Your Voting System. All rights reserved.
            </p>
        </div>
    </footer>
@endsection