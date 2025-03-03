<?php

namespace Wobsoriano\LaravelClerk\Guards;

use Illuminate\Contracts\Auth\Guard;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Http\Request;
use Clerk\Backend\Helpers\Jwks\AuthenticateRequest;
use Clerk\Backend\Helpers\Jwks\AuthenticateRequestOptions;
use Clerk\Backend\Helpers\Jwks\RequestState;
use Illuminate\Support\Str;

final class ClerkGuard implements Guard
{ 
    protected $user;
    protected RequestState $requestState;

    public function __construct(Request $request)
    {
        $this->requestState = $this->authenticateRequest($request);

        // // Initialize user from payload if signed in
        if ($this->requestState->isSignedIn()) {
            $payload = $this->requestState->getPayload();
            $this->user = (object) [
                'id' => $payload->sub,
                'email' => $payload->email
            ];
        }
    }

    /**
     * Check if the user is authenticated against Clerk
     */
    public function check()
    {
        return $this->requestState->isSignedIn();
    }

    /**
     * Check if the user is a guest (not authenticated)
     */
    public function guest()
    {
        return $this->requestState->isSignedOut();
    }

    public function user()
    {
        return $this->user;
    }

    /**
     * Get the currently authenticated user's Clerk ID (sub claim from JWT)
     */
    public function id()
    {
        return $this->user?->id;
    }

    /**
     * Validate credentials - Not used with Clerk as it handles its own authentication
     */
    public function validate(array $credentials = [])
    {
        return false;
    }

    /**
     * Check if we have a user payload cached
     */
    public function hasUser()
    {
        return $this->user !== null;
    }

    /**
     * Set the current user - Not used with Clerk as it handles its own user management
     */
    public function setUser(Authenticatable $user)
    {
        throw new \Exception('Cannot set user directly when using Clerk authentication.');
    }

    protected function authenticateRequest(Request $request): RequestState
    {
        $options = new AuthenticateRequestOptions(
            secretKey: config('clerk.secret_key'),
            authorizedParties: ['http://laravel-clerk.localhost'],
            jwtKey: config('clerk.jwt_key'),
        );

        return AuthenticateRequest::authenticateRequest(
            $this->createPsr7Request($request),
            $options
        );
    }

    protected function createPsr7Request(Request $request)
    {
        return new \GuzzleHttp\Psr7\ServerRequest(
            $request->getMethod(),
            $request->getUri(),
            $request->headers->all(),
            $request->getContent(),
            $request->getProtocolVersion()
        );
    }
}
