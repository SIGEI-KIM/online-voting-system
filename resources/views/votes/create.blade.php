<x-app-layout>
    <head>
        <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
        <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
    </head>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Vote') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h1 class="text-2xl font-bold mb-6">Vote in {{ $election->title }}</h1>

                <form id="voteForm" method="POST" action="{{ route('votes.store', $election) }}">
                    @csrf

                    @foreach($election->candidates as $candidate)
                    <div class="mb-6 p-4 border rounded-lg hover:bg-gray-50 transition">
                        <label class="flex items-center cursor-pointer">
                            <input type="radio" name="candidate_id" value="{{ $candidate->id }}"
                                class="h-5 w-5 text-blue-600 focus:ring-blue-500" required>
                            <div class="ml-4">
                                <div class="flex items-center">
                                    @if($candidate->photo)
                                    <img src="{{ Storage::url($candidate->photo) }}"
                                        class="h-12 w-12 rounded-full object-cover mr-3">
                                    @endif
                                    <div>
                                        <span class="block font-medium text-lg">{{ $candidate->name }}</span>
                                        <span class="block text-sm text-gray-500">{{ $candidate->position }}</span>
                                    </div>
                                </div>
                                <p class="mt-2 text-gray-700">{{ $candidate->bio }}</p>
                            </div>
                        </label>
                    </div>
                    @endforeach

                    <x-primary-button id="submitVoteButton" class="w-full justify-center mt-6 py-3">
                        {{ __('Submit Vote') }}
                    </x-primary-button>
                </form>
            </div>
        </div>
    </div>

    <script>
        const form = document.getElementById('voteForm');
        const submitButton = document.getElementById('submitVoteButton');

        form.addEventListener('submit', function(event) {
            event.preventDefault(); // Prevent default form submission

            const formData = new FormData(form);

            fetch(form.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}' // Laravel CSRF token
                }
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    Toastify({
                        text: "You have voted successfully!",
                        duration: 3000,
                        gravity: "top",
                        position: "right",
                        backgroundColor: "green",
                    }).showToast();

                    window.location.href = '{{ route('dashboard') }}'; // Redirect immediately

                    // Disable the form and button to prevent multiple submissions
                    form.querySelectorAll('input[type="radio"], button').forEach(el => el.disabled = true);
                } else {
                    // Check if the error is due to already voting
                    if (data.message && data.message.includes('already voted')) {
                        Toastify({
                            text: data.message,
                            duration: 5000,
                            gravity: "top",
                            position: "right",
                            backgroundColor: "red", 
                        }).showToast();
                        window.location.href = '{{ route('dashboard') }}'; // Redirect immediately
                        // disable the form 
                        //form.querySelectorAll('input[type="radio"], button').forEach(el => el.disabled = true);
                    } else {
                        Toastify({
                            text: data.message || "An error occurred.",
                            duration: 3000,
                            gravity: "top",
                            position: "right",
                            backgroundColor: "red",
                        }).showToast();
                    }
                }
            })
            .catch(error => {
                console.error('There was a problem with the fetch operation:', error);
                Toastify({
                    text: "An error occurred: " + error.message,
                    duration: 3000,
                    gravity: "top",
                    position: "right",
                    backgroundColor: "red",
                }).showToast();
            });
        });
    </script>
</x-app-layout>