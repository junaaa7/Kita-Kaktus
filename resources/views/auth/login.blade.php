@extends('layouts.app')

@section('title', 'Login')

@section('content')
<div class="max-w-md mx-auto">
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-8">
        <div class="text-center mb-8">
            <i class="fas fa-user-circle text-6xl text-green-600"></i>
            <h2 class="text-2xl font-bold text-gray-800 dark:text-white mt-4">Login</h2>
            <p class="text-gray-600 dark:text-gray-400 mt-2">Silahkan login untuk berbelanja</p>
        </div>
        
        <form method="POST" action="{{ route('login') }}">
            @csrf
            
            <div class="mb-4">
                <label class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2">Email</label>
                <div class="relative">
                    <i class="fas fa-envelope absolute left-3 top-3 text-gray-400"></i>
                    <input type="email" name="email" value="{{ old('email') }}" required 
                           class="w-full pl-10 pr-3 py-2 border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-lg focus:outline-none focus:border-green-500">
                </div>
                @error('email')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>
            
            <div class="mb-6">
                <label class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2">Password</label>
                <div class="relative">
                    <i class="fas fa-lock absolute left-3 top-3 text-gray-400"></i>
                    <input type="password" name="password" id="password" required 
                           class="w-full pl-10 pr-10 py-2 border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-lg focus:outline-none focus:border-green-500">
                    <button type="button" onclick="togglePassword('password', 'toggleIcon')" class="absolute right-3 top-2 text-gray-400 hover:text-gray-600">
                        <i id="toggleIcon" class="fas fa-eye"></i>
                    </button>
                </div>
            </div>
            
            <button type="submit" class="w-full bg-green-600 text-white py-2 rounded-lg hover:bg-green-700 transition">
                <i class="fas fa-sign-in-alt"></i> Login
            </button>
        </form>
        
        <div class="mt-6 text-center">
            <p class="text-gray-600 dark:text-gray-400">
                Belum punya akun? 
                <a href="{{ route('register') }}" class="text-green-600 hover:text-green-700 font-semibold">Register</a>
            </p>
        </div>
        
        <div class="mt-6 p-4 bg-gray-100 dark:bg-gray-700 rounded-lg">
            <p class="text-sm text-gray-600 dark:text-gray-400 text-center font-semibold mb-2">Demo Account:</p>
            <div class="text-xs text-gray-500 dark:text-gray-500 space-y-1">
                <p class="flex justify-between">
                    <span>Admin:</span>
                    <span>admin@kitakaktus.com / password123</span>
                </p>
                <p class="flex justify-between">
                    <span>User:</span>
                    <span>user@kitakaktus.com / password123</span>
                </p>
            </div>
        </div>
    </div>
</div>
@endsection