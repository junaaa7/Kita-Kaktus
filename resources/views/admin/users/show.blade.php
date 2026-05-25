@extends('layouts.app')

@section('title', 'Detail User')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-800 dark:text-white">Detail User</h1>
        <p class="text-gray-600 dark:text-gray-400 mt-1">Informasi lengkap user</p>
    </div>

    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden">
        <div class="p-6">
            <div class="flex items-center mb-6">
                <div class="w-20 h-20 rounded-full bg-gradient-to-r from-green-400 to-green-600 flex items-center justify-center text-white font-bold text-2xl">
                    {{ strtoupper(substr($user->name, 0, 1)) }}
                </div>
                <div class="ml-4">
                    <h2 class="text-xl font-bold text-gray-800 dark:text-white">{{ $user->name }}</h2>
                    <p class="text-gray-600 dark:text-gray-400">{{ $user->email }}</p>
                </div>
            </div>

            <div class="border-t border-gray-200 dark:border-gray-700 pt-4 space-y-3">
                <div class="flex justify-between">
                    <span class="font-medium text-gray-700 dark:text-gray-300">ID User:</span>
                    <span class="text-gray-900 dark:text-white">#{{ $user->id }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="font-medium text-gray-700 dark:text-gray-300">Role:</span>
                    @if($user->role == 'admin')
                        <span class="px-2 py-1 text-xs rounded-full bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200">
                            <i class="fas fa-user-shield mr-1"></i> Admin
                        </span>
                    @else
                        <span class="px-2 py-1 text-xs rounded-full bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">
                            <i class="fas fa-user mr-1"></i> Customer
                        </span>
                    @endif
                </div>
                <div class="flex justify-between">
                    <span class="font-medium text-gray-700 dark:text-gray-300">Tanggal Daftar:</span>
                    <span class="text-gray-900 dark:text-white">{{ $user->created_at->format('d F Y, H:i') }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="font-medium text-gray-700 dark:text-gray-300">Terakhir Update:</span>
                    <span class="text-gray-900 dark:text-white">{{ $user->updated_at->format('d F Y, H:i') }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="font-medium text-gray-700 dark:text-gray-300">Total Pesanan:</span>
                    <span class="text-gray-900 dark:text-white">{{ $user->orders()->count() }} pesanan</span>
                </div>
            </div>
        </div>

        <div class="bg-gray-50 dark:bg-gray-700/50 px-6 py-4 flex justify-end gap-3">
            <a href="{{ route('admin.users.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg transition">Kembali</a>
            <a href="{{ route('admin.users.edit', $user) }}" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg transition">Edit User</a>
        </div>
    </div>
</div>
@endsection