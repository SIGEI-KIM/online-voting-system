<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }} - Admin</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased flex min-h-screen bg-gray-100" x-data="{
    isSidebarOpen: localStorage.getItem('sidebarOpen') === 'false' ? false : true,
    init() {
        $watch('isSidebarOpen', value => {
            localStorage.setItem('sidebarOpen', value);
            applySidebarState(value);
        });
        initSidebar();
    },
    toggleSidebar() {
        this.isSidebarOpen = !this.isSidebarOpen;
    }
}">

    @php
        $initialSidebarOpen = "<script>document.write(localStorage.getItem('sidebarOpen') === 'false' ? false : true)</script>";
    @endphp

    {{-- Sidebar --}}
    <div id="sidebar-wrapper" class="fixed top-0 left-0 flex-shrink-0 h-full text-white shadow-lg transition-transform duration-300 z-20">
        <x-admin-sidebar :isSidebarOpen="$initialSidebarOpen" />
    </div>

    {{-- Main Content Area --}}
    <div id="content-area" class="flex-1 flex flex-col transition-margin duration-300">
        {{-- Top Navbar --}}
        <div class="bg-white shadow-sm p-4 border-b border-gray-200">
            <button @click="toggleSidebar()" class="me-4">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 text-gray-500 cursor-pointer">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                </svg>
            </button>
            @include('layouts.navigation') {{-- Your top navigation --}}
        </div>

        {{-- Page Heading (from x-slot 'header') --}}
        @hasSection('header')
            <header class="bg-white shadow">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    @yield('header')
                </div>
            </header>
        @endif

        {{-- Main Content --}}
        <main class="flex-1 p-6">
            @yield('content')
        </main>
    </div>

    @stack('modals')
    @vite(['resources/js/app.js'])

    <script>
        function initSidebar() {
            const sidebar = document.getElementById('sidebar-wrapper');
            const content = document.getElementById('content-area');
            const isOpen = localStorage.getItem('sidebarOpen') !== 'false';
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