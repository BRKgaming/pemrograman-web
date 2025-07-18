<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Cek apakah user adalah admin
        if (!$request->user() || $request->user()->role !== 'admin') {
            // Redirect ke home dengan pesan error
            return redirect()->route('home')->with('error', 'Anda tidak memiliki izin untuk mengakses halaman admin.');
        }

        return $next($request);
    }
}
