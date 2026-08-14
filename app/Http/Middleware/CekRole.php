<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class CekRole
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     * @param  string  ...$roles (Mendukung banyak role sekaligus)
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        if (!Auth::check()) {
            return redirect('/login');
        }

        // Jika role user saat ini TIDAK ADA di dalam daftar role yang diizinkan
        if (!in_array(Auth::user()->role, $roles)) {
            
            // Jika dia staf/owner yang salah kamar, kembalikan ke dashboard
            if (in_array(Auth::user()->role, ['admin', 'resepsionis', 'owner'])) {
                return redirect('/dashboard');
            }
            
            // Jika dia tamu yang mencoba masuk dashboard, kembalikan ke landing page
            return redirect('/');
        }

        return $next($request);
    }
}