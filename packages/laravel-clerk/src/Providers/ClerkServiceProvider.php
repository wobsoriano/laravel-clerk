<?php

namespace Wobsoriano\LaravelClerk\Providers;

use Clerk\Backend\ClerkBackend;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;
use Wobsoriano\LaravelClerk\Guards\ClerkGuard;

class ClerkServiceProvider extends ServiceProvider
{
    public function boot()
    {
        Auth::extend('clerk_session', function ($app) {
            return new ClerkGuard(
                $app->make('request'),
                $app->make(ClerkBackend::class)
            );
        });
        
        $this->publishes([
            __DIR__.'/../config/clerk.php' => config_path('clerk.php'),
        ], 'config');
      }
      
      public function register()
      {
        $this->mergeConfigFrom(__DIR__."/../config/clerk.php", "clerk");

        $this->app->singleton(ClerkBackend::class, function ($app) {
            $config = $app["config"]->get("clerk");
            $sdk = ClerkBackend::builder();
            $sdk->setSecurity($config["secret_key"]);
            if ($config["server_url"]) {
                $sdk->setServerUrl($config["server_url"]);
            }
            return $sdk->build();
        });
    }
}
