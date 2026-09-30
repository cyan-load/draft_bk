<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckRole // <-- Pastikan namanya CheckRole
{
    public function handle(Request $request, Closure $next, $role): Response
    {
        if (!Auth::check() || Auth::user()->role !== $role) {
            
            if (Auth::check() && Auth::user()->role === 'guru') {
                return redirect('/guru/dashboard');
            } elseif (Auth::check() && Auth::user()->role === 'siswa') {
                return redirect('/dashboard');
            }
            
            return redirect('/login')->withErrors(['login' => 'Silakan login terlebih dahulu.']);
        }

        return $next($request);
    }
}