@extends('layouts.app')

@section('title', 'Register')

@section('content')
<div class="max-w-md mx-auto">
    <div class="bg-white rounded-lg shadow-md p-8">
        <div class="text-center mb-8">
            <i class="fas fa-user-plus text-6xl text-green-600"></i>
            <h2 class="text-2xl font-bold text-gray-800 mt-4">Daftar Akun Baru</h2>
            <p class="text-gray-600 mt-2">Bergabunglah dengan Kita Kaktus</p>
        </div>
        
        <form method="POST" action="{{ route('register') }}">
            @csrf
            
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2">Nama Lengkap</label>
                <div class="relative">
                    <i class="fas fa-user absolute left-3 top-3 text-gray-400"></i>
                    <input type="text" name="name" value="{{ old('name') }}" required 
                           class="w-full pl-10 pr-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-green-500">
                </div>
                @error('name')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>
            
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2">Email</label>
                <div class="relative">
                    <i class="fas fa-envelope absolute left-3 top-3 text-gray-400"></i>
                    <input type="email" name="email" value="{{ old('email') }}" required 
                           class="w-full pl-10 pr-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-green-500">
                </div>
                @error('email')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>
            
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2">Password</label>
                <div class="relative">
                    <i class="fas fa-lock absolute left-3 top-3 text-gray-400"></i>
                    <input type="password" name="password" id="password" required 
                           class="w-full pl-10 pr-10 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-green-500">
                    <button type="button" onclick="togglePassword('password', 'toggleIcon1')" class="absolute right-3 top-2 text-gray-400 hover:text-gray-600">
                        <i id="toggleIcon1" class="fas fa-eye"></i>
                    </button>
                </div>
                <p class="text-xs text-gray-500 mt-1">Minimal 8 karakter</p>
                @error('password')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>
            
            <div class="mb-6">
                <label class="block text-gray-700 text-sm font-bold mb-2">Konfirmasi Password</label>
                <div class="relative">
                    <i class="fas fa-check-circle absolute left-3 top-3 text-gray-400"></i>
                    <input type="password" name="password_confirmation" id="password_confirmation" required 
                           class="w-full pl-10 pr-10 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-green-500">
                    <button type="button" onclick="togglePassword('password_confirmation', 'toggleIcon2')" class="absolute right-3 top-2 text-gray-400 hover:text-gray-600">
                        <i id="toggleIcon2" class="fas fa-eye"></i>
                    </button>
                </div>
            </div>
            
            <button type="submit" class="w-full bg-green-600 text-white py-2 rounded-lg hover:bg-green-700 transition">
                <i class="fas fa-user-plus"></i> Daftar
            </button>
        </form>
        
        <div class="mt-6 text-center">
            <p class="text-gray-600">
                Sudah punya akun? 
                <a href="{{ route('login') }}" class="text-green-600 hover:text-green-700 font-semibold">Login</a>
            </p>
        </div>
    </div>
</div>

<script>
function togglePassword(inputId, iconId) {
    const passwordInput = document.getElementById(inputId);
    const icon = document.getElementById(iconId);
    
    if (passwordInput.type === 'password') {
        passwordInput.type = 'text';
        icon.classList.remove('fa-eye');
        icon.classList.add('fa-eye-slash');
    } else {
        passwordInput.type = 'password';
        icon.classList.remove('fa-eye-slash');
        icon.classList.add('fa-eye');
    }
}
</script>
@endsection