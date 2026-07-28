<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        View::composer('*', function ($view) {
            if (Auth::check()) {
                $view->with([
                    'notifications' => Auth::user()->notifications()->take(5)->get(),
                    'unreadCount'   => Auth::user()->unreadNotifications()->count(),
                ]);
            }
        });
    }
}