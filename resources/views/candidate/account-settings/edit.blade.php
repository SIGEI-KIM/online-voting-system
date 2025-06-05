{{-- resources/views/candidate/account-settings/edit.blade.php --}}
<x-candidate-layout> {{-- Use your candidate-specific layout --}}
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Account Settings') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            @if (session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    {{-- Form for Name and Email --}}
                    @include('candidate.account-settings.partials.update-profile-information-form', ['user' => $user])
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    {{-- Form for Password Update --}}
                    @include('candidate.account-settings.partials.update-password-form', ['user' => $user])
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    {{-- Form for Delete Account --}}
                    @include('candidate.account-settings.partials.delete-user-form', ['user' => $user])
                </div>
            </div>
        </div>
    </div>
</x-candidate-layout>