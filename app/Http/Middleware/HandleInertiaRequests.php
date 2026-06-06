<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Inertia\Middleware;

class HandleInertiaRequests extends Middleware
{
    protected $rootView = 'app';

    public function version(Request $request): ?string
    {
        return parent::version($request);
    }

    public function share(Request $request): array
    {
        $user = $request->user();

        return [
            ...parent::share($request),
            'name' => config('app.name'),
            'auth' => [
                'user' => $user ? [
                    'id' => $user->id,
                    'name' => $user->name,
                    'username' => $user->username,
                    'email' => $user->email,
                    'privileges' => $user->privilegeKeys(),
                ] : null,
            ],
            'site' => [
                'discordInviteUrl' => config('technowax.discord_invite_url'),
                'enableRegistration' => config('technowax.enable_registration'),
                'nav' => [
                    ['href' => '/', 'label' => 'Home'],
                    ['href' => '/projects', 'label' => 'Projects'],
                    ['href' => '/tools', 'label' => 'Tools'],
                    ['href' => '/markdown', 'label' => 'Document Repos'],
                    ['href' => '/services', 'label' => 'Services'],
                ],
            ],
            'flash' => [
                'status' => fn () => $request->session()->get('status'),
            ],
            'sidebarOpen' => ! $request->hasCookie('sidebar_state') || $request->cookie('sidebar_state') === 'true',
        ];
    }
}
