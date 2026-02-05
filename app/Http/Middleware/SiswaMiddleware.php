<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SiswaMiddleware
{
    /**
     * Handle an incoming request.
     * Memastikan hanya siswa yang sudah login yang dapat mengakses.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!session()->has('siswa_nisn')) {
            return redirect()->route('siswa.login')
                ->with('error', 'Silakan login terlebih dahulu.');
        }

        return $next($request);
    }
}
