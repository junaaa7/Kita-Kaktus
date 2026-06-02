<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class StaticAssetCache
{
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        if (preg_match('/\.(webp|jpg|jpeg|png|gif|svg|css|js|woff|woff2)$/i', $request->path())) {
            $response->headers->set('Cache-Control', 'public, max-age=31536000, immutable');
        }

        return $response;
    }
}