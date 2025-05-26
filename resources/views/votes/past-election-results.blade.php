<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ $election->title }} - Results
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Election Results</h3>

                @if ($election->candidates->isNotEmpty())
                    <table class="w-full text-left">
                        <thead>
                            <tr>
                                <th class="px-4 py-2">Candidate</th>
                                <th class="px-4 py-2">Votes</th>
                                <th class="px-4 py-2">Percentage</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($election->candidates as $candidate)
                                <tr>
                                    <td class="px-4 py-2">{{ $candidate->name }} ({{ $candidate->position }})</td>
                                    <td class="px-4 py-2">{{ $candidate->votes_count }}</td>
                                    <td class="px-4 py-2">
                                        @if ($totalVotes > 0)
                                            {{ number_format(($candidate->votes_count / $totalVotes) * 100, 2) }}%
                                        @else
                                            0.00%
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <div class="mt-4">
                        <p class="font-semibold">Winner: {{ $winner->name }}</p>
                    </div>
                @else
                    <p>No results available for this election.</p>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>