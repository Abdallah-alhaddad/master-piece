<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>Doctor Panel | {{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        @yield('styles')
    </head>
    <body class="font-sans text-gray-900 antialiased bg-gradient-to-br from-gray-50 to-gray-100">
        @yield('background')

        <div class="min-h-screen flex flex-col sm:justify-center items-center  sm:pt-0">
            <!-- Header Section -->
            <div class="w-full bg-[#223a66] py-3 shadow-lg">
                <div class="container mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex justify-between items-center">
                        <a href="/" class="flex items-center">
                            <img src="/images/logo.png" width="80" alt="logo" class="h-auto drop-shadow-lg shadow-white" style="filter: drop-shadow(0px 0px 10px  rgb(255, 255, 255))">
                        </a>
                        <div class="hidden md:block">
                            <span class="text-white font-medium">Doctor Portal</span>
                            @auth('doctor')
                                <form method="POST" action="{{ route('doctor.logout') }}" class="inline-block btn-primary px-3 py-1 ml-4 rounded-md">
                                    @csrf
                                    <button type="submit" class="text-white font-medium hover:underline">Logout</button>
                                </form>
                            @else
                                <a href="{{ route('doctor.login') }}" class="text-white font-medium hover:underline ml-4">Login</a>
                                <a href="{{ route('register.doctor') }}" class="text-white font-medium hover:underline ml-4">Register</a>
                            @endauth
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main Content -->
            <main class="w-full flex-1">
                <div class=" mx-auto px-8 py-8">
                    @yield('content')
                </div>
            </main>

            <!-- Footer -->
            <footer class="w-full bg-[#223a66] text-white py-6 mt-8">
                <div class="container mx-auto px-4 text-center">
                    <p class="text-sm">
                        &copy; {{ date('Y') }} {{ config('app.name', 'Medical System') }}. All rights reserved.
                    </p>
                    <div class="mt-2 flex justify-center space-x-4">
                        <a href="#" class="text-sm hover:text-[#e12454] transition">Terms of Service</a>
                        <a href="#" class="text-sm hover:text-[#e12454] transition">Privacy Policy</a>
                        <a href="#" class="text-sm hover:text-[#e12454] transition">Contact Support</a>
                    </div>
                </div>
            </footer>
        </div>

        @yield('scripts')
    </body>
</html>
