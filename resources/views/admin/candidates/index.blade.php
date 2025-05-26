<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Candidates') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="mb-4">
                        <a href="{{ route('admin.candidates.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            {{ __('Add New Candidate') }}
                        </a>
                    </div>

                    @if (session('success'))
                        <div class="bg-green-200 border-green-600 text-green-600 border-l-4 p-4 mb-4" role="alert">
                            {{ session('success') }}
                        </div>
                    @endif

                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        @forelse ($candidates as $candidate)
                            <div class="border rounded p-4">
                                <div class="flex items-center mb-4">
                                    @if ($candidate->photo)
                                        <img src="{{ asset('storage/' . $candidate->photo) }}" alt="{{ $candidate->name }}" class="w-20 h-20 rounded-full mr-4 object-cover">
                                    @else
                                        <div class="w-20 h-20 bg-gray-200 rounded-full mr-4 flex items-center justify-center">
                                            <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                        </div>
                                    @endif
                                    <div>
                                        <h3 class="font-semibold">{{ $candidate->name }}</h3>
                                        <p class="text-gray-600">{{ $candidate->position }}</p>
                                        <p class="text-sm text-gray-500">{{ $candidate->election->title }}</p>
                                    </div>
                                </div>
                                <div class="flex justify-end">
                                    <a href="{{ route('admin.candidates.show', $candidate) }}" class="text-indigo-600 hover:text-indigo-900 mr-2">{{ __('View') }}</a>
                                    <a href="{{ route('admin.candidates.edit', $candidate) }}" class="text-yellow-600 hover:text-yellow-900 mr-2">{{ __('Edit') }}</a>
                                    <form action="{{ route('admin.candidates.destroy', $candidate) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('{{ __('Are you sure you want to delete this candidate?') }}')">{{ __('Delete') }}</button>
                                    </form>
                                </div>
                            </div>
                        @empty
                            <p>{{ __('No candidates found.') }}</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>