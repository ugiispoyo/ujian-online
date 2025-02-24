<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfAuthenticated
{
    public function handle(Request $request, Closure $next, $guard = null): Response
    {
        // Jika sudah login sebagai admin, redirect ke dashboard admin
        if ($guard === 'admin' && Auth::guard('admin')->check()) {
            return redirect('/admin/dashboard');
        }

        // Jika sudah login sebagai user biasa, redirect ke dashboard user
        if ($guard === 'web' && Auth::guard('web')->check()) {
            return redirect('/dashboard');
        }

        return $next($request);
    }
}
