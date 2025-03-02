# Laravel Clerk

Laravel integration for Clerk authentication.

## Installation

```bash
composer require wobsoriano/laravel-clerk
```

## Usage

### Option 1: Using the Laravel Integration (Recommended)

The package provides a Laravel-friendly way to interact with Clerk. All these methods use the same shared SDK instance:

```php
// Using the Facade (with import)
use Wobsoriano\LaravelClerk\Facades\ClerkBackend;

// Access SDK resources
$users = ClerkBackend::users()->get('user_id');
$sessions = ClerkBackend::sessions()->list();

// OR using the global alias (no import needed)
$users = \ClerkBackend::users()->get('user_id');

// Using dependency injection
use Clerk\Backend\ClerkBackend;
class YourController 
{
    public function __construct(private ClerkBackend $clerk) 
    {
        // Uses the same shared SDK instance
        $users = $this->clerk->users->get('user_id');
    }
}

// Using the container
$clerk = app(ClerkBackend::class); // Same shared instance
$users = $clerk->users->get('user_id');
```

### Option 2: Direct SDK Usage (Not Recommended)

While possible, creating a new SDK instance directly bypasses the shared instance and Laravel's configuration:

```php
use Clerk\Backend\ClerkBackend;

// This creates a new instance (not using the shared one)
$sdk = ClerkBackend::builder()
    ->setSecurity(config('clerk.secret_key'))
    ->setServerUrl(config('clerk.server_url')) // Optional
    ->build();
```

## Configuration

Publish the configuration file:

```bash
php artisan vendor:publish --provider="Wobsoriano\LaravelClerk\Providers\ClerkServiceProvider"
```

Then set your Clerk credentials in your `.env` file:

```env
CLERK_SECRET_KEY=your_secret_key
CLERK_PUBLISHABLE_KEY=your_publishable_key
```

## Benefits of Using the Laravel Integration

1. **Singleton Pattern**: A single shared SDK instance across your entire application
2. **Automatic Configuration**: The SDK is automatically configured using your `.env` settings
3. **Laravel Service Container**: Proper integration with Laravel's dependency injection
4. **Future Features**: Access to any Laravel-specific features we add in the future
