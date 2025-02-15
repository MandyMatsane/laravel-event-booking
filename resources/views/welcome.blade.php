<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Event Booking</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

        <!-- Tailwind CSS -->
        <script src="https://cdn.tailwindcss.com"></script>
    </head>
    <body class="antialiased bg-gray-100 dark:bg-gray-900">
        <div class="relative flex flex-col justify-center items-center min-h-screen bg-dots-darker dark:bg-dots-lighter">
            <!-- Authentication Links -->
            @if (Route::has('login'))
                <div class="absolute top-4 right-4">
                    @auth
                        <a href="{{ url('/dashboard') }}" class="text-lg font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:ring-2 focus:ring-red-500 focus:rounded-md">
                            Dashboard
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="text-lg font-semibold text-black hover:text-blue-600 dark:text-gray-400 dark:hover:text-white focus:outline focus:ring-2 focus:ring-red-500 focus:rounded-md">
                            Log in
                        </a>

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="ml-4 text-lg font-semibold text-black hover:text-blue-600 dark:text-gray-400 dark:hover:text-white focus:outline focus:ring-2 focus:ring-red-500 focus:rounded-md">
                                Register
                            </a>
                        @endif
                    @endauth
                </div>
            @endif

            <!-- Main Content -->
            <div class="max-w-4xl w-full text-center py-12 px-6 lg:py-16 lg:px-8 bg-white dark:bg-gray-800 rounded-lg shadow-lg">
                <h1 class="text-4xl font-extrabold text-gray-800 dark:text-white">
                    Welcome to Event Booking
                </h1>
                <p class="mt-4 text-lg text-gray-600 dark:text-gray-300">
                    Book your favorite events easily and stay updated with the latest happenings.
                </p>

                <div class="mt-8">
                    <a href="{{ route('login') }}" class="px-6 py-3 text-lg font-semibold text-white bg-blue-500 hover:bg-blue-600 rounded-md shadow-md">
                        Get Started
                    </a>
                </div>
            </div>

            <!-- Footer -->
            <footer class="mt-12 text-center text-gray-500 dark:text-gray-400">
                <p>&copy; 2024 Event Booking. All rights reserved.</p>
            </footer>
        </div>
    </body>
</html>
