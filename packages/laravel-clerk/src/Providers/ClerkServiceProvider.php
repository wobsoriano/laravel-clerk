<?php

declare(strict_types=1);

namespace Wobsoriano\LaravelClerk\Providers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\ServiceProvider;
use Wobsoriano\LaravelClerk\ClerkClient;
use Wobsoriano\LaravelClerk\Guards\ClerkGuard;

final class ClerkServiceProvider extends ServiceProvider
{
    public function boot()
    {
        Auth::extend('clerk_session', function ($app) {
            return new ClerkGuard($app->make('request'));
        });
        
        if($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../config/clerk.php' => config_path('clerk.php'),
            ], 'config');
        }

        $this->app->singleton(ClerkClient::class, function () {
            return new ClerkClient();
        });
      }
      
      public function register()
      {
        $this->mergeConfigFrom(__DIR__."/../config/clerk.php", "clerk");
    }
}
