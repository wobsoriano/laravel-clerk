# Laravel Clerk

> **Proof of Concept**: Laravel integration for [Clerk](https://clerk.com). This package provides a custom auth guard and Backend API integration for Clerk authentication in Laravel applications. Currently experimental and not recommended for production use.

Demo: https://laravel-clerk.laravel.cloud

## Features

- Custom authentication guard for Clerk sessions
- Backend API integration via [clerk-sdk-php](https://github.com/clerk/clerk-sdk-php)
- Middleware for protected routes

## Installation

```bash
composer require wobsoriano/laravel-clerk
```

## Configuration

1. Publish the configuration file:

```bash
php artisan vendor:publish --provider="Wobsoriano\LaravelClerk\Providers\ClerkServiceProvider"
```

2. Add your Clerk credentials to your `.env` file:

```env
CLERK_SECRET_KEY=your_secret_key
CLERK_PUBLISHABLE_KEY=your_publishable_key
```

## Usage

```php
use Wobsoriano\LaravelClerk\ClerkClient;

Route::get('/api/user', function (ClerkClient $clerkClient) {
    $user = $clerkClient->getClient()->users->get('user_id');

    return response()->json($user);
});
```

## Authentication Guard

If you want to use Clerk for Laravel authentication, update your `config/auth.php`:

```php
return [
    'defaults' => [
        'guard' => 'clerk',
        // ...
    ],
    'guards' => [
        'clerk' => [
            'driver' => 'clerk_session',
        ],
    ],
    // ...
]
```

Then you can use it like so:

```php
use Wobsoriano\LaravelClerk\ClerkClient;

Route::get('/api/protected', function (ClerkClient $clerkClient) {
    $userId = Auth::id();
    $user = $clerkClient->getClient()->users->get($userId)->user;

    return response()->json($user);
})->middleware('clerk.auth');
```

The package provides two middlewares for handling authentication:

- `clerk.auth`: Ensures the user is authenticated, redirects to sign-in if not
- `clerk.guest`: Ensures the user is not authenticated, redirects to dashboard if they are

Example usage in routes:

```php
// Protected routes
Route::middleware('clerk.auth')->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    });
});

// Guest routes
Route::middleware('clerk.guest')->group(function () {
    Route::get('/sign-in', function () {
        return view('auth.sign-in');
    })->name('sign-in');
});
```

## License

MIT
