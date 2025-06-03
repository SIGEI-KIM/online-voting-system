@extends('layouts.admin')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Candidates and Applications') }}
    </h2>
@endsection

@section('content')
    <div class="py-12 bg-gray-100">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h3 class="text-2xl font-semibold text-gray-800 mb-6">{{ __('Candidates and Applications by Election') }}</h3>

                @forelse ($applicationsByElection as $electionTitle => $applications)
                    <div class="mb-8 border-b pb-6">
                        <h4 class="text-xl font-semibold text-blue-700 mb-3">{{ $electionTitle }}</h4>
                        @if ($applications->isNotEmpty())
                            <ol class="list-decimal pl-5 text-gray-700">
                                @foreach ($applications as $application)
                                    <li class="py-1">
                                        <span class="font-semibold text-green-600">{{ $application->candidate->name }}</span> -
                                        Applied on: <span class="text-gray-600">{{ $application->applied_at->format('M d, Y') }}</span>
                                        (<span class="{{ $application->status === 'approved' ? 'text-green-500' : ($application->status === 'rejected' ? 'text-red-500' : 'text-yellow-500') }}">
                                            {{ ucfirst($application->status) }}
                                        </span>)
                                        @if ($application->election)
                                            <span class="text-sm text-gray-500">for {{ $application->election->title }}</span>
                                        @endif
                                    </li>
                                @endforeach
                            </ol>
                        @else
                            <p class="text-gray-500">{{ __('No applications found for this election.') }}</p>
                        @endif
                    </div>
                @empty
                    <p class="text-gray-500">{{ __('No applications found.') }}</p>
                @endforelse
            </div>
        </div>
    </div>
@endsection