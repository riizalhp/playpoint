<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    {{-- Mengubah teks title default --}}
    <title>@yield('title', 'PlayPoint - Jual Beli Akun Game Online')</title>
    
    {{-- Menambahkan favicon --}}
    <link rel="icon" type="image/png" href="{{ asset('images/play-point-logo.png') }}">


    <!-- Google Fonts & FontAwesome -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    
    <!-- Swiper's CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css"/>
    
    <!-- Style Utama -->
    <style>
        body { font-family: 'Inter', sans-serif; transition: background-color 0.3s ease, color 0.3s ease; }
    </style>

    <!-- Tailwind CSS dengan Konfigurasi (FIX) -->
    <script>
        tailwind.config = {
            darkMode: 'class', // Memberitahu Tailwind untuk menggunakan mode gelap berbasis class
        }
    </script>
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Script Logika Dark Mode (Ditempatkan di akhir <head>) -->
    <script>
        // Fungsi untuk memperbarui ikon berdasarkan tema
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

        // Fungsi untuk mengganti tema
        function toggleTheme() {
            const html = document.documentElement;
            html.classList.toggle('dark');
            localStorage.theme = html.classList.contains('dark') ? 'dark' : 'light';
            updateThemeIcons();
        }

        // Terapkan tema awal saat halaman pertama kali dimuat (mencegah kedipan)
        if (localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
        
        // Pastikan ikon diperbarui setelah semua elemen halaman siap
        document.addEventListener('DOMContentLoaded', updateThemeIcons);
    </script>
</head>
<body class="bg-gray-50 dark:bg-gray-900 text-gray-800 dark:text-gray-200 antialiased">

    <!-- Header / Navigation Bar -->
    <header class="bg-white dark:bg-gray-800 shadow-md dark:shadow-gray-700/50 sticky top-0 z-50">
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
                    <a href="#" class="text-gray-500 dark:text-gray-400 hover:text-gray-800 dark:hover:text-white"><i class="fas fa-shopping-cart text-xl"></i></a>
                    <a href="#" class="bg-blue-600 text-white font-semibold py-2 px-4 rounded-lg hover:bg-blue-700 transition-colors">Login</a>
                </div>
            </div>
        </nav>
    </header>

    <main>
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-white dark:bg-gray-800 border-t border-gray-200 dark:border-gray-700 mt-12">
        <div class="container mx-auto py-6 px-4 sm:px-6 lg:px-8 text-center text-gray-600 dark:text-gray-400">
            <p>&copy; {{ date('Y') }} PlayPoint. Dibuat dengan cinta.</p>
        </div>
    </footer>
    
    <!-- Swiper's JS -->
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    
    @stack('scripts')
</body>
</html>
