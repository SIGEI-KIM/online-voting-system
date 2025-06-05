<x-admin-layout> {{-- Changed from x-app-layout --}}
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Edit Election') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-md mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h3 class="mb-6 text-lg font-semibold text-gray-900">{{ __('Edit Election Details') }}</h3>
                    <form method="POST" action="{{ route('elections.update', $election->id) }}">
                        @csrf
                        @method('PUT')

                        {{-- Determine if the election is ongoing or completed --}}
                        @php
                            $isOngoingOrCompleted = in_array($election->status, ['ongoing', 'completed']);
                            $isCompleted = ($election->status === 'completed');
                        @endphp

                        {{-- Display a warning if the election is ongoing or completed --}}
                        @if ($isOngoingOrCompleted)
                            <div class="mb-4 p-3 text-sm text-yellow-800 rounded-lg bg-yellow-50 dark:bg-gray-800 dark:text-yellow-300" role="alert">
                                <span class="font-medium">{{ __('Warning!') }}</span>
                                {{ $isCompleted ? __('This election has been completed and cannot be modified.') : __('This election is ongoing and its details cannot be changed.') }}
                            </div>
                        @endif

                        <div class="mb-4">
                            <x-input-label for="title" :value="__('Title')" class="block font-medium text-sm text-gray-700" />
                            <x-text-input id="title" class="block mt-1 w-full rounded-md shadow-sm border-gray-300 focus:border-green-500 focus:ring-green-500" type="text" name="title" :value="old('title', $election->title)" required autofocus {{ $isOngoingOrCompleted ? 'disabled' : '' }} />
                            <x-input-error :messages="$errors->get('title')" class="mt-2 text-sm text-red-600" />
                        </div>

                        <div class="mb-4">
                            <x-input-label for="description" :value="__('Description')" class="block font-medium text-sm text-gray-700" />
                            <textarea id="description" name="description" rows="4" class="block mt-1 w-full rounded-md shadow-sm border-gray-300 focus:border-green-500 focus:ring-green-500" {{ $isOngoingOrCompleted ? 'disabled' : '' }}>{{ old('description', $election->description) }}</textarea>
                            <x-input-error :messages="$errors->get('description')" class="mt-2 text-sm text-red-600" />
                        </div>

                        <div class="mb-4">
                            <x-input-label for="start_date" :value="__('Start Date')" class="block font-medium text-sm text-gray-700" />
                            <x-text-input id="start_date" class="block mt-1 w-full rounded-md shadow-sm border-gray-300 focus:border-green-500 focus:ring-green-500" type="datetime-local" name="start_date" :value="old('start_date', \Carbon\Carbon::parse($election->start_date)->setTimezone('Africa/Nairobi')->format('Y-m-d\TH:i'))" required {{ $isOngoingOrCompleted ? 'disabled' : '' }} />
                            <x-input-error :messages="$errors->get('start_date')" class="mt-2 text-sm text-red-600" />
                        </div>

                        <div class="mb-4">
                            <x-input-label for="end_date" :value="__('End Date')" class="block font-medium text-sm text-gray-700" />
                            <x-text-input id="end_date" class="block mt-1 w-full rounded-md shadow-sm border-gray-300 focus:border-green-500 focus:ring-green-500" type="datetime-local" name="end_date" :value="old('end_date', \Carbon\Carbon::parse($election->end_date)->setTimezone('Africa/Nairobi')->format('Y-m-d\TH:i'))" required {{ $isOngoingOrCompleted ? 'disabled' : '' }} />
                            <x-input-error :messages="$errors->get('end_date')" class="mt-2 text-sm text-red-600" />
                        </div>

                        <div class="mb-4">
                            <x-input-label for="status" :value="__('Status')" class="block font-medium text-sm text-gray-700" />
                            <select id="status" class="block mt-1 w-full rounded-md shadow-sm border-gray-300 focus:border-green-500 focus:ring-green-500" name="status" required {{ $isCompleted ? 'disabled' : '' }}>
                                <option value="upcoming" {{ old('status', $election->status) === 'upcoming' ? 'selected' : '' }} {{ $isOngoingOrCompleted ? 'disabled' : '' }}>{{ __('Upcoming') }}</option>
                                <option value="ongoing" {{ old('status', $election->status) === 'ongoing' ? 'selected' : '' }} {{ $isOngoingOrCompleted ? 'disabled' : '' }}>{{ __('Ongoing') }}</option>
                                <option value="completed" {{ old('status', $election->status) === 'completed' ? 'selected' : '' }} {{ $election->status === 'upcoming' ? 'disabled' : '' }}>{{ __('Completed') }}</option>
                            </select>
                            <x-input-error :messages="$errors->get('status')" class="mt-2 text-sm text-red-600" />
                        </div>

                        <div class="flex items-center justify-end mt-6">
                            <a href="{{ route('elections.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-500 hover:bg-gray-700 text-white font-bold rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 mr-4">
                                {{ __('Back to Elections') }}
                            </a>
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-green-600 hover:bg-green-700 text-white font-bold rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2" {{ $isCompleted ? 'disabled' : '' }}>
                                {{ __('Update Election') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>
