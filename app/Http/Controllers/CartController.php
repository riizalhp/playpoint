<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class CartController extends Controller
{
    /**
     * Menampilkan halaman keranjang belanja dengan perhitungan biaya admin.
     */
    public function index()
    {
        $cartItems = session()->get('cart', []);
        $products = Product::whereIn('id', array_keys($cartItems))->get();
        
        // 1. Hitung subtotal dari semua produk di keranjang
        $subtotal = 0;
        foreach ($products as $product) {
            $subtotal += $product->price;
        }
        
        // 2. Hitung biaya admin (11%)
        $adminFee = $subtotal * 0.11;
        
        // 3. Hitung total akhir
        $finalTotal = $subtotal + $adminFee;

        // Terapkan diskon voucher jika ada di sesi
        if (session()->has('voucher_discount')) {
            $finalTotal -= session('voucher_discount');
        }

        // 4. Kirim semua data ke view
        return view('cart.index', [
            'products' => $products,
            'subtotal' => $subtotal,
            'adminFee' => $adminFee,
            'finalTotal' => $finalTotal,
        ]);
    }

    /**
     * Menambahkan produk ke dalam keranjang (session).
     */
    public function add(Product $product)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$product->id])) {
            return redirect()->back()->with('info', 'Produk ini sudah ada di keranjang Anda.');
        }

        $cart[$product->id] = [
            "name" => $product->name,
            "quantity" => 1,
            "price" => $product->price,
            "thumbnail_url" => $product->thumbnail_url
        ];

        session()->put('cart', $cart);

        return redirect()->route('cart.index');
    }

    /**
     * Menghapus produk dari keranjang.
     */
    public function remove(Product $product)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$product->id])) {
            unset($cart[$product->id]);
            session()->forget('voucher_discount'); // Reset voucher saat item dihapus
            session()->forget('applied_voucher_code');
            session()->put('cart', $cart);
        }

        // Hitung ulang total setelah penghapusan
        $newCartItems = session()->get('cart', []);
        $newProducts = Product::whereIn('id', array_keys($newCartItems))->get();
        
        $newSubtotal = 0;
        foreach ($newProducts as $prod) {
            $newSubtotal += $prod->price;
        }
        
        $newAdminFee = $newSubtotal * 0.11;
        $newFinalTotal = $newSubtotal + $newAdminFee;

        // Terapkan diskon voucher jika ada di sesi (setelah reset)
        $discountAmount = 0;
        if (session()->has('voucher_discount')) {
            $discountAmount = session('voucher_discount');
            $newFinalTotal -= $discountAmount;
        }

        return response()->json([
            'success' => true,
            'message' => 'Produk berhasil dihapus dari keranjang.',
            'cartCount' => count($newCartItems),
            'subtotal' => $newSubtotal, // Kirim angka mentah
            'adminFee' => $newAdminFee, // Kirim angka mentah
            'finalTotal' => $newFinalTotal, // Kirim angka mentah
            'isEmpty' => count($newCartItems) === 0,
            'discountAmount' => $discountAmount, // Kirim angka mentah
        ]);
    }

    /**
     * Menambahkan produk ke keranjang dan langsung mengarahkan ke halaman keranjang.
     */
    public function buyNow(Product $product)
    {
        $cart = session()->get('cart', []);

        if (!isset($cart[$product->id])) {
            $cart[$product->id] = [
                "name" => $product->name,
                "quantity" => 1,
                "price" => $product->price,
                "thumbnail_url" => $product->thumbnail_url
            ];
            session()->put('cart', $cart);
        }

        return redirect()->route('cart.index');
    }

    /**
     * Memproses informasi kontak dan melanjutkan ke pembayaran.
     */
    public function processCheckout(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'phone_optional' => 'nullable|string|max:20',
        ]);

        // Simpan informasi kontak ke sesi
        session()->put('customer_info', [
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'phone_optional' => $request->phone_optional,
        ]);

        // Untuk saat ini, kita akan mengarahkan kembali ke halaman keranjang
        // Di masa depan, ini akan diarahkan ke halaman pembayaran atau ringkasan pesanan
        return redirect()->route('cart.index')->with('success', 'Informasi kontak berhasil disimpan. Lanjutkan ke pembayaran.');
    }

    /**
     * Memverifikasi kode voucher dan menerapkan diskon.
     */
    public function verifyVoucher(Request $request)
    {
        // Perubahan: Menghapus strtoupper() agar menjadi case-sensitive
        $voucherCode = $request->input('voucher_code'); 
        $cartItems = session()->get('cart', []);
        $products = Product::whereIn('id', array_keys($cartItems))->get();
        
        $subtotal = 0;
        foreach ($products as $product) {
            $subtotal += $product->price;
        }
        $adminFee = $subtotal * 0.11;
        $finalTotal = $subtotal + $adminFee;

        $discount = 0;
        $message = '';
        $success = false;

        // Logika verifikasi voucher (sekarang case-sensitive)
        if ($voucherCode === 'DISKON10') {
            $discount = $finalTotal * 0.10; // Diskon 10%
            $message = 'Voucher DISKON10 berhasil diterapkan! Anda mendapatkan diskon 10%.';
            $success = true;
        } elseif ($voucherCode === 'GRATISADMIN') {
            $discount = $adminFee; // Diskon biaya admin
            $message = 'Voucher GRATISADMIN berhasil diterapkan! Biaya admin dihapus.';
            $success = true;
        } elseif ($voucherCode === 'TEST20K') { // Voucher baru
            $discount = 20000; // Potongan harga Rp 20.000
            $message = 'Voucher TEST20K berhasil diterapkan! Anda mendapatkan potongan Rp 20.000.';
            $success = true;
        } else {
            $message = 'Kode voucher tidak valid.';
            $success = false;
        }

        // Pastikan total tidak menjadi negatif
        $finalTotal -= $discount;
        if ($finalTotal < 0) {
            $finalTotal = 0;
        }

        session()->put('voucher_discount', $discount);
        session()->put('applied_voucher_code', $voucherCode); // Simpan kode voucher yang diterapkan

        return response()->json([
            'success' => $success,
            'message' => $message,
            'subtotal' => $subtotal, // Kirim angka mentah
            'adminFee' => $adminFee, // Kirim angka mentah
            'finalTotal' => $finalTotal, // Kirim angka mentah
            'discountAmount' => $discount, // Kirim angka mentah
        ]);
    }

    /**
     * Mereset voucher yang diterapkan.
     */
    public function resetVoucher(Request $request)
    {
        session()->forget('voucher_discount');
        session()->forget('applied_voucher_code'); // Hapus kode voucher dari sesi

        $cartItems = session()->get('cart', []);
        $products = Product::whereIn('id', array_keys($cartItems))->get();
        
        $subtotal = 0;
        foreach ($products as $product) {
            $subtotal += $product->price;
        }
        $adminFee = $subtotal * 0.11;
        $finalTotal = $subtotal + $adminFee;

        return response()->json([
            'success' => true,
            'message' => 'Voucher berhasil direset.',
            'subtotal' => $subtotal, // Kirim angka mentah
            'adminFee' => $adminFee, // Kirim angka mentah
            'finalTotal' => $finalTotal, // Kirim angka mentah
            'discountAmount' => 0, // Setelah reset, diskon 0
        ]);
    }
}