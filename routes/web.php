<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('welcome');
})->name('home');

Route::middleware('clerk.auth')->group(function () {
    Route::get('dashboard', function () {
        return Inertia::render('dashboard');
    })->name('dashboard');

    Route::get('/settings/profile', function () {
        return Inertia::render('settings/profile', [
            'user' => Auth::user(),
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