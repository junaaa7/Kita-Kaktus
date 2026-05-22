<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;

class GoogleController extends Controller
{
    public function redirectToGoogleLogin()
    {
        Session::put('google_auth_type', 'login');

        return Socialite::driver('google')
            ->redirectUrl(config('services.google.redirect'))
            ->with([
                'prompt' => 'select_account',
            ])
            ->redirect();
    }

    public function redirectToGoogleRegister()
    {
        Session::put('google_auth_type', 'register');

        return Socialite::driver('google')
            ->redirectUrl(config('services.google.redirect'))
            ->with([
                'prompt' => 'select_account',
            ])
            ->redirect();
    }

    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')
                ->redirectUrl(config('services.google.redirect'))
                ->user();

            $authType = Session::get('google_auth_type', 'login');

            $user = User::where('email', $googleUser->getEmail())->first();

            if ($authType === 'register') {
                if ($user) {
                    return redirect()->route('register')
                        ->with('error', 'Email Google ini sudah terdaftar. Silakan login.');
                }

                $user = User::create([
                    'name' => $googleUser->getName(),
                    'email' => $googleUser->getEmail(),
                    'google_id' => $googleUser->getId(),
                    'avatar' => $googleUser->getAvatar(),
                    'password' => bcrypt(Str::random(24)),
                    'role' => 'user',
                ]);

                Auth::login($user);

                return redirect()->route('home')
                    ->with('success', 'Selamat datang, ' . $user->name . '!');
            }

            if (!$user) {
                $user = User::create([
                    'name' => $googleUser->getName(),
                    'email' => $googleUser->getEmail(),
                    'google_id' => $googleUser->getId(),
                    'avatar' => $googleUser->getAvatar(),
                    'password' => bcrypt(Str::random(24)),
                    'role' => 'user',
                ]);

                Auth::login($user);

                return redirect()->route('home')
                    ->with('success', 'Selamat datang, ' . $user->name . '!');
            }

            $user->update([
                'google_id' => $googleUser->getId(),
                'avatar' => $googleUser->getAvatar(),
            ]);

            Auth::login($user);

            return redirect()->route('home')
                ->with('success', 'Selamat datang kembali, ' . $user->name . '!');

        } catch (Exception $e) {
            return redirect()->route('login')
                ->with('error', 'Login dengan Google gagal. Silakan coba lagi.');
        }
    }
}