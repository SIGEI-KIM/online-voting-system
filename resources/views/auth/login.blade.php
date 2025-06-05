<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Online Voting Platform</title>
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

        /* Pulsing effect for background elements (optional, matches welcome page) */
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

    <div class="bg-white rounded-3xl shadow-2xl p-8 md:p-12 max-w-xl w-full text-center transform transition-all duration-500 animate-fadeInScale relative z-10"> {{-- Changed max-w-sm to max-w-xl --}}

        <!-- IEBC Logo -->
        <div class="mb-8 flex justify-center animate-bounceIn">
            <img src="{{ asset('images/iebc_logo.png') }}"
                 alt="IEBC Logo"
                 class="w-28 h-28 object-contain rounded-full shadow-lg border-4 border-green-200 p-1"
                 onerror="this.onerror=null;this.src='https://placehold.co/112x112/CCCCCC/333333?text=Logo+Error';"
            >
        </div>

        <h2 class="text-3xl font-extrabold text-gray-900 mb-8 tracking-tight">
            {{ __('Login to Your Account') }}
        </h2>

        <!-- Laravel Session Status (e.g., for password reset messages) -->
        @if (session('status'))
            <div class="mb-4 font-medium text-sm text-green-600">
                {{ session('status') }}
            </div>
        @endif

        <!-- Validation Errors -->
        @if ($errors->any())
            <div class="mb-4">
                <div class="font-medium text-red-600">{{ __('Whoops! Something went wrong.') }}</div>

                <ul class="mt-3 list-disc list-inside text-sm text-red-600">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <!-- Email Address -->
            <div class="mb-6">
                <label for="email" class="block text-left text-sm font-medium text-gray-700 mb-2">{{ __('Email') }}</label>
                <input id="email" class="block w-full px-4 py-3 rounded-lg shadow-sm border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 text-base" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username" placeholder="Enter your email" />
            </div>

            <!-- Password -->
            <div class="mb-6">
                <label for="password" class="block text-left text-sm font-medium text-gray-700 mb-2">{{ __('Password') }}</label>
                <input id="password" class="block w-full px-4 py-3 rounded-lg shadow-sm border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 text-base" type="password" name="password" required autocomplete="current-password" placeholder="Enter your password" />
            </div>

            <!-- Remember Me -->
            <div class="flex justify-between items-center mb-6">
                <label for="remember_me" class="flex items-center">
                    <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember">
                    <span class="ml-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
                </label>

                @if (Route::has('password.request'))
                    <a class="text-sm text-indigo-600 hover:text-indigo-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors duration-200" href="{{ route('password.request') }}">
                        {{ __('Forgot your password?') }}
                    </a>
                @endif
            </div>

            <div class="flex flex-col items-center">
                <button type="submit" class="inline-flex items-center justify-center px-8 py-3 bg-green-600 border border-transparent rounded-full font-bold text-lg text-white uppercase tracking-wide shadow-xl hover:bg-green-700 focus:outline-none focus:ring-4 focus:ring-green-500 focus:ring-offset-2 transform hover:-translate-y-1 hover:scale-105 transition-all duration-300 ease-in-out w-full max-w-xs">
                    {{ __('Log in') }}
                </button>

                @if (Route::has('register'))
                    <a class="mt-6 text-sm text-gray-700 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors duration-200" href="{{ route('register') }}">
                        {{ __("Don't have an account?") }} <span class="font-semibold text-indigo-600 hover:underline">{{ __('Register') }}</span>
                    </a>
                @endif
            </div>
        </form>
    </div>

</body>
</html>
