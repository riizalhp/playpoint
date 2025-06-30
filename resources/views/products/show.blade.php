@extends('layouts.app')

@section('title', $product->name . ' - ' . $game->name)

@section('content')
<div class="container mx-auto p-4 sm:p-6 lg:p-8">
    <nav class="text-sm mb-6" aria-label="Breadcrumb">
        <ol class="list-none p-0 inline-flex">
            <li class="flex items-center">
                <a href="{{ route('home') }}" class="text-gray-500 hover:text-blue-600">Home</a>
                <i class="fas fa-chevron-right text-gray-400 mx-2"></i>
            </li>
            <li class="flex items-center">
                <a href="{{ route('games.show', $game) }}" class="text-gray-500 hover:text-blue-600">{{ $game->name }}</a>
                <i class="fas fa-chevron-right text-gray-400 mx-2"></i>
            </li>
            <li class="flex items-center">
                <span class="text-gray-800 dark:text-white truncate max-w-xs">{{ $product->name }}</span>
            </li>
        </ol>
    </nav>

    

    <div class="grid grid-cols-1 lg:grid-cols-5 gap-8">
        <div class="lg:col-span-3">
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md border border-gray-200 dark:border-gray-700 overflow-hidden">
                <div class="bg-black">
                    <img id="main-product-image" src="{{ $product->gallery[0] ?? $product->thumbnail_url }}" alt="[Gambar Utama {{ $product->name }}]" class="w-full h-auto object-contain mx-auto">
                </div>
                
                @if(is_array($product->gallery) && count($product->gallery) > 1)
                    <div class="grid grid-cols-4 sm:grid-cols-5 gap-2 p-2">
                        @foreach($product->gallery as $image)
                        <div>
                            <img src="{{ $image }}" alt="[Pratinjau Gambar {{ $product->name }}]" class="thumbnail-image w-full h-24 object-cover rounded-md cursor-pointer border-2 border-transparent hover:border-blue-500 transition">
                        </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>

        <div class="lg:col-span-2">
            <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-md sticky top-24">
                
                <div class="mb-3">
                    @if($product->is_available)
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">
                            <i class="fas fa-check-circle mr-2"></i>Tersedia
                        </span>
                    @else
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200">
                            <i class="fas fa-times-circle mr-2"></i>Sudah Terjual
                        </span>
                    @endif
                </div>

                <h1 class="text-2xl lg:text-3xl font-bold text-gray-900 dark:text-white mb-4">{{ $product->name }}</h1>
                <div class="mb-6">
                    @if(isset($product->original_price) && $product->original_price > 0)
                    <p class="text-lg text-gray-400 dark:text-gray-500 line-through">
                        Rp {{ number_format($product->original_price, 0, ',', '.') }}
                    </p>
                    @endif
                    <p class="text-4xl font-extrabold text-blue-600 dark:text-blue-400">
                        Rp {{ number_format($product->price, 0, ',', '.') }}
                    </p>
                </div>
                
                <div class="flex flex-col gap-3">
                    <form action="{{ route('cart.buyNow', $product) }}" method="POST">
                        @csrf
                        <button type="submit" class="w-full bg-blue-600 text-white font-bold py-3 px-6 rounded-lg hover:bg-blue-700 transition-colors flex items-center justify-center disabled:bg-gray-400 disabled:cursor-not-allowed" {{ !$product->is_available ? 'disabled' : '' }}>
                            <i class="fas fa-bolt mr-2"></i> Beli Langsung
                        </button>
                    </form>
                    <form action="{{ route('cart.add', $product) }}" method="POST">
                        @csrf
                        <button type="submit" class="w-full bg-gray-200 dark:bg-gray-700 text-gray-800 dark:text-white font-bold py-3 px-6 rounded-lg hover:bg-gray-300 dark:hover:bg-gray-600 transition-colors flex items-center justify-center disabled:bg-gray-500 disabled:cursor-not-allowed" {{ !$product->is_available ? 'disabled' : '' }}>
                            <i class="fas fa-shopping-cart mr-2"></i> Tambah ke Keranjang
                        </button>
                    </form>

                    <a href="https://wa.me/6281234567890?text=Halo,%20saya%20tertarik%20dengan%20produk%20{{ urlencode($product->name) }}" target="_blank" 
                       class="w-full bg-green-500 text-white font-bold py-3 px-6 rounded-lg hover:bg-green-600 transition-colors flex items-center justify-center {{ !$product->is_available ? 'bg-gray-400 hover:bg-gray-400 cursor-not-allowed pointer-events-none' : '' }}">
                        <i class="fab fa-whatsapp mr-2"></i> Nego via WhatsApp
                    </a>
                </div>

                <div class="mt-6 border-t border-gray-200 dark:border-gray-700 pt-4 text-center">
                    <p class="text-sm text-green-600 dark:text-green-400 font-semibold"><i class="fas fa-shield-alt mr-2"></i> Garansi Admin & Transaksi Aman</p>
                </div>
            </div>
        </div>
    </div>

    <div class="mt-10 bg-white dark:bg-gray-800 p-6 rounded-lg shadow-md">
        <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-4">Detail Produk</h2>
        <div class="prose dark:prose-invert max-w-none text-gray-600 dark:text-gray-300">
            <p><strong>Spesifikasi Singkat:</strong><br>{{ $product->short_specs }}</p>
            <hr class="my-4">
            <p>{{ $product->description }}</p>
        </div>
    </div>

    @if($relatedProducts->count() > 0)
    <div class="mt-10">
        <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-6 text-center">Produk Lainnya</h2>
        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 xl:grid-cols-6 gap-4 sm:gap-6">
            @foreach($relatedProducts as $relatedProduct)
                <a href="{{ route('products.show', ['game' => $game, 'product' => $relatedProduct]) }}" class="block bg-white dark:bg-gray-800 rounded-lg shadow-md hover:shadow-xl transition-shadow duration-300 ease-in-out overflow-hidden">
                    <div class="relative">
                        <img src="{{ $relatedProduct->thumbnail_url }}" alt="Gambar Akun {{ $relatedProduct->name }}" class="w-full h-56 object-cover">
                        @if($relatedProduct->original_price > $relatedProduct->price)
                            <span class="absolute top-2 right-2 bg-red-500 text-white text-xs font-bold px-2 py-1 rounded">SALE</span>
                        @endif
                    </div>
                    <div class="p-4">
                        <h3 class="font-semibold text-gray-800 dark:text-white text-md truncate" title="{{ $relatedProduct->name }}">{{ $relatedProduct->name }}</h3>
                        
                        @if($relatedProduct->original_price > $relatedProduct->price)
                        <p class="text-sm text-gray-400 dark:text-gray-500 line-through">
                            Rp {{ number_format($relatedProduct->original_price, 0, ',', '.') }}
                        </p>
                        @endif
                        <p class="text-blue-600 dark:text-blue-400 font-bold text-lg mt-1">
                            Rp {{ number_format($relatedProduct->price, 0, ',', '.') }}
                        </p>
                    </div>
                </a>
            @endforeach
        </div>
    </div>
    @endif
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const mainImage = document.getElementById('main-product-image');
    const thumbnails = document.querySelectorAll('.thumbnail-image');

    thumbnails.forEach(thumbnail => {
        // Highlight thumbnail jika cocok dengan gambar utama
        if (mainImage.src === thumbnail.src) {
            thumbnail.classList.add('border-blue-500');
            thumbnail.classList.remove('border-transparent');
        }

        thumbnail.addEventListener('click', function() {
            mainImage.src = this.src;
            thumbnails.forEach(t => {
                t.classList.remove('border-blue-500');
                t.classList.add('border-transparent');
            });
            this.classList.add('border-blue-500');
            this.classList.remove('border-transparent');
        });
    });
});
</script>
@endpush