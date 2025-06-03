<x-candidate-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Election Results') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-2xl font-bold mb-6 text-center">{{ __('Available Election Results') }}</h3>

                    @forelse ($elections as $election)
                        <div class="mb-8 p-6 bg-gray-50 rounded-lg shadow-md border border-gray-200">
                            <h4 class="text-xl font-semibold mb-3 text-indigo-700">{{ $election->title }}</h4>

                            @if ($election->end_date > now())
                                <p class="mb-4 text-sm font-medium text-yellow-600 flex items-center">
                                    <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 00-2 0v4a1 1 0 00.293.707l3 3a1 1 0 001.414-1.414L11 9.586V6z" clip-rule="evenodd"></path></svg>
                                    {{ __('This election is ongoing. Results are live.') }}
                                </p>
                            @else
                                <p class="mb-4 text-sm font-medium text-green-600 flex items-center">
                                    <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                                    {{ __('This election has concluded.') }}
                                </p>

                                @if ($election->candidates->isNotEmpty())
                                    @php
                                        $winner = $election->candidates->sortByDesc('votes_count')->first();
                                    @endphp
                                    <p class="mt-4 text-lg font-semibold text-indigo-700">
                                        {{ __('Winner:') }} {{ $winner->name }}
                                    </p>
                                @endif
                            @endif

                            @if ($election->candidates->isNotEmpty())
                                <h5 class="text-lg font-medium mb-2">{{ __('Candidates & Votes:') }}</h5>

                                <div class="overflow-x-auto">
                                    <table class="min-w-full divide-y divide-gray-200">
                                        <thead class="bg-gray-50">
                                            <tr>
                                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Candidate Name') }}</th>
                                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Votes') }}</th>
                                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Percentage') }}</th>
                                            </tr>
                                        </thead>
                                        <tbody class="bg-white divide-y divide-gray-200">
                                            @foreach ($election->candidates->sortByDesc('votes_count') as $candidate)
                                                <tr>
                                                    <td class="px-6 py-4 whitespace-nowrap">{{ $candidate->name }}</td>
                                                    <td class="px-6 py-4 whitespace-nowrap">{{ $candidate->votes_count }} {{ Str::plural('vote', $candidate->votes_count) }}</td>
                                                    <td class="px-6 py-4 whitespace-nowrap">{{ $candidate->percentage }}%</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @else
                                <p class="text-gray-600">{{ __('No candidates participated in this election.') }}</p>
                            @endif
                        </div>
                    @empty
                        <p class="text-center text-gray-600 text-lg py-8">{{ __('No election results are currently available.') }}</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</x-candidate-layout>