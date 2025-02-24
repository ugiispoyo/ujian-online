<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Middleware\RedirectIfAuthenticated;
use App\Http\Middleware\AuthenticateRole;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {

        // Route::middleware('web')
        //     ->group(function () {

        // Route untuk tamu (guest) yang belum login
        // Route::middleware(['guest:web', 'guest:admin'])
        //     ->group(base_path('routes/guest.php'));

        // // Route untuk user biasa (web)
        // Route::middleware(['auth:web'])
        //     ->group(base_path('routes/web.php'));

        // // Route untuk admin
        // Route::middleware(['auth:admin'])
        //     ->prefix('admin')
        //     ->group(base_path('routes/admin.php'));

        // Route default untuk /
        //     Route::get('/', function () {
        //         if (Auth::guard('admin')->check()) {
        //             return redirect('/admin/dashboard');
        //         } elseif (Auth::guard('web')->check()) {
        //             return redirect('/dashboard');
        //         }
        //         return redirect('/login');
        //     })->name('home');
        // });
    }
}
