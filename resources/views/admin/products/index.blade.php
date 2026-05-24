@extends('layouts.app')

@section('title', 'Manajemen Produk')

@section('content')
<div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3 mb-4 sm:mb-6">
    <h1 class="text-xl sm:text-2xl font-bold text-gray-800 dark:text-white">Manajemen Produk</h1>
    <a href="{{ route('admin.products.create') }}" class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 text-sm sm:text-base inline-flex items-center justify-center">
        <i class="fas fa-plus mr-1 sm:mr-2"></i> Tambah Produk
    </a>
</div>

<div class="bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden">
    <!-- Tampilan Desktop (Table) -->
    <div class="hidden sm:block overflow-x-auto">
        <table class="min-w-full">
            <thead class="bg-gray-50 dark:bg-gray-700">
                <tr>
                    <th class="px-4 md:px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Gambar</th>
                    <th class="px-4 md:px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Nama Produk</th>
                    <th class="px-4 md:px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Kategori</th>
                    <th class="px-4 md:px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Harga</th>
                    <th class="px-4 md:px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Stok</th>
                    <th class="px-4 md:px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                @foreach($products as $product)
                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition">
                    <td class="px-4 md:px-6 py-3 md:py-4">
                        @if($product->image)
                            <img src="{{ asset($product->image) }}" alt="{{ $product->name }}" class="w-10 h-10 md:w-12 md:h-12 object-cover rounded">
                        @else
                            <div class="w-10 h-10 md:w-12 md:h-12 bg-gray-300 dark:bg-gray-600 rounded flex items-center justify-center">
                                <i class="fas fa-image text-gray-500 dark:text-gray-400 text-sm md:text-base"></i>
                            </div>
                        @endif
                    </td>
                    <td class="px-4 md:px-6 py-3 md:py-4 text-sm md:text-base text-gray-900 dark:text-white">{{ $product->name }}</td>
                    <td class="px-4 md:px-6 py-3 md:py-4 text-sm md:text-base text-gray-600 dark:text-gray-300">{{ $product->category->name }}</td>
                    <td class="px-4 md:px-6 py-3 md:py-4 text-sm md:text-base text-gray-600 dark:text-gray-300">Rp {{ number_format($product->price, 0, ',', '.') }}</td>
                    <td class="px-4 md:px-6 py-3 md:py-4 text-sm md:text-base text-gray-600 dark:text-gray-300">{{ $product->stock }}</td>
                    <td class="px-4 md:px-6 py-3 md:py-4">
                        <div class="flex flex-col sm:flex-row items-start sm:items-center gap-2 sm:gap-3">
                            <a href="{{ route('admin.products.edit', $product) }}" class="text-blue-600 hover:text-blue-900 dark:text-blue-400 dark:hover:text-blue-300 text-sm inline-flex items-center">
                                <i class="fas fa-edit mr-1"></i> Edit
                            </a>
                            <form action="{{ route('admin.products.destroy', $product) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300 text-sm inline-flex items-center" onclick="return confirm('Yakin ingin menghapus produk ini?')">
                                    <i class="fas fa-trash mr-1"></i> Hapus
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    
    <!-- Tampilan Mobile (Card) -->
    <div class="block sm:hidden divide-y divide-gray-200 dark:divide-gray-700">
        @foreach($products as $product)
        <div class="p-4 hover:bg-gray-50 dark:hover:bg-gray-700 transition">
            <div class="flex items-start space-x-3">
                <div class="flex-shrink-0">
                    @if($product->image)
                        <img src="{{ asset($product->image) }}" alt="{{ $product->name }}" class="w-16 h-16 object-cover rounded-lg">
                    @else
                        <div class="w-16 h-16 bg-gray-300 dark:bg-gray-600 rounded-lg flex items-center justify-center">
                            <i class="fas fa-image text-gray-500 dark:text-gray-400 text-2xl"></i>
                        </div>
                    @endif
                </div>
                <div class="flex-1">
                    <h3 class="font-semibold text-gray-900 dark:text-white text-base">{{ $product->name }}</h3>
                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Kategori: {{ $product->category->name }}</p>
                    <div class="mt-2 flex flex-wrap justify-between items-center gap-2">
                        <div>
                            <span class="text-green-600 dark:text-green-400 font-bold text-sm">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                            <span class="text-xs text-gray-500 dark:text-gray-400 ml-2">Stok: {{ $product->stock }}</span>
                        </div>
                        <div class="flex space-x-3">
                            <a href="{{ route('admin.products.edit', $product) }}" class="text-blue-600 dark:text-blue-400 text-sm">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('admin.products.destroy', $product) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 dark:text-red-400 text-sm" onclick="return confirm('Yakin ingin menghapus produk ini?')">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>

<div class="mt-4">
    {{ $products->links() }}
</div>
@endsection