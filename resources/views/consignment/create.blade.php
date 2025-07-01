@extends('layouts.app')

@section('title', 'Form Titip Jual - ' . $game->name)

@section('content')
<div class="container mx-auto p-4 sm:p-6 lg:p-8">
    <div class="max-w-2xl mx-auto">
        <div class="text-center mb-8">
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Formulir Titip Jual</h1>
            <p class="text-lg text-gray-600 dark:text-gray-400">Untuk Game: <span class="font-semibold">{{ $game->name }}</span></p>
            <a href="{{ route('consignment.create') }}" class="text-sm text-blue-600 dark:text-blue-400 hover:underline">&larr; Ganti Game</a>
        </div>

        <div class="bg-white dark:bg-gray-800 p-8 rounded-lg shadow-md">
            @if(session('success'))
                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6" role="alert">
                    <p class="font-bold">Berhasil!</p>
                    <p>{{ session('success') }}</p>
                </div>
            @endif

            <form action="{{ route('consignment.store', $game) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    {{-- Data Diri --}}
                    <div class="md:col-span-2"><h3 class="text-lg font-semibold border-b pb-2 mb-4">Informasi Penjual</h3></div>
                    <div>
                        <label for="seller_name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Nama Lengkap</label>
                        <input type="text" name="seller_name" id="seller_name" value="{{ old('seller_name') }}" required class="block w-full input-style">
                    </div>
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Email</label>
                        <input type="email" name="email" id="email" value="{{ old('email') }}" required class="block w-full input-style">
                    </div>
                    <div>
                        <label for="contact_whatsapp" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Nomor WA</label>
                        <input type="text" name="contact_whatsapp" id="contact_whatsapp" value="{{ old('contact_whatsapp') }}" required class="block w-full input-style">
                    </div>
                    <div>
                        <label for="contact_whatsapp_optional" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Nomor WA Opsional</label>
                        <input type="text" name="contact_whatsapp_optional" id="contact_whatsapp_optional" value="{{ old('contact_whatsapp_optional') }}" class="block w-full input-style">
                    </div>

                    {{-- Alamat --}}
                    <div class="md:col-span-2"><h3 class="text-lg font-semibold border-b pb-2 mb-4 mt-4">Alamat</h3></div>
                    <div>
                        <label for="province" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Provinsi</label>
                        <select name="province" id="province" required class="block w-full input-style">
                            <option value="">Pilih Provinsi</option>
                            @foreach($provinces as $province)
                                <option value="{{ $province }}" {{ old('province') == $province ? 'selected' : '' }}>{{ $province }}</option>
                            @endforeach
                        </select>
                    </div>
                     <div>
                        <label for="city" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Kota/Kabupaten</label>
                        <select name="city" id="city" required class="block w-full input-style" disabled>
                            <option value="">Pilih Provinsi Dulu</option>
                        </select>
                    </div>
                    <div class="md:col-span-2">
                        <label for="address" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Alamat Lengkap</label>
                        <textarea name="address" id="address" rows="3" required class="block w-full input-style">{{ old('address') }}</textarea>
                    </div>
                     <div>
                        <label for="postal_code" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Kode Pos</label>
                        <input type="text" name="postal_code" id="postal_code" value="{{ old('postal_code') }}" required class="block w-full input-style">
                    </div>

                    {{-- Detail Akun --}}
                    <div class="md:col-span-2"><h3 class="text-lg font-semibold border-b pb-2 mb-4 mt-4">Informasi Akun</h3></div>
                    <div class="md:col-span-2">
                        <label for="account_details" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Detail Akun</label>
                        <textarea name="account_details" id="account_details" rows="5" required class="block w-full input-style">{{ old('account_details') }}</textarea>
                    </div>
                    <div class="md:col-span-2">
                        <label for="account_images" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Gambar Akun (Maks. 5 Gambar)</label>
                        <input type="file" name="account_images[]" id="account_images" multiple accept="image/*" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                        <div id="image-preview-container" class="mt-4 grid grid-cols-3 sm:grid-cols-5 gap-4"></div>
                    </div>
                    
                    {{-- Input Harga --}}
                    <div>
                        <label for="price_low_display" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Harga Terendah</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-500">Rp</span>
                            <input type="text" id="price_low_display" placeholder="0" class="block w-full pl-9 input-style">
                        </div>
                        <input type="hidden" name="price_low" id="price_low" value="{{ old('price_low') }}">
                        <p id="price-error" class="text-red-500 text-xs mt-1 hidden">Harga terendah harus lebih kecil dari Harga tertinggi.</p>
                    </div>
                    <div>
                        <label for="price_high_display" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Harga Tertinggi</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-500">Rp</span>
                            <input type="text" id="price_high_display" placeholder="0" class="block w-full pl-9 input-style">
                        </div>
                        <input type="hidden" name="price_high" id="price_high" value="{{ old('price_high') }}">
                    </div>
                </div>

                {{-- Syarat & Ketentuan --}}
                <div class="mt-6">
                    <div class="flex items-start">
                        <div class="flex items-center h-5">
                            <input id="terms" name="terms" type="checkbox" required class="focus:ring-blue-500 h-4 w-4 text-blue-600 border-gray-300 rounded">
                        </div>
                        <div class="ml-3 text-sm">
                            <label for="terms" class="font-medium text-gray-700 dark:text-gray-300">Saya menyetujui</label>
                            <button type="button" id="open-terms-modal" class="text-blue-600 hover:underline">Syarat & Ketentuan</button>
                            <p class="text-gray-500">yang berlaku.</p>
                        </div>
                    </div>
                     @error('terms') <span class="text-red-500 text-sm">Anda harus menyetujui Syarat & Ketentuan.</span> @enderror
                </div>

                <div class="mt-8">
                    <button type="submit" id="submit-button" class="w-full bg-blue-600 text-white font-bold py-3 rounded-lg hover:bg-blue-700 transition-colors disabled:bg-gray-400" disabled>
                        Kirim Permintaan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Syarat & Ketentuan -->
