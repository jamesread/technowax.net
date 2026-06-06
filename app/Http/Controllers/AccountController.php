<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class AccountController extends Controller
{
    public function show(Request $request): Response
    {
        $user = $request->user();

        return Inertia::render('Account/Show', [
            'user' => [
                'id' => $user->id,
                'username' => $user->username ?? $user->name,
                'email' => $user->email,
            ],
            'permissions' => $user->privilegeDetails(),
        ]);
    }
}
