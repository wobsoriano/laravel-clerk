<?php

namespace Wobsoriano\LaravelClerk;

use Clerk\Backend\ClerkBackend;

class ClerkClient {
    public ClerkBackend $backendBuilder;

    public function __construct() {
        $this->backendBuilder = ClerkBackend::builder()
            ->setSecurity(
                config('clerk.secret_key')
            )
            ->build();
    }

    public function getClient(): ClerkBackend {
        return $this->backendBuilder;
    }

    public function setClient(ClerkBackend $client): void {
        $this->backendBuilder = $client;
    }
}
