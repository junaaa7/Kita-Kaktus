@extends('layouts.app')

@section('title', 'Login - Kita Kaktus')

@section('content')
<style>
    /* Fix untuk auto-fill browser */
    input:-webkit-autofill,
    input:-webkit-autofill:hover,
    input:-webkit-autofill:focus,
    input:-webkit-autofill:active {
        -webkit-background-clip: text;
        transition: background-color 5000s ease-in-out 0s;
        box-shadow: inset 0 0 20px 20px #ffffff !important;
        -webkit-text-fill-color: #111827 !important;
    }

    /* Dark mode fix untuk auto-fill */
    .dark input:-webkit-autofill,
    .dark input:-webkit-autofill:hover,
    .dark input:-webkit-autofill:focus,
    .dark input:-webkit-autofill:active {
        box-shadow: inset 0 0 20px 20px #374151 !important;
        -webkit-text-fill-color: #f9fafb !important;
    }

    /* Responsive adjustments */
    @media (max-width: 640px) {
        .responsive-card {
            padding: 1.5rem !important;
        }
        .responsive-title {
            font-size: 1.5rem !important;
        }
        .responsive-logo {
            padding: 0.5rem 1rem !important;
            font-size: 0.875rem !important;
        }
        .demo-account {
            flex-direction: column !important;
            align-items: flex-start !important;
            gap: 0.25rem !important;
        }
    }
</style>

