<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Wobsoriano\LaravelClerk\ClerkClient;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('welcome');
})->name('home');

Route::middleware([])->group(function () {
    Route::get('dashboard', function () {
        return Inertia::render('dashboard');
    })->name('dashboard');

    Route::get('/sign-in', function () {
        return Inertia::render('auth/sign-in');
    })->name('sign-in');

    Route::get('/sign-up', function () {
        return Inertia::render('auth/sign-up');
    })->name('sign-up');
});

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
