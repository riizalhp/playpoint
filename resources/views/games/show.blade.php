@extends('layouts.app')

@section('title', 'Jual Akun ' . $game->name)

@section('content')
<div class="container mx-auto p-4 sm:p-6 lg:p-8">
    <!-- Breadcrumbs -->
    <nav class="text-sm mb-6" aria-label="Breadcrumb">
        <ol class="list-none p-0 inline-flex">
            <li class="flex items-center">
                <a href="{{ route('home') }}" class="text-gray-500 hover:text-blue-600">Home</a>
                <i class="fas fa-chevron-right text-gray-400 mx-2"></i>
            </li>
            <li class="flex items-center">
                <span class="text-gray-800 dark:text-white">Daftar Akun {{ $game->name }}</span>
            </li>
        </ol>
    </nav>

    <div class="mb-8 text-center">
        <h1 class="text-3xl lg:text-4xl font-bold text-gray-900 dark:text-white">Daftar Akun {{ $game->name }}</h1>
        <p class="text-md text-gray-600 dark:text-gray-400 mt-2">Temukan akun {{ $game->name }} impian Anda.</p>
    </div>

    <!-- Grid Produk -->
    <div id="product-list" class="grid grid-cols-2 sm:grid-cols-2 md:grid-cols-4 lg:grid-cols-6 xl:grid-cols-6 gap-6">
        @forelse ($products as $product)
            <a href="{{ route('products.show', ['game' => $game, 'product' => $product]) }}" class="block bg-[#1E3A8A] rounded-xl shadow-md shadow-indigo-500/50 hover:shadow-xl hover:shadow-indigo-500 transition-shadow duration-300 ease-in-out overflow-hidden max-w-[250px]">
                <div class="relative aspect-[4/5]">
                    <img src="{{ $product->thumbnail_url }}" alt="Gambar Akun {{ $product->name }}" class="w-full object-cover">
                    @if($product->original_price > $product->price)
                        <span class="absolute top-2 right-2 bg-red-500 text-white text-xs font-bold px-2 py-1 rounded">SALE</span>
                    @endif
                </div>
                <div class="p-2">
                    <h3 class="font-semibold text-gray-800 dark:text-white text-[15px] truncate" title="{{ $product->name }}">{{ $product->name }}</h3>
                    
                    {{-- PERBAIKAN: Harga coret di atas harga diskon --}}
                    @if($product->original_price > $product->price)
                    <p class="text-sm text-gray-400 dark:text-gray-500 line-through">
                        Rp {{ number_format($product->original_price, 0, ',', '.') }}
                    </p>
                    @endif

                    <p class="text-yellow-300 font-bold text-lg mt-1">
                        Rp {{ number_format($product->price, 0, ',', '.') }}
                    </p>
                </div>
            </a>
        @empty
            <div class="col-span-full text-center py-12">
                <p class="text-gray-500 dark:text-gray-400 text-lg">Belum ada akun yang dijual untuk game ini.</p>
            </div>
        @endforelse
    </div>

    <div class="mt-8">
        {{ $products->links() }}
    </div>
</div>
@endsection
