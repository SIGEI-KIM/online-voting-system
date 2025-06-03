{{-- This file now contains the logo, dashboard title, and user dropdown --}}
<div class="flex items-center">
    <div class="mr-2">
    <img src="{{ asset('images/iebc_logo.png') }}" alt="IEBC Logo" class="block h-9 w-auto" style="height: 40px; width: auto;" />
        
    </div>
    <h2 class="font-semibold text-xl text-gray-800 leading-tight mr-4">
        Dashboard
    </h2>
</div>

{{-- User Dropdown (right side) --}}
<div x-data="{ open: false }" @click.away="open = false" class="relative ml-auto"> {{-- ml-auto pushes it to the right --}}
    <button @click="open = !open" class="flex items-center text-sm font-medium text-gray-500 hover:text-gray-700 focus:outline-none transition duration-150 ease-in-out">
        <div>{{ Auth::user()->name }}</div>
        <div class="ml-1">
            <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
            </svg>
        </div>
    </button>

    <div x-show="open" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="transform opacity-0 scale-95" x-transition:enter-end="transform opacity-100 scale-100" x-transition:leave="transition ease-in duration-75" x-transition:leave-start="transform opacity-100 scale-100" x-transition:leave-end="transform opacity-0 scale-95" class="absolute z-50 mt-2 w-48 rounded-md shadow-lg origin-top-right right-0" style="display: none;">
        <div class="rounded-md ring-1 ring-black ring-opacity-5 py-1 bg-white">
            <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">{{ __('Profile') }}</a>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">{{ __('Log Out') }}</button>
            </form>
        </div>
    </div>
</div>