{{-- Versi kode yang lebih aman untuk mencegah error --}}

@if (session()->has('success'))
    <div class="fixed top-24 right-5 bg-green-500 text-white py-2 px-4 rounded-lg shadow-lg animate-fade-in-out z-50">
        <p>{{ session('success') }}</p>
    </div>
@endif

@if (session()->has('info'))
    <div class="fixed top-24 right-5 bg-blue-500 text-white py-2 px-4 rounded-lg shadow-lg animate-fade-in-out z-50">
        <p>{{ session('info') }}</p>
    </div>
@endif

@if (session()->has('error'))
    <div class="fixed top-24 right-5 bg-red-500 text-white py-2 px-4 rounded-lg shadow-lg animate-fade-in-out z-50">
        <p>{{ session('error') }}</p>
    </div>
@endif

<style>
    .animate-fade-in-out {
        animation: fadeInOut 4s forwards;
    }
    @keyframes fadeInOut {
        0% { opacity: 0; transform: translateY(-20px); }
        15% { opacity: 1; transform: translateY(0); }
        85% { opacity: 1; transform: translateY(0); }
        100% { opacity: 0; transform: translateY(-20px); }
    }
</style>
