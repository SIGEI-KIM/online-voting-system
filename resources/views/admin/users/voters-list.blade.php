<!-- resources/views/admin/users/voters-list.blade.php -->
@extends('layouts.admin') {{-- Assuming you have a main admin layout --}}

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Voters List') }}
    </h2>
@endsection

@section('content')
    <div class="py-10 bg-gradient-to-br from-gray-100 to-gray-200 min-h-screen"> {{-- Enhanced background gradient and padding --}}
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-2xl sm:rounded-xl border border-gray-200"> {{-- Stronger shadow and slightly more rounded --}}
                <div class="p-8 text-gray-900"> {{-- Increased padding --}}
                    <h3 class="text-3xl font-extrabold mb-8 text-center text-purple-700">{{ __('All Registered Voters') }}</h3> {{-- Larger, bolder, purple heading --}}

                    @if ($voters->count() > 0)
                        <div class="overflow-x-auto rounded-xl shadow-lg border border-purple-200"> {{-- More rounded and purple border --}}
                            <table class="min-w-full divide-y divide-purple-200"> {{-- Purple divider --}}
                                <thead class="bg-purple-600 text-white"> {{-- Solid purple header --}}
                                    <tr>
                                        <th class="px-6 py-3 text-left text-sm font-bold uppercase tracking-wider">{{ __('Name') }}</th> {{-- Increased text size and weight --}}
                                        <th class="px-6 py-3 text-left text-sm font-bold uppercase tracking-wider">{{ __('Email') }}</th>
                                        <th class="px-6 py-3 text-left text-sm font-bold uppercase tracking-wider">{{ __('Registration Date') }}</th>
                                        <th class="px-6 py-3 text-left text-sm font-bold uppercase tracking-wider">{{ __('Has Voted?') }}</th>
                                        {{-- Add more columns if needed, e.g., Actions --}}
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach ($voters as $voter)
                                        <tr class="odd:bg-white even:bg-purple-50 hover:bg-purple-100 transition duration-150 ease-in-out"> {{-- Alternate row colors and hover effect --}}
                                            <td class="px-6 py-4 whitespace-nowrap text-base font-medium text-gray-900">{{ $voter->name }}</td> {{-- Increased text size --}}
                                            <td class="px-6 py-4 whitespace-nowrap text-base text-gray-700"> {{-- Increased text size and darker gray --}}
                                                @php
                                                    $emailParts = explode('@', $voter->email);
                                                    $username = $emailParts[0];
                                                    $domain = $emailParts[1];

                                                    // Mask part of the username
                                                    // This logic ensures at least 2 characters are shown at the start and end,
                                                    // and fills the middle with asterisks, handling short usernames gracefully.
                                                    $maskedUsername = substr($username, 0, 2) . str_repeat('*', max(0, strlen($username) - 4)) . substr($username, -2);

                                                    echo $maskedUsername . '@' . $domain;
                                                @endphp
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-base text-gray-700">{{ $voter->created_at->format('M d, Y') }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-base">
                                                @if ($voter->votes()->exists()) {{-- Check if voter has cast any votes --}}
                                                    <span class="px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full bg-green-500 text-white shadow-sm"> {{-- More prominent green badge --}}
                                                        {{ __('Yes') }}
                                                    </span>
                                                @else
                                                    <span class="px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full bg-red-500 text-white shadow-sm"> {{-- More prominent red badge --}}
                                                        {{ __('No') }}
                                                    </span>
                                                @endif
                                            </td>
                                            {{-- Example Action Button --}}
                                            {{-- <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                                <a href="{{ route('users.edit', $voter->id) }}" class="text-indigo-600 hover:text-indigo-900">Edit</a>
                                            </td> --}}
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <p class="text-center text-gray-600 py-10 text-xl font-medium">{{ __('No voters found in the system.') }}</p> {{-- Larger and more emphasized message --}}
                    @endif

                    <div class="mt-10 text-center"> {{-- Increased top margin --}}
                        <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center px-8 py-3 bg-purple-600 border border-transparent rounded-full font-bold text-lg text-white uppercase tracking-wider shadow-xl hover:bg-purple-700 focus:outline-none focus:ring-4 focus:ring-purple-300 focus:ring-offset-2 transition-all duration-300 transform hover:-translate-y-1 hover:shadow-2xl"> {{-- Larger, bolder, purple button with more prominent effects --}}
                            {{ __('Back to Dashboard') }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
