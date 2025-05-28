<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Voter Dashboard') }}
        </h2>
    </x-slot>

    {{-- Inline CSS for blinking effect (we can remove this entire style block if no other element uses it) --}}
    <style>
        .blink {
            animation: blinker 1s linear infinite;
        }

        @keyframes blinker {
            50% {
                opacity: 0;
            }
        }
    </style>

    <div class="py-2 bg-gray-100">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <marquee behavior="scroll" direction="left" class="text-lg font-semibold text-green-600">
                        Welcome to the Voting Site!
                    </marquee>
                </div>
            </div>
        </div>
    </div>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div>
                    <h3 class="text-lg font-medium text-red-600 mb-4">{{ __('Active Elections') }}</h3>
                    @if($activeElections->count() > 0)
                        <div>
                            @foreach($activeElections as $election)
                                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-4 border-l-4 border-red-500">
                                    <div class="p-6">
                                        <h4 class="font-bold text-lg mb-2">{{ $election->title }}</h4>
                                        <p class="text-gray-600 mb-4">{{ $election->description }}</p>
                                        <div class="flex justify-between text-sm text-gray-500 mb-4">
                                            <span>Start: {{ $election->start_date->format('M d, Y H:i') }}</span>
                                            <span>End: {{ $election->end_date->format('M d, Y H:i') }}</span>
                                        </div>
                                        <a href="{{ route('votes.create', $election) }}"
                                           class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                            {{ __('Vote Now') }}
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-gray-500">{{ __('No active elections at this time.') }}</p>
                    @endif
                </div>

                <div>
                    <h3 class="text-lg font-medium text-green-600 mb-4">{{ __('Upcoming Elections') }}</h3>
                    @if($upcomingElections->count() > 0)
                        <div>
                            @foreach($upcomingElections as $election)
                                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-4 border-l-4 border-green-500">
                                    <div class="p-6">
                                        <h4 class="font-bold text-lg mb-2">{{ $election->title }}</h4>
                                        <p class="text-gray-600 mb-4">{{ $election->description }}</p>
                                        <div class="flex justify-between text-sm text-gray-500 mb-4">
                                            <span>Start: {{ $election->start_date->format('M d, Y H:i') }}</span>
                                            <span>End: {{ $election->end_date->format('M d, Y H:i') }}</span>
                                        </div>
                                        <button disabled
                                                class="inline-flex items-center px-4 py-2 bg-gray-400 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest transition ease-in-out duration-150">
                                            {{ __('Vote Now (Starts Soon)') }}
                                        </button>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-gray-500">{{ __('No upcoming elections at this time.') }}</p>
                    @endif
                </div>

                <div>
                    <h3 class="text-lg font-medium text-black mb-4">{{ __('Past Elections') }}</h3>
                    @if($completedElections->count() > 0)
                        <div>
                            @foreach($completedElections as $election)
                                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-4 border-l-4 border-black">
                                    <div class="p-6">
                                        <h4 class="font-bold text-lg mb-2">{{ $election->title }}</h4>
                                        <p class="text-gray-600 mb-4">{{ $election->description }}</p>
                                        <div class="flex justify-between text-sm text-gray-500 mb-4">
                                            <span>Ended: {{ $election->end_date->format('M d, Y H:i') }}</span>
                                        </div>
                                        <a href="{{ route('voter.past.election.results', $election) }}"
                                           class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 focus:bg-green-700 active:bg-green-900 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                            {{ __('View Results') }}
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-gray-500">{{ __('No past elections available.') }}</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>