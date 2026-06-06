<?php

namespace App\Http\Controllers;

use App\Models\User;
use Inertia\Inertia;
use Inertia\Response;

class UsersController extends Controller
{
    public function index(): Response
    {
        $users = User::query()
            ->with('group:id,title')
            ->orderBy('username')
            ->get(['id', 'username', 'group_id'])
            ->map(fn (User $user) => [
                'id' => $user->id,
                'username' => $user->username ?? $user->name,
                'groupName' => $user->group?->title,
            ]);

        return Inertia::render('Users/Index', [
            'users' => $users,
        ]);
    }
}
