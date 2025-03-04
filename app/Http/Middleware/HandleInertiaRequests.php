<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Inertia\Middleware;
use Illuminate\Support\Facades\Auth;
use Wobsoriano\LaravelClerk\Guards\ClerkGuard;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that's loaded on the first page visit.
     *
     * @see https://inertiajs.com/server-side-setup#root-template
     *
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determines the current asset version.
     *
     * @see https://inertiajs.com/asset-versioning
     */
    public function version(Request $request): ?string
    {
        return parent::version($request);
    }

    /**
     * Define the props that are shared by default.
     *
     * @see https://inertiajs.com/shared-data
     *
     * @return array<string, mixed>
     */
    public function share(Request $request): array
    {
        /** @var ClerkGuard $guard */
        $guard = Auth::guard('clerk');
        $payload = $guard->getRequestState()->getPayload();

        return array_merge(parent::share($request), [
            'initialState' => [
                'userId' => $guard->id(),
                'sessionId' => data_get($payload, 'sid'),
                'orgId' => data_get($payload, 'org_id'),
                'orgRole' => data_get($payload, 'org_role'),
                'orgPermissions' => data_get($payload, 'org_permissions'),
                'orgSlug' => data_get($payload, 'org_slug'),
                'factorVerificationAge' => data_get($payload, 'fva'),
            ],
        ]);
    }
}
