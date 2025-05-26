<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Candidate Details') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h3 class="text-lg font-semibold mb-4">{{ $candidate->name }}</h3>

                @if($candidate->photo)
                    <img src="{{ asset('storage/' . $candidate->photo) }}" alt="{{ $candidate->name }}" class="mb-4 rounded-md">
                @endif

                <p class="mb-2"><strong>Election:</strong> {{ $candidate->election->title ?? 'N/A' }}</p>
                <p class="mb-2"><strong>Position:</strong> {{ $candidate->position }}</p>
                <p class="mb-2"><strong>Biography:</strong></p>
                <p class="mb-4">{{ $candidate->bio ?? 'N/A' }}</p>

                <a href="{{ route('admin.candidates.edit', $candidate->id) }}" class="inline-flex items-center px-4 py-2 bg-blue-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 active:bg-blue-900 focus:outline-none focus:border-blue-900 focus:ring focus:ring-blue-300 disabled:opacity-25 transition ease-in-out duration-150">
                    {{ __('Edit') }}
                </a>
                <a href="{{ route('admin.candidates.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring focus:ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150 ml-2">
                    {{ __('Back to Candidates') }}
                </a>
            </div>
        </div>
    </div>
</x-app-layout>