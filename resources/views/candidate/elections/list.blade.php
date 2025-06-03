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

                    @if ($elections->count() > 0)
                        <form method="GET" action="{{ route('candidate.apply.get-form') }}" class="mt-4">
                            <ul class="space-y-3">
                                @foreach ($elections as $election)
                                    <li class="border rounded-md shadow-sm">
                                        <label for="election_{{ $election->id }}" class="block p-4 hover:bg-gray-50 cursor-pointer">
                                            <div class="flex items-center">
                                                <input type="radio" name="election_id" id="election_{{ $election->id }}" value="{{ $election->id }}" class="mr-3 text-indigo-600 focus:ring-indigo-500 h-4 w-4">
                                                <div>
                                                    <h4 class="font-semibold text-md text-gray-700">{{ $election->title }}</h4>
                                                    <p class="text-gray-500 text-sm">{{ $election->description }}</p>
                                                    <p class="text-gray-400 text-xs">Starts: {{ \Carbon\Carbon::parse($election->start_date)->format('M d, Y') }} - Ends: {{ \Carbon\Carbon::parse($election->end_date)->format('M d, Y') }}</p>
                                                </div>
                                            </div>
                                        </label>
                                    </li>
                                @endforeach
                            </ul>

                            <div class="mt-6">
                                <x-primary-button class="bg-indigo-600 hover:bg-indigo-700 focus:bg-indigo-700">
                                    {{ __('Proceed to Application Form') }}
                                </x-primary-button>
                            </div>
                        </form>
                    @else
                        <p class="text-gray-600">{{ __('No elections available to apply for at this time.') }}</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-candidate-layout>