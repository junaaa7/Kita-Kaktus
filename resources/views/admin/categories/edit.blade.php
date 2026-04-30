@extends('layouts.app')

@section('title', 'Edit Kategori')

@section('content')
<div class="max-w-2xl mx-auto">
    <h1 class="text-2xl font-bold text-gray-800 mb-6">Edit Kategori</h1>
    
    <form action="{{ route('admin.categories.update', $category) }}" method="POST" class="bg-white rounded-lg shadow-md p-6">
        @csrf
        @method('PUT')
        
        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2">Nama Kategori</label>
            <input type="text" name="name" value="{{ old('name', $category->name) }}" required class="w-full px-3 py-2 border border-gray-300 rounded-lg">
        </div>
        
        <div class="mb-6">
            <label class="block text-gray-700 text-sm font-bold mb-2">Deskripsi (Opsional)</label>
            <textarea name="description" rows="4" class="w-full px-3 py-2 border border-gray-300 rounded-lg">{{ old('description', $category->description) }}</textarea>
        </div>
        
        <div class="flex justify-end space-x-3">
            <a href="{{ route('admin.categories.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600">Batal</a>
            <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700">Update</button>
        </div>
    </form>
</div>
@endsection