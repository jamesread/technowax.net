<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsurePrivilege
{
    public function handle(Request $request, Closure $next, string $privilege): Response
    {
        $user = $request->user();

        if ($user === null || ! $user->hasPrivilege($privilege)) {
            return redirect('/')->with('status', 'No permissions.');
        }

        return $next($request);
    }
}
