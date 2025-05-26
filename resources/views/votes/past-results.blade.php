<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Past Election Results') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h3 class="mb-6 text-2xl font-semibold text-gray-900">{{ __('Past Elections') }}</h3>
                    @if($pastElections->count() > 0)
                        <div class="space-y-6">
                            @foreach($pastElections as $election)
                                <div class="p-6 bg-gray-100 rounded-lg shadow">
                                    <h4 class="mb-3 text-xl font-semibold text-gray-800">{{ $election->title }}</h4>
                                    @include('partials.election-results-table', ['election' => $election])
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-gray-600">{{ __('No past elections available.') }}</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>