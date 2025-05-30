@extends('layouts.admin')

@section('header')
    <div style="background-color: #008C51; color: white; padding: 1rem;">
        <h2 class="font-semibold text-xl leading-tight">
            {{ __('Profile') }}
        </h2>
    </div>
@endsection

@section('content')
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="bg-white shadow sm:rounded-lg" style="border-left: 4px solid #008C51;">
                <div class="p-4 sm:p-8">
                    <div class="max-w-xl">
                        @include('profile.partials.update-profile-information-form')
                    </div>
                </div>
            </div>

            <div class="bg-white shadow sm:rounded-lg" style="border-left: 4px solid #008C51;">
                <div class="p-4 sm:p-8">
                    <div class="max-w-xl">
                        @include('profile.partials.update-password-form')
                    </div>
                </div>
            </div>

            <div class="bg-white shadow sm:rounded-lg" style="border-left: 4px solid #dc3545;">
                <div class="p-4 sm:p-8">
                    <div class="max-w-xl">
                        @include('profile.partials.delete-user-form')
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

<style>
    /* General button styling */
    button {
        padding: 0.5rem 1rem;
        border-radius: 0.25rem;
        font-weight: 500;
    }

    .btn-primary {
        background-color: #008C51 !important;
        border-color: #008C51 !important;
        color: white !important;
    }

    .btn-danger {
        background-color: #dc3545 !important; /* A shade of red */
        border-color: #dc3545 !important;
        color: white !important;
    }

    a {
        color: #008C51;
        text-decoration: none;
    }

    a:hover {
        text-decoration: underline;
    }

    .shadow.sm\:rounded-lg {
        border-radius: 0.5rem;
        box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06);
        margin-bottom: 1rem;
    }

    .space-y-6 > * + * {
        margin-top: 1.5rem;
    }

    .max-w-7xl {
        max-width: 85rem; /* Adjust as needed */
        margin-left: auto;
        margin-right: auto;
    }

    .sm\:px-6 {
        padding-left: 1.5rem;
        padding-right: 1.5rem;
    }

    .lg\:px-8 {
        padding-left: 2rem;
        padding-right: 2rem;
    }

    .p-4 {
        padding: 1rem;
    }

    .sm\:p-8 {
        padding: 2rem;
    }

    .bg-white {
        background-color: #fff;
    }

    .text-gray-800 {
        color: #2d3748;
    }

    .leading-tight {
        line-height: 1.5;
    }

    .font-semibold {
        font-weight: 600;
    }

    /* Form specific styling - you might need to adjust based on the actual form classes */
    input[type="text"],
    input[type="email"],
    input[type="password"] {
        border: 1px solid #ccc;
        border-radius: 0.25rem;
        padding: 0.5rem;
        width: 100%;
        margin-bottom: 0.75rem;
    }

    label {
        display: block;
        margin-bottom: 0.25rem;
        font-weight: bold;
        color: #374151;
    }

    /* Specific border color for each section */
    .space-y-6 > div:nth-child(1) { /* Update Profile */
        border-left: 4px solid #008C51;
    }

    .space-y-6 > div:nth-child(2) { /* Update Password */
        border-left: 4px solid #008C51;
    }

    .space-y-6 > div:nth-child(3) { /* Delete User */
        border-left: 4px solid #dc3545;
    }
</style>