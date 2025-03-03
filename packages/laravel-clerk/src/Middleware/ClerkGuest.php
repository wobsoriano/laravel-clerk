<?php

namespace Wobsoriano\LaravelClerk\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ClerkGuest
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::guard('clerk')->check()) {
            return redirect()->route('dashboard');
        }

        return $next($request);
    }
} 