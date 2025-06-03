@extends('layouts.candidate')

@section('content')
    <div class="py-12 bg-gray-100">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                    <div class="flex items-center mb-4">
                        <svg class="w-8 h-8 text-indigo-500 mr-3" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path></svg>
                        <h2 class="text-xl font-semibold text-gray-800">{{ __('Profile Overview') }}</h2>
                    </div>
                    <p class="text-gray-700">
                        <strong>{{ __('Status:') }}</strong>
                        @if ($profile && $profile->bio)
                            <span class="text-green-600 font-semibold">{{ __('Complete') }}</span>
                            <p class="text-sm text-gray-500 mt-1">{{ __('Your public profile is ready.') }}</p>
                        @else
                            <span class="text-red-600 font-semibold">{{ __('Incomplete') }}</span>
                            <p class="text-sm text-gray-500 mt-1">{{ __('Please complete your profile to engage with voters.') }}</p>
                            <a href="{{ route('candidate.profile.create') }}" class="inline-block mt-2 text-indigo-600 hover:underline">{{ __('Edit Profile') }}</a>
                        @endif
                    </p>
                </div>

                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                    <div class="flex items-center mb-4">
                        <svg class="w-8 h-8 text-green-500 mr-3" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M10 2a6 6 0 00-6 6v3.586l-.707.707A1 1 0 004 14h12a1 1 0 00.707-1.707L16 11.586V8a6 6 0 00-6-6zM10 18a3 3 0 01-3-3h6a3 3 0 01-3 3z"></path></svg>
                        <h2 class="text-xl font-semibold text-gray-800">{{ __('Your Election Applications') }}</h2>
                    </div>
                    @if ($applications->count() > 0)
                        <ul class="space-y-3">
                            @foreach ($applications as $application)
                                <li class="bg-gray-50 rounded-md p-3 border border-gray-200">
                                    <p class="font-semibold text-gray-800">{{ $application->election->title }}</p>
                                    <p class="text-sm text-gray-600">{{ __('Status:') }}
                                        @php
                                            $statusClass = '';
                                            switch ($application->status) {
                                                case 'pending':
                                                    $statusClass = 'text-yellow-500';
                                                    break;
                                                case 'approved':
                                                    $statusClass = 'text-green-500';
                                                    break;
                                                case 'rejected':
                                                    $statusClass = 'text-red-500';
                                                    break;
                                                default:
                                                    $statusClass = 'text-gray-500';
                                                    break;
                                            }
                                        @endphp
                                        <span class="{{ $statusClass }} font-semibold">{{ ucfirst($application->status) }}</span>
                                    </p>
                                </li>
                            @endforeach
                        </ul>
                        <a href="{{ route('candidate.elections') }}" class="inline-block mt-4 text-blue-600 hover:underline">{{ __('View All Elections') }}</a>
                    @else
                        <p class="text-gray-600">{{ __('You have not applied for any elections yet.') }}</p>
                        <a href="{{ route('candidate.apply') }}" class="inline-block mt-2 text-indigo-600 hover:underline">{{ __('Apply for a New Election') }}</a>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <footer class="fixed bottom-0 w-full bg-gray-100 text-center py-4 text-sm text-gray-500">
        © 2025 Your Voting System. All rights reserved.
    </footer>
@endsection