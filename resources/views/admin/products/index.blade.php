@extends('layouts.admin')

@section('title', 'Pilih Game untuk Dikelola')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Kelola Produk</h1>
</div>

<!-- Form Pencarian -->
<div class="mb-8">
    <form action="{{ route('admin.products.index') }}" method="GET">
        <div class="relative">
            <span class="absolute inset-y-0 left-0 flex items-center pl-4">
                <i class="fas fa-search text-gray-400"></i>
            </span>
            <input type="text" name="search" placeholder="Cari nama game..." value="{{ request('search') }}"
                   class="w-full pl-12 pr-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-200 focus:outline-none focus:ring-2 focus:ring-blue-500">
        </div>
    </form>
</div>

<!-- Daftar Game -->
<div class="bg-white dark:bg-gray-800 rounded-lg shadow-md">
    <div class="divide-y divide-gray-200 dark:divide-gray-700">
        @forelse ($games as $game)
            <a href="{{ route('admin.products.listByGame', $game) }}" class="flex justify-between items-center p-4 hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors duration-200">
                <p class="font-semibold text-gray-800 dark:text-white">{{ $game->name }}</p>
                <i class="fas fa-chevron-right text-gray-400"></i>
            </a>
        @empty
            <div class="p-4 text-center text-gray-500 dark:text-gray-400">
                Tidak ada game yang cocok dengan pencarian Anda.
            </div>
        @endforelse
    </div>
</div>
@endsection
