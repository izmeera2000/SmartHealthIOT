<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Schema;

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
        
    Schema::defaultStringLength(191);



        View::composer('layouts.header', function ($view) {

            if (!auth()->check()) {
                $view->with([
                    'headerUnreadCount' => 0,
                    'headerNotifications' => collect(),
                ]);

                return;
            }

            $user = auth()->user();

            $view->with([
                'headerUnreadCount' => $user
                    ->unreadNotifications()
                    ->count(),

                'headerNotifications' => $user
                    ->notifications()
                    ->latest()
                    ->limit(5)
                    ->get(),
            ]);
        });
    }
}
