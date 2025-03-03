<?php

namespace Wobsoriano\LaravelClerk\Providers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;
use Wobsoriano\LaravelClerk\ClerkClient;
use Wobsoriano\LaravelClerk\Guards\ClerkGuard;
use Wobsoriano\LaravelClerk\Middleware\ClerkAuthenticated;
use Wobsoriano\LaravelClerk\Middleware\ClerkGuest;

final class ClerkServiceProvider extends ServiceProvider
{
    public function boot()
    {
        Auth::extend('clerk_session', function ($app) {
            return new ClerkGuard(
                $app->make('request'),
                $app->make(ClerkClient::class)
            );
        });

        if($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../config/clerk.php' => config_path('clerk.php'),
            ], 'config');
        }

        $this->app->singleton(ClerkClient::class, function () {
            return new ClerkClient();
        });
        
        $router = $this->app['router'];
        $router->aliasMiddleware('clerk.auth', ClerkAuthenticated::class);
        $router->aliasMiddleware('clerk.guest', ClerkGuest::class);
      }
      
      public function register()
      {
        $this->mergeConfigFrom(__DIR__."/../config/clerk.php", "clerk");
    }
}
