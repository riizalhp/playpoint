<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Dasbor') - PlayPoint</title>
    
    <link rel="icon" type="image/png" href="{{ asset('images/play-point-logo.png') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    
    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = { darkMode: 'class' }
    </script>
</head>
<body class="bg-gray-100 dark:bg-gray-900">
    <div class="flex h-screen bg-gray-100 dark:bg-gray-900">
        <!-- Sidebar -->
        <aside class="w-64 flex-shrink-0 bg-white dark:bg-gray-800 shadow-lg">
            <div class="flex items-center justify-center h-20 border-b dark:border-gray-700">
                <a href="{{ route('home') }}" class="flex items-center gap-3">
                    <img src="{{ asset('images/play-point-logo.png') }}" alt="[Logo PlayPoint]" class="h-10 w-auto">
                    <span class="text-2xl font-bold text-gray-800 dark:text-white">PlayPoint</span>
                </a>
            </div>
            <nav class="mt-4">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center px-6 py-3 text-gray-700 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-700 {{ request()->routeIs('admin.dashboard') ? 'bg-gray-200 dark:bg-gray-700' : '' }}">
                    <i class="fas fa-tachometer-alt w-6"></i>
                    <span class="ml-3">Dasbor</span>
                </a>
                <a href="{{ route('admin.products.index') }}" class="flex items-center px-6 py-3 mt-2 text-gray-700 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-700 {{ request()->routeIs('admin.products.*') ? 'bg-gray-200 dark:bg-gray-700' : '' }}">
                    <i class="fas fa-gamepad w-6"></i>
                    <span class="ml-3">Kelola Produk</span>
                </a>
                <!-- Menu lain bisa ditambahkan di sini -->
            </nav>
        </aside>

        <div class="flex-1 flex flex-col overflow-hidden">
            <!-- Header -->
            <header class="flex justify-end items-center p-4 bg-white dark:bg-gray-800 border-b dark:border-gray-700">
                <div class="flex items-center space-x-4">
                    <span class="text-gray-700 dark:text-gray-300 font-semibold hidden sm:block">Halo, {{ Auth::user()->name }}</span>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="bg-red-600 text-white font-semibold py-2 px-4 rounded-lg hover:bg-red-700 transition-colors">
                            <i class="fas fa-sign-out-alt mr-2"></i>Logout
                        </button>
                    </form>
                </div>
            </header>
            
            <!-- Main Content -->
            <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-100 dark:bg-gray-900">
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
