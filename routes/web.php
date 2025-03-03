<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Wobsoriano\LaravelClerk\ClerkClient;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('welcome');
})->name('home');

Route::get('/api/user', function (ClerkClient $clerkClient) {
    if (!Auth::check()) {
        return response()->json(['error' => 'Unauthorized'], 401);
    }

    $user = $clerkClient->getClient()->users->get(Auth::id());

    return response()->json($user);
});

// Route::middleware(['auth', 'verified'])->group(function () {
//     Route::get('dashboard', function () {
//         return Inertia::render('dashboard');
//     })->name('dashboard');
// });
