@extends('layouts.admin')

@section('header')
    <h2 class="text-xl font-semibold leading-tight text-gray-800">
        {{ __('Users') }}
    </h2>
@endsection

@section('content')
    <div class="py-12 bg-gray-100">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                <h3 class="text-lg font-semibold mb-4 text-gray-900">{{ __('Voters') }}</h3>
                <div class="overflow-x-auto mb-8 border rounded-md shadow-sm">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-green-100">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">{{ __('Name') }}</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">{{ __('Email') }}</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">{{ __('Registered On') }}</th>
                                <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-700 uppercase tracking-wider">{{ __('Voted?') }}</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse ($voters as $voter)
                                <tr class="hover:bg-green-50 transition duration-150">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $voter->name }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                        @php
                                            $parts = explode('@', $voter->email);
                                            $username = $parts[0];
                                            $domain = isset($parts[1]) ? '@' . $parts[1] : '';
                                            $maskedUsername = substr($username, 0, 2) . str_repeat('*', max(0, strlen($username) - 2));
                                            echo $maskedUsername . $domain;
                                        @endphp
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ $voter->created_at->format('M d, Y') }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-center text-sm">
                                        @if ($voter->has_voted)
                                            <span class="text-green-500 font-semibold">{{ __('Yes') }}</span>
                                        @else
                                            <span class="text-red-500 font-semibold">{{ __('No') }}</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr><td class="px-6 py-4 whitespace-nowrap text-center" colspan="4">{{ __('No voters found.') }}</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="border-t my-8"></div>

                <h3 class="text-lg font-semibold mb-4 mt-8 text-gray-900">{{ __('Candidates') }}</h3>
                <div class="overflow-x-auto border rounded-md shadow-sm">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-blue-100">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">{{ __('Name') }}</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">{{ __('Email') }}</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">{{ __('Registered On') }}</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">{{ __('Status') }}</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse ($candidates as $candidate)
                                <tr class="hover:bg-blue-50 transition duration-150">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $candidate->name }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                        @php
                                            $parts = explode('@', $candidate->email);
                                            $username = $parts[0];
                                            $domain = isset($parts[1]) ? '@' . $parts[1] : '';
                                            $maskedUsername = substr($username, 0, 2) . str_repeat('*', max(0, strlen($username) - 2));
                                            echo $maskedUsername . $domain;
                                        @endphp
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ $candidate->created_at->format('M d, Y') }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                                        @if ($candidate->application_status === 'approved')
                                            <span class="text-green-500 font-semibold">{{ __('Approved') }}</span>
                                        @elseif ($candidate->application_status === 'pending')
                                            <span class="text-yellow-500 font-semibold">{{ __('Pending') }}</span>
                                        @elseif ($candidate->application_status === 'rejected')
                                            <span class="text-red-500 font-semibold">{{ __('Rejected') }}</span>
                                        @else
                                            {{ $candidate->application_status }}
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr><td class="px-6 py-4 whitespace-nowrap text-center" colspan="4">{{ __('No candidates found.') }}</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection