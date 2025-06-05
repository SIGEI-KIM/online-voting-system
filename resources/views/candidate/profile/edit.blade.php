<x-candidate-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Your Candidate Profile') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form method="POST" action="{{ route('candidate.profile.update') }}">
                        @csrf
                        @method('PUT')

                        <div>
                            <x-input-label for="name" :value="__('Candidate Name')" />
                            {{-- This name comes from the User model, not the Candidate model --}}
                            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name', Auth::user()->name)" required autofocus autocomplete="name" disabled />
                            {{-- Consider making this read-only or removing if name is handled by account settings --}}
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        </div>

                        <div class="mt-4">
                            <x-input-label for="bio" :value="__('Bio / Statement')" />
                            {{-- THIS IS THE LINE WHERE $profile->bio IS USED --}}
                            <textarea id="bio" class="block mt-1 w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm" name="bio" rows="5" required>{{ old('bio', $profile->bio ?? '') }}</textarea>
                            <x-input-error :messages="$errors->get('bio')" class="mt-2" />
                        </div>

                        {{-- If you have a photo upload, ensure it also uses $profile->photo --}}
                        {{-- <div class="mt-4">
                            <x-input-label for="photo" :value="__('Profile Photo')" />
                            <input type="file" id="photo" name="photo" class="block mt-1 w-full" />
                            @if ($profile->photo)
                                <img src="{{ asset('storage/' . $profile->photo) }}" alt="Current Photo" class="mt-2 w-20 h-20 object-cover rounded-full">
                            @endif
                            <x-input-error :messages="$errors->get('photo')" class="mt-2" />
                        </div> --}}


                        <div class="flex items-center justify-end mt-4">
                            <x-primary-button class="ml-4">
                                {{ __('Update Profile') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-candidate-layout>