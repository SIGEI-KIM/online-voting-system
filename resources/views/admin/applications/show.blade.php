<x-admin-layout>
    <x-slot name="header">
        <div class="bg-white shadow">
            <div class="max-w-7xl mx-auto py-4 px-4 sm:px-6 lg:px-8">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    {{ __('Review Application') }}
                </h2>
            </div>
        </div>
    </x-slot>

    <div class="py-10 bg-gray-100">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-lg rounded-lg border">
                <div class="px-6 py-5 border-b bg-gray-50">
                    <h3 class="text-lg font-semibold text-gray-900">{{ __('Application Details') }}</h3>
                </div>
                <div class="p-6 space-y-4">
                    <div>
                        <strong class="text-gray-700">{{ __('Election:') }}</strong>
                        <p class="mt-1 text-gray-600">{{ $application->election->title }}</p>
                    </div>
                    <div>
                        <strong class="text-gray-700">{{ __('Candidate Name:') }}</strong>
                        <p class="mt-1 text-gray-600">{{ $application->full_name }}</p>
                    </div>
                    <div>
                        <strong class="text-gray-700">{{ __('ID Number:') }}</strong>
                        <p class="mt-1 text-gray-600">{{ $application->id_number }}</p>
                    </div>
                    <div>
                        <strong class="text-gray-700">{{ __('Contact Email:') }}</strong>
                        <p class="mt-1 text-blue-600">{{ $application->contact_email }}</p>
                    </div>
                    <div>
                        <strong class="text-gray-700">{{ __('Contact Phone:') }}</strong>
                        <p class="mt-1 text-gray-600">{{ $application->contact_phone }}</p>
                    </div>

                    @if ($application->passport_photo_path)
                        <div>
                            <strong class="text-gray-700 block mb-2">{{ __('Passport Photo:') }}</strong>
                            <div class="rounded-md overflow-hidden shadow-md border w-48">
                                <img src="{{ asset('storage/' . $application->passport_photo_path) }}" alt="Passport Photo" class="w-full h-auto">
                            </div>
                        </div>
                    @endif

                    @if ($application->document_path)
                        <div>
                            <strong class="text-gray-700">{{ __('Supporting Document:') }}</strong>
                            <p class="mt-1">
                                <a href="{{ asset('storage/' . $application->document_path) }}" target="_blank" class="text-blue-600 hover:underline">{{ __('View Document') }}</a>
                            </p>
                        </div>
                    @endif
                </div>
                <div class="px-6 py-4 bg-gray-100 border-t flex justify-end space-x-3">
                    <form method="POST" action="{{ route('admin.applications.update', $application) }}">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="status" value="approved">
                        <x-primary-button class="bg-green-500 hover:bg-green-700 text-white shadow">{{ __('Approve') }}</x-primary-button>
                    </form>
                    <form method="POST" action="{{ route('admin.applications.update', $application) }}">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="status" value="rejected">
                        <x-danger-button class="shadow">{{ __('Reject') }}</x-danger-button>
                    </form>
                    <a href="{{ route('admin.applications.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-300 border border-gray-300 rounded-md font-semibold text-sm text-gray-700 uppercase tracking-widest hover:bg-gray-400 focus:bg-gray-400 active:bg-gray-500 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition ease-in-out duration-150 shadow">{{ __('Back to List') }}</a>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>