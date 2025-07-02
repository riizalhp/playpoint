@extends('layouts.app')

@section('title', 'Login ke Akun Anda')

@section('content')
<div class="container mx-auto p-4 sm:p-6 lg:p-8 flex justify-center items-center" style="min-height: calc(100vh - 250px);">
    <div class="w-full max-w-md p-8 rounded-lg shadow-md" style="background-color: var(--color-base)">
        <h1 class="text-3xl font-bold mb-6 text-center" style="color: var(--color-primary)">Login</h1>
        
        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div class="mb-4">
                <label for="email" class="block text-sm font-medium" style="color: var(--color-primary)">Email</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-accent focus:ring-accent dark:bg-gray-700 dark:border-gray-600 dark:text-white py-2 px-3 @error('email') border-red-500 @enderror">
                
                @error('email')
                    <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label for="password" class="block text-sm font-medium" style="color: var(--color-primary)">Password</label>
                <input id="password" type="password" name="password" required
                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-accent focus:ring-accent dark:bg-gray-700 dark:border-gray-600 dark:text-white py-2 px-3">
            </div>

            <div class="flex items-center justify-between mb-6">
                <label for="remember_me" class="flex items-center">
                    <input id="remember_me" type="checkbox" name="remember" class="rounded border-gray-300 shadow-sm focus:ring-accent dark:bg-gray-700 dark:border-gray-600" style="color: var(--color-accent)">
                    <span class="ml-2 text-sm text-gray-600 dark:text-gray-400">Ingat saya</span>
                </label>

                {{-- Tautan Lupa Password bisa ditambahkan di sini jika perlu --}}
                {{-- <a href="#" class="text-sm hover:underline" style="color: var(--color-accent)">Lupa password?</a> --}}
            </div>
            
            <button type="submit" class="w-full text-white font-bold py-3 rounded-lg hover:bg-opacity-90 transition-colors" style="background-color: var(--color-accent)">
                Login
            </button>
        </form>
    </div>
</div>
@endsection