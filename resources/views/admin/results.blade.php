<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800" style="color: #922529;">
            Election Results
        </h2>
    </x-slot>

    <head>
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <style>
            /* Styles for larger screens (default) */
            .election-results-table {
                width: 100%;
            }

            /* Styles for smaller screens (e.g., tablets) */
            @media (max-width: 768px) {
                .election-results-table {
                    overflow-x: auto; /* Enable horizontal scrolling for tables */
                }
            }

            /* Styles for even smaller screens (e.g., phones) */
            @media (max-width: 480px) {
                /* You might want to further adjust table layout or font sizes here */
                .election-results-table th,
                .election-results-table td {
                    padding: 8px 5px;
                    font-size: 0.9em;
                }
            }

            /* Responsive chart (already mostly handled by width: 100%) */
            canvas {
                max-width: 100%;
                height: auto; /* Maintain aspect ratio */
                margin-top: 20px;
            }

            /* Kenyan IEBC color scheme */
            .p-6.bg-white.rounded-lg.shadow {
                border: 2px solid #008C51; /* Green border */
            }

            .space-y-6 > * + * {
                margin-top: 1.5rem;
            }

            .live-indicator {
                color: red;
                font-weight: bold;
                animation: blink 1s infinite alternate;
                margin-left: 0.5rem;
            }

            @keyframes blink {
                0% {
                    opacity: 1;
                }
                100% {
                    opacity: 0;
                }
            }
        </style>
    </head>

    <div class="py-4">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 mb-8 border border-gray-200">
                <h3 class="mb-4 text-lg font-semibold text-gray-900">Recent Activity</h3>
                <p class="text-gray-700 mb-2">
                    Total Ongoing Elections: <span class="font-semibold">{{ $ongoingElectionCount ?? 0 }}</span>
                </p>
                <p class="text-gray-700">
                    Total Votes Cast Today: <span class="font-semibold">{{ $votesToday ?? 0 }}</span>
                </p>
            </div>
        </div>
    </div>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="mb-8">
                <h3 class="mb-4 text-2xl font-semibold text-gray-900" style="color: #000000;">
                    Ongoing Elections <span class="live-indicator">Live</span>
                </h3>
                @if($ongoingElections->count() > 0)
                    <div class="space-y-6">
                        @foreach($ongoingElections as $election)
                            <div class="p-6 bg-white rounded-lg shadow">
                                <h3 class="mb-4 text-xl font-semibold text-gray-900" style="color: #000000;">{{ $election->title }}</h3>
                                <div class="election-results-table">
                                    <table class="w-full text-left">
                                        <thead>
                                            <tr>
                                                <th class="px-4 py-2">Candidate</th>
                                                <th class="px-4 py-2">Votes</th>
                                                <th class="px-4 py-2">Percentage</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php
                                                $maxVotes = $election->candidates->max('votes_count') ?? 0;
                                            @endphp
                                            @foreach($election->candidates as $candidate)
                                            <tr @if($candidate->votes_count == $maxVotes && $election->votes()->count() > 0) class="font-semibold" @endif>
                                                <td class="px-4 py-2">
                                                    {{ $candidate->name }} ({{ $candidate->position }})
                                                    @if($candidate->votes_count == $maxVotes && $election->votes()->count() > 0)
                                                        <span class="text-green-500 font-bold">(Winner)</span>
                                                    @endif
                                                </td>
                                                <td class="px-4 py-2">{{ $candidate->votes_count }}</td>
                                                <td class="px-4 py-2">
                                                    @if($election->votes()->count() > 0)
                                                        {{ number_format(($candidate->votes_count / $election->votes()->count()) * 100, 2) }}%
                                                    @else
                                                        0.00%
                                                    @endif
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <canvas id="electionChart{{ $election->id }}" style="width:100%; max-width:800px; height: 300px; margin-top: 30px;"></canvas>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-gray-600">No ongoing elections.</p>
                @endif
            </div>

            <div class="mt-12">
                <h3 class="mb-4 text-2xl font-semibold text-gray-900" style="color: #000000;">Past Elections</h3>
                @if($pastElections->count() > 0)
                    <div class="space-y-6">
                        @foreach($pastElections as $election)
                            <div class="p-6 bg-white rounded-lg shadow">
                                <h3 class="mb-4 text-xl font-semibold text-gray-900" style="color: #000000;">{{ $election->title }}</h3>
                                <div class="election-results-table">
                                    <table class="w-full text-left">
                                        <thead>
                                            <tr>
                                                <th class="px-4 py-2">Candidate</th>
                                                <th class="px-4 py-2">Votes</th>
                                                <th class="px-4 py-2">Percentage</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php
                                                $maxVotes = $election->candidates->max('votes_count') ?? 0;
                                            @endphp
                                            @foreach($election->candidates as $candidate)
                                            <tr @if($candidate->votes_count == $maxVotes && $election->votes()->count() > 0) class="font-semibold" @endif>
                                                <td class="px-4 py-2">
                                                    {{ $candidate->name }} ({{ $candidate->position }})
                                                    @if($candidate->votes_count == $maxVotes && $election->votes()->count() > 0)
                                                        <span class="text-green-500 font-bold">(Winner)</span>
                                                    @endif
                                                </td>
                                                <td class="px-4 py-2">{{ $candidate->votes_count }}</td>
                                                <td class="px-4 py-2">
                                                    @if($election->votes()->count() > 0)
                                                        {{ number_format(($candidate->votes_count / $election->votes()->count()) * 100, 2) }}%
                                                    @else
                                                        0.00%
                                                    @endif
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <canvas id="pastElectionChart{{ $election->id }}" style="width:100%; max-width:800px; height: 300px; margin-top: 30px;"></canvas>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-gray-600">No past elections.</p>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
<script>
    @foreach($ongoingElections as $election)
    {
        const ctxOngoing{{ $election->id }} = document.getElementById('electionChart{{ $election->id }}').getContext('2d');
        const ongoingElectionChart{{ $election->id }} = new Chart(ctxOngoing{{ $election->id }}, {
            type: 'bar',
            data: {
                labels: [
                    @foreach($election->candidates as $candidate)
                        '{{ $candidate->name }}',
                    @endforeach
                ],
                datasets: [{
                    label: 'Votes',
                    data: [
                        @foreach($election->candidates as $candidate)
                            {{ $candidate->votes_count }},
                        @endforeach
                    ],
                    backgroundColor: [
                        @foreach($election->candidates as $candidate)
                            'rgba({{ rand(0, 255) }}, {{ rand(0, 255) }}, {{ rand(0, 255) }}, 0.2)',
                        @endforeach
                    ],
                    borderColor: [
                        @foreach($election->candidates as $candidate)
                            'rgba({{ rand(0, 255) }}, {{ rand(0, 255) }}, {{ rand(0, 255) }}, 1)',
                        @endforeach
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    }
    @endforeach

    @foreach($pastElections as $election)
    {
        const ctxPast{{ $election->id }} = document.getElementById('pastElectionChart{{ $election->id }}').getContext('2d');
        const pastElectionChart{{ $election->id }} = new Chart(ctxPast{{ $election->id }}, {
            type: 'bar',
            data: {
                labels: [
                    @foreach($election->candidates as $candidate)
                        '{{ $candidate->name }}',
                    @endforeach
                ],
                datasets: [{
                    label: 'Votes',
                    data: [
                        @foreach($election->candidates as $candidate)
                            {{ $candidate->votes_count }},
                        @endforeach
                    ],
                    backgroundColor: [
                        @foreach($election->candidates as $candidate)
                            'rgba({{ rand(0, 255) }}, {{ rand(0, 255) }}, {{ rand(0, 255) }}, 0.2)',
                        @endforeach
                    ],
                    borderColor: [
                        @foreach($election->candidates as $candidate)
                            'rgba({{ rand(0, 255) }}, {{ rand(0, 255) }}, {{ rand(0, 255) }}, 1)',
                        @endforeach
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    }
    @endforeach
</script>