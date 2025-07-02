<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'PlayPoint - Jual Beli Akun Game Online')</title>
    
    <link rel="icon" type="image/png" href="{{ asset('images/play-point-logo.png') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css"/>
    
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
                color: var(--color-primary);
            }
        </style>
</head>
<body class="antialiased flex flex-col min-h-screen bg-base text-primary dark:text-[#F1F5F9]">

    <header class="bg-base dark:bg-[#3A3A42] shadow-lg sticky top-0 z-40">
        <nav class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">
                <div class="flex-shrink-0">
                    <a href="{{ route('home') }}" class="flex items-center gap-3">
                        <img src="{{ asset('images/play-point-logo.png') }}" alt="[Logo PlayPoint]" class="h-12 w-auto">
                        <span class="text-2xl font-bold text-primary dark:text-[#F1F5F9] hidden sm:block">PlayPoint</span>
                    </a>
                </div>
                <div class="flex items-center space-x-6">
                    <a href="{{ route('cart.index') }}" class="relative text-primary dark:text-[#F1F5F9] hover:text-accent transition-colors duration-300" id="cart-icon-container">
                        <i class="fas fa-shopping-cart text-2xl"></i>
                         @if(session('cart') && count(session('cart')) > 0)
                            <span id="cart-count-badge" class="absolute -top-2 -right-3 bg-highlight text-primary dark:text-[#0F172A] font-bold text-xs rounded-full h-5 w-5 flex items-center justify-center border-2 border-base dark:border-[#0F172A]">{{ count(session('cart')) }}</span>
                        @else
                            <span id="cart-count-badge" class="absolute -top-2 -right-3 bg-highlight text-primary dark:text-[#0F172A] font-bold text-xs rounded-full h-5 w-5 flex items-center justify-center border-2 border-base dark:border-[#0F172A] hidden">0</span>
                        @endif
                    </a>
                    @auth
                        <div class="flex items-center space-x-4">
                            <a href="{{ route('admin.dashboard') }}" class="text-primary dark:text-[#F1F5F9] font-semibold hidden sm:block hover:text-accent transition-colors duration-300">Dasbor</a>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="bg-red-600 text-white font-semibold py-2 px-5 rounded-lg hover:bg-red-700 transition-transform duration-300 ease-in-out hover:scale-105">
                                    Logout
                                </button>
                            </form>
                        </div>
                    @else
                        <a href="{{ route('login') }}" class="bg-accent text-white font-bold py-3 px-6 rounded-lg shadow-md hover:bg-opacity-90 transition-all duration-300 ease-in-out hover:shadow-lg hover:scale-105">Login</a>
                    @endauth
                </div>
            </div>
        </nav>
    </header>

    <main class="flex-grow bg-base text-primary dark:text-[#F1F5F9]">
        @include('patrials._notifications')
        @yield('content')
    </main>

    <footer class="mt-16 dark:bg-[#3A3A42] dark:text-[#F1F5F9]">
        <div class="container mx-auto px-6 py-12">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8 text-gray-300">
                <div class="col-span-1 md:col-span-2 lg:col-span-1">
                    <div class="flex items-center mb-4">
                        <a href="{{ route('home') }}" class="flex items-center gap-3">
                            <img src="{{ asset('images/play-point-logo.png') }}" alt="[Logo PlayPoint]" class="h-12 w-auto">
                            <span class="text-3xl font-bold text-primary dark:text-[#F1F5F9]">PlayPoint</span>
                        </a>
                    </div>
                    <p class="text-gray-400 mt-2 text-sm dark:text-gray-500">
                        Platform jual beli akun game online aman, cepat, dan terpercaya di Indonesia.
                    </p>
                </div>
                <div class="lg:pl-12">
                    <h3 class="text-lg font-semibold text-base dark:text-[#F1F5F9] mb-4">Navigasi</h3>
                    <ul class="space-y-2">
                        <li><a href="{{ route('home') }}" class="hover:text-accent hover:underline">Beranda</a></li>
                        <li><a href="{{ route('consignment.create') }}" class="hover:text-accent hover:underline">Titip Jual Akun</a></li>
                        <li><a href="#" class="hover:text-accent hover:underline">Tentang Kami</a></li>
                        <li><a href="#" class="hover:text-accent hover:underline">Hubungi Kami</a></li>
                    </ul>
                </div>
                <div>
                    <h3 class="text-lg font-semibold text-base dark:text-[#F1F5F9] mb-4">Customer Service</h3>
                    <ul class="space-y-2">
                        <li><a href="#" class="hover:text-accent hover:underline"><i class="fab fa-whatsapp mr-2"></i>WhatsApp</a></li>
                        <li><a href="#" class="hover:text-accent hover:underline"><i class="fas fa-envelope mr-2"></i>Email</a></li>
                        <li><a href="#" class="hover:text-accent hover:underline"><i class="fas fa-question-circle mr-2"></i>Pusat Bantuan</a></li>
                    </ul>
                </div>
                <div>
                    <h3 class="text-lg font-semibold text-base dark:text-[#F1F5F9] mb-4">Ikuti Kami</h3>
                    <div class="flex space-x-4">
                        <a href="#" class="text-gray-400 hover:text-[#1877F2] transition-colors duration-300"><i class="fab fa-facebook-f text-2xl"></i></a>
                        <a href="#" class="text-gray-400 hover:text-[#E4405F] transition-colors duration-300"><i class="fab fa-instagram text-2xl"></i></a>
                        <a href="#" class="text-gray-400 hover:text-[#1DA1F2] transition-colors duration-300"><i class="fab fa-twitter text-2xl"></i></a>
                        <a href="#" class="text-gray-400 hover:text-[#FF0000] transition-colors duration-300"><i class="fab fa-youtube text-2xl"></i></a>
                    </div>
                </div>
            </div>
            <div class="mt-12 border-t border-gray-700 dark:border-gray-600 pt-6 text-center text-gray-400 dark:text-gray-500 text-sm">
                <p>&copy; {{ date('Y') }} PlayPoint. Seluruh hak cipta dilindungi.</p>
            </div>
        </div>
    </footer>
    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    
    @stack('scripts')
</body>
</html>
