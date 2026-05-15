@extends('layouts.app')

@section('title', 'Register - Kita Kaktus')

@section('content')
<div class="min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8 relative overflow-hidden">
    <!-- Background Decoration -->
    <div class="absolute inset-0 -z-10">
        <div class="absolute top-0 left-0 w-full h-full bg-gradient-to-br from-green-50 via-white to-green-50 dark:from-gray-900 dark:via-gray-800 dark:to-gray-900"></div>
        <div class="absolute top-10 right-10 w-72 h-72 bg-green-200 rounded-full mix-blend-multiply filter blur-xl opacity-70 animate-blob dark:bg-green-900/30"></div>
        <div class="absolute bottom-10 left-10 w-72 h-72 bg-yellow-200 rounded-full mix-blend-multiply filter blur-xl opacity-70 animate-blob animation-delay-2000 dark:bg-yellow-900/30"></div>
        <div class="absolute top-40 left-1/3 w-72 h-72 bg-green-300 rounded-full mix-blend-multiply filter blur-xl opacity-70 animate-blob animation-delay-4000 dark:bg-green-800/30"></div>
    </div>

    <div class="max-w-md w-full space-y-8 animate-fade-in-up">
        <!-- Logo & Title -->
        <div class="text-center">
            <div class="animate-bounce-slow">
                <div class="w-auto h-auto px-6 py-3 bg-gradient-to-r from-green-500 to-green-600 rounded-full flex items-center justify-center mx-auto shadow-lg">
                    <span class="text-xl font-bold text-white">🌵 Kita Kaktus</span>
                </div>
            </div>
            <h2 class="mt-6 text-3xl font-extrabold text-gray-900 dark:text-white">
                Daftar Akun Baru
            </h2>
            <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">
                Bergabunglah dengan Kita Kaktus
            </p>
        </div>

        <!-- Form Register -->
        <form class="mt-8 space-y-5 bg-white dark:bg-gray-800 p-8 rounded-2xl shadow-2xl transform transition-all duration-500 hover:scale-[1.02]" method="POST" action="{{ route('register') }}">
            @csrf
            
            <div class="space-y-4">
                <!-- Name Field -->
                <div>
                    <div class="relative mt-1">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-user text-gray-400 dark:text-gray-300"></i>
                        </div>
                        <input id="name" name="name" type="text" autocomplete="name" required 
                               value="{{ old('name') }}"
                               class="block w-full rounded-xl border-gray-300 dark:border-gray-600 pl-10 pr-3 py-3 bg-white dark:bg-gray-700 text-gray-900 dark:text-white placeholder-gray-400 dark:placeholder-gray-500 focus:border-green-500 focus:ring-green-500 focus:outline-none focus:ring-2 transition-all duration-200"
                               placeholder="Nama Lengkap">
                    </div>
                    @error('name')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400 animate-shake">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Email Field -->
                <div>
                    <div class="relative mt-1">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-envelope text-gray-400 dark:text-gray-300"></i>
                        </div>
                        <input id="email" name="email" type="email" autocomplete="email" required 
                               value="{{ old('email') }}"
                               class="block w-full rounded-xl border-gray-300 dark:border-gray-600 pl-10 pr-3 py-3 bg-white dark:bg-gray-700 text-gray-900 dark:text-white placeholder-gray-400 dark:placeholder-gray-500 focus:border-green-500 focus:ring-green-500 focus:outline-none focus:ring-2 transition-all duration-200"
                               placeholder="Alamat Email">
                    </div>
                    @error('email')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400 animate-shake">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Password Field -->
                <div>
                    <div class="relative mt-1">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-lock text-gray-400 dark:text-gray-300"></i>
                        </div>
                        <input id="password" name="password" type="password" required 
                               class="block w-full rounded-xl border-gray-300 dark:border-gray-600 pl-10 pr-10 py-3 bg-white dark:bg-gray-700 text-gray-900 dark:text-white placeholder-gray-400 dark:placeholder-gray-500 focus:border-green-500 focus:ring-green-500 focus:outline-none focus:ring-2 transition-all duration-200"
                               placeholder="Password (min. 8 karakter)">
                        <button type="button" id="togglePassword" class="absolute inset-y-0 right-0 pr-3 flex items-center">
                            <i id="eyeIcon" class="fas fa-eye text-gray-400 dark:text-gray-400 hover:text-gray-600 dark:hover:text-gray-300"></i>
                        </button>
                    </div>
                    @error('password')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400 animate-shake">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Confirm Password Field -->
                <div>
                    <div class="relative mt-1">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-check-circle text-gray-400 dark:text-gray-300"></i>
                        </div>
                        <input id="password_confirmation" name="password_confirmation" type="password" required 
                               class="block w-full rounded-xl border-gray-300 dark:border-gray-600 pl-10 pr-10 py-3 bg-white dark:bg-gray-700 text-gray-900 dark:text-white placeholder-gray-400 dark:placeholder-gray-500 focus:border-green-500 focus:ring-green-500 focus:outline-none focus:ring-2 transition-all duration-200"
                               placeholder="Konfirmasi Password">
                        <button type="button" id="toggleConfirmPassword" class="absolute inset-y-0 right-0 pr-3 flex items-center">
                            <i id="eyeIconConfirm" class="fas fa-eye text-gray-400 dark:text-gray-400 hover:text-gray-600 dark:hover:text-gray-300"></i>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Submit Button - DITAMBAH margin-top mt-6 -->
            <div class="mt-8">
                <button type="submit" class="group relative w-full flex justify-center py-3 px-4 border border-transparent text-sm font-medium rounded-xl text-white bg-gradient-to-r from-green-600 to-green-700 hover:from-green-700 hover:to-green-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transform transition-all duration-300 hover:scale-[1.02] active:scale-95 shadow-lg">
                    <span class="absolute left-0 inset-y-0 flex items-center pl-3">
                        <i class="fas fa-user-plus text-green-300 group-hover:text-green-200 transition-colors duration-200"></i>
                    </span>
                    Daftar Sekarang
                </button>
            </div>

            <!-- Login Link -->
            <div class="text-center mt-4">
                <p class="text-sm text-gray-600 dark:text-gray-400">
                    Sudah punya akun? 
                    <a href="{{ route('login') }}" class="font-medium text-green-600 hover:text-green-500 transition-colors duration-200 hover:underline">
                        Login Sekarang
                        <i class="fas fa-arrow-right ml-1 text-xs"></i>
                    </a>
                </p>
            </div>
        </form>
    </div>
</div>

<style>
@keyframes fade-in-up {
    from {
        opacity: 0;
        transform: translateY(30px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

@keyframes blob {
    0% {
        transform: translate(0px, 0px) scale(1);
    }
    33% {
        transform: translate(30px, -50px) scale(1.1);
    }
    66% {
        transform: translate(-20px, 20px) scale(0.9);
    }
    100% {
        transform: translate(0px, 0px) scale(1);
    }
}

@keyframes shake {
    0%, 100% { transform: translateX(0); }
    25% { transform: translateX(-5px); }
    75% { transform: translateX(5px); }
}

.animate-fade-in-up {
    animation: fade-in-up 0.6s ease-out;
}

.animate-bounce-slow {
    animation: bounce 2s infinite;
}

.animate-blob {
    animation: blob 7s infinite;
}

.animation-delay-2000 {
    animation-delay: 2s;
}

.animation-delay-4000 {
    animation-delay: 4s;
}

.animate-shake {
    animation: shake 0.3s ease-in-out;
}
</style>

@push('scripts')
<script>
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