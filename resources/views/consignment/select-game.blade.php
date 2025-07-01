@extends('layouts.app')

@section('title', 'Titip Jual - Pilih Game')

@section('content')
<div class="container mx-auto p-4 sm:p-6 lg:p-8">
    <div class="max-w-4xl mx-auto text-center">
        <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-2">Titip Jual Akun Anda</h1>
        <p class="text-lg text-gray-600 dark:text-gray-400 mb-8">Langkah 1: Pilih Game yang Akan Dijual</p>
    </div>

    <div class="grid grid-cols-3 sm:grid-cols-4 md:grid-cols-5 lg:grid-cols-6 gap-4 md:gap-5 max-w-5xl mx-auto">
        @foreach ($games as $game)
            <a href="{{ route('consignment.showForm', $game) }}" class="group text-center">
                <div class="aspect-square bg-white dark:bg-gray-800 rounded-xl overflow-hidden shadow-lg transition-transform duration-300 group-hover:-translate-y-1 border-2 border-transparent dark:hover:border-blue-500 hover:border-blue-500">
                    <img src="{{ asset($game->thumbnail_url) }}" alt="[Gambar {{ $game->name }}]" class="w-full h-full object-cover">
                </div>
                <p class="mt-2 text-sm font-semibold text-gray-700 dark:text-gray-300 group-hover:text-blue-600 dark:group-hover:text-blue-400 transition-colors">
                    {{ $game->name }}
                </p>
            </a>
        @endforeach
    </div>
</div>
@endsection
