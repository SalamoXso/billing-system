<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="font-sans antialiased bg-gray-50 dark:bg-gray-900">
    <div class="min-h-screen flex" x-data="{ sidebarOpen: localStorage.getItem('sidebarOpen') === 'true' || window.innerWidth >= 1024 }">
        <!-- Include the sidebar component -->
        @include('components.sidebar')
        
        <!-- Main Content -->
        <div class="flex-1 flex flex-col min-h-screen transition-all duration-300" 
             :class="{'lg:ml-64': sidebarOpen, 'lg:ml-0': !sidebarOpen}">
            <!-- Top Navigation -->
            <header class="bg-white dark:bg-gray-800 shadow z-10">
                <div class="px-4 sm:px-6 lg:px-8 py-4 flex items-center justify-between">
                    <!-- Hamburger button -->
                    <button 
                        @click="sidebarOpen = !sidebarOpen; localStorage.setItem('sidebarOpen', sidebarOpen)" 
                        class="text-gray-500 hover:text-gray-700 focus:outline-none"
                    >
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>
                    
                    <!-- Page title -->
                    <h1 class="text-xl font-semibold text-gray-800 dark:text-gray-200">
                        @yield('title', 'Dashboard')
                    </h1>
                    
                    <!-- User dropdown -->
                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open" class="flex items-center text-gray-700 dark:text-gray-300 hover:text-gray-900 dark:hover:text-gray-100 focus:outline-none">
                            <span class="mr-2">{{ Auth::user()->name }}</span>
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </button>
                        
                        <div x-show="open" @click.away="open = false" class="absolute right-0 mt-2 w-48 bg-white dark:bg-gray-800 rounded-md shadow-lg py-1 z-50">
                            <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">
                                Profile
                            </a>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="w-full text-left block px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">
                                    Logout
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </header>
            
            <!-- Flash Messages -->
            @if (session('success') || session('error'))
                <div class="px-4 sm:px-6 lg:px-8 py-4">
                    @include('components.flash-message')
                </div>
            @endif
            
            <!-- Page Content -->
            <main class="flex-1 px-4 sm:px-6 lg:px-8 py-6">
                @yield('content')
            </main>
            
            <!-- Footer -->
            <footer class="bg-white dark:bg-gray-800 shadow mt-auto">
                <div class="max-w-7xl mx-auto py-4 px-4 sm:px-6 lg:px-8">
                    <p class="text-center text-sm text-gray-500 dark:text-gray-400">
                        &copy; {{ date('Y') }} Billing System. All rights reserved.
                    </p>
                </div>
            </footer>
        </div>
    </div>
</body>
</html>
