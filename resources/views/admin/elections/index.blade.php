<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Manage Elections') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="mb-4">
                        <a href="{{ route('elections.create') }}" class="inline-flex items-center px-4 py-2 bg-green-500 hover:bg-green-700 text-white font-bold rounded">
                            {{ __('Create New Election') }}
                        </a>
                    </div>

                    @if (session('success'))
                        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4" role="alert">
                            <p>{{ session('success') }}</p>
                        </div>
                    @endif

                    <div>
                        @php
                            $electionsByStatus = $elections->groupBy('status');
                        @endphp

                        @foreach(['ongoing', 'upcoming', 'completed'] as $status)
                            @if(isset($electionsByStatus[$status]) && $electionsByStatus[$status]->count() > 0)
                                <h3 class="mb-2 mt-6 text-lg font-semibold text-gray-900">{{ ucfirst($status) }} Elections</h3>
                                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 mb-6">
                                    @foreach ($electionsByStatus[$status] as $election)
                                        <div class="border rounded-md shadow-sm p-4">
                                            <h4 class="font-semibold text-gray-800">{{ $election->title }}</h4>
                                            <p class="text-sm text-gray-600">
                                                {{ __('Start:') }} {{ \Carbon\Carbon::parse($election->start_date)->format('M d, Y H:i') }}<br>
                                                {{ __('End:') }} {{ \Carbon\Carbon::parse($election->end_date)->format('M d, Y H:i') }}
                                            </p>
                                            <p class="text-sm">
                                                {{ __('Status:') }}
                                                @if ($election->status === 'ongoing')
                                                    <span class="text-green-500 font-semibold">{{ ucfirst($election->status) }}</span>
                                                @elseif ($election->status === 'upcoming')
                                                    <span class="text-blue-500 font-semibold">{{ ucfirst($election->status) }}</span>
                                                @else
                                                    <span class="text-gray-500 font-semibold">{{ ucfirst($election->status) }}</span>
                                                @endif
                                            </p>
                                            <div class="mt-2 flex justify-end">
                                                <a href="{{ route('elections.edit', $election->id) }}" class="inline-flex items-center px-2 py-1 bg-yellow-500 hover:bg-yellow-700 text-white text-xs rounded mr-2">{{ __('Edit') }}</a>
                                                <form action="{{ route('elections.destroy', $election->id) }}" method="POST" class="inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="inline-flex items-center px-2 py-1 bg-red-500 hover:bg-red-700 text-white text-xs rounded">{{ __('Delete') }}</button>
                                                </form>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        @endforeach

                        @if ($elections->isEmpty())
                            <p>{{ __('No elections created yet.') }}</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>