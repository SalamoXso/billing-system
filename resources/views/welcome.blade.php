<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Laravel') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
</head>
<body class="antialiased">
    <div class="relative min-h-screen bg-gray-100 dark:bg-gray-900">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Navigation -->
            <nav class="py-6">
                <div class="flex justify-between items-center">
                    <div class="flex items-center">
                        <svg viewBox="0 0 316 316" xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 fill-current text-blue-500">
                            <path d="M305.8 81.125C305.77 80.995 305.69 80.885 305.65 80.755C305.56 80.525 305.49 80.285 305.37 80.075C305.29 79.935 305.17 79.815 305.07 79.685C304.94 79.515 304.83 79.325 304.68 79.175C304.55 79.045 304.39 78.955 304.25 78.845C304.09 78.715 303.95 78.575 303.77 78.475L251.32 48.275C249.97 47.495 248.31 47.495 246.96 48.275L194.51 78.475C194.33 78.575 194.19 78.725 194.03 78.845C193.89 78.955 193.73 79.045 193.6 79.175C193.45 79.325 193.34 79.515 193.21 79.685C193.11 79.815 192.99 79.935 192.91 80.075C192.79 80.285 192.71 80.525 192.63 80.755C192.58 80.875 192.51 80.995 192.48 81.125C192.38 81.495 192.33 81.875 192.33 82.265V139.625L148.62 164.795V52.575C148.62 52.185 148.57 51.805 148.47 51.435C148.44 51.305 148.36 51.195 148.32 51.065C148.23 50.835 148.16 50.595 148.04 50.385C147.96 50.245 147.84 50.125 147.74 49.995C147.61 49.825 147.5 49.635 147.35 49.485C147.22 49.355 147.06 49.265 146.92 49.155C146.76 49.025 146.62 48.885 146.44 48.785L93.99 18.585C92.64 17.805 90.98 17.805 89.63 18.585L37.18 48.785C37 48.885 36.86 49.035 36.7 49.155C36.56 49.265 36.4 49.355 36.27 49.485C36.12 49.635 36.01 49.825 35.88 49.995C35.78 50.125 35.66 50.245 35.58 50.385C35.46 50.595 35.38 50.835 35.3 51.065C35.25 51.185 35.18 51.305 35.15 51.435C35.05 51.805 35 52.185 35 52.575V232.235C35 233.795 35.84 235.245 37.19 236.025L142.1 296.425C142.33 296.555 142.58 296.635 142.82 296.725C142.93 296.765 143.04 296.835 143.16 296.865C143.53 296.965 143.9 297.015 144.28 297.015C144.66 297.015 145.03 296.965 145.4 296.865C145.5 296.835 145.59 296.775 145.69 296.745C145.95 296.655 146.21 296.565 146.45 296.435L251.36 236.035C252.72 235.255 253.55 233.815 253.55 232.245V174.885L303.81 145.945C305.17 145.165 306 143.725 306 142.155V82.265C305.95 81.875 305.89 81.495 305.8 81.125Z"/>
                        </svg>
                        <span class="ml-3 text-xl font-bold text-gray-900 dark:text-white">Billing System</span>
                    </div>
                    
                    @if (Route::has('login'))
                        <div class="space-x-4">
                            @auth
                                <a href="{{ route('dashboard') }}" class="btn btn-primary">
                                    Dashboard
                                </a>
                            @else
                                <a href="{{ route('login') }}" class="btn btn-primary">
                                    Log in
                                </a>

                                @if (Route::has('register'))
                                    <a href="{{ route('register') }}" class="btn btn-secondary">
                                        Register
                                    </a>
                                @endif
                            @endauth
                        </div>
                    @endif
                </div>
            </nav>

            <!-- Hero Section -->
            <div class="py-16 sm:py-24">
                <div class="text-center">
                    <h1 class="text-4xl tracking-tight font-extrabold text-gray-900 dark:text-white sm:text-5xl md:text-6xl">
                        <span class="block">Professional</span>
                        <span class="block text-blue-600">Billing System</span>
                    </h1>
                    <p class="mt-3 max-w-md mx-auto text-base text-gray-500 dark:text-gray-400 sm:text-lg md:mt-5 md:text-xl md:max-w-3xl">
                        A comprehensive solution for managing clients, invoices, quotes, and payments for your business.
                    </p>
                    <div class="mt-5 max-w-md mx-auto sm:flex sm:justify-center md:mt-8">
                        @if (Route::has('login'))
                            @auth
                                <div class="rounded-md shadow">
                                    <a href="{{ route('dashboard') }}" class="w-full flex items-center justify-center px-8 py-3 border border-transparent text-base font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 md:py-4 md:text-lg md:px-10">
                                        Go to Dashboard
                                    </a>
                                </div>
                            @else
                                <div class="rounded-md shadow">
                                    <a href="{{ route('login') }}" class="w-full flex items-center justify-center px-8 py-3 border border-transparent text-base font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 md:py-4 md:text-lg md:px-10">
                                        Get Started
                                    </a>
                                </div>
                                @if (Route::has('register'))
                                    <div class="mt-3 rounded-md shadow sm:mt-0 sm:ml-3">
                                        <a href="{{ route('register') }}" class="w-full flex items-center justify-center px-8 py-3 border border-transparent text-base font-medium rounded-md text-blue-600 bg-white hover:bg-gray-50 md:py-4 md:text-lg md:px-10">
                                            Register
                                        </a>
                                    </div>
                                @endif
                            @endauth
                        @endif
                    </div>
                </div>
            </div>

            <!-- Features Section -->
            <div class="py-12">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm rounded-lg transition-all duration-300 hover:shadow-lg hover:-translate-y-1">
                        <div class="p-6">
                            <div class="flex items-center">
                                <div class="p-3 rounded-full bg-blue-500 bg-opacity-10">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                                    </svg>
                                </div>
                                <h2 class="ml-3 text-xl font-semibold text-gray-900 dark:text-white">Client Management</h2>
                            </div>
                            <p class="mt-4 text-gray-600 dark:text-gray-400">Easily manage your clients and their information with our comprehensive client management system.</p>
                        </div>
                    </div>

                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm rounded-lg transition-all duration-300 hover:shadow-lg hover:-translate-y-1">
                        <div class="p-6">
                            <div class="flex items-center">
                                <div class="p-3 rounded-full bg-green-500 bg-opacity-10">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                    </svg>
                                </div>
                                <h2 class="ml-3 text-xl font-semibold text-gray-900 dark:text-white">Invoice Generation</h2>
                            </div>
                            <p class="mt-4 text-gray-600 dark:text-gray-400">Create professional invoices with GST calculation and serial number tracking for your business needs.</p>
                        </div>
                    </div>

                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm rounded-lg transition-all duration-300 hover:shadow-lg hover:-translate-y-1">
                        <div class="p-6">
                            <div class="flex items-center">
                                <div class="p-3 rounded-full bg-purple-500 bg-opacity-10">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-purple-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                                    </svg>
                                </div>
                                <h2 class="ml-3 text-xl font-semibold text-gray-900 dark:text-white">Product Management</h2>
                            </div>
                            <p class="mt-4 text-gray-600 dark:text-gray-400">Track your products and their serial numbers efficiently with our product management system.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
