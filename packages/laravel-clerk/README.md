# Laravel Clerk

Laravel integration for [Clerk](https://clerk.com). Access Clerk's BAPI and optionally use the custom auth guard.

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

## Authentication Guard (Optional)

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
    if (!Auth::check()) {
        return response()->json(['error' => 'Unauthorized'], 401);
    }

    $userId = Auth::id();
    $user = $clerkClient->getClient()->users->get($userId);

    return response()->json($user);
});
```

## License

MIT
