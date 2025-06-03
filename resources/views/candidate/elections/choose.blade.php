<x-candidate-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-indigo-700 leading-tight">
            {{ __('Choose Election to Apply For') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-md sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">{{ __('Select the Election you want to apply for:') }}</h3>

                    @if ($hasActiveApplication)
                        <div class="mb-4 text-yellow-600 bg-yellow-100 border border-yellow-400 rounded-md p-4">
                            {{ __('You have already applied for an upcoming election. You cannot apply for another one at this time.') }}
                        </div>
                    @endif

                    @if ($elections->count() > 0)
                        <ul class="space-y-3">
                            @foreach ($elections as $election)
                                <li class="border rounded-md shadow-sm">
                                    <div class="block p-4">
                                        <div class="flex items-center justify-between">
                                            <div>
                                                <h4 class="font-semibold text-md text-gray-700">{{ $election->title }}</h4>
                                                <p class="text-gray-500 text-sm">{{ $election->description }}</p>
                                                <p class="text-gray-400 text-xs">Starts: {{ \Carbon\Carbon::parse($election->start_date)->format('M d, Y') }} - Ends: {{ \Carbon\Carbon::parse($election->end_date)->format('M d, Y') }}</p>
                                            </div>
                                            @if (!$hasActiveApplication)
                                                <a href="{{ route('candidate.apply.get-form', ['election_id' => $election->id]) }}" class="inline-flex items-center px-4 py-2 bg-green-500 hover:bg-green-700 text-white font-semibold rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                                    {{ __('Apply Now') }}
                                                </a>
                                            @else
                                                <span class="inline-flex items-center px-4 py-2 bg-gray-300 text-gray-500 font-semibold rounded-md shadow-sm cursor-not-allowed">
                                                    {{ __('Apply Now') }}
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <p class="text-gray-600">{{ __('No elections available to apply for at this time.') }}</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-candidate-layout>