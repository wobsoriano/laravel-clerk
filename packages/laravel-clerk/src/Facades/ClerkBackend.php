<?php

namespace Wobsoriano\LaravelClerk\Facades;

use Illuminate\Support\Facades\Facade;
use Clerk\Backend\ClerkBackend as ClerkBackendSDK;

/**
 * @property-read \Clerk\Backend\Resources\Users $users
 * @property-read \Clerk\Backend\Resources\Sessions $sessions
 * @method static \Clerk\Backend\Resources\Users users()
 * @method static \Clerk\Backend\Resources\Sessions sessions()
 */
class ClerkBackend extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return ClerkBackendSDK::class;
    }

    public static function __callStatic($method, $arguments)
    {
        $instance = static::getFacadeRoot();
        return $instance->{$method};
    }
} 
