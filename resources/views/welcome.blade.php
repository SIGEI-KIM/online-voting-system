<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to Online Voting</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css2?family=Inter:wght@400;600;700;800&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            overflow: hidden; /* Prevent scrollbar from background animations */
        }

        /* Custom animation for fading in and subtle movement */
        @keyframes fadeInScale {
            from {
                opacity: 0;
                transform: scale(0.95) translateY(20px);
            }
            to {
                opacity: 1;
                transform: scale(1) translateY(0);
            }
        }

        /* Apply animation to the main card */
        .animate-fadeInScale {
            animation: fadeInScale 1s ease-out forwards;
            animation-delay: 0.3s; /* Delay the start for a nicer effect */
            opacity: 0; /* Start hidden */
        }

        /* Specific animation for the logo */
        @keyframes bounceIn {
            0%, 20%, 40%, 60%, 80%, 100% {
                transition-timing-function: cubic-bezier(0.215, 0.61, 0.355, 1);
            }
            0% {
                opacity: 0;
                transform: scale3d(0.3, 0.3, 0.3);
            }
            20% {
                transform: scale3d(1.1, 1.1, 1.1);
            }
            40% {
                transform: scale3d(0.9, 0.9, 0.9);
            }
            60% {
                opacity: 1;
                transform: scale3d(1.03, 1.03, 1.03);
            }
            80% {
                transform: scale3d(0.97, 0.97, 0.97);
            }
            100% {
                opacity: 1;
                transform: scale3d(1, 1, 1);
            }
        }

        .animate-bounceIn {
            animation: bounceIn 1s ease-out forwards;
        }

        /* Pulsing effect for background elements */
        @keyframes pulseBackground {
            0% { transform: scale(0.8); opacity: 0.7; }
            50% { transform: scale(1.2); opacity: 0.4; }
            100% { transform: scale(0.8); opacity: 0.7; }
        }
        .bg-pulse-element-1 { animation: pulseBackground 10s infinite ease-in-out; }
        .bg-pulse-element-2 { animation: pulseBackground 12s infinite ease-in-out reverse; }
        .bg-pulse-element-3 { animation: pulseBackground 8s infinite ease-in-out; }
    </style>
</head>
<body class="bg-gradient-to-br from-blue-100 to-indigo-200 min-h-screen flex items-center justify-center p-4 relative">

    {{-- Background animated elements for visual interest --}}
    <div class="absolute top-1/4 left-1/4 w-48 h-48 bg-blue-300 rounded-full mix-blend-multiply filter blur-xl opacity-70 animate-pulse-element-1"></div>
    <div class="absolute bottom-1/4 right-1/4 w-64 h-64 bg-green-300 rounded-full mix-blend-multiply filter blur-xl opacity-70 animate-pulse-element-2"></div>
    <div class="absolute top-1/2 left-1/2 w-56 h-56 bg-indigo-300 rounded-full mix-blend-multiply filter blur-xl opacity-70 animate-pulse-element-3 -translate-x-1/2 -translate-y-1/2"></div>


    <div class="bg-white rounded-3xl shadow-2xl p-8 md:p-12 max-w-lg w-full text-center transform transition-all duration-500 animate-fadeInScale relative z-10">

        <!-- IEBC Logo -->
        <div class="mb-4 flex justify-center animate-bounceIn"> {{-- Adjusted mb for spacing --}}
            <img src="{{ asset('images/iebc_logo.png') }}"
                 alt="IEBC Logo"
                 class="w-32 h-32 object-contain rounded-full shadow-lg border-4 border-green-200 p-1"
                 onerror="this.onerror=null;this.src='https://placehold.co/120x120/CCCCCC/333333?text=Logo+Error';"
            >
        </div>

        <!-- Casting Vote Icon -->
        <div class="mb-8 flex justify-center animate-fadeInScale" style="animation-delay: 0.5s;">
            <img src="{{ asset('images/casting_vote.png') }}"
                 alt="Casting Vote Icon"
                 class="w-24 h-24 object-contain rounded-xl shadow-lg"
                 onerror="this.onerror=null;this.src='https://placehold.co/96x96/CCCCCC/333333?text=Icon+Error';"
            >
        </div>

        <!-- Welcome Message -->
        <h1 class="text-3xl md:text-4xl font-extrabold text-gray-900 mb-4 tracking-tight leading-tight">
            Welcome to the <span class="text-green-600 drop-shadow-md">Online Voting Platform</span>
        </h1>
        <p class="text-base md:text-lg text-gray-700 mb-8 max-w-sm mx-auto leading-relaxed">
            Participate in democratic elections online, securely and efficiently.
        </p>

        <!-- Action Buttons with subtle transitions -->
        <div class="flex flex-col sm:flex-row justify-center gap-4">
            <a href="{{ route('login') }}" class="inline-flex items-center justify-center px-8 py-3 bg-green-600 border border-transparent rounded-full font-bold text-lg text-white uppercase tracking-wide shadow-xl hover:bg-green-700 focus:outline-none focus:ring-4 focus:ring-green-500 focus:ring-offset-2 transform hover:-translate-y-1 hover:scale-105 transition-all duration-300 ease-in-out">
                {{ __('Log In') }}
            </a>
            <a href="{{ route('register') }}" class="inline-flex items-center justify-center px-8 py-3 bg-gray-200 border border-gray-300 rounded-full font-bold text-lg text-gray-800 uppercase tracking-wide shadow-md hover:bg-gray-300 focus:outline-none focus:ring-4 focus:ring-gray-400 focus:ring-offset-2 transform hover:-translate-y-1 hover:scale-105 transition-all duration-300 ease-in-out">
                {{ __('Register') }}
            </a>
        </div>
    </div>

</body>
</html>
