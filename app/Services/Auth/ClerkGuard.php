<?php

namespace App\Services\Auth;

use Illuminate\Contracts\Auth\Guard;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Http\Request;
use Clerk\Backend;
use Illuminate\Support\Facades\Context;

class ClerkGuard implements Guard
{
    protected $request;
    protected $user;
    protected $sdk;
    protected $payload;

    public function __construct(Request $request)
    {
        $this->request = $request;
        $this->sdk = Backend\ClerkBackend::builder()->setSecurity(env("CLERK_SECRET_KEY"))->build();
        $this->payload = Context::get('clerk_payload');
    }

    public function check()
    {
        return $this->payload !== null;
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

        if ($this->payload) {
            if ($this->id()) {
                $this->user = $this->sdk->users->get($this->id())->user;
            }
        }

        return $this->user;
    }

    public function id()
    {
        if ($user = $this->payload) {
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
}