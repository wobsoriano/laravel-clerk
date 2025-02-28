<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Clerk\Backend\Helpers\Jwks\AuthenticateRequest;
use Clerk\Backend\Helpers\Jwks\AuthenticateRequestOptions;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Context;

class Clerk
{
    public function handle(Request $request, Closure $next): Response
    {
        $options = new AuthenticateRequestOptions(
            secretKey: env("CLERK_SECRET_KEY"),
            authorizedParties: [
                Str::of(config('app.url'))->ltrim('/')->toString()
            ],
        );

        $requestState = AuthenticateRequest::authenticateRequest(
            $this->createPsr7Request($request),
            $options
        );

        Context::add('clerk_payload', $requestState->getPayload());

        return $next($request);
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
