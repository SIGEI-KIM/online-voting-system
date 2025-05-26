<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Candidate Details') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h3 class="text-lg font-semibold mb-4">{{ $candidate->name }}</h3>
                    <p><strong>{{ __('Position:') }}</strong> {{ $candidate->position }}</p>
                    <p><strong>{{ __('Election:') }}</strong> {{ $candidate->election->name }}</p>

                    <div class="mt-4">
                        <a href="{{ route('admin.candidates.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                            {{ __('Back to Candidates') }}
                        </a>
                        <a href="{{ route('admin.candidates.edit', $candidate) }}" class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded ml-2">
                            {{ __('Edit Candidate') }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>