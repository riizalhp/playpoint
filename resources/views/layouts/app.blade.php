<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="">
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
    
    <style>
        body { font-family: 'Inter', sans-serif; transition: background-color 0.3s ease, color 0.3s ease; }
    </style>

    <script>
        tailwind.config = {
            darkMode: 'class', 
        }
    </script>
    <script src="https://cdn.tailwindcss.com"></script>

    <script>
        function updateThemeIcons() {
             const html = document.documentElement;
             const sunIcon = document.getElementById('sun-icon');
             const moonIcon = document.getElementById('moon-icon');
             if (sunIcon && moonIcon) {
                if (html.classList.contains('dark')) {
                    sunIcon.classList.remove('hidden');
                    moonIcon.classList.add('hidden');
                } else {
                    sunIcon.classList.add('hidden');
                    moonIcon.classList.remove('hidden');
                }
             }
        }

        function toggleTheme() {
            const html = document.documentElement;
            html.classList.toggle('dark');
            localStorage.theme = html.classList.contains('dark') ? 'dark' : 'light';
            updateThemeIcons();
        }

        if (localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
        
        document.addEventListener('DOMContentLoaded', updateThemeIcons);
    </script>
</head>
<body class="bg-gray-50 dark:bg-gray-900 text-gray-800 dark:text-gray-200 antialiased flex flex-col min-h-screen">

    <header class="bg-white dark:bg-gray-800 shadow-md dark:shadow-gray-700/50 sticky top-0 z-40">
        <nav class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">
                <div class="flex-shrink-0">
                    <a href="{{ route('home') }}" class="flex items-center gap-3">
                        <img src="{{ asset('images/play-point-logo.png') }}" alt="PlayPoint Logo" class="h-10 w-auto">
                        <span class="text-2xl font-bold text-gray-800 dark:text-white hidden sm:block">PlayPoint</span>
                    </a>
                </div>
                <div class="flex items-center space-x-4">
                    <button onclick="toggleTheme()" class="text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-full w-10 h-10 flex items-center justify-center">
                        <i id="sun-icon" class="fas fa-sun text-xl hidden"></i>
                        <i id="moon-icon" class="fas fa-moon text-xl hidden"></i>
                    </button>
                    {{-- PERUBAHAN: Tambahkan ID pada badge keranjang dan bungkus dalam div --}}
                    <a href="{{ route('cart.index') }}" class="relative text-gray-500 dark:text-gray-400 hover:text-gray-800 dark:hover:text-white" id="cart-icon-container">
                        <i class="fas fa-shopping-cart text-xl"></i>
                         @if(session('cart') && count(session('cart')) > 0)
                            <span id="cart-count-badge" class="absolute -top-2 -right-2 bg-red-500 text-white text-xs rounded-full h-5 w-5 flex items-center justify-center">{{ count(session('cart')) }}</span>
                        @else
                            <span id="cart-count-badge" class="absolute -top-2 -right-2 bg-red-500 text-white text-xs rounded-full h-5 w-5 flex items-center justify-center hidden">0</span>
                        @endif
                    </a>
                    <a href="#" class="bg-blue-600 text-white font-semibold py-2 px-4 rounded-lg hover:bg-blue-700 transition-colors">Login</a>
                </div>
            </div>
        </nav>
    </header>

    <main class="flex-grow">
        @yield('content')
    </main>

    <footer class="bg-white dark:bg-gray-800 border-t border-gray-200 dark:border-gray-700 mt-12">
        <div class="container mx-auto px-6 py-12">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <div class="col-span-1 md:col-span-2">
                    <div class="flex items-center mb-4">
                        <img src="{{ asset('images/play-point-logo.png') }}" alt="PlayPoint Logo" class="h-12 w-auto mr-3">
                        <span class="text-2xl font-bold text-gray-900 dark:text-white">PlayPoint</span>
                    </div>
                    <p class="text-gray-600 dark:text-gray-400 font-semibold">PT Anda Cemerlang</p>
                    <p class="text-gray-600 dark:text-gray-400 mt-2 text-sm">
                        <i class="fas fa-map-marker-alt mr-2"></i>Jl. Sukun MBS No.3, Ngringin, Condongcatur, Kec. Depok, Kabupaten Sleman, Daerah Istimewa Yogyakarta 55283
                    </p>
                </div>

                <div>
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Sosial Media</h3>
                    <div class="flex space-x-4">
                        <a href="#" class="text-gray-500 hover:text-blue-600 dark:hover:text-blue-400"><i class="fab fa-facebook-f text-2xl"></i></a>
                        <a href="#" class="text-gray-500 hover:text-pink-500 dark:hover:text-pink-400"><i class="fab fa-instagram text-2xl"></i></a>
                        <a href="#" class="text-gray-500 hover:text-blue-400 dark:hover:text-blue-300"><i class="fab fa-twitter text-2xl"></i></a>
                        <a href="#" class="text-gray-500 hover:text-red-600 dark:hover:text-red-500"><i class="fab fa-youtube text-2xl"></i></a>
                    </div>
                </div>

                <div>
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Customer Service</h3>
                    <ul class="space-y-2 text-gray-600 dark:text-gray-400">
                        <li><a href="#" class="hover:underline"><i class="fab fa-whatsapp mr-2"></i>WhatsApp</a></li>
                        <li><a href="#" class="hover:underline"><i class="fas fa-envelope mr-2"></i>Email</a></li>
                        <li><a href="#" class="hover:underline"><i class="fas fa-question-circle mr-2"></i>Pusat Bantuan</a></li>
                    </ul>
                </div>
            </div>

            <div class="mt-12 border-t border-gray-200 dark:border-gray-700 pt-6 text-center text-gray-600 dark:text-gray-400">
                <p>&copy; {{ date('Y') }} PlayPoint. Dibuat dengan ☕ dan ❤️.</p>
            </div>
        </div>
    </footer>
    
    {{-- Tambahkan jQuery untuk kemudahan AJAX --}}
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    
    @stack('scripts')
</body>
</html>