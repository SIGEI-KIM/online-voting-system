@extends('layouts.candidate') {{-- CORRECTED: Changed from layouts.candidate-layout to layouts.candidate --}}

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('My Elections') }}
    </h2>
@endsection

@section('content')
    <div class="py-12 bg-gray-100 min-h-screen"> {{-- Added bg-gray-100 and min-h-screen for consistent background --}}
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg border border-gray-200"> {{-- Enhanced shadow and border --}}
                <div class="p-8 text-gray-900"> {{-- Increased padding --}}
                    @if (session('info'))
                        <div class="mb-6 p-4 font-medium text-sm text-blue-600 bg-blue-100 rounded-lg flex items-center" role="alert"> {{-- Styled info alert --}}
                            <svg class="w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9.293 12.293a1 1 0 001.414 1.414L12 11.414l1.293 1.293a1 1 0 001.414-1.414L13.414 10l1.293-1.293a1 1 0 00-1.414-1.414L12 8.586l-1.293-1.293a1 1 0 00-1.414 1.414L10.586 10l-1.293 1.293z" clip-rule="evenodd"></path></svg>
                            <span>{{ session('info') }}</span>
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="mb-6 p-4 font-medium text-sm text-red-600 bg-red-100 rounded-lg flex items-center" role="alert"> {{-- Styled error alert --}}
                            <svg class="w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zM10 12.586l2.293-2.293a1 1 0 00-1.414-1.414L10 11.172l-1.879-1.879a1 1 0 00-1.414 1.414L8.586 10l-1.879 1.879a1 1 0 101.414 1.414L10 11.172z" clip-rule="evenodd"></path></svg>
                            <span>{{ session('error') }}</span>
                        </div>
                    @endif

                    <h3 class="text-2xl font-bold mb-6 text-gray-800 text-center">{{ __('Elections You Have Applied For') }}</h3>

                    @if ($appliedElections->count() > 0)
                        <ul class="space-y-6"> {{-- Increased space-y --}}
                            @foreach ($appliedElections as $application)
                                <li class="bg-gray-50 border border-gray-200 rounded-lg p-5 shadow-sm hover:shadow-md transition-shadow duration-200 ease-in-out flex flex-col sm:flex-row justify-between items-start sm:items-center"> {{-- Enhanced card styling --}}
                                    <div>
                                        <h4 class="font-semibold text-lg text-gray-800">{{ $application->election->title }}</h4>
                                        <p class="text-gray-600 text-sm mt-1">{{ $application->election->description }}</p>
                                        <p class="text-gray-500 text-xs mt-2">Applied On: {{ $application->created_at->format('M d, Y') }}</p> {{-- Changed to created_at --}}
                                    </div>
                                    <div class="mt-4 sm:mt-0 sm:ml-4 flex-shrink-0">
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
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold {{ $statusClass }}">
                                            {{ ucfirst($application->status) }}
                                        </span>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <p class="text-gray-600 text-center py-8">{{ __('You have not applied for any elections yet. Click the button below to start your application!') }}</p>
                    @endif

                    <div class="mt-8 text-center"> {{-- Centered the button --}}
                        <a href="{{ route('candidate.apply.choose') }}" class="inline-flex items-center px-6 py-3 bg-blue-600 border border-transparent rounded-full font-bold text-base text-white uppercase tracking-wider shadow-lg hover:bg-blue-700 active:bg-blue-800 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150 transform hover:-translate-y-0.5">
                            {{ __('Apply for an Election') }}
                            <svg class="w-5 h-5 ml-2 -mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg> {{-- Plus icon --}}
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
