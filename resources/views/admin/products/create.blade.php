@extends('layouts.admin')

@section('title', 'Tambah Produk Baru untuk ' . $game->name)

@section('content')
<h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-6">Tambah Produk: {{ $game->name }}</h1>

@if ($errors->any())
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-6" role="alert">
        <strong class="font-bold">Oops!</strong>
        <span class="block sm:inline">Ada beberapa masalah dengan input Anda.</span>
        <ul>
            @foreach ($errors->all() as $error)
                <li>- {{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form action="{{ route('admin.products.store', $game) }}" method="POST">
    @csrf
    <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-md">
        @include('admin.products._form')
    </div>
</form>
@endsection
