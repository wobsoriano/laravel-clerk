<?php

use Illuminate\Support\Facades\Route;
use Wobsoriano\LaravelClerk\ClerkClient;
use Clerk\Backend\Models\Operations;

Route::get('/', function (ClerkClient $clerkClient) {
    $request = new Operations\GetUserListRequest(
        lastActiveAtBefore: 1700690400000,
        lastActiveAtAfter: 1700690400000,
        createdAtBefore: 1730160000000,
        createdAtAfter: 1730160000000,
    );

    // $response = $clerkClient->getClient()->users->get(
    //     userId: 'user_2thq5ZJjHEBl4L3AgJl47VyGSCk'
    // );
    // dd($response);

    // dd($response);
    // dd(auth()->guard('clerk')->user());

    return view('welcome');
});
