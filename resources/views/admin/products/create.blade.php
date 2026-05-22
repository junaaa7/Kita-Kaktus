@extends('layouts.app')

@section('title', 'Tambah Produk')

@section('content')
<div class="max-w-2xl mx-auto">
    <h1 class="text-2xl font-bold text-gray-800 dark:text-white mb-6">Tambah Produk Baru</h1>
    
    <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data" class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6">
        @csrf
        
        <div class="mb-4">
            <label class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2">Nama Produk</label>
            <input type="text" name="name" value="{{ old('name') }}" required class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
        </div>
        
        <div class="mb-4">
            <label class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2">Kategori</label>
            <select name="category_id" required class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                <option value="" class="bg-white dark:bg-gray-700 text-gray-900 dark:text-white">Pilih Kategori</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" class="bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
        </div>
        
        <div class="mb-4">
            <label class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2">Deskripsi</label>
            <textarea name="description" rows="5" required class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white">{{ old('description') }}</textarea>
        </div>
        
        <div class="grid grid-cols-2 gap-4 mb-4">
            <div>
                <label class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2">Harga (Rp)</label>
                <input type="number" name="price" value="{{ old('price') }}" required class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
            </div>
            
            <div>
                <label class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2">Stok</label>
                <input type="number" name="stock" value="{{ old('stock') }}" required class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
            </div>
        </div>
        
        <div class="mb-6">
            <label class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2">Gambar Produk</label>
            <input type="file" name="image" accept="image/jpeg,image/png,image/jpg,image/webp" 
                    onchange="validateFileSize(this)" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
            <div id="fileSizeError" class="text-red-500 text-xs mt-1 hidden"></div>
            <div id="fileInfo" class="text-gray-500 dark:text-gray-400 text-xs mt-1"></div>
            <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Format: JPG, PNG. Maksimal 5MB</p>
        </div>
        
        <div class="flex justify-end space-x-3">
            <a href="{{ route('admin.products.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600">Batal</a>
            <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700">Simpan</button>
        </div>
    </form>
</div>

<script>
function validateFileSize(input) {
    const file = input.files[0];
    const maxSize = 5 * 1024 * 1024;
    const errorDiv = document.getElementById('fileSizeError');
    const infoDiv = document.getElementById('fileInfo');
    
    if (file) {
        const fileSizeMB = (file.size / (1024 * 1024)).toFixed(2);
        infoDiv.innerHTML = `Ukuran file: ${fileSizeMB} MB`;
        infoDiv.classList.remove('hidden');
        
        if (file.size > maxSize) {
            errorDiv.innerHTML = `File terlalu besar! Maksimal 5MB. Ukuran file Anda: ${fileSizeMB} MB`;
            errorDiv.classList.remove('hidden');
            input.value = '';
            infoDiv.classList.add('hidden');
        } else {
            errorDiv.classList.add('hidden');
            if (fileSizeMB > 2) {
                infoDiv.classList.add('text-yellow-500');
                infoDiv.innerHTML = `Ukuran file: ${fileSizeMB} MB (Akan dikompres otomatis)`;
            } else {
                infoDiv.classList.remove('text-yellow-500');
                infoDiv.classList.add('text-green-500');
            }
        }
    }
}
</script>
@endsection