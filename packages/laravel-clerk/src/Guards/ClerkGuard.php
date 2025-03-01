<?php

namespace Wobsoriano\LaravelClerk\Guards;

use Illuminate\Contracts\Auth\Guard;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Http\Request;
use Clerk\Backend\ClerkBackend;
use Clerk\Backend\Helpers\Jwks\AuthenticateRequest;
use Clerk\Backend\Helpers\Jwks\AuthenticateRequestOptions;
use Clerk\Backend\Helpers\Jwks\RequestState;

class ClerkGuard implements Guard
{ 
    protected $user;
    protected ClerkBackend $sdk;
    protected RequestState $requestState;

    public function __construct(Request $request, ClerkBackend $sdk)
    {
        $this->sdk = $sdk;
        $this->requestState = $this->authenticateRequest($request);
    }

    public function check()
    {
        return $this->requestState->getPayload() !== null;
    }

    public function guest()
    {
        return !$this->check();
    }

    public function user()
    {
        if ($this->user !== null) {
            return $this->user;
        }

        $payload = $this->requestState->getPayload();
        if ($payload) {
            if ($this->id()) {
                $this->user = $this->sdk->users->get($this->id())->user;
            }
        }

        return $this->user;
    }

    public function id()
    {
        if ($user = $this->requestState->getPayload()) {
            $sub = data_get($user, 'sub', null);
            return $sub ?? null;
        }
    }

    public function validate(array $credentials = [])
    {
        throw new \Exception('Method not implemented.');
    }

    public function hasUser()
    {
        return $this->user() !== null;
    }

    public function setUser(Authenticatable $user)
    {
        throw new \Exception('Method not implemented.');
    }

    protected function authenticateRequest(Request $request): RequestState
    {
      // TODO: Make this dynamic
      $options = new AuthenticateRequestOptions(
          secretKey: env("CLERK_SECRET_KEY"),
          authorizedParties: [
              // Str::of(config('app.url'))->ltrim('/')->toString()
              'http://laravel-clerk.localhost'
          ],
      );

      $requestState = AuthenticateRequest::authenticateRequest(
          $this->createPsr7Request($request),
          $options
      );

      return $requestState;
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
