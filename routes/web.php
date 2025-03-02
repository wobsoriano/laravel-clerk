<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Wobsoriano\LaravelClerk\ClerkClient;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/api/protected', function (ClerkClient $clerkClient) {
    if (!Auth::check()) {
        return response()->json(['error' => 'Unauthorized'], 401);
    }

    $userId = Auth::id();
    $user = $clerkClient->getClient()->users->get($userId);

    return response()->json($user);
});
