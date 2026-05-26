@extends('layouts.app')

@section('title', 'Tambah User')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-800 dark:text-white">Tambah User Baru</h1>
        <p class="text-gray-600 dark:text-gray-400 mt-1">Buat akun user atau admin baru</p>
    </div>

    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6">
        <form action="{{ route('admin.users.store') }}" method="POST">
            @csrf

            <div class="mb-4">
                <label class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2">Nama Lengkap</label>
                <input type="text" name="name" value="{{ old('name') }}" required
                       class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-green-500 focus:border-green-500">
                @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2">Email</label>
                <input type="email" name="email" value="{{ old('email') }}" required
                       class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-green-500 focus:border-green-500">
                @error('email') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2">Password</label>
                <div class="relative">
                    <input type="password" name="password" id="password" required
                           class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-green-500 focus:border-green-500 pr-10">
                    <button type="button" id="togglePassword" class="absolute inset-y-0 right-0 pr-3 flex items-center">
                        <i id="eyeIcon" class="fas fa-eye text-gray-400 hover:text-gray-600 dark:text-gray-500 dark:hover:text-gray-300 cursor-pointer"></i>
                    </button>
                </div>
                @error('password') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2">Konfirmasi Password</label>
                <div class="relative">
                    <input type="password" name="password_confirmation" id="password_confirmation" required
                           class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-green-500 focus:border-green-500 pr-10">
                    <button type="button" id="toggleConfirmPassword" class="absolute inset-y-0 right-0 pr-3 flex items-center">
                        <i id="eyeIconConfirm" class="fas fa-eye text-gray-400 hover:text-gray-600 dark:text-gray-500 dark:hover:text-gray-300 cursor-pointer"></i>
                    </button>
                </div>
            </div>

            <div class="mb-6">
                <label class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2">Role</label>
                <div class="flex gap-4">
                    <label class="flex items-center">
                        <input type="radio" name="role" value="user" {{ old('role', 'user') == 'user' ? 'checked' : '' }} class="mr-2">
                        <span class="text-gray-700 dark:text-gray-300">Customer</span>
                    </label>
                    <label class="flex items-center">
                        <input type="radio" name="role" value="admin" {{ old('role') == 'admin' ? 'checked' : '' }} class="mr-2">
                        <span class="text-gray-700 dark:text-gray-300">Admin</span>
                    </label>
                </div>
                @error('role') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="flex justify-end gap-3">
                <a href="{{ route('admin.users.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg transition">Batal</a>
                <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg transition">Simpan</button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    // Toggle password visibility for password field
    document.getElementById('togglePassword').addEventListener('click', function() {
        const password = document.getElementById('password');
        const eyeIcon = document.getElementById('eyeIcon');
        
        if (password.type === 'password') {
            password.type = 'text';
            eyeIcon.classList.remove('fa-eye');
            eyeIcon.classList.add('fa-eye-slash');
        } else {
            password.type = 'password';
            eyeIcon.classList.remove('fa-eye-slash');
            eyeIcon.classList.add('fa-eye');
        }
    });
    
    // Toggle password visibility for confirm password field
    document.getElementById('toggleConfirmPassword').addEventListener('click', function() {
        const password = document.getElementById('password_confirmation');
        const eyeIcon = document.getElementById('eyeIconConfirm');
        
        if (password.type === 'password') {
            password.type = 'text';
            eyeIcon.classList.remove('fa-eye');
            eyeIcon.classList.add('fa-eye-slash');
        } else {
            password.type = 'password';
            eyeIcon.classList.remove('fa-eye-slash');
            eyeIcon.classList.add('fa-eye');
        }
    });
</script>
@endpush
@endsection