<div id="terms-modal" class="fixed z-10 inset-0 overflow-y-auto hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
        <div class="inline-block align-bottom bg-white dark:bg-gray-800 rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
            <div class="bg-white dark:bg-gray-800 px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-white" id="modal-title">Syarat & Ketentuan Titip Jual</h3>
                <div id="terms-content" class="mt-4 max-h-64 overflow-y-scroll pr-4 text-sm text-gray-600 dark:text-gray-400 space-y-2">
                    <p><strong>1. Keaslian Akun:</strong> ...</p>
                </div>
            </div>
            <div class="bg-gray-50 dark:bg-gray-700 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                <button type="button" id="close-terms-modal" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-600 text-base font-medium text-white hover:bg-blue-700 sm:ml-3 sm:w-auto sm:text-sm">
                    Saya Mengerti
                </button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<style>
.input-style {
    padding: 0.75rem 1rem;
    border-radius: 0.5rem;
    border: 1px solid #D1D5DB;
    box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
    transition: border-color 0.2s ease-in-out, box-shadow 0.2s ease-in-out;
}
.input-style:focus {
    border-color: #3B82F6;
    box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.3);
    outline: none;
}
.dark .input-style {
    background-color: #374151;
    border-color: #4B5563;
    color: #F9FAFB;
}
.dark .input-style:focus {
    border-color: #60A5FA;
    box-shadow: 0 0 0 3px rgba(96, 165, 250, 0.3);
}
/* PERBAIKAN: Padding kiri untuk input dengan ikon Rp */
.pl-9 {
    padding-left: 2.25rem;
}
</style>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const provinceSelect = document.getElementById('province');
    const citySelect = document.getElementById('city');
    const termsCheckbox = document.getElementById('terms');
    const submitButton = document.getElementById('submit-button');
    const modal = document.getElementById('terms-modal');
    const openModalBtn = document.getElementById('open-terms-modal');
    const closeModalBtn = document.getElementById('close-terms-modal');
    
    provinceSelect.addEventListener('change', function() {
        const selectedProvince = this.value;
        citySelect.innerHTML = '<option value="">Memuat...</option>';
        citySelect.disabled = true;

        if (selectedProvince) {
            fetch(`{{ route('api.cities') }}?province=${selectedProvince}`)
                .then(response => response.json())
                .then(data => {
                    citySelect.innerHTML = '<option value="">Pilih Kota/Kabupaten</option>';
                    data.forEach(city => {
                        const option = new Option(city, city);
                        citySelect.add(option);
                    });
                    citySelect.disabled = false;
                })
                .catch(error => {
                    console.error('Error fetching cities:', error);
                    citySelect.innerHTML = '<option value="">Gagal memuat kota</option>';
                });
        } else {
            citySelect.innerHTML = '<option value="">Pilih Provinsi Dulu</option>';
        }
    });

    function checkSubmitButton() {
        submitButton.disabled = !termsCheckbox.checked;
    }
    termsCheckbox.addEventListener('change', checkSubmitButton);
    openModalBtn.addEventListener('click', () => modal.classList.remove('hidden'));
    closeModalBtn.addEventListener('click', () => modal.classList.add('hidden'));

    // --- Logika untuk Preview Gambar ---
    const imageInput = document.getElementById('account_images');
    const previewContainer = document.getElementById('image-preview-container');

    imageInput.addEventListener('change', function() {
        previewContainer.innerHTML = '';
        const files = this.files;

        if (files.length > 5) {
            alert('Anda hanya bisa mengunggah maksimal 5 gambar.');
            this.value = '';
            return;
        }

        for (const file of files) {
            if (file) {
                const reader = new FileReader();
                const previewWrapper = document.createElement('div');
                previewWrapper.className = 'relative w-full h-24';
                const img = document.createElement('img');
                img.className = 'w-full h-full object-cover rounded-lg shadow-md';
                reader.onload = function(e) {
                    img.src = e.target.result;
                }
                reader.readAsDataURL(file);
                previewWrapper.appendChild(img);
                previewContainer.appendChild(previewWrapper);
            }
        }
    });

    // --- Logika untuk Format Harga ---
    const priceLowDisplay = document.getElementById('price_low_display');
    const priceLowHidden = document.getElementById('price_low');
    const priceHighDisplay = document.getElementById('price_high_display');
    const priceHighHidden = document.getElementById('price_high');
    const priceError = document.getElementById('price-error');

    function formatNumber(num) {
        return num.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1.');
    }

    function setupPriceInput(displayInput, hiddenInput) {
        if (hiddenInput.value) {
            displayInput.value = formatNumber(hiddenInput.value);
        }
        displayInput.addEventListener('input', function(e) {
            let rawValue = e.target.value.replace(/[^0-9]/g, '');
            hiddenInput.value = rawValue;
            e.target.value = rawValue ? formatNumber(rawValue) : '';
            validatePriceRange();
        });
    }

    function validatePriceRange() {
        const low = parseInt(priceLowHidden.value, 10);
        const high = parseInt(priceHighHidden.value, 10);

        if (!isNaN(low) && !isNaN(high) && low > high) {
            priceError.classList.remove('hidden');
            submitButton.disabled = true;
        } else {
            priceError.classList.add('hidden');
            checkSubmitButton();
        }
    }

    setupPriceInput(priceLowDisplay, priceLowHidden);
    setupPriceInput(priceHighDisplay, priceHighHidden);
    
    checkSubmitButton();
});
</script>
@endpush
