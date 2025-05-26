<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Vote in') }} {{ $election->title }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-md mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form id="votingForm" method="POST" action="{{ route('votes.store', $election) }}">
                        @csrf

                        <div class="mb-4">
                            <p class="mb-2 font-semibold">{{ __('Select your candidate:') }}</p>
                            @forelse ($election->candidates as $candidate)
                                <div class="mb-4 border rounded p-3 flex items-center">
                                    <input type="radio" id="candidate_{{ $candidate->id }}" name="candidate_id" value="{{ $candidate->id }}" class="mr-4">
                                    @if ($candidate->photo)
                                        <img src="{{ asset('storage/' . $candidate->photo) }}" alt="{{ $candidate->name }}" class="w-16 h-16 rounded-full object-cover mr-4">
                                    @else
                                        <div class="w-16 h-16 bg-gray-200 rounded-full mr-4 flex items-center justify-center">
                                            <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                        </div>
                                    @endif
                                    <div>
                                        <label for="candidate_{{ $candidate->id }}" class="font-semibold">{{ $candidate->name }}</label>
                                        <p class="text-sm text-gray-600">{{ $candidate->position }}</p>
                                        @if ($candidate->biography)
                                            <p class="text-xs text-gray-500 italic">{{ Str::limit($candidate->biography, 50) }}</p>
                                        @endif
                                    </div>
                                </div>
                            @empty
                                <p>{{ __('No candidates available for this election.') }}</p>
                            @endforelse
                        </div>

                        @if ($election->candidates->isNotEmpty())
                            <div class="flex justify-end">
                                <button type="submit" class="inline-flex items-center px-4 py-2 bg-green-600 hover:bg-green-700 text-white font-bold rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2">
                                    {{ __('Cast Vote') }}
                                </button>
                            </div>
                        @endif
                    </form>

                    <div id="voteMessage" class="mt-4 font-semibold"></div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const form = document.getElementById('votingForm');
            const voteMessage = document.getElementById('voteMessage');

            form.addEventListener('submit', function (e) {
                e.preventDefault();
                const formData = new FormData(form);

                fetch(form.action, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    voteMessage.textContent = data.message;
                    if (data.success) {
                        voteMessage.className = 'text-green-600';
                    } else {
                        voteMessage.className = 'text-red-600';
                    }
                    setTimeout(function() {
                        window.location.href = '{{ route('dashboard') }}';
                    }, 1500);
                })
                .catch(error => {
                    console.error('Error:', error);
                    voteMessage.className = 'text-red-600';
                    voteMessage.textContent = 'An error occurred while recording your vote.';
                });
            });
        });
    </script>
</x-app-layout>