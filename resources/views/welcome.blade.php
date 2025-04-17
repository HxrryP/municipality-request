<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Anilao E-Services') }}</title>
    <link rel="icon" href="{{ asset('images/anilao_logo_720x720.png') }}" type="image/png">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
        .hero-pattern {
            background-color: #4f46e5;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='100' height='100' viewBox='0 0 100 100'%3E%3Cg fill-rule='evenodd'%3E%3Cg fill='%236366f1' fill-opacity='0.4'%3E%3Cpath opacity='.5' d='M96 95h4v1h-4v4h-1v-4h-9v4h-1v-4h-9v4h-1v-4h-9v4h-1v-4h-9v4h-1v-4h-9v4h-1v-4h-9v4h-1v-4h-9v4h-1v-4h-9v4h-1v-4H0v-1h15v-9H0v-1h15v-9H0v-1h15v-9H0v-1h15v-9H0v-1h15v-9H0v-1h15v-9H0v-1h15v-9H0v-1h15v-9H0v-1h15V0h1v15h9V0h1v15h9V0h1v15h9V0h1v15h9V0h1v15h9V0h1v15h9V0h1v15h9V0h1v15h9V0h1v15h4v1h-4v9h4v1h-4v9h4v1h-4v9h4v1h-4v9h4v1h-4v9h4v1h-4v9h4v1h-4v9h4v1h-4v9zm-1 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-9-10h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm9-10v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-9-10h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm9-10v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-9-10h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm9-10v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-9-10h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9z'/%3E%3Cpath d='M6 5V0H5v5H0v1h5v94h1V6h94V5H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
        }
        .appear-animation {
            animation: appear 0.8s ease-out;
        }
        .slide-in-right {
            animation: slideInRight 0.8s ease-out;
        }
        @keyframes appear {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        @keyframes slideInRight {
            from {
                opacity: 0;
                transform: translateX(50px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        /* Mobile-specific styles */
        @media (max-width: 640px) {
            .mobile-hero {
                padding-top: 6rem;
                padding-bottom: 3rem;
            }
            .mobile-hero h1 {
                font-size: 2.25rem;
                line-height: 2.5rem;
            }
            .mobile-menu-container {
                height: 100vh;
                width: 100%;
                position: fixed;
                top: 0;
                left: 0;
                z-index: 50;
                transition: all 0.3s ease-in-out;
            }
            .mobile-step {
                position: relative;
                padding-left: 2.5rem;
                margin-bottom: 2rem;
            }
            .mobile-step:before {
                content: '';
                position: absolute;
                left: 0;
                top: 0;
                bottom: 0;
                width: 2px;
                background: #e5e7eb;
            }
            .mobile-step .step-circle {
                position: absolute;
                left: -12px;
                width: 24px;
                height: 24px;
                border-radius: 50%;
                background: #4f46e5;
                color: white;
                display: flex;
                align-items: center;
                justify-content: center;
                font-weight: bold;
            }
        }

        /* Touch-friendly adjustments */
        @media (max-width: 768px) {
            .touch-target {
                min-height: 44px; /* Apple's recommended minimum touch target size */
                min-width: 44px;
            }
        }
    </style>
</head>
<body class="antialiased bg-gray-50">
    <!-- Navigation -->
    <nav class="bg-white shadow-sm fixed w-full z-50 backdrop-blur-md bg-opacity-90">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <div class="flex-shrink-0 flex items-center">
                        <img class="h-8 w-auto" src="{{ asset('images/anilao_logo_720x720.png') }}" alt="Anilao Logo">
                        <span class="ml-2 text-lg font-semibold text-indigo-600 hidden sm:block">ANILAO E-SERVICES</span>
                        <span class="ml-2 text-lg font-semibold text-indigo-600 sm:hidden">Anilao</span>
                    </div>
                </div>
                
                <!-- Desktop Navigation -->
                <div class="hidden sm:ml-6 sm:flex sm:items-center">
                    <div class="sm:flex sm:space-x-6">
                        <a href="#services" class="border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700 inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium">
                            Services
                        </a>
                        <a href="#how-it-works" class="border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700 inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium">
                            How It Works
                        </a>
                        <a href="{{ route('ordinances.index') }}" class="border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700 inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium">
                            Ordinances
                        </a>
                        <a href="#contact" class="border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700 inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium">
                            Contact
                        </a>
                    </div>
                    <div class="ml-6 flex items-center">
                        @auth
                            <a href="{{ url('/dashboard') }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                Dashboard
                            </a>
                        @else
                            <a href="{{ route('login') }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-indigo-600 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                Log in
                            </a>
                            <a href="{{ route('register') }}" class="ml-3 inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                Register
                            </a>
                        @endauth
                    </div>
                </div>
                
                <!-- Mobile menu button -->
                <div class="flex items-center sm:hidden">
                    <button id="mobile-menu-button" type="button" class="touch-target inline-flex items-center justify-center p-2 rounded-md text-gray-500 hover:text-indigo-600 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-indigo-500" aria-expanded="false">
                        <span class="sr-only">Open main menu</span>
                        <!-- Icon when menu is closed -->
                        <svg id="menu-closed-icon" class="block h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                        <!-- Icon when menu is open -->
                        <svg id="menu-open-icon" class="hidden h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile menu -->
        <div id="mobile-menu" class="sm:hidden hidden">
            <div class="pt-2 pb-3 space-y-1 bg-white shadow-lg rounded-b-lg">
                <a href="#services" class="text-gray-600 hover:bg-gray-50 hover:text-indigo-600 block px-3 py-3 rounded-md text-base font-medium touch-target">
                    Services
                </a>
                <a href="#how-it-works" class="text-gray-600 hover:bg-gray-50 hover:text-indigo-600 block px-3 py-3 rounded-md text-base font-medium touch-target">
                    How It Works
                </a>
                <a href="{{ route('ordinances.index') }}" class="text-gray-600 hover:bg-gray-50 hover:text-indigo-600 block px-3 py-3 rounded-md text-base font-medium touch-target">
                    Ordinances
                </a>
                <a href="#contact" class="text-gray-600 hover:bg-gray-50 hover:text-indigo-600 block px-3 py-3 rounded-md text-base font-medium touch-target">
                    Contact
                </a>
                <div class="px-3 py-3 space-y-2">
                    @auth
                        <a href="{{ url('/dashboard') }}" class="w-full flex justify-center items-center px-4 py-3 border border-transparent text-base font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 touch-target">
                            Dashboard
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="w-full flex justify-center items-center px-4 py-3 border border-transparent text-base font-medium rounded-md text-indigo-600 bg-white border-indigo-600 hover:bg-indigo-50 touch-target">
                            Log in
                        </a>
                        <a href="{{ route('register') }}" class="w-full flex justify-center items-center px-4 py-3 border border-transparent text-base font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 touch-target">
                            Register
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <div class="hero-pattern relative overflow-hidden pt-32 pb-20 md:pt-40 md:pb-32 mobile-hero">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="lg:grid lg:grid-cols-12 lg:gap-8">
                <div class="text-center lg:text-left sm:max-w-md sm:mx-auto lg:col-span-6 lg:max-w-none appear-animation">
                    <h1>
                        <span class="block text-sm font-semibold uppercase tracking-wide text-white">Municipality of Anilao, Iloilo</span>
                        <span class="mt-1 block text-3xl sm:text-4xl md:text-5xl lg:text-6xl tracking-tight font-extrabold">
                            <span class="block text-white">Digital Services</span>
                            <span class="block text-indigo-200">At Your Fingertips</span>
                        </span>
                    </h1>
                    <p class="mt-3 text-base text-indigo-100 sm:mt-5 sm:text-xl lg:text-lg xl:text-xl">
                        Access government services anytime, anywhere. Request documents, pay fees online, and track your applications with ease.
                    </p>
                    <div class="mt-8 sm:max-w-lg mx-auto lg:mx-0">
                        <div class="flex flex-col sm:flex-row sm:justify-center lg:justify-start gap-4 sm:gap-3">
                            <a href="{{ route('services.index') }}" class="w-full flex items-center justify-center px-8 py-3 border border-transparent text-base font-medium rounded-md text-indigo-600 bg-white hover:bg-gray-50 shadow touch-target">
                                Get Started
                            </a>
                            @auth
                                <a href="{{ url('/dashboard') }}" class="w-full flex items-center justify-center px-8 py-3 border border-transparent text-base font-medium rounded-md text-white bg-indigo-500 bg-opacity-60 hover:bg-opacity-70 touch-target">
                                    Dashboard
                                </a>
                            @else
                                <a href="{{ route('login') }}" class="w-full flex items-center justify-center px-8 py-3 border border-transparent text-base font-medium rounded-md text-white bg-indigo-500 bg-opacity-60 hover:bg-opacity-70 touch-target">
                                    Sign In
                                </a>
                            @endauth
                        </div>
                    </div>
                </div>
                <div class="mt-12 hidden sm:block relative sm:max-w-lg sm:mx-auto lg:mt-0 lg:max-w-none lg:mx-0 lg:col-span-6 lg:flex lg:items-center">
                    <div class="relative mx-auto w-full rounded-lg shadow-lg lg:max-w-md">
                        <div class="relative block w-full bg-white rounded-lg overflow-hidden">
                            <img class="w-full" src="{{ asset('images/ILLUSTRATION.png') }}" alt="E-services illustration">
                            <div class="absolute inset-0 w-full h-full flex items-center justify-center">
                                <button type="button" class="flex items-center justify-center h-16 w-16 rounded-full bg-indigo-600 text-white">
                                    <svg class="h-8 w-8" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Featured Services -->
    <div id="services" class="py-12 sm:py-16 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <h2 class="text-base font-semibold text-indigo-600 tracking-wide uppercase">E-Services</h2>
                <p class="mt-1 text-2xl sm:text-3xl font-extrabold text-gray-900 sm:tracking-tight">What We Offer</p>
                <p class="max-w-xl mt-3 sm:mt-5 mx-auto text-base sm:text-xl text-gray-500">Access a wide range of municipal services online, designed to make government transactions easier and more convenient.</p>
            </div>

            <div class="mt-10 sm:mt-16">
                <div class="grid grid-cols-1 gap-4 sm:gap-6 md:grid-cols-2 lg:grid-cols-3">
                    <!-- Business Permits -->
                    <div class="relative group">
                        <div class="absolute -inset-0.5 bg-gradient-to-r from-indigo-600 to-blue-600 rounded-lg blur opacity-25 group-hover:opacity-100 transition duration-1000 group-hover:duration-200"></div>
                        <div class="relative p-4 sm:p-6 bg-white ring-1 ring-gray-900/5 rounded-lg leading-none flex items-top justify-start space-x-4 sm:space-x-6 hover:shadow-lg transition-all duration-200">
                            <div class="flex-shrink-0">
                                <div class="bg-indigo-500 rounded-md p-2 sm:p-3">
                                    <svg class="h-5 w-5 sm:h-6 sm:w-6 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                    </svg>
                                </div>
                            </div>
                            <div class="space-y-2">
                                <h3 class="text-base sm:text-lg font-medium text-gray-900">Business Permits</h3>
                                <p class="text-sm text-gray-500">Apply for new business permits, renewals, or request changes to your business information.</p>
                                <a href="{{ route('services.index') }}" class="text-indigo-600 hover:text-indigo-500 transition-colors text-sm font-medium touch-target inline-block py-1">
                                    Learn more →
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Real Property Tax -->
                    <div class="relative group">
                        <div class="absolute -inset-0.5 bg-gradient-to-r from-emerald-600 to-green-600 rounded-lg blur opacity-25 group-hover:opacity-100 transition duration-1000 group-hover:duration-200"></div>
                        <div class="relative p-4 sm:p-6 bg-white ring-1 ring-gray-900/5 rounded-lg leading-none flex items-top justify-start space-x-4 sm:space-x-6 hover:shadow-lg transition-all duration-200">
                            <div class="flex-shrink-0">
                                <div class="bg-emerald-500 rounded-md p-2 sm:p-3">
                                    <svg class="h-5 w-5 sm:h-6 sm:w-6 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                                    </svg>
                                </div>
                            </div>
                            <div class="space-y-2">
                                <h3 class="text-base sm:text-lg font-medium text-gray-900">Real Property Tax</h3>
                                <p class="text-sm text-gray-500">Pay your real property taxes online and request tax clearance certificates.</p>
                                <a href="{{ route('services.index') }}" class="text-emerald-600 hover:text-emerald-500 transition-colors text-sm font-medium touch-target inline-block py-1">
                                    Learn more →
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Civil Registry -->
                    <div class="relative group">
                        <div class="absolute -inset-0.5 bg-gradient-to-r from-purple-600 to-violet-600 rounded-lg blur opacity-25 group-hover:opacity-100 transition duration-1000 group-hover:duration-200"></div>
                        <div class="relative p-4 sm:p-6 bg-white ring-1 ring-gray-900/5 rounded-lg leading-none flex items-top justify-start space-x-4 sm:space-x-6 hover:shadow-lg transition-all duration-200">
                            <div class="flex-shrink-0">
                                <div class="bg-purple-500 rounded-md p-2 sm:p-3">
                                    <svg class="h-5 w-5 sm:h-6 sm:w-6 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7v8a2 2 0 002 2h6M8 7V5a2 2 0 012-2h4.586a1 1 0 01.707.293l4.414 4.414a1 1 0 01.293.707V15a2 2 0 01-2 2h-2M8 7H6a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2v-2" />
                                    </svg>
                                </div>
                            </div>
                            <div class="space-y-2">
                                <h3 class="text-base sm:text-lg font-medium text-gray-900">Civil Registry</h3>
                                <p class="text-sm text-gray-500">Request birth, marriage, and death certificates from the Local Civil Registry.</p>
                                <a href="{{ route('services.index') }}" class="text-purple-600 hover:text-purple-500 transition-colors text-sm font-medium touch-target inline-block py-1">
                                    Learn more →
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Health Certificates -->
                    <div class="relative group">
                        <div class="absolute -inset-0.5 bg-gradient-to-r from-rose-600 to-red-600 rounded-lg blur opacity-25 group-hover:opacity-100 transition duration-1000 group-hover:duration-200"></div>
                        <div class="relative p-4 sm:p-6 bg-white ring-1 ring-gray-900/5 rounded-lg leading-none flex items-top justify-start space-x-4 sm:space-x-6 hover:shadow-lg transition-all duration-200">
                            <div class="flex-shrink-0">
                                <div class="bg-rose-500 rounded-md p-2 sm:p-3">
                                    <svg class="h-5 w-5 sm:h-6 sm:w-6 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                    </svg>
                                </div>
                            </div>
                            <div class="space-y-2">
                                <h3 class="text-base sm:text-lg font-medium text-gray-900">Health Certificates</h3>
                                <p class="text-sm text-gray-500">Apply for health certificates and occupational permits.</p>
                                <a href="{{ route('services.index') }}" class="text-rose-600 hover:text-rose-500 transition-colors text-sm font-medium touch-target inline-block py-1">
                                    Learn more →
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Ordinances -->
                    <div class="relative group">
                        <div class="absolute -inset-0.5 bg-gradient-to-r from-amber-600 to-yellow-600 rounded-lg blur opacity-25 group-hover:opacity-100 transition duration-1000 group-hover:duration-200"></div>
                        <div class="relative p-4 sm:p-6 bg-white ring-1 ring-gray-900/5 rounded-lg leading-none flex items-top justify-start space-x-4 sm:space-x-6 hover:shadow-lg transition-all duration-200">
                            <div class="flex-shrink-0">
                                <div class="bg-amber-500 rounded-md p-2 sm:p-3">
                                    <svg class="h-5 w-5 sm:h-6 sm:w-6 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 14v3m4-3v3m4-3v3M3 21h18M3 10h18M3 7l9-4 9 4M4 10h16v11H4V10z" />
                                    </svg>
                                </div>
                            </div>
                            <div class="space-y-2">
                                <h3 class="text-base sm:text-lg font-medium text-gray-900">Ordinances</h3>
                                <p class="text-sm text-gray-500">Access municipal ordinances including administrative, public safety, and business regulations.</p>
                                <a href="{{ route('ordinances.index') }}" class="text-amber-600 hover:text-amber-500 transition-colors text-sm font-medium touch-target inline-block py-1">
                                    Learn more →
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- View All -->
                    <div class="relative group">
                        <div class="absolute -inset-0.5 bg-gradient-to-r from-gray-600 to-slate-600 rounded-lg blur opacity-25 group-hover:opacity-100 transition duration-1000 group-hover:duration-200"></div>
                        <div class="relative p-4 sm:p-6 bg-white ring-1 ring-gray-900/5 rounded-lg leading-none flex items-center justify-center hover:shadow-lg transition-all duration-200">
                            <a href="{{ route('services.index') }}" class="text-base sm:text-lg font-medium text-gray-900 hover:text-indigo-600 transition-colors touch-target py-3 px-4 block w-full text-center">
                                View All Services →
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- How It Works -->
    <div id="how-it-works" class="py-12 sm:py-16 bg-gray-50 overflow-hidden">
        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="relative">
                <div class="text-center">
                    <h2 class="text-base font-semibold text-indigo-600 tracking-wide uppercase">Process</h2>
                    <p class="mt-1 text-2xl sm:text-3xl font-extrabold text-gray-900 sm:tracking-tight">How It Works</p>
                    <p class="max-w-xl mt-3 sm:mt-5 mx-auto text-base sm:text-xl text-gray-500">Complete your transactions in just a few simple steps.</p>
                </div>

                <div class="mt-10 sm:mt-16">
                    <!-- Desktop Timeline (Hidden on Mobile) -->
                    <div class="hidden md:block relative">
                        <!-- Steps Timeline -->
                        <div class="absolute left-1/2 transform -translate-x-1/2 w-0.5 h-full bg-gradient-to-b from-indigo-600 via-indigo-400 to-indigo-100"></div>
                        
                        <!-- Steps -->
                        <div class="space-y-24">
                            <!-- Step 1 -->
                            <div class="relative flex items-center">
                                <div class="w-1/2 pr-8 text-right">
                                    <div class="bg-white p-6 rounded-xl shadow-md ml-auto mr-12 transform transition-all duration-500 hover:scale-105 hover:rotate-1" style="max-width: 350px;">
                                        <div class="inline-flex items-center justify-center w-12 h-12 rounded-full bg-indigo-100 text-indigo-600 mb-4">
                                            <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                            </svg>
                                        </div>
                                        <h3 class="text-lg font-bold text-gray-900">1. Register & Login</h3>
                                        <p class="mt-2 text-gray-600">Create your account or log in to access municipal services. Verify your identity to ensure security.</p>
                                    </div>
                                </div>
                                <div class="flex h-10 w-10 rounded-full bg-indigo-600 items-center justify-center relative z-10">
                                    <span class="text-white font-bold">1</span>
                                </div>
                                <div class="w-1/2"><!-- Empty div to maintain layout --></div>
                            </div>

                            <!-- Step 2 -->
                            <div class="relative flex items-center">
                                <div class="w-1/2"><!-- Empty div to maintain layout --></div>
                                <div class="flex h-10 w-10 rounded-full bg-indigo-600 items-center justify-center relative z-10">
                                    <span class="text-white font-bold">2</span>
                                </div>
                                <div class="w-1/2 pl-8">
                                    <div class="bg-white p-6 rounded-xl shadow-md mr-auto ml-12 transform transition-all duration-500 hover:scale-105 hover:rotate-1" style="max-width: 350px;">
                                        <div class="inline-flex items-center justify-center w-12 h-12 rounded-full bg-indigo-100 text-indigo-600 mb-4">
                                            <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                                            </svg>
                                        </div>
                                        <h3 class="text-lg font-bold text-gray-900">2. Select a Service</h3>
                                        <p class="mt-2 text-gray-600">Browse and choose from our available services. Each service includes requirements and processing times.</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Step 3 -->
                            <div class="relative flex items-center">
                                <div class="w-1/2 pr-8 text-right">
                                    <div class="bg-white p-6 rounded-xl shadow-md ml-auto mr-12 transform transition-all duration-500 hover:scale-105 hover:rotate-1" style="max-width: 350px;">
                                        <div class="inline-flex items-center justify-center w-12 h-12 rounded-full bg-indigo-100 text-indigo-600 mb-4">
                                            <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                            </svg>
                                        </div>
                                        <h3 class="text-lg font-bold text-gray-900">3. Submit Application</h3>
                                        <p class="mt-2 text-gray-600">Fill out the necessary forms and upload required documents. Our system guides you through each step.</p>
                                    </div>
                                </div>
                                <div class="flex h-10 w-10 rounded-full bg-indigo-600 items-center justify-center relative z-10">
                                    <span class="text-white font-bold">3</span>
                                </div>
                                <div class="w-1/2"><!-- Empty div to maintain layout --></div>
                            </div>

                            <!-- Step 4 -->
                            <div class="relative flex items-center">
                                <div class="w-1/2"><!-- Empty div to maintain layout --></div>
                                <div class="flex h-10 w-10 rounded-full bg-indigo-600 items-center justify-center relative z-10">
                                    <span class="text-white font-bold">4</span>
                                </div>
                                <div class="w-1/2 pl-8">
                                    <div class="bg-white p-6 rounded-xl shadow-md mr-auto ml-12 transform transition-all duration-500 hover:scale-105 hover:rotate-1" style="max-width: 350px;">
                                        <div class="inline-flex items-center justify-center w-12 h-12 rounded-full bg-indigo-100 text-indigo-600 mb-4">
                                            <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                        </div>
                                        <h3 class="text-lg font-bold text-gray-900">4. Pay Online</h3>
                                        <p class="mt-2 text-gray-600">Make secure payments through GCash or PayMaya. Receive instant confirmation of your transaction.</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Step 5 -->
                            <div class="relative flex items-center">
                                <div class="w-1/2 pr-8 text-right">
                                    <div class="bg-white p-6 rounded-xl shadow-md ml-auto mr-12 transform transition-all duration-500 hover:scale-105 hover:rotate-1" style="max-width: 350px;">
                                        <div class="inline-flex items-center justify-center w-12 h-12 rounded-full bg-indigo-100 text-indigo-600 mb-4">
                                            <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                                            </svg>
                                        </div>
                                        <h3 class="text-lg font-bold text-gray-900">5. Track & Receive</h3>
                                        <p class="mt-2 text-gray-600">Monitor your application status in real-time. Get notifications via email and SMS about your request.</p>
                                    </div>
                                </div>
                                <div class="flex h-10 w-10 rounded-full bg-indigo-600 items-center justify-center relative z-10">
                                    <span class="text-white font-bold">5</span>
                                </div>
                                <div class="w-1/2"><!-- Empty div to maintain layout --></div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Mobile Timeline -->
                    <div class="md:hidden">
                        <div class="space-y-8">
                            <!-- Step 1 -->
                            <div class="mobile-step">
                                <div class="step-circle">1</div>
                                <div class="bg-white p-4 rounded-xl shadow-md">
                                    <div class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-indigo-100 text-indigo-600 mb-3">
                                        <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                        </svg>
                                    </div>
                                    <h3 class="text-base font-bold text-gray-900">Register & Login</h3>
                                    <p class="mt-2 text-sm text-gray-600">Create your account or log in to access municipal services.</p>
                                </div>
                            </div>

                            <!-- Step 2 -->
                            <div class="mobile-step">
                                <div class="step-circle">2</div>
                                <div class="bg-white p-4 rounded-xl shadow-md">
                                    <div class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-indigo-100 text-indigo-600 mb-3">
                                        <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                                        </svg>
                                    </div>
                                    <h3 class="text-base font-bold text-gray-900">Select a Service</h3>
                                    <p class="mt-2 text-sm text-gray-600">Browse and choose from our available services.</p>
                                </div>
                            </div>

                            <!-- Step 3 -->
                            <div class="mobile-step">
                                <div class="step-circle">3</div>
                                <div class="bg-white p-4 rounded-xl shadow-md">
                                    <div class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-indigo-100 text-indigo-600 mb-3">
                                        <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                        </svg>
                                    </div>
                                    <h3 class="text-base font-bold text-gray-900">Submit Application</h3>
                                    <p class="mt-2 text-sm text-gray-600">Fill out forms and upload required documents.</p>
                                </div>
                            </div>

                            <!-- Step 4 -->
                            <div class="mobile-step">
                                <div class="step-circle">4</div>
                                <div class="bg-white p-4 rounded-xl shadow-md">
                                    <div class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-indigo-100 text-indigo-600 mb-3">
                                        <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                    </div>
                                    <h3 class="text-base font-bold text-gray-900">Pay Online</h3>
                                    <p class="mt-2 text-sm text-gray-600">Make secure payments through GCash or PayMaya.</p>
                                </div>
                            </div>

                            <!-- Step 5 -->
                            <div class="mobile-step">
                                <div class="step-circle">5</div>
                                <div class="bg-white p-4 rounded-xl shadow-md">
                                    <div class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-indigo-100 text-indigo-600 mb-3">
                                        <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                                        </svg>
                                    </div>
                                    <h3 class="text-base font-bold text-gray-900">Track & Receive</h3>
                                    <p class="mt-2 text-sm text-gray-600">Monitor your application status and receive notifications.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- CTA Section -->
    <div class="bg-indigo-700">
        <div class="max-w-2xl mx-auto text-center py-12 px-4 sm:py-16 sm:px-6 lg:px-8">
            <h2 class="text-2xl sm:text-3xl font-extrabold text-white">
                <span class="block">Ready to get started?</span>
                <span class="block mt-1">Access government services digitally today.</span>
            </h2>
            <p class="mt-4 text-base sm:text-lg leading-6 text-indigo-200">Create an account to begin your journey with Anilao E-Services. No more long lines and waiting times.</p>
            <div class="mt-8 flex flex-col sm:flex-row justify-center gap-3 sm:gap-4">
                @auth
                    <a href="{{ route('dashboard') }}" class="w-full sm:w-auto inline-flex items-center justify-center px-5 py-3 border border-transparent text-base font-medium rounded-md text-indigo-600 bg-white hover:bg-indigo-50 shadow-sm touch-target">
                        Go to Dashboard
                    </a>
                @else
                    <a href="{{ route('register') }}" class="w-full sm:w-auto inline-flex items-center justify-center px-5 py-3 border border-transparent text-base font-medium rounded-md text-indigo-600 bg-white hover:bg-indigo-50 shadow-sm touch-target">
                        Register Now
                    </a>
                    <a href="{{ route('login') }}" class="w-full sm:w-auto inline-flex items-center justify-center px-5 py-3 border border-transparent text-base font-medium rounded-md text-white bg-indigo-500 bg-opacity-60 hover:bg-opacity-70 touch-target">
                        Sign In
                    </a>
                @endauth
            </div>
        </div>
    </div>

    <!-- Stats Section -->
    <div class="bg-white py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="max-w-4xl mx-auto text-center">
                <h2 class="text-2xl sm:text-3xl font-extrabold text-gray-900">
                    Trusted by thousands of citizens
                </h2>
                <p class="mt-3 text-base sm:text-lg text-gray-500">
                    Our digital services have transformed the way residents interact with the municipality.
                </p>
            </div>
        </div>
        <div class="mt-8 pb-12 bg-white">
            <div class="relative">
                <div class="absolute inset-0 h-1/2 bg-gray-50"></div>
                <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="max-w-4xl mx-auto">
                        <dl class="rounded-lg bg-white shadow-lg grid grid-cols-1 sm:grid-cols-3">
                            <div class="flex flex-col p-6 text-center border-b sm:border-0 sm:border-r">
                                <dt class="order-2 mt-2 text-base leading-6 font-medium text-gray-500">
                                    Users
                                </dt>
                                <dd class="order-1 text-4xl font-extrabold text-indigo-600">
                                    5,800+
                                </dd>
                            </div>
                            <div class="flex flex-col p-6 text-center border-t border-b sm:border-0 sm:border-l sm:border-r">
                                <dt class="order-2 mt-2 text-base leading-6 font-medium text-gray-500">
                                    Documents
                                </dt>
                                <dd class="order-1 text-4xl font-extrabold text-indigo-600">
                                    12K+
                                </dd>
                            </div>
                            <div class="flex flex-col p-6 text-center border-t sm:border-0 sm:border-l">
                                <dt class="order-2 mt-2 text-base leading-6 font-medium text-gray-500">
                                    Satisfaction
                                </dt>
                                <dd class="order-1 text-4xl font-extrabold text-indigo-600">
                                    98%
                                </dd>
                            </div>
                        </dl>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Contact Section -->
    <div id="contact" class="bg-gray-50">
        <div class="max-w-7xl mx-auto py-12 px-4 sm:py-16 sm:px-6 lg:py-20 lg:px-8">
            <div class="divide-y-2 divide-gray-200">
                <div class="lg:grid lg:grid-cols-3 lg:gap-8 pb-12">
                    <h2 class="text-2xl font-extrabold text-gray-900 sm:text-3xl lg:mb-0 mb-8">
                        Get in touch
                    </h2>
                    <div class="grid grid-cols-1 gap-12 sm:grid-cols-2 sm:gap-x-8 sm:gap-y-12 lg:col-span-2">
                        <div>
                            <h3 class="text-lg leading-6 font-medium text-gray-900">
                                Municipal Hall
                            </h3>
                            <dl class="mt-2 text-base text-gray-500">
                                <div>
                                    <dt class="sr-only">Address</dt>
                                    <dd>
                                        Poblacion, Anilao<br>
                                        Iloilo, Philippines 5009
                                    </dd>
                                </div>
                                <div class="mt-1">
                                    <dt class="sr-only">Phone number</dt>
                                    <dd>+63 (33) 123-4567</dd>
                                </div>
                                <div class="mt-1">
                                    <dt class="sr-only">Email</dt>
                                    <dd>info@anilao.gov.ph</dd>
                                </div>
                            </dl>
                        </div>
                        <div>
                            <h3 class="text-lg leading-6 font-medium text-gray-900">
                                Office Hours
                            </h3>
                            <dl class="mt-2 text-base text-gray-500">
                                <div>
                                    <dt class="sr-only">Office Hours</dt>
                                    <dd>
                                        Monday - Friday<br>
                                        8:00 AM - 5:00 PM
                                    </dd>
                                </div>
                                <div class="mt-1">
                                    <dt class="sr-only">Closed</dt>
                                    <dd>Weekends and Holidays</dd>
                                </div>
                            </dl>
                        </div>
                        <div>
                            <h3 class="text-lg leading-6 font-medium text-gray-900">
                                Technical Support
                            </h3>
                            <dl class="mt-2 text-base text-gray-500">
                                <div>
                                    <dt class="sr-only">Email</dt>
                                    <dd>support@anilao.gov.ph</dd>
                                </div>
                                <div class="mt-1">
                                    <dt class="sr-only">Phone number</dt>
                                    <dd>+63 (33) 123-4569</dd>
                                </div>
                            </dl>
                        </div>
                        <div>
                            <h3 class="text-lg leading-6 font-medium text-gray-900">
                                Social Media
                            </h3>
                            <ul role="list" class="mt-3 space-y-3">
                                <li>
                                <a href="#" class="flex text-base text-gray-500 hover:text-gray-900 touch-target">
                                        <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                            <path fill-rule="evenodd" d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z" clip-rule="evenodd" />
                                        </svg>
                                        <span class="ml-3">Facebook</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="#" class="flex text-base text-gray-500 hover:text-gray-900 touch-target">
                                        <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                            <path d="M8.29 20.251c7.547 0 11.675-6.253 11.675-11.675 0-.178 0-.355-.012-.53A8.348 8.348 0 0022 5.92a8.19 8.19 0 01-2.357.646 4.118 4.118 0 001.804-2.27 8.224 8.224 0 01-2.605.996 4.107 4.107 0 00-6.993 3.743 11.65 11.65 0 01-8.457-4.287 4.106 4.106 0 001.27 5.477A4.072 4.072 0 012.8 9.713v.052a4.105 4.105 0 003.292 4.022 4.095 4.095 0 01-1.853.07 4.108 4.108 0 003.834 2.85A8.233 8.233 0 012 18.407a11.616 11.616 0 006.29 1.84" />
                                        </svg>
                                        <span class="ml-3">Twitter</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="pt-12">
                    <div class="lg:grid lg:grid-cols-3 lg:gap-8">
                        <h2 class="text-2xl font-extrabold text-gray-900 sm:text-3xl lg:mb-0 mb-8">
                            Frequently asked questions
                        </h2>
                        <div class="lg:col-span-2">
                            <dl class="space-y-8">
                                <div>
                                    <dt class="text-lg leading-6 font-medium text-gray-900">
                                        How do I create an account?
                                    </dt>
                                    <dd class="mt-2 text-base text-gray-500">
                                        Click on the Register button, fill in your personal details, and verify your email address. Once verified, you can log in and access all our e-services.
                                    </dd>
                                </div>

                                <div>
                                    <dt class="text-lg leading-6 font-medium text-gray-900">
                                        What payment methods are accepted?
                                    </dt>
                                    <dd class="mt-2 text-base text-gray-500">
                                        We currently accept payments through GCash and PayMaya. We're working to add more payment options in the future.
                                    </dd>
                                </div>

                                <div>
                                    <dt class="text-lg leading-6 font-medium text-gray-900">
                                        How long does it take to process my request?
                                    </dt>
                                    <dd class="mt-2 text-base text-gray-500">
                                        Processing times vary depending on the service requested. Each service page displays the estimated processing time. You'll receive notifications at every stage of your request.
                                    </dd>
                                </div>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-white">
        <div class="max-w-7xl mx-auto py-12 px-4 overflow-hidden sm:px-6 lg:px-8">
            <nav class="flex flex-wrap justify-center -mx-5 -my-2" aria-label="Footer">
                <div class="px-5 py-2">
                    <a href="#" class="text-base text-gray-500 hover:text-gray-900 touch-target">
                        About
                    </a>
                </div>
                <div class="px-5 py-2">
                    <a href="#services" class="text-base text-gray-500 hover:text-gray-900 touch-target">
                        Services
                    </a>
                </div>
                <div class="px-5 py-2">
                    <a href="#how-it-works" class="text-base text-gray-500 hover:text-gray-900 touch-target">
                        How It Works
                    </a>
                </div>
                <div class="px-5 py-2">
                    <a href="{{ route('ordinances.index') }}" class="text-base text-gray-500 hover:text-gray-900 touch-target">
                        Ordinances
                    </a>
                </div>
                <div class="px-5 py-2">
                    <a href="#contact" class="text-base text-gray-500 hover:text-gray-900 touch-target">
                        Contact
                    </a>
                </div>
                <div class="px-5 py-2">
                    <a href="#" class="text-base text-gray-500 hover:text-gray-900 touch-target">
                        Privacy Policy
                    </a>
                </div>
            </nav>
            <div class="mt-8 flex justify-center space-x-6">
                <a href="#" class="text-gray-400 hover:text-gray-500 touch-target">
                    <span class="sr-only">Facebook</span>
                    <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path fill-rule="evenodd" d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z" clip-rule="evenodd" />
                    </svg>
                </a>
                <a href="#" class="text-gray-400 hover:text-gray-500 touch-target">
                    <span class="sr-only">Twitter</span>
                    <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path d="M8.29 20.251c7.547 0 11.675-6.253 11.675-11.675 0-.178 0-.355-.012-.53A8.348 8.348 0 0022 5.92a8.19 8.19 0 01-2.357.646 4.118 4.118 0 001.804-2.27 8.224 8.224 0 01-2.605.996 4.107 4.107 0 00-6.993 3.743 11.65 11.65 0 01-8.457-4.287 4.106 4.106 0 001.27 5.477A4.072 4.072 0 012.8 9.713v.052a4.105 4.105 0 003.292 4.022 4.095 4.095 0 01-1.853.07 4.108 4.108 0 003.834 2.85A8.233 8.233 0 012 18.407a11.616 11.616 0 006.29 1.84" />
                    </svg>
                </a>
                <a href="#" class="text-gray-400 hover:text-gray-500 touch-target">
                    <span class="sr-only">YouTube</span>
                    <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path fill-rule="evenodd" d="M19.812 5.418c.861.23 1.538.907 1.768 1.768C21.998 8.746 22 12 22 12s0 3.255-.418 4.814a2.504 2.504 0 0 1-1.768 1.768c-1.56.419-7.814.419-7.814.419s-6.255 0-7.814-.419a2.505 2.505 0 0 1-1.768-1.768C2 15.255 2 12 2 12s0-3.255.417-4.814a2.507 2.507 0 0 1 1.768-1.768C5.744 5 11.998 5 11.998 5s6.255 0 7.814.418ZM15.194 12 10 15V9l5.194 3Z" clip-rule="evenodd" />
                    </svg>
                </a>
            </div>
            <p class="mt-8 text-center text-base text-gray-500">
                &copy; {{ date('Y') }} Municipality of Anilao, Iloilo. All rights reserved.
            </p>
            <p class="mt-2 text-center text-sm text-gray-500">
                Last updated: April 5, 2025
            </p>
        </div>
    </footer>

    <!-- Mobile menu toggle script -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const mobileMenuButton = document.getElementById('mobile-menu-button');
            const mobileMenu = document.getElementById('mobile-menu');
            const menuOpenIcon = document.getElementById('menu-open-icon');
            const menuClosedIcon = document.getElementById('menu-closed-icon');
            
            if (mobileMenuButton) {
                mobileMenuButton.addEventListener('click', function() {
                    const isMenuOpen = mobileMenu.classList.contains('hidden');
                    
                    if (isMenuOpen) {
                        // Open menu
                        mobileMenu.classList.remove('hidden');
                        menuOpenIcon.classList.remove('hidden');
                        menuClosedIcon.classList.add('hidden');
                    } else {
                        // Close menu
                        mobileMenu.classList.add('hidden');
                        menuOpenIcon.classList.add('hidden');
                        menuClosedIcon.classList.remove('hidden');
                    }
                });
            }
            
            // Close menu when clicking on a menu item
            const menuItems = mobileMenu.querySelectorAll('a');
            menuItems.forEach(item => {
                item.addEventListener('click', function() {
                    mobileMenu.classList.add('hidden');
                    menuOpenIcon.classList.add('hidden');
                    menuClosedIcon.classList.remove('hidden');
                });
            });
            
            // Close menu when clicking outside
            document.addEventListener('click', function(event) {
                if (!mobileMenu.contains(event.target) && !mobileMenuButton.contains(event.target) && !mobileMenu.classList.contains('hidden')) {
                    mobileMenu.classList.add('hidden');
                    menuOpenIcon.classList.add('hidden');
                    menuClosedIcon.classList.remove('hidden');
                }
            });
        });
    </script>
</body>
</html>