<div class="min-h-screen flex items-center justify-center py-8 sm:py-12 px-3 sm:px-4 lg:px-8 relative overflow-hidden">
    <div class="absolute inset-0 -z-10 overflow-hidden">

    <!-- Background Image -->
    <img src="{{ asset('images/promosi/logo new.webp') }}"
         alt="Background Kita Kaktus"
         class="w-full h-full object-cover scale-110 blur-sm">

    <!-- Dark Overlay -->
    <div class="absolute inset-0 bg-black/65 dark:bg-black/75 backdrop-blur-[2px]"></div>

    <!-- Glow Effects -->
    <div class="absolute top-10 left-10 w-48 sm:w-72 h-48 sm:h-72 bg-green-500/20 rounded-full blur-3xl"></div>

    <div class="absolute bottom-10 right-10 w-48 sm:w-72 h-48 sm:h-72 bg-yellow-500/20 rounded-full blur-3xl"></div>
    </div>

    <div class="w-full max-w-md space-y-6 sm:space-y-8 animate-fade-in-up px-2 sm:px-0">
        <div class="text-center">
            <div class="animate-bounce-slow">
                <div class="w-auto h-auto px-4 sm:px-6 py-2 sm:py-3 bg-gradient-to-r from-green-500 to-green-600 rounded-full flex items-center justify-center mx-auto shadow-lg">
                    <span class="text-sm sm:text-xl font-bold text-white responsive-logo">Kita Kaktus</span>
                </div>
            </div>
            <h2 class="mt-4 sm:mt-6 text-2xl sm:text-3xl font-extrabold text-white responsive-title">
                Selamat Datang Kembali
            </h2>
            <p class="mt-1 sm:mt-2 text-xs sm:text-sm text-gray-200">
                Silahkan login untuk melanjutkan berbelanja
            </p>
        </div>

        <form class="mt-6 sm:mt-8 space-y-4 sm:space-y-5 bg-white/90 dark:bg-gray-800/90 backdrop-blur-md p-5 sm:p-8 rounded-2xl shadow-2xl transform transition-all duration-500 hover:scale-[1.02] responsive-card" method="POST" action="{{ secure_url('/login') }}">
            @csrf

            @if (session('error'))
                <div class="p-3 rounded-xl bg-red-100 text-red-700 text-sm">
                    {{ session('error') }}
                </div>
            @endif

            <div class="space-y-3 sm:space-y-4">
                <div>
                    <div class="relative mt-1">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-envelope text-gray-400 dark:text-gray-300 text-sm sm:text-base"></i>
                        </div>
                        <input id="email" name="email" type="email" autocomplete="email" required 
                               value="{{ old('email') }}"
                               class="block w-full rounded-xl border-gray-300 dark:border-gray-600 pl-10 pr-3 py-2.5 sm:py-3 bg-white dark:bg-gray-700 text-gray-900 dark:text-white placeholder-gray-400 dark:placeholder-gray-500 focus:border-green-500 focus:ring-green-500 focus:outline-none focus:ring-2 transition-all duration-200 text-sm sm:text-base"
                               placeholder="Alamat Email">
                    </div>
                    @error('email')
                        <p class="mt-1 text-xs sm:text-sm text-red-600 dark:text-red-400 animate-shake">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <div class="relative mt-1">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-lock text-gray-400 dark:text-gray-300 text-sm sm:text-base"></i>
                        </div>
                        <input id="password" name="password" type="password" autocomplete="current-password" required 
                               class="block w-full rounded-xl border-gray-300 dark:border-gray-600 pl-10 pr-10 py-2.5 sm:py-3 bg-white dark:bg-gray-700 text-gray-900 dark:text-white placeholder-gray-400 dark:placeholder-gray-500 focus:border-green-500 focus:ring-green-500 focus:outline-none focus:ring-2 transition-all duration-200 text-sm sm:text-base"
                               placeholder="Password">
                        <button type="button" id="togglePassword" class="absolute inset-y-0 right-0 pr-3 flex items-center">
                            <i id="eyeIcon" class="fas fa-eye text-gray-400 dark:text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 text-sm sm:text-base"></i>
                        </button>
                    </div>
                </div>
            </div>

            <div class="mt-6 sm:mt-8">
                <button type="submit" class="group relative w-full flex justify-center py-2.5 sm:py-3 px-4 border border-transparent text-sm font-medium rounded-xl text-white bg-gradient-to-r from-green-600 to-green-700 hover:from-green-700 hover:to-green-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transform transition-all duration-300 hover:scale-[1.02] active:scale-95 shadow-lg">
                    <span class="absolute left-0 inset-y-0 flex items-center pl-3">
                        <i class="fas fa-sign-in-alt text-green-300 group-hover:text-green-200 transition-colors duration-200 text-sm sm:text-base"></i>
                    </span>
                    Login
                </button>
            </div>

            <div class="relative flex items-center justify-center my-4 sm:my-6">
                <div class="absolute left-0 w-full border-t border-gray-300 dark:border-gray-600"></div>
                <span class="relative px-3 sm:px-4 bg-white/90 dark:bg-gray-800/90 text-xs sm:text-sm text-gray-500 dark:text-gray-400 font-medium">
                    ATAU
                </span>
            </div>

            <a href="{{ route('google.login') }}"
                style="position: relative; z-index: 99999; cursor: pointer; display: flex;"
                class="mt-2 w-full flex items-center justify-center gap-2 sm:gap-3 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-white py-2.5 sm:py-3 rounded-xl hover:bg-gray-100 dark:hover:bg-gray-600 transition shadow-sm text-sm sm:text-base">

                 <img src="https://www.svgrepo.com/show/475656/google-color.svg"
                 alt="Google"
                 style="width: 18px !important; height: 18px !important; max-width: 18px !important;">
                 <span class="font-medium text-xs sm:text-sm">Login dengan Google</span>
            </a>

            <div class="text-center mt-3 sm:mt-4 relative z-10">
                <p class="text-xs sm:text-sm text-gray-600 dark:text-gray-400">
                    Belum punya akun? 
                    <a href="{{ route('register') }}" 
                       class="relative z-20 inline-flex items-center font-medium text-green-600 hover:text-green-500 transition-colors duration-200 hover:underline text-xs sm:text-sm">
                        Daftar Sekarang
                        <i class="fas fa-arrow-right ml-1 text-xs"></i>
                    </a>
                </p>
            </div>

            <div class="mt-4 sm:mt-6 p-3 sm:p-4 bg-gray-50/90 dark:bg-gray-700/50 rounded-xl">
                <p class="text-xs font-semibold text-gray-700 dark:text-gray-300 text-center mb-2">
                    <i class="fas fa-users mr-1"></i> Akun Demo
                </p>
                <div class="space-y-1 text-xs text-gray-600 dark:text-gray-400">
                    <div class="demo-account flex flex-col sm:flex-row justify-between items-start sm:items-center gap-1 sm:gap-2 p-2 rounded-lg transition-colors duration-200 hover:bg-gray-100 dark:hover:bg-gray-600">
                        <span><i class="fas fa-user-shield mr-1 text-yellow-500"></i> Admin:</span>
                        <span class="font-mono text-xs break-all">admin@kitakaktus.com</span>
                        <span class="font-mono text-green-600 dark:text-green-400 text-xs">password123</span>
                    </div>
                    <div class="demo-account flex flex-col sm:flex-row justify-between items-start sm:items-center gap-1 sm:gap-2 p-2 rounded-lg transition-colors duration-200 hover:bg-gray-100 dark:hover:bg-gray-600">
                        <span><i class="fas fa-user mr-1 text-blue-500"></i> User:</span>
                        <span class="font-mono text-xs break-all">user@kitakaktus.com</span>
                        <span class="font-mono text-green-600 dark:text-green-400 text-xs">password123</span>
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