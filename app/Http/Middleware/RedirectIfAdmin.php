<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RedirectIfAdmin
{
    public function handle(Request $request, Closure $next)
    {
        if (auth()->check() && auth()->user()->isAdmin()) {
            // Jika admin mencoba mengakses halaman user, redirect ke admin dashboard
            if ($request->routeIs('home') || 
                $request->routeIs('cart.*') || 
                $request->routeIs('checkout.*') ||
                $request->routeIs('orders.history')) {
                return redirect()->route('admin.dashboard');
            }
        }
        
        return $next($request);
    }
}