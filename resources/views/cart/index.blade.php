@extends('layouts.app')

@section('title', 'Keranjang Belanja')

@section('content')
<div class="container mx-auto p-4 sm:p-6 lg:p-8">
    <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-6">Keranjang Belanja Anda</h1>

    @if(!empty($products) && count($products) > 0)
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8" id="cart-content">
            {{-- Daftar Item di Keranjang --}}
            <div class="lg:col-span-2 bg-white dark:bg-gray-800 p-6 rounded-lg shadow-md">
                <h2 class="text-xl font-bold mb-4" id="cart-items-count">Item di Keranjang ({{ count($products) }})</h2>
                <div id="cart-items-list">
                    @foreach($products as $product)
                        <div class="flex items-center justify-between py-4 border-b border-gray-200 dark:border-gray-700 last:border-b-0" id="cart-item-{{ $product->id }}">
                            <div class="flex items-center gap-4">
                                <a href="{{ route('products.show', ['game' => $product->game, 'product' => $product]) }}">
                                    <img src="{{ $product->thumbnail_url }}" alt="{{ $product->name }}" class="w-16 h-16 sm:w-20 sm:h-20 object-cover rounded-md">
                                </a>
                                <div>
                                    <a href="{{ route('products.show', ['game' => $product->game, 'product' => $product]) }}" class="font-semibold text-lg text-gray-800 dark:text-gray-200 hover:text-blue-600">{{ $product->name }}</a>
                                    <p class="text-blue-500 font-bold">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                                </div>
                            </div>
                            {{-- Tombol Hapus Item --}}
                            <form class="remove-from-cart-form" data-product-id="{{ $product->id }}" action="{{ route('cart.remove', $product) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-500 hover:text-red-700 transition-colors" title="Hapus item">
                                    <i class="fas fa-trash-alt text-xl"></i>
                                </button>
                            </form>
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- Ringkasan Pesanan & Informasi Kontak --}}
            <div class="lg:col-span-1">
                <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-md sticky top-24" id="order-summary">
                    <h2 class="text-xl font-bold border-b pb-4 mb-4">Ringkasan Pesanan</h2>
                    
                    <div class="space-y-3">
                        <div class="flex justify-between items-center">
                            <span class="text-gray-600 dark:text-gray-300 whitespace-nowrap">Total Harga (<span id="summary-item-count">{{ count($products) }}</span> item)</span>
                            <span class="font-bold text-right" id="summary-subtotal">Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-gray-600 dark:text-gray-300">Biaya Admin (11%)</span>
                            <span class="font-bold text-right" id="summary-admin-fee">Rp {{ number_format($adminFee, 0, ',', '.') }}</span>
                        </div>
                        {{-- Tambahkan input voucher dengan tombol verifikasi dan reset --}}
                        <div class="flex items-center justify-between">
                            <span class="text-gray-600 dark:text-gray-300">Voucher</span>
                            <div class="flex-grow flex items-center ml-4">
                                <input type="text" name="voucher_code" id="voucher_code" placeholder="Kode Voucher" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white text-sm py-2 px-3" value="{{ session('applied_voucher_code') ?? '' }}" {{ session()->has('voucher_discount') ? 'readonly' : '' }}>
                                <button type="button" id="verify-voucher-btn" class="ml-2 bg-green-500 text-white text-sm px-4 py-2 rounded-md hover:bg-green-600 transition-colors {{ session()->has('voucher_discount') ? 'hidden' : '' }}">Verifikasi</button>
                                <button type="button" id="reset-voucher-btn" class="ml-2 bg-red-500 text-white text-sm px-4 py-2 rounded-md hover:bg-red-600 transition-colors {{ session()->has('voucher_discount') ? '' : 'hidden' }}">Reset</button>
                            </div>
                        </div>
                        <div id="voucher-message" class="text-sm text-right mt-1 {{ session('voucher_message_class') ?? '' }}">{{ session('voucher_message') ?? '' }}</div>
                        
                        {{-- Baris Diskon Voucher --}}
                        @if(session()->has('voucher_discount') && session('voucher_discount') > 0)
                        <div class="flex justify-between items-center text-green-600 dark:text-green-400 font-bold" id="voucher-discount-row">
                            <span>Diskon Voucher</span>
                            <span id="summary-voucher-discount">- Rp {{ number_format(session('voucher_discount'), 0, ',', '.') }}</span>
                        </div>
                        @else
                        <div class="flex justify-between items-center text-green-600 dark:text-green-400 font-bold hidden" id="voucher-discount-row">
                            <span>Diskon Voucher</span>
                            <span id="summary-voucher-discount"></span>
                        </div>
                        @endif
                    </div>

                    <div class="flex justify-between items-center font-extrabold text-xl border-t pt-4 mt-4">
                        <span>Total Pembayaran</span>
                        <span class="text-right" id="summary-final-total">Rp {{ number_format($finalTotal, 0, ',', '.') }}</span>
                    </div>

                    {{-- Formulir Informasi Kontak --}}
                    <h2 class="text-xl font-bold border-b pb-4 mb-4 mt-8">Informasi Kontak</h2>
                    <form action="{{ route('cart.processCheckout') }}" method="POST">
                        @csrf
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-4">
                            <div>
                                <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Nama Lengkap</label>
                                <input type="text" name="name" id="name" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white py-2 px-3" required>
                            </div>
                            <div>
                                <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Email</label>
                                <input type="email" name="email" id="email" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white py-2 px-3" required>
                            </div>
                        </div>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-6">
                            <div>
                                <label for="phone" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Nomor WA</label>
                                <input type="tel" name="phone" id="phone" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white py-2 px-3" required>
                            </div>
                            <div>
                                <label for="phone_optional" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Nomor WA Lain (Opsional)</label>
                                <input type="tel" name="phone_optional" id="phone_optional" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white py-2 px-3">
                            </div>
                        </div>
                        
                        <button type="submit" class="w-full mt-6 bg-blue-600 text-white font-bold py-3 rounded-lg hover:bg-blue-700 transition-colors">
                            Lanjut ke Pembayaran
                        </button>
                    </form>
                </div>
            </div>
        </div>
    @else
        {{-- Tampilan Keranjang Kosong --}}
        <div class="text-center py-24 bg-white dark:bg-gray-800 rounded-lg shadow-md" id="empty-cart-message">
            <i class="fas fa-shopping-cart text-5xl text-gray-400 dark:text-gray-500 mb-4"></i>
            <h3 class="text-xl font-semibold text-gray-700 dark:text-gray-300">Keranjang Anda Masih Kosong</h3>
            <p class="text-gray-500 dark:text-gray-400 mt-2">Ayo cari akun game impianmu sekarang!</p>
            <a href="{{ route('home') }}" class="mt-6 inline-block bg-blue-600 text-white font-semibold py-2 px-6 rounded-lg hover:bg-blue-700 transition-colors">
                Mulai Belanja
            </a>
        </div>
    @endif
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    // Setup AJAX untuk menyertakan CSRF token
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    // Fungsi untuk memperbarui badge keranjang di header
    function updateCartBadge(count) {
        const badge = $('#cart-count-badge');
        if (count > 0) {
            badge.text(count).removeClass('hidden');
        } else {
            badge.text(0).addClass('hidden');
        }
    }

    // Fungsi untuk memperbarui ringkasan pesanan
    function updateOrderSummary(data) {
        $('#summary-subtotal').text('Rp ' + formatRupiah(data.subtotal));
        $('#summary-admin-fee').text('Rp ' + formatRupiah(data.adminFee));
        $('#summary-final-total').text('Rp ' + formatRupiah(data.finalTotal));

        const voucherDiscountRow = $('#voucher-discount-row');
        const summaryVoucherDiscount = $('#summary-voucher-discount');

        // data.discountAmount sekarang adalah angka mentah dari backend
        if (data.discountAmount && data.discountAmount > 0) {
            summaryVoucherDiscount.text('- Rp ' + formatRupiah(data.discountAmount));
            voucherDiscountRow.removeClass('hidden');
        } else {
            voucherDiscountRow.addClass('hidden');
            summaryVoucherDiscount.text('');
        }
    }

    // Fungsi untuk format angka ke Rupiah (lebih robust)
    function formatRupiah(angka) {
        var number_string = angka.toString(),
            sisa = number_string.length % 3,
            rupiah = number_string.substr(0, sisa),
            ribuan = number_string.substr(sisa).match(/\d{3}/g);

        if (ribuan) {
            let separator = sisa ? '.' : '';
            rupiah += separator + ribuan.join('.');
        }

        return rupiah;
    }

    // Tangani submit form hapus item dari keranjang
    $('.remove-from-cart-form').on('submit', function(e) {
        e.preventDefault(); // Cegah refresh halaman

        const form = $(this);
        const productId = form.data('product-id');
        const url = form.attr('action');

        $.ajax({
            url: url,
            type: 'POST',
            data: form.serialize(), // Kirim data form (termasuk CSRF token dan _method)
            success: function(response) {
                if (response.success) {
                    // Hapus item dari DOM
                    $('#cart-item-' + productId).remove();

                    // Perbarui jumlah item di keranjang
                    $('#cart-items-count').text('Item di Keranjang (' + response.cartCount + ')');
                    $('#summary-item-count').text(response.cartCount);

                    // Perbarui ringkasan pesanan
                    updateOrderSummary(response);

                    // Perbarui badge keranjang di header
                    updateCartBadge(response.cartCount);

                    // Tampilkan pesan keranjang kosong jika tidak ada item
                    if (response.isEmpty) {
                        $('#cart-content').addClass('hidden');
                        $('#empty-cart-message').removeClass('hidden');
                    }

                    // Reset voucher jika item terakhir dihapus atau jika voucher tidak lagi valid
                    if (response.cartCount === 0 || response.discountAmount === 0) {
                        $('#voucher_code').val('').prop('readonly', false);
                        $('#verify-voucher-btn').removeClass('hidden');
                        $('#reset-voucher-btn').addClass('hidden');
                        $('#voucher-message').text('').removeClass('text-green-600 text-red-600');
                    }
                }
            },
            error: function(xhr) {
                console.error('Error removing item from cart:', xhr.responseText);
                alert('Terjadi kesalahan saat menghapus produk.');
            }
        });
    });

    // Tangani klik tombol Verifikasi Voucher
    $('#verify-voucher-btn').on('click', function() {
        const voucherCode = $('#voucher_code').val();
        const messageDiv = $('#voucher-message');
        const resetButton = $('#reset-voucher-btn');
        const verifyButton = $('#verify-voucher-btn');

        if (voucherCode.trim() === '') {
            messageDiv.text('Kode voucher tidak boleh kosong.').removeClass('text-green-600').addClass('text-red-600');
            return;
        }

        $.ajax({
            url: "{{ route('cart.verifyVoucher') }}",
            type: 'POST',
            data: {
                voucher_code: voucherCode
            },
            success: function(response) {
                if (response.success) {
                    messageDiv.text(response.message).removeClass('text-red-600').addClass('text-green-600');
                    updateOrderSummary(response);
                    resetButton.removeClass('hidden');
                    verifyButton.addClass('hidden'); // Sembunyikan tombol verifikasi
                    $('#voucher_code').prop('readonly', true);
                } else {
                    messageDiv.text(response.message).removeClass('text-green-600').addClass('text-red-600');
                    resetButton.addClass('hidden');
                    verifyButton.removeClass('hidden'); // Tampilkan tombol verifikasi
                    $('#voucher_code').prop('readonly', false);
                }
            },
            error: function(xhr) {
                console.error('Error verifying voucher:', xhr.responseText);
                messageDiv.text('Terjadi kesalahan saat verifikasi voucher.').removeClass('text-green-600').addClass('text-red-600');
                resetButton.addClass('hidden');
                verifyButton.removeClass('hidden'); // Tampilkan tombol verifikasi
                $('#voucher_code').prop('readonly', false);
            }
        });
    });

    // Tangani klik tombol Reset Voucher
    $('#reset-voucher-btn').on('click', function() {
        const messageDiv = $('#voucher-message');
        const resetButton = $('#reset-voucher-btn');
        const verifyButton = $('#verify-voucher-btn');

        $.ajax({
            url: "{{ route('cart.resetVoucher') }}",
            type: 'POST',
            success: function(response) {
                if (response.success) {
                    messageDiv.text('').removeClass('text-green-600 text-red-600');
                    $('#voucher_code').val('').prop('readonly', false);
                    updateOrderSummary(response);
                    resetButton.addClass('hidden');
                    verifyButton.removeClass('hidden'); // Tampilkan tombol verifikasi
                }
            },
            error: function(xhr) {
                console.error('Error resetting voucher:', xhr.responseText);
                alert('Terjadi kesalahan saat mereset voucher.');
            }
        });
    });

    // Inisialisasi tampilan tombol saat halaman dimuat
    const initialVoucherCode = $('#voucher_code').val();
    // Periksa apakah ada diskon voucher yang diterapkan dari sesi
    const hasVoucherDiscount = parseFloat('{{ session('voucher_discount') ?? 0 }}') > 0;

    if (initialVoucherCode.trim() !== '' && hasVoucherDiscount) {
        $('#verify-voucher-btn').addClass('hidden');
        $('#reset-voucher-btn').removeClass('hidden');
        $('#voucher_code').prop('readonly', true);
    } else {
        $('#verify-voucher-btn').removeClass('hidden');
        $('#reset-voucher-btn').addClass('hidden');
        $('#voucher_code').prop('readonly', false);
    }
});
</script>
@endpush