<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            Admin Dashboard
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            {{-- Statistics Cards --}}
            <div class="grid grid-cols-1 gap-6 mb-8 md:grid-cols-2 lg:grid-cols-4">
                <div class="p-6 bg-white rounded-lg shadow border-2 border-green-500">
                    <h3 class="text-lg font-medium text-gray-900">{{ __('Total Elections') }}</h3>
                    <p class="text-3xl font-bold text-green-700">{{ $stats['elections'] }}</p>
                </div>
                <div class="p-6 bg-white rounded-lg shadow border-2 border-green-500">
                    <h3 class="text-lg font-medium text-gray-900">{{ __('Total Candidates') }}</h3>
                    <p class="text-3xl font-bold text-green-700">{{ $stats['candidates'] }}</p>
                </div>
                <div class="p-6 bg-white rounded-lg shadow border-2 border-green-500">
                    <h3 class="text-lg font-medium text-gray-900">{{ __('Total Votes') }}</h3>
                    <p class="text-3xl font-bold text-green-700">{{ $stats['votes'] }}</p>
                </div>
                <div class="p-6 bg-white rounded-lg shadow border-2 border-green-500">
                    <h3 class="text-lg font-medium text-gray-900">{{ __('Total Users') }}</h3>
                    <p class="text-3xl font-bold text-green-700">{{ $stats['users'] }}</p>
                </div>
                <div class="p-6 bg-white rounded-lg shadow border-2 border-blue-500 cursor-pointer hover:shadow-md transition duration-300">
                    <a href="{{ route('admin.candidates.index') }}" class="block">
                        <h3 class="text-lg font-medium text-gray-900">{{ __('Manage Candidates') }}</h3>
                        <p class="text-3xl font-bold text-blue-700">{{ $stats['candidates'] }}</p>
                        <p class="text-sm text-gray-600 mt-1">{{ __('View, edit, & delete candidates') }}</p>
                    </a>
                </div>
                <div class="p-6 bg-white rounded-lg shadow border-2 border-blue-500 cursor-pointer hover:shadow-md transition duration-300">
                    <a href="{{ route('elections.index') }}" class="block">
                        <h3 class="text-lg font-medium text-gray-900">{{ __('Manage Elections') }}</h3>
                        <p class="text-3xl font-bold text-blue-700">{{ $stats['elections'] }}</p>
                        <p class="text-sm text-gray-600 mt-1">{{ __('View, edit, & reschedule elections') }}</p>
                    </a>
                </div>
            </div>

            {{-- Action Buttons --}}
            <div class="grid grid-cols-1 gap-6 mb-8 md:grid-cols-3">
                <a href="{{ route('elections.create') }}" class="p-4 text-center text-white bg-blue-600 rounded-lg shadow hover:bg-blue-700">
                    {{ __('Create New Election') }}
                </a>
                <a href="{{ route('admin.candidates.create') }}" class="p-4 text-center text-white bg-green-600 rounded-lg shadow hover:bg-green-700">
                    {{ __('Add Candidate') }}
                </a>
                <a href="{{ route('admin.results') }}" class="p-4 text-center text-white bg-purple-600 rounded-lg shadow hover:bg-purple-700">
                    {{ __('View Results') }}
                </a>
            </div>

            {{-- Recent Activity Section --}}
            <div class="mt-8 bg-white overflow-hidden shadow-sm sm:rounded-lg border-l-4 border-green-500">
                <div class="p-6">
                    <h2 class="mb-4 text-xl font-semibold text-gray-900 border-b pb-2 text-green-700">{{ __('Recent Activity') }}</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <h3 class="mb-2 font-semibold text-gray-700 border-b pb-1 text-green-600">{{ __('Recent Elections') }}</h3>
                            @forelse ($recentElections as $election)
                                <p class="text-gray-600 py-1">- <span class="font-medium">{{ $election->title }}</span> <span class="text-sm text-gray-500">({{ $election->created_at->diffForHumans() }})</span></p>
                            @empty
                                <p class="text-gray-600">{{ __('No recent elections created.') }}</p>
                            @endforelse
                        </div>
                        <div>
                            <h3 class="mb-2 font-semibold text-gray-700 border-b pb-1 text-green-600">{{ __('Recent Candidates') }}</h3>
                            @forelse ($recentCandidates as $candidate)
                                <p class="text-gray-600 py-1">- <span class="font-medium">{{ $candidate->name }}</span> <span class="text-sm text-gray-500">({{ $candidate->created_at->diffForHumans() }})</span></p>
                            @empty
                                <p class="text-gray-600">{{ __('No recent candidates added.') }}</p>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>