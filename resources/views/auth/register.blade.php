@extends('layouts.app')

@section('title', 'Register - Kita Kaktus')

@section('content')
<div class="flex min-h-screen items-center justify-center bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
    <div class="w-full max-w-md space-y-8">
        <div>
            <div class="flex justify-center">
                <div class="w-20 h-20 bg-green-100 rounded-full flex items-center justify-center">
                    <i class="fas fa-user-plus text-5xl text-green-600"></i>
                </div>
            </div>
            <h2 class="mt-6 text-center text-3xl font-bold tracking-tight text-gray-900">Daftar Akun Baru</h2>
            <p class="mt-2 text-center text-sm text-gray-600">Bergabunglah dengan Kita Kaktus</p>
        </div>
        
        <form class="mt-8 space-y-6" method="POST" action="{{ route('register') }}">
            @csrf
            
            <div class="space-y-4">
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700">Nama Lengkap</label>
                    <div class="relative mt-1">
                        <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                            <i class="fas fa-user text-gray-400"></i>
                        </div>
                        <input id="name" name="name" type="text" required value="{{ old('name') }}"
                               class="block w-full rounded-lg border-gray-300 pl-10 focus:border-green-500 focus:ring-green-500 @error('name') border-red-500 @enderror">
                    </div>
                    @error('name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                    <div class="relative mt-1">
                        <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                            <i class="fas fa-envelope text-gray-400"></i>
                        </div>
                        <input id="email" name="email" type="email" required value="{{ old('email') }}"
                               class="block w-full rounded-lg border-gray-300 pl-10 focus:border-green-500 focus:ring-green-500 @error('email') border-red-500 @enderror">
                    </div>
                    @error('email')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                    <div class="relative mt-1">
                        <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                            <i class="fas fa-lock text-gray-400"></i>
                        </div>
                        <input id="password" name="password" type="password" required
                               class="block w-full rounded-lg border-gray-300 pl-10 focus:border-green-500 focus:ring-green-500 @error('password') border-red-500 @enderror">
                        <button type="button" id="togglePassword1" class="absolute inset-y-0 right-0 flex items-center pr-3">
                            <i id="eyeIcon1" class="fas fa-eye text-gray-400 hover:text-gray-600"></i>
                        </button>
                    </div>
                    @error('password')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                
                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Konfirmasi Password</label>
                    <div class="relative mt-1">
                        <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                            <i class="fas fa-check-circle text-gray-400"></i>
                        </div>
                        <input id="password_confirmation" name="password_confirmation" type="password" required
                               class="block w-full rounded-lg border-gray-300 pl-10 focus:border-green-500 focus:ring-green-500">
                        <button type="button" id="togglePassword2" class="absolute inset-y-0 right-0 flex items-center pr-3">
                            <i id="eyeIcon2" class="fas fa-eye text-gray-400 hover:text-gray-600"></i>
                        </button>
                    </div>
                </div>
            </div>
            
            <div>
                <button type="submit" class="group relative flex w-full justify-center rounded-lg bg-green-600 px-3 py-2 text-sm font-semibold text-white hover:bg-green-500">
                    <i class="fas fa-user-plus mr-2"></i> Daftar
                </button>
            </div>
        </form>
        
        <div class="text-center">
            <p class="text-sm text-gray-600">
                Sudah punya akun? 
                <a href="{{ route('login') }}" class="font-medium text-green-600 hover:text-green-500">Login Sekarang</a>
            </p>
        </div>
    </div>
</div>

@push('scripts')
<script>
    // Toggle password untuk field password
    document.getElementById('togglePassword1').addEventListener('click', function() {
        const password = document.getElementById('password');
        const eyeIcon = document.getElementById('eyeIcon1');
        
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
    
    // Toggle password untuk field confirm password
    document.getElementById('togglePassword2').addEventListener('click', function() {
        const password = document.getElementById('password_confirmation');
        const eyeIcon = document.getElementById('eyeIcon2');
        
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