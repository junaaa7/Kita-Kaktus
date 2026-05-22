@extends('layouts.app')

@section('title', 'Login - Kita Kaktus')

@section('content')
<div class="min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8 relative overflow-hidden">
    <div class="absolute inset-0 -z-10">
        <div class="absolute top-0 left-0 w-full h-full bg-gradient-to-br from-green-50 via-white to-green-50 dark:from-gray-900 dark:via-gray-800 dark:to-gray-900"></div>
        <div class="absolute top-10 left-10 w-72 h-72 bg-green-200 rounded-full mix-blend-multiply filter blur-xl opacity-70 animate-blob dark:bg-green-900/30"></div>
        <div class="absolute top-40 right-10 w-72 h-72 bg-yellow-200 rounded-full mix-blend-multiply filter blur-xl opacity-70 animate-blob animation-delay-2000 dark:bg-yellow-900/30"></div>
        <div class="absolute bottom-10 left-20 w-72 h-72 bg-green-300 rounded-full mix-blend-multiply filter blur-xl opacity-70 animate-blob animation-delay-4000 dark:bg-green-800/30"></div>
    </div>

    <div class="max-w-md w-full space-y-8 animate-fade-in-up">
        <div class="text-center">
            <div class="animate-bounce-slow">
                <div class="w-auto h-auto px-6 py-3 bg-gradient-to-r from-green-500 to-green-600 rounded-full flex items-center justify-center mx-auto shadow-lg">
                    <span class="text-xl font-bold text-white">Kita Kaktus</span>
                </div>
            </div>
            <h2 class="mt-6 text-3xl font-extrabold text-gray-900 dark:text-white">
                Selamat Datang Kembali
            </h2>
            <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">
                Silahkan login untuk melanjutkan berbelanja
            </p>
        </div>

        <form class="mt-8 space-y-5 bg-white dark:bg-gray-800 p-8 rounded-2xl shadow-2xl transform transition-all duration-500 hover:scale-[1.02]" method="POST" action="{{ secure_url('/login') }}">
            @csrf

            @if (session('error'))
                <div class="p-3 rounded-xl bg-red-100 text-red-700 text-sm">
                    {{ session('error') }}
                </div>
            @endif

            <div class="space-y-4">
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

                <div>
                    <div class="relative mt-1">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-lock text-gray-400 dark:text-gray-300"></i>
                        </div>
                        <input id="password" name="password" type="password" autocomplete="current-password" required 
                               class="block w-full rounded-xl border-gray-300 dark:border-gray-600 pl-10 pr-10 py-3 bg-white dark:bg-gray-700 text-gray-900 dark:text-white placeholder-gray-400 dark:placeholder-gray-500 focus:border-green-500 focus:ring-green-500 focus:outline-none focus:ring-2 transition-all duration-200"
                               placeholder="Password">
                        <button type="button" id="togglePassword" class="absolute inset-y-0 right-0 pr-3 flex items-center">
                            <i id="eyeIcon" class="fas fa-eye text-gray-400 dark:text-gray-400 hover:text-gray-600 dark:hover:text-gray-300"></i>
                        </button>
                    </div>
                </div>
            </div>

            <div class="mt-8">
                <button type="submit" class="group relative w-full flex justify-center py-3 px-4 mb-6 border border-transparent text-sm font-medium rounded-xl text-white bg-gradient-to-r from-green-600 to-green-700 hover:from-green-700 hover:to-green-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transform transition-all duration-300 hover:scale-[1.02] active:scale-95 shadow-lg">
                    <span class="absolute left-0 inset-y-0 flex items-center pl-3">
                        <i class="fas fa-sign-in-alt text-green-300 group-hover:text-green-200 transition-colors duration-200"></i>
                    </span>
                    Login
                </button>
            </div>

            <div class="relative flex items-center justify-center my-6">
                <div class="absolute left-0 w-full border-t border-gray-300 dark:border-gray-600"></div>
                <span class="relative px-4 bg-white dark:bg-gray-800 text-sm text-gray-500 dark:text-gray-400 font-medium">
                    ATAU
                </span>
            </div>

            <a href="{{ route('google.login') }}"
                style="position: relative; z-index: 99999; cursor: pointer; display: flex;"
                class="mt-4 w-full flex items-center justify-center gap-3 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-white py-3 rounded-xl hover:bg-gray-100 dark:hover:bg-gray-600 transition shadow-sm">

                 <img src="https://www.svgrepo.com/show/475656/google-color.svg"
                 alt="Google"
                 style="width: 22px !important; height: 22px !important; max-width: 22px !important;">
                 <span class="font-medium text-sm">Login dengan Google</span>
            </a>

            <div class="text-center mt-4 relative z-10">
                <p class="text-sm text-gray-600 dark:text-gray-400">
                    Belum punya akun? 
                    <a href="{{ route('register') }}" 
                       class="relative z-20 inline-flex items-center font-medium text-green-600 hover:text-green-500 transition-colors duration-200 hover:underline">
                        Daftar Sekarang
                        <i class="fas fa-arrow-right ml-1 text-xs"></i>
                    </a>
                </p>
            </div>

            <div class="mt-6 p-4 bg-gray-50 dark:bg-gray-700/50 rounded-xl">
                <p class="text-xs font-semibold text-gray-700 dark:text-gray-300 text-center mb-2">
                    <i class="fas fa-users mr-1"></i> Akun Demo
                </p>
                <div class="space-y-1 text-xs text-gray-600 dark:text-gray-400">
                    <div class="flex justify-between items-center hover:bg-gray-100 dark:hover:bg-gray-600 p-2 rounded-lg transition-colors duration-200">
                        <span><i class="fas fa-user-shield mr-1 text-yellow-500"></i> Admin:</span>
                        <span class="font-mono">admin@kitakaktus.com</span>
                        <span class="font-mono text-green-600 dark:text-green-400">password123</span>
                    </div>
                    <div class="flex justify-between items-center hover:bg-gray-100 dark:hover:bg-gray-600 p-2 rounded-lg transition-colors duration-200">
                        <span><i class="fas fa-user mr-1 text-blue-500"></i> User:</span>
                        <span class="font-mono">user@kitakaktus.com</span>
                        <span class="font-mono text-green-600 dark:text-green-400">password123</span>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<style>
@keyframes fade-in-up {
    from { opacity: 0; transform: translateY(30px); }
    to { opacity: 1; transform: translateY(0); }
}

@keyframes blob {
    0% { transform: translate(0px, 0px) scale(1); }
    33% { transform: translate(30px, -50px) scale(1.1); }
    66% { transform: translate(-20px, 20px) scale(0.9); }
    100% { transform: translate(0px, 0px) scale(1); }
}

@keyframes shake {
    0%, 100% { transform: translateX(0); }
    25% { transform: translateX(-5px); }
    75% { transform: translateX(5px); }
}

.animate-fade-in-up { animation: fade-in-up 0.6s ease-out; }
.animate-bounce-slow { animation: bounce 2s infinite; }
.animate-blob { animation: blob 7s infinite; }
.animation-delay-2000 { animation-delay: 2s; }
.animation-delay-4000 { animation-delay: 4s; }
.animate-shake { animation: shake 0.3s ease-in-out; }
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
</script>
@endpush
@endsection