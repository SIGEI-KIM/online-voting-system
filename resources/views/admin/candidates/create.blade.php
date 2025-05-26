<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h2 class="text-xl font-semibold mb-4">Add New Candidate</h2>
                
                <form method="POST" action="{{ route('admin.candidates.store') }}" enctype="multipart/form-data">
                    @csrf
                    
                    <!-- Name -->
                    <div class="mb-4">
                        <x-input-label for="name" :value="__('Full Name')" />
                        <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" required />
                    </div>

                    <!-- Election -->
                    <div class="mb-4">
                        <x-input-label for="election_id" :value="__('Election')" />
                        <select id="election_id" name="election_id" class="block mt-1 w-full rounded-md border-gray-300">
                            @foreach($elections as $election)
                                <option value="{{ $election->id }}">{{ $election->title }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Position -->
                    <div class="mb-4">
                        <x-input-label for="position" :value="__('Position')" />
                        <x-text-input id="position" class="block mt-1 w-full" type="text" name="position" required />
                    </div>

                    <!-- Photo -->
                    <div class="mb-4">
                        <x-input-label for="photo" :value="__('Photo')" />
                        <input id="photo" class="block mt-1 w-full" type="file" name="photo" accept="image/*" />
                    </div>

                    <!-- Bio -->
                    <div class="mb-4">
                        <x-input-label for="bio" :value="__('Biography')" />
                        <textarea id="bio" name="bio" rows="4" class="block mt-1 w-full rounded-md border-gray-300"></textarea>
                    </div>

                    <x-primary-button type="submit">
                        {{ __('Add Candidate') }}
                    </x-primary-button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>