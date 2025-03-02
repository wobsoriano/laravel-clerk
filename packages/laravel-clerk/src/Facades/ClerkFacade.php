<?php

namespace Wobsoriano\LaravelClerk\Facades;

use Illuminate\Support\Facades\Facade;
use Wobsoriano\LaravelClerk\ClerkClient;

class ClerkFacade extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return ClerkClient::class;
    }
} 
