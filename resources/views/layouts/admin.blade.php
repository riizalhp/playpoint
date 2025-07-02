<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin - PlayPoint')</title>
    
    <link rel="icon" type="image/png" href="{{ asset('images/play-point-logo.png') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
            :root {
                --color-primary: #0C2A47;
                --color-accent: #4DBCBE;
                --color-highlight: #FEC601;
                --color-base: #FFFFFF;
            }
            .dark {
                --color-primary: #F1F5F9;
                --color-accent: #4DBCBE;
                --color-highlight: #FEC601;
                --color-base: #1A1A22;
            }
            body { 
                font-family: 'Inter', sans-serif;
                background-color: var(--color-base);
            }
        </style>
</head>
<body class="bg-base">
    <div class="flex h-screen bg-base">
        <aside class="w-64 flex-shrink-0 bg-base dark:bg-[#3A3A42] shadow-lg">
            <div class="flex items-center justify-center h-16 border-b dark:border-gray-700">
                <a href="{{ route('home') }}" class="flex items-center gap-3">
                    <img src="{{ asset('images/play-point-logo.png') }}" alt="[Logo PlayPoint]" class="h-10 w-auto">
                    <span class="text-2xl font-bold text-primary dark:text-[#F1F5F9]">PlayPoint</span>
                </a>
            </div>
            <nav class="mt-4">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center px-6 py-3 text-gray-700 dark:text-[#F1F5F9] hover:bg-gray-200 dark:hover:bg-gray-700 {{ request()->routeIs('admin.dashboard') ? 'bg-accent bg-opacity-20 text-primary dark:text-[#F1F5F9]' : '' }}">
                    <i class="fas fa-tachometer-alt w-6"></i>
                    <span class="ml-3">Dasbor</span>
                </a>
                <a href="{{ route('admin.products.index') }}" class="flex items-center px-6 py-3 mt-2 text-gray-700 dark:text-[#F1F5F9] hover:bg-gray-200 dark:hover:bg-gray-700 {{ request()->routeIs('admin.products.*') ? 'bg-accent bg-opacity-20 text-primary dark:text-[#F1F5F9]' : '' }}">
                    <i class="fas fa-gamepad w-6"></i>
                    <span class="ml-3">Kelola Produk</span>
                </a>
            </nav>
        </aside>

        <div class="flex-1 flex flex-col overflow-hidden">
            <header class="flex justify-end items-center p-3 border-b dark:border-gray-700 bg-base dark:bg-[#3A3A42]">
                <div class="flex items-center space-x-4">
                    <span class="text-gray-700 dark:text-[#F1F5F9] font-semibold hidden sm:block">Halo, {{ Auth::user()->name }}</span>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="bg-gray-600 text-white font-semibold py-2 px-4 rounded-lg hover:bg-gray-700 transition-colors">
                            <i class="fas fa-sign-out-alt mr-2"></i>Logout
                        </button>
                    </form>
                </div>
            </header>
            
            <main class="flex-1 overflow-x-hidden overflow-y-auto bg-base">
                <div class="container mx-auto px-6 py-8">
                    @include('patrials._notifications')
                    @yield('content')
                </div>
            </main>
        </div>
    </div>
    @stack('scripts')
</body>
</html>