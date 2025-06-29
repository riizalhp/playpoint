@extends('layouts.app')

@section('title', 'PlayPoint - Jual Beli Akun Game Online Aman Terpercaya')

@section('content')
    <div class="container mx-auto p-4 sm:p-6 lg:p-8">

        <!-- Bagian Banner Iklan Slider -->
        <div class="swiper mySwiper rounded-lg shadow-lg mb-12 mt-4">
            <div class="swiper-wrapper">
                <!-- Slide 1 -->
                <div class="swiper-slide">
                    <img src="https://placehold.co/1200x400/1e40af/ffffff?text=Promo+Payday!+Cashback+90%25" class="w-full h-full object-cover" alt="[Iklan Promo 1]"/>
                </div>
                <!-- Slide 2 -->
                <div class="swiper-slide">
                    <img src="https://placehold.co/1200x400/be123c/ffffff?text=Top+Up+Game+Baru+MURAH!" class="w-full h-full object-cover" alt="[Iklan Promo 2]"/>
                </div>
                <!-- Slide 3 -->
                <div class="swiper-slide">
                    <img src="https://placehold.co/1200x400/047857/ffffff?text=Bonus+Akhir+Pekan+Gamers" class="w-full h-full object-cover" alt="[Iklan Promo 3]"/>
                </div>
            </div>
            <div class="swiper-pagination"></div>
        </div>

        <!-- Bagian Daftar Game dengan Tampilan Baru -->
        <div class="mt-8">

            <!-- AWAL: Judul dan Kolom Pencarian Sejajar -->
            <div class="flex flex-col md:flex-row justify-between items-center mb-8 gap-4">
                <h2 class="text-2xl md:text-3xl font-bold text-gray-800 dark:text-white flex-shrink-0">Pilih Game & Layanan</h2>
                {{-- Lebar maksimum diperbesar dari lg ke 2xl --}}
                <div class="relative w-full md:w-auto md:max-w-2xl">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-4">
                        <i class="fas fa-search text-gray-400"></i>
                    </span>
                    <input type="text" id="game-search-input" placeholder="Cari game favoritmu..." class="w-full pl-12 pr-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-200 focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
            </div>
            <!-- AKHIR: Judul dan Kolom Pencarian Sejajar -->
            
            @if($games->isEmpty())
                <p class="text-center text-gray-500 dark:text-gray-400">Belum ada game yang tersedia saat ini.</p>
            @else
                <div id="game-list" class="grid grid-cols-4 sm:grid-cols-5 md:grid-cols-6 lg:grid-cols-7 xl:grid-cols-8 gap-4 md:gap-5">
                    {{-- Loop untuk setiap game --}}
                    @foreach ($games as $game)
                        @php
                            // Mendefinisikan peta kata kunci untuk pencarian.
                            // Catatan: Cara terbaik adalah menyimpan ini di database,
                            // tapi untuk implementasi cepat, kita definisikan di sini.
                            $game_name_lower = strtolower($game->name);
                            $keywords_map = [
                                'mobile legends' => 'ml emel',
                                'free fire' => 'ff epep',
                                'point blank' => 'pb',
                                'fc mobile' => 'fcm ea sports ea',
                                'honor of kings' => 'hok',
                                'magic chess gogo' => 'mcgg',
                                'grand chase' => 'gc',
                                'clash of clans' => 'coc',
                                'call of duty mobile' => 'codm'
                            ];
                            $keywords = $keywords_map[$game_name_lower] ?? '';
                        @endphp
                        {{-- Atribut data-keywords sekarang berisi nama asli dan aliasnya --}}
                        <a href="{{ route('games.show', $game) }}" class="group text-center game-card" data-keywords="{{ $game_name_lower }} {{ $keywords }}">
                            <div class="aspect-square bg-gray-200 dark:bg-gray-800 rounded-xl overflow-hidden shadow-lg transition-transform duration-300 group-hover:-translate-y-1">
                                <img src="{{ asset($game->thumbnail_url) }}" alt="[Gambar {{ $game->name }}]" class="w-full h-full object-cover">
                            </div>
                            <p class="mt-2 text-sm font-semibold text-gray-700 dark:text-gray-300 group-hover:text-blue-600 dark:group-hover:text-blue-400 transition-colors">
                                {{ $game->name }}
                            </p>
                        </a>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
@endsection

@push('scripts')
<script>
    // Inisialisasi Swiper.js
    var swiper = new Swiper(".mySwiper", {
        loop: true,
        autoplay: {
            delay: 3000,
            disableOnInteraction: false,
        },
        pagination: {
            el: ".swiper-pagination",
            clickable: true,
        },
    });

    // Script untuk Live Search Game
    const searchInput = document.getElementById('game-search-input');
    const gameListContainer = document.getElementById('game-list');
    const gameCards = gameListContainer.querySelectorAll('.game-card');

    searchInput.addEventListener('keyup', function(event) {
        const searchTerm = event.target.value.toLowerCase();

        gameCards.forEach(card => {
            // Menggunakan data-keywords untuk pencarian
            const gameKeywords = card.dataset.keywords;
            if (gameKeywords.includes(searchTerm)) {
                card.style.display = 'block';
            } else {
                card.style.display = 'none';
            }
        });
    });
</script>
@endpush
