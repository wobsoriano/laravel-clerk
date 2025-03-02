# Laravel Clerk

Unofficial Laravel integration for [Clerk](https://clerk.com).

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

3. Update your `config/auth.php` to use the `clerk` guard:

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

## Usage

```php
use Wobsoriano\LaravelClerk\Facades\ClerkBackend;

Route::get('/api/protected', function () {
    if (!auth()->check()) {
        return response()->json(['error' => 'Unauthorized'], 401);
    }

    $userId = auth()->id();
    $user = ClerkBackend::users()->get($userId);

    return response()->json($user);
});
```

## License

MIT
