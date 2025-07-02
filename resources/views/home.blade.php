@extends('layouts.app')

@section('title', 'PlayPoint - Jual Beli Akun Game Online Aman Terpercaya')

@section('content')
    <div class="container mx-auto p-4 sm:p-6 lg:p-8">

        <!-- Bagian Banner Iklan Slider -->
        <div class="swiper mySwiper rounded-lg shadow-lg mb-12 mt-4">
            <div class="swiper-wrapper">
                <!-- Slide 1 -->
                <div class="swiper-slide">
                    <img src="https://placehold.co/1200x400/0C2A47/ffffff?text=Promo+Payday!+Cashback+90%25" class="w-full h-full object-cover" alt="[Iklan Promo 1]"/>
                </div>
                <!-- Slide 2 -->
                <div class="swiper-slide">
                    <img src="https://placehold.co/1200x400/4DBCBE/ffffff?text=Top+Up+Game+Baru+MURAH!" class="w-full h-full object-cover" alt="[Iklan Promo 2]"/>
                </div>
                <!-- Slide 3 -->
                <div class="swiper-slide">
                    <img src="https://placehold.co/1200x400/FEC601/0C2A47?text=Bonus+Akhir+Pekan+Gamers" class="w-full h-full object-cover" alt="[Iklan Promo 3]"/>
                </div>
            </div>
            <div class="swiper-pagination"></div>
        </div>

        <!-- Bagian Daftar Game dengan Tampilan Baru -->
        <div class="mt-8">

            <!-- AWAL: Judul dan Kolom Pencarian Sejajar -->
            <div class="flex flex-col md:flex-row justify-between items-center mb-8 gap-4">
                <h2 class="text-2xl md:text-3xl font-bold flex-shrink-0" style="color: var(--color-primary)">Pilih Game & Layanan</h2>
                {{-- Lebar maksimum diperbesar dari lg ke 2xl --}}
                <div class="relative w-full md:w-auto md:max-w-2xl">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-4">
                        <i class="fas fa-search text-gray-400"></i>
                    </span>
                    <input type="text" id="game-search-input" placeholder="Cari game favoritmu..." class="w-full pl-12 pr-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2" style="background-color: var(--color-base); color: var(--color-primary); --focus-ring-color: var(--color-accent)">
                </div>
            </div>
            <!-- AKHIR: Judul dan Kolom Pencarian Sejajar -->
            
            @if($games->isEmpty())
                <p class="text-center text-gray-500">Belum ada game yang tersedia saat ini.</p>
            @else
                <div id="game-list" class="grid grid-cols-2 sm:grid-cols-2 md:grid-cols-4 lg:grid-cols-6 xl:grid-cols-6 gap-6">
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
                        <a href="{{ route('games.show', $game) }}" class="group relative text-center game-card overflow-hidden rounded-xl max-w-[250px]" data-keywords="{{ $game_name_lower }} {{ $keywords }}">
                            <div class="aspect-[4/5] bg-[#1E293B] rounded-xl overflow-hidden shadow-lg shadow-indigo-500/50 transition-transform duration-300 group-hover:-translate-y-1">
                                <img src="{{ asset($game->thumbnail_url) }}" alt="[Gambar {{ $game->name }}]" class="w-full object-cover transition-all duration-300 group-hover:blur-sm">
                                <div class="absolute inset-0 flex items-center justify-center bg-black bg-opacity-50 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                    <img src="{{ asset('images/play-point-logo.png') }}" alt="PlayPoint Logo" class="h-16 w-auto">
                                </div>
                            </div>
                            <p class="mt-2 text-[15px] font-semibold transition-colors text-white">
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
