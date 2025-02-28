<?php

namespace App\Providers;

use App\Services\Auth\ClerkGuard;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Auth;

class AuthServiceProvider extends ServiceProvider
{
    public function boot()
    {
        Auth::extend('clerk', function ($app, $name, array $config) {
            return new ClerkGuard($app['request']);
        });
    }
}