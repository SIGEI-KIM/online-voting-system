@extends('layouts.admin')

@section('header')
    <h2 class="text-xl font-semibold leading-tight text-gray-800">
        {{ __('Manage Elections') }}
    </h2>
@endsection

@section('content')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

    <div class="py-12 bg-gray-100">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                <div class="mb-6">
                    <a href="{{ route('elections.create') }}" class="inline-flex items-center px-4 py-2 bg-green-500 hover:bg-green-700 text-white font-semibold rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2">
                        {{ __('Create New Election') }}
                    </a>
                </div>

                @if (session('success'))
                    <div class="bg-green-50 border-l-4 border-green-500 text-green-700 p-4 mb-4 rounded-md">
                        {{ session('success') }}
                    </div>
                @endif

                <div>
                    @php
                        $electionsByStatus = $elections->groupBy('status');
                    @endphp

                    @foreach(['ongoing', 'upcoming', 'completed'] as $status)
                        @if(isset($electionsByStatus[$status]) && $electionsByStatus[$status]->count() > 0)
                            <h3 class="mb-4 mt-8 text-xl font-semibold text-gray-900">{{ ucfirst($status) }} Elections</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
                                @foreach ($electionsByStatus[$status] as $election)
                                    <div class="bg-white border rounded-md shadow-md hover:shadow-lg transition duration-200">
                                        <div class="p-4">
                                            <h4 class="font-semibold text-lg text-gray-800 mb-2">{{ $election->title }}</h4>
                                            <p class="text-sm text-gray-600 mb-1">
                                                {{ __('Start:') }} <span class="font-medium">{{ \Carbon\Carbon::parse($election->start_date)->format('M d, Y H:i') }}</span><br>
                                                {{ __('End:') }} <span class="font-medium">{{ \Carbon\Carbon::parse($election->end_date)->format('M d, Y H:i') }}</span>
                                            </p>
                                            <p class="text-sm mb-2">
                                                {{ __('Status:') }}
                                                @if ($election->status === 'ongoing')
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">{{ ucfirst($election->status) }}</span>
                                                @elseif ($election->status === 'upcoming')
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">{{ ucfirst($election->status) }}</span>
                                                @else
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">{{ ucfirst($election->status) }}</span>
                                                @endif
                                            </p>
                                            <div class="mt-4 flex justify-end space-x-2">
                                                @if ($status !== 'completed')
                                                    <a href="{{ route('elections.edit', $election->id) }}" class="inline-flex items-center px-3 py-2 bg-yellow-400 hover:bg-yellow-500 text-white hover:text-gray-100 shadow-sm text-xs font-semibold rounded-md focus:outline-none focus:ring-2 focus:ring-yellow-400 focus:ring-offset-2 transition duration-150">
                                                        {{ __('Edit') }}
                                                    </a>
                                                @endif
                                                @if ($status !== 'ongoing' && $status !== 'completed')
                                                    <form id="delete-form-{{ $election->id }}" action="{{ route('elections.destroy', $election->id) }}" method="POST" class="inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="button"
                                                                onclick="confirmDeleteElection({{ $election->id }})"
                                                                class="inline-flex items-center px-3 py-2 bg-red-500 hover:bg-red-700 text-white hover:text-gray-100 shadow-sm text-xs font-semibold rounded-md focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition duration-150">
                                                            {{ __('Delete') }}
                                                        </button>
                                                    </form>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    @endforeach

                    @if ($elections->isEmpty())
                        <p class="text-gray-600">{{ __('No elections created yet.') }}</p>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function confirmDeleteElection(electionId) {
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('delete-form-' + electionId).submit();
                }
            });
        }
    </script>
@endsection