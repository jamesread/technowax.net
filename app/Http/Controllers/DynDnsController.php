<?php

namespace App\Http\Controllers;

use App\Models\DynDnsUpdate;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Inertia\Inertia;
use Inertia\Response as InertiaResponse;

class DynDnsController extends Controller
{
    public function update(Request $request): Response
    {
        if ($request->has('update')) {
            DynDnsUpdate::query()->create([
                'ip_address' => $request->ip() ?? '0.0.0.0',
                'ident' => $request->string('ident')->toString() ?: null,
                'user_id' => (int) $request->query('user'),
            ]);
        }

        return response('', 200);
    }

    public function updates(Request $request): InertiaResponse
    {
        $updates = DynDnsUpdate::query()
            ->where('user_id', $request->user()->id)
            ->orderByDesc('timestamp')
            ->limit(15)
            ->get(['ident', 'ip_address', 'timestamp']);

        return Inertia::render('DynDns/Updates', [
            'updates' => $updates,
            'userId' => $request->user()->id,
        ]);
    }
}
