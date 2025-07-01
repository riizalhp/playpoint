@extends('layouts.app')

@section('title', 'Login ke Akun Anda')

@section('content')
<div class="container mx-auto p-4 sm:p-6 lg:p-8 flex justify-center items-center" style="min-height: calc(100vh - 250px);">
    <div class="w-full max-w-md bg-white dark:bg-gray-800 p-8 rounded-lg shadow-md">
        <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-6 text-center">Login</h1>
        
        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div class="mb-4">
                <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Email</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white py-2 px-3 @error('email') border-red-500 @enderror">
                
                @error('email')
                    <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label for="password" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Password</label>
                <input id="password" type="password" name="password" required
                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white py-2 px-3">
            </div>

            <div class="flex items-center justify-between mb-6">
                <label for="remember_me" class="flex items-center">
                    <input id="remember_me" type="checkbox" name="remember" class="rounded border-gray-300 text-blue-600 shadow-sm focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600">
                    <span class="ml-2 text-sm text-gray-600 dark:text-gray-400">Ingat saya</span>
                </label>

                {{-- Tautan Lupa Password bisa ditambahkan di sini jika perlu --}}
                {{-- <a href="#" class="text-sm text-blue-600 hover:underline">Lupa password?</a> --}}
            </div>
            
            <button type="submit" class="w-full bg-blue-600 text-white font-bold py-3 rounded-lg hover:bg-blue-700 transition-colors">
                Login
            </button>
        </form>
    </div>
</div>
@endsection