<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }} - Candidate</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        /* General layout for body */
        body {
            font-family: 'figtree', sans-serif;
            background-color: #f3f4f6;
            display: flex;
            min-height: 100vh;
        }

        /* Sidebar styles */
        #sidebar-wrapper {
            width: 256px;
            min-width: 256px; /* Ensures it doesn't shrink below this */
            background-color: rgb(43, 48, 57); /* Dark background */
            color: white;
            transition: width 0.3s ease-in-out, min-width 0.3s ease-in-out;
            position: fixed; /* Stays in place when scrolling */
            top: 0;
            left: 0;
            height: 100vh; /* Full viewport height */
            z-index: 20; /* Ensure it's above other content */
            overflow-x: hidden; /* Hide horizontal scrollbar if content overflows */
        }

        #sidebar-wrapper.sidebar-closed {
            width: 60px;
            min-width: 60px; /* Collapsed width */
        }

        /* Main content area styles */
        #content-area {
            margin-left: 256px; /* Initial margin to accommodate the sidebar */
            transition: margin-left 0.3s ease-in-out;
            flex-grow: 1; /* Allows it to take up remaining space */
            display: flex;
            flex-direction: column;
            min-height: 100vh; /* Ensures it takes full height */
            width: calc(100% - 256px); /* Initial width */
        }

        #content-area.content-shifted-closed {
            margin-left: 60px; /* Margin when sidebar is collapsed */
            width: calc(100% - 60px); /* Expanded width */
        }

        /* Styles for sidebar text visibility */
        .sidebar-text {
            opacity: 1;
            transition: opacity 0.3s ease-in-out, visibility 0.3s ease-in-out;
            white-space: nowrap; /* Prevent text wrapping */
            overflow: hidden; /* Hide overflowing text */
        }

        /* Hide text when sidebar is closed */
        #sidebar-wrapper.sidebar-closed .sidebar-text {
            opacity: 0;
            visibility: hidden;
            /* Using pointer-events: none and visibility: hidden for better accessibility and interaction */
            pointer-events: none;
        }
    </style>
</head>
<body class="font-sans antialiased flex min-h-screen bg-gray-100" x-data="{
    isSidebarOpen: localStorage.getItem('candidateSidebarOpen') === 'false' ? false : true,
    init() {
        $watch('isSidebarOpen', value => {
            localStorage.setItem('candidateSidebarOpen', value);
            applySidebarState(value);
        });
        initSidebar();
    },
    toggleSidebar() {
        this.isSidebarOpen = !this.isSidebarOpen;
    }
}">

    @php
        $initialSidebarOpen = "<script>document.write(localStorage.getItem('candidateSidebarOpen') === 'false' ? false : true)</script>";
    @endphp

    {{-- Sidebar --}}
    <div id="sidebar-wrapper" class="fixed top-0 left-0 flex-shrink-0 h-full text-white shadow-lg transition-transform duration-300 z-20">
        <x-candidate-sidebar :is-sidebar-open="$initialSidebarOpen" />
    </div>

    {{-- Main Content Area --}}
    <div id="content-area" class="flex-1 flex flex-col transition-margin duration-300">
        {{-- Top Navbar --}}
        <div class="bg-white shadow-sm p-4 border-b border-gray-200 flex justify-between items-center">
            <button @click="toggleSidebar()" class="me-4 focus:outline-none">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 text-gray-500 cursor-pointer">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                </svg>
            </button>
            @include('layouts.candidate-navigation')
        </div>

        {{-- Toast Notification for Success Messages --}}
        @if (session('success'))
            <div x-data="{ show: true }"
                 x-show="show"
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0 transform -translate-y-full"
                 x-transition:enter-end="opacity-100 transform translate-y-0"
                 x-transition:leave="transition ease-in duration-300"
                 x-transition:leave-start="opacity-100 transform translate-y-0"
                 x-transition:leave-end="opacity-0 transform -translate-y-full"
                 x-init="setTimeout(() => show = false, 3000)" {{-- Hide after 3 seconds --}}
                 class="fixed top-0 left-1/2 -translate-x-1/2 mt-4 px-6 py-3 bg-green-500 text-white rounded-lg shadow-lg z-50 text-center"
            >
                {{ session('success') }}
            </div>
        @endif

        {{-- Page Heading --}}
        @hasSection('header')
            <header class="bg-white shadow">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    @yield('header')
                </div>
            </header>
        @endif

        {{-- Main Content --}}
        <main class="flex-1 p-6 bg-gray-50">
            @yield('content')
        </main>
    </div>

    @stack('modals')
    @vite(['resources/js/app.js'])

    <script>
        function initSidebar() {
            const sidebar = document.getElementById('sidebar-wrapper');
            const content = document.getElementById('content-area');
            const isOpen = localStorage.getItem('candidateSidebarOpen') !== 'false';
            applySidebarState(isOpen);
        }

        function applySidebarState(isOpen) {
            const sidebar = document.getElementById('sidebar-wrapper');
            const content = document.getElementById('content-area');

            sidebar.style.width = isOpen ? '256px' : '60px';
            sidebar.style.minWidth = isOpen ? '256px' : '60px';
            sidebar.style.backgroundColor = isOpen ? 'rgb(43, 48, 57)' : 'rgba(43, 48, 57, 0.9)';
            content.style.marginLeft = isOpen ? '256px' : '60px';

            sidebar.classList.toggle('sidebar-open', isOpen);
            sidebar.classList.toggle('sidebar-closed', !isOpen);
            content.classList.toggle('content-shifted-open', isOpen);
            content.classList.toggle('content-shifted-closed', !isOpen);
        }
    </script>

</body>
</html>