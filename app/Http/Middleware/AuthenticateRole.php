<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AuthenticateRole
{
    public function handle(Request $request, Closure $next, $role = 'web'): Response
    {
        // Jika role adalah admin tetapi tidak login sebagai admin
        if ($role === 'admin' && !Auth::guard('admin')->check()) {
            return redirect('/login')->withErrors(['error' => 'Akses khusus admin. Silakan login sebagai admin.']);
        }

        // Jika role adalah user biasa tetapi tidak login sebagai user
        if ($role === 'web' && !Auth::guard('web')->check()) {
            return redirect('/login')->withErrors(['error' => 'Anda harus login terlebih dahulu.']);
        }

        return $next($request);
    }
}
