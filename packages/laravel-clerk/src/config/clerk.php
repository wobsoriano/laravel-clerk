<?php

return [
    // Clerk Publishable Key
    "publishable_key" => env("CLERK_PUBLISHABLE_KEY"),

    // Clerk Secret Key
    "secret_key" => env("CLERK_SECRET_KEY"),

    // Clerk Server URL
    "server_url" => env("CLERK_SERVER_URL"),

    // Clerk JWT key
    "jwt_key" => env("CLERK_JWT_KEY"),

    // Add authorized parties config
    'authorized_parties' => array_filter(
        explode(',', env('CLERK_AUTHORIZED_PARTIES', 'http://localhost')),
    ),
];
