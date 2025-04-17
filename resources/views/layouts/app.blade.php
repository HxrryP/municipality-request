<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">


    <title>{{ config('app.name', 'Anilao E-Services') }}</title>
    <link rel="icon" href="{{ asset('images/anilao_logo_720x720.png') }}" type="image/png">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased">
    <div class="min-h-screen bg-gray-100">
        <!-- Show navigation only for authenticated users -->
        @auth
            @include('layouts.navigation')
        @endauth

        <!-- Page Heading -->
        @if (isset($header))
            <header class="bg-white shadow">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    {{ $header }}
                </div>
            </header>
        @endif

        <!-- Flash Messages -->
        @if (session('success'))
            <div id="success-alert" class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4 max-w-7xl mx-auto mt-4" role="alert">
                <span class="block sm:inline">{{ session('success') }}</span>
                <button class="absolute top-0 right-0 px-4 py-3" onclick="document.getElementById('success-alert').style.display='none'">
                    <span class="sr-only">Close</span>
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        @endif

        @if (session('error'))
            <div id="error-alert" class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4 max-w-7xl mx-auto mt-4" role="alert">
                <span class="block sm:inline">{{ session('error') }}</span>
                <button class="absolute top-0 right-0 px-4 py-3" onclick="document.getElementById('error-alert').style.display='none'">
                    <span class="sr-only">Close</span>
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        @endif

        <!-- Page Content -->
        <main>
            {{ $slot }}
        </main>

        <!-- Footer -->
        <footer class="bg-white border-t border-gray-200 py-8 mt-auto">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="md:flex md:items-center md:justify-between">
                    <div class="flex justify-center md:justify-start">
                        <img src="{{ asset('images/anilao_logo_1000x1000.png') }}" alt="Anilao Logo" class="h-10">
                        <div class="ml-4">
                            <p class="text-gray-500 text-sm">© {{ date('Y') }} Municipality of Anilao</p>
                            <p class="text-gray-500 text-sm">All rights reserved</p>
                        </div>
                    </div>
                    <div class="mt-8 md:mt-0">
                        <p class="text-center text-gray-500 text-sm md:text-right">
                            For inquiries: contact@anilao.gov.ph<br>
                            Phone: (033) 123-4567
                        </p>
                    </div>
                </div>
            </div>
        </footer>
    </div>
</body>
</html>