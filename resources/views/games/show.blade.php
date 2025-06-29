@extends('layouts.app')

@section('title', 'Jual Akun ' . $game->name)

@section('content')
<div class="container mx-auto p-4 sm:p-6 lg:p-8 mt-4">
    
    {{-- Judul dan Filter --}}
    <div class="flex flex-col md:flex-row justify-between items-center mb-6">
        <div>
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Akun {{ $game->name }}</h1>
            <p class="text-gray-600 dark:text-gray-400 mt-1">Menampilkan {{ $game->products->count() }} akun yang tersedia</p>
        </div>
        {{-- Nanti kita bisa menambahkan filter di sini --}}
        <div class="relative mt-4 md:mt-0">
            <select class="appearance-none bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg py-2 pl-3 pr-10 text-gray-700 dark:text-gray-200 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                <option>Urutkan: Terbaru</option>
                <option>Urutkan: Harga Terendah</option>
                <option>Urutkan: Harga Tertinggi</option>
            </select>
            <i class="fas fa-chevron-down absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 pointer-events-none"></i>
        </div>
    </div>

    {{-- Grid Daftar Produk --}}
    @if($game->products->isEmpty())
        <div class="text-center py-24 bg-white dark:bg-gray-800 rounded-lg shadow-md">
            <i class="fas fa-ghost text-5xl text-gray-400 dark:text-gray-500 mb-4"></i>
            <h3 class="text-xl font-semibold text-gray-700 dark:text-gray-300">Oops! Belum Ada Produk</h3>
            <p class="text-gray-500 dark:text-gray-400 mt-2">Belum ada akun yang dijual untuk game ini. Cek kembali nanti!</p>
        </div>
    @else
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-6">
            @foreach($game->products as $product)
                {{-- Kartu Produk --}}
                <div class="group bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden flex flex-col transition-transform duration-200 ease-in-out hover:-translate-y-1.5">
                    <a href="#">
                        <div class="aspect-w-16 aspect-h-9">
                            <img src="{{ asset($product->thumbnail_url) }}" alt="[Gambar {{ $product->name }}]" class="w-full h-full object-cover">
                        </div>
                    </a>
                    <div class="p-4 flex flex-col flex-grow">
                        <h3 class="font-bold text-lg text-gray-800 dark:text-gray-100 mb-2 h-14">{{ $product->name }}</h3>
                        <p class="flex-grow text-sm text-gray-600 dark:text-gray-400 mb-4">{{ $product->short_specs }}</p>
                        <div class="mt-auto">
                            <p class="text-xl font-bold text-blue-600 dark:text-blue-500 mb-3">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                            <a href="#" class="block text-center w-full bg-blue-600 text-white font-semibold py-2 rounded-lg hover:bg-blue-700 transition-colors">
                                Lihat Detail
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection
