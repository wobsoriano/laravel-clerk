<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Wobsoriano\LaravelClerk\ClerkClient;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('welcome');
})->name('home');

Route::middleware('clerk.auth')->group(function () {
    Route::get('dashboard', function () {
        return Inertia::render('dashboard');
    })->name('dashboard');

    Route::get('/settings/profile', function (ClerkClient $clerkClient) {
        $user = $clerkClient->getClient()->users->get(Auth::id());

        return Inertia::render('settings/profile', [
            'user' => $user->user,
        ]);
    })->name('settings.profile');
});

Route::middleware('clerk.guest')->group(function () {
    Route::get('/sign-in', function () {
        return Inertia::render('auth/sign-in');
    })->name('sign-in');

    Route::get('/sign-up', function () {
        return Inertia::render('auth/sign-up');
    })->name('sign-up');
});