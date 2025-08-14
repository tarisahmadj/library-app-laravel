<?php

namespace App\Providers;

use Filament\Facades\Filament;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\App;

class FilamentAuthBypassServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
         App::booted(function () {
            Filament::serving(function () {
                if (App::environment('local')) {
                    Auth::loginUsingId(1); // auto-login user ID 1
                }
            });
        });
    }
}
