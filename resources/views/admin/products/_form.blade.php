<div class="grid grid-cols-1 md:grid-cols-2 gap-6">
    <div>
        <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Nama Produk</label>
        <input type="text" name="name" id="name" value="{{ old('name', $product->name ?? '') }}" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white py-2 px-3">
    </div>
    <div>
        <label for="price" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Harga Jual (Rp)</label>
        <input type="number" name="price" id="price" value="{{ old('price', $product->price ?? '') }}" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white py-2 px-3">
    </div>
    <div class="md:col-span-2">
        <label for="original_price" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Harga Asli (Coret) (Opsional)</label>
        <input type="number" name="original_price" id="original_price" value="{{ old('original_price', $product->original_price ?? '') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white py-2 px-3">
    </div>
</div>
<div class="mt-6">
    <label for="short_specs" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Spesifikasi Singkat</label>
    <textarea name="short_specs" id="short_specs" rows="3" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">{{ old('short_specs', $product->short_specs ?? '') }}</textarea>
</div>
<div class="mt-6">
    <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Deskripsi Lengkap</label>
    <textarea name="description" id="description" rows="5" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">{{ old('description', $product->description ?? '') }}</textarea>
</div>
<div class="mt-6">
    <label for="thumbnail_url" class="block text-sm font-medium text-gray-700 dark:text-gray-300">URL Gambar Utama (Thumbnail)</label>
    <input type="url" name="thumbnail_url" id="thumbnail_url" value="{{ old('thumbnail_url', $product->thumbnail_url ?? '') }}" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white py-2 px-3">
</div>
<div class="mt-6">
    <label for="gallery" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Galeri Gambar (JSON Array)</label>
    <textarea name="gallery" id="gallery" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">{{ old('gallery', isset($product) ? json_encode($product->gallery, JSON_PRETTY_PRINT) : '[]') }}</textarea>
    <p class="mt-2 text-xs text-gray-500 dark:text-gray-400">Contoh: ["url_gambar_1.jpg", "url_gambar_2.jpg"]</p>
</div>
<div class="mt-6">
    <label for="is_available" class="flex items-center">
        <input type="hidden" name="is_available" value="0">
        <input type="checkbox" name="is_available" id="is_available" value="1" class="rounded border-gray-300 text-blue-600 shadow-sm focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600" {{ old('is_available', $product->is_available ?? true) ? 'checked' : '' }}>
        <span class="ml-2 text-sm text-gray-600 dark:text-gray-400">Tersedia untuk dijual</span>
    </label>
</div>

<div class="mt-8 flex justify-end gap-4">
    <a href="{{ isset($product) ? route('admin.products.listByGame', $product->game) : route('admin.products.index') }}" class="bg-gray-200 dark:bg-gray-600 text-gray-800 dark:text-white font-bold py-2 px-4 rounded-lg hover:bg-gray-300 dark:hover:bg-gray-500 transition-colors">Batal</a>
    <button type="submit" class="bg-blue-600 text-white font-bold py-2 px-4 rounded-lg hover:bg-blue-700 transition-colors">
        {{ isset($product) ? 'Perbarui Produk' : 'Simpan Produk' }}
    </button>
</div>
