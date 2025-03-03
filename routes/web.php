<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Wobsoriano\LaravelClerk\ClerkClient;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/api/user', function (ClerkClient $clerkClient) {
    if (!Auth::check()) {
        return response()->json(['error' => 'Unauthorized'], 401);
    }

    $user = $clerkClient->getClient()->users->get(Auth::id());

    return response()->json($user);
});
