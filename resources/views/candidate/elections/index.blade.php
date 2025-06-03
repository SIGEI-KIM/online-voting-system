<x-candidate-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('My Elections') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @if (session('info'))
                        <div class="mb-4 font-medium text-sm text-blue-600">
                            {{ session('info') }}
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="mb-4 font-medium text-sm text-red-600">
                            {{ session('error') }}
                        </div>
                    @endif

                    <h3 class="text-lg font-semibold mb-4">{{ __('Elections You Have Applied For') }}</h3>

                    @if ($appliedElections->count() > 0)
                        <ul class="space-y-4">
                            @foreach ($appliedElections as $application)
                                <li class="border rounded-md p-4">
                                    <h4 class="font-semibold text-md">{{ $application->election->title }}</h4>
                                    <p class="text-gray-600 text-sm">{{ $application->election->description }}</p>
                                    <p class="text-gray-500 text-xs">Applied On: {{ $application->applied_at->format('M d, Y') }}</p>
                                    <span class="font-semibold">Status: {{ ucfirst($application->status) }}</span>
                                    {{-- You can add more details or actions here --}}
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <p>{{ __('You have not applied for any elections yet.') }}</p>
                    @endif

                    <div class="mt-6">
                        <a href="{{ route('candidate.apply') }}" class="inline-flex items-center px-4 py-2 bg-blue-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-600 active:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150">
                            {{ __('Apply for an Election') }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-candidate-layout>