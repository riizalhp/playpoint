@extends('layouts.admin')

@section('title', 'Manajemen Produk untuk ' . $game->name)

@section('content')
<div class="flex justify-between items-center mb-6">
    <div>
        <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Produk: {{ $game->name }}</h1>
        <a href="{{ route('admin.products.index') }}" class="text-sm text-blue-600 dark:text-blue-400 hover:underline">&larr; Kembali ke Pilih Game</a>
    </div>
    <a href="{{ route('admin.products.create', $game) }}" class="bg-blue-600 text-white font-semibold py-2 px-4 rounded-lg hover:bg-blue-700 transition-colors">
        <i class="fas fa-plus mr-2"></i>Tambah Produk
    </a>
</div>

<div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-md overflow-x-auto">
    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
            <tr>
                <th scope="col" class="px-6 py-3">Nama Produk</th>
                <th scope="col" class="px-6 py-3">Harga</th>
                <th scope="col" class="px-6 py-3">Status</th>
                <th scope="col" class="px-6 py-3">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($products as $product)
            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">{{ $product->name }}</th>
                <td class="px-6 py-4">Rp {{ number_format($product->price, 0, ',', '.') }}</td>
                <td class="px-6 py-4">
                    @if($product->is_available)
                        <span class="px-2 py-1 font-semibold leading-tight text-green-700 bg-green-100 rounded-full dark:bg-green-700 dark:text-green-100">Tersedia</span>
                    @else
                        <span class="px-2 py-1 font-semibold leading-tight text-red-700 bg-red-100 rounded-full dark:bg-red-700 dark:text-red-100">Terjual</span>
                    @endif
                </td>
                <td class="px-6 py-4 flex items-center gap-4">
                    <a href="{{ route('admin.products.edit', $product) }}" class="font-medium text-blue-600 dark:text-blue-500 hover:underline">Edit</a>
                    <form action="{{ route('admin.products.destroy', $product) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus produk ini?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="font-medium text-red-600 dark:text-red-500 hover:underline">Hapus</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="4" class="px-6 py-4 text-center">Belum ada produk untuk game ini.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
<div class="mt-6">
    {{ $products->links() }}
</div>
@endsection
