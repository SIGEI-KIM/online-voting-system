<x-candidate-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-indigo-700 leading-tight">
            {{ __('Apply for Election') }} - <span class="text-gray-800">{{ $election->title }}</span>
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-md mx-auto bg-white overflow-hidden shadow-md sm:rounded-lg p-6">
            <h3 class="text-xl font-semibold text-gray-800 mb-4">{{ __('Application Form for:') }} <span class="text-indigo-600">{{ $election->title }}</span></h3>
            <p class="text-gray-600 text-sm mb-4">{{ $election->description }}</p>

            <form method="POST" action="{{ route('candidate.apply.submit', $election) }}" class="mt-4" id="applicationForm" enctype="multipart/form-data">
                @csrf

                <div class="mb-4">
                    <x-input-label for="full_name" :value="__('Full Name')" class="text-gray-700" />
                    <x-text-input id="full_name" class="block mt-1 w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-500 focus:ring-indigo-500" type="text" name="full_name" :value="old('full_name')" required autofocus />
                    <x-input-error :messages="$errors->get('full_name')" class="mt-2 text-red-600 text-sm" />
                </div>

                <div class="mb-4">
                    <x-input-label for="id_number" :value="__('ID Number')" class="text-gray-700" />
                    <x-text-input id="id_number" class="block mt-1 w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-500 focus:ring-indigo-500" type="text" name="id_number" :value="old('id_number')" required />
                    <x-input-error :messages="$errors->get('id_number')" class="mt-2 text-red-600 text-sm" />
                </div>

                <div class="mb-4">
                    <x-input-label for="contact_email" :value="__('Contact Email')" class="text-gray-700" />
                    <x-text-input id="contact_email" class="block mt-1 w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-500 focus:ring-indigo-500" type="email" name="contact_email" :value="old('contact_email')" required />
                    <x-input-error :messages="$errors->get('contact_email')" class="mt-2 text-red-600 text-sm" />
                </div>

                <div class="mb-4">
                    <x-input-label for="contact_phone" :value="__('Contact Phone')" class="text-gray-700" />
                    <x-text-input id="contact_phone" class="block mt-1 w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-500 focus:ring-indigo-500" type="tel" name="contact_phone" :value="old('contact_phone')" required />
                    <x-input-error :messages="$errors->get('contact_phone')" class="mt-2 text-red-600 text-sm" />
                </div>

                <div class="mb-4">
                    <x-input-label for="passport_photo" :value="__('Passport Photo Upload')" class="text-gray-700" />
                    <div class="mt-1 rounded-md shadow-sm">
                        <input id="passport_photo" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100" type="file" name="passport_photo" accept="image/*">
                    </div>
                    <x-input-error :messages="$errors->get('passport_photo')" class="mt-2 text-red-600 text-sm" />
                </div>

                <div class="mb-4">
                    <x-input-label for="document" :value="__('Supporting Document (e.g., Certificate)')" class="text-gray-700" />
                    <div class="mt-1 rounded-md shadow-sm">
                        <input id="document" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100" type="file" name="document">
                    </div>
                    <x-input-error :messages="$errors->get('document')" class="mt-2 text-red-600 text-sm" />
                </div>

                <div class="mb-4">
                    <label for="terms" class="inline-flex items-center text-gray-700">
                        <input id="terms" type="checkbox" name="terms" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500 h-4 w-4" required>
                        <span class="ml-2 text-sm text-gray-600">{{ __('I agree to the terms and conditions.') }}</span>
                    </label>
                    <x-input-error :messages="$errors->get('terms')" class="mt-2 text-red-600 text-sm" />
                </div>

                <div class="mt-6">
                    <x-primary-button type="submit">
                        {{ __('Submit Application') }}
                    </x-primary-button>
                </div>
            </form>
        </div>
    </div>
</x-candidate-layout>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.10.5/dist/sweetalert2.min.css">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.10.5/dist/sweetalert2.all.min.js"></script>

<script>
    document.getElementById('applicationForm').addEventListener('submit', function(event) {
        event.preventDefault(); // Prevent the default form submission

        Swal.fire({
            title: 'Are you sure you want to submit your application?',
            text: "Please double-check all the information before submitting.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, submit it!',
            cancelButtonText: 'No, go back',
        }).then((result) => {
            if (result.isConfirmed) {
                this.submit(); 
            }
        });
    });
</script>