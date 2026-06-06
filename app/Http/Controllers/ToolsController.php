<?php

namespace App\Http\Controllers;

use App\Http\Requests\Tools\DnsLookupRequest;
use App\Http\Requests\Tools\IndenterRequest;
use App\Http\Requests\Tools\TeamMakerRequest;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;

class ToolsController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('Tools/Index');
    }

    public function dnsLookup(DnsLookupRequest $request): Response
    {
        $results = [];

        if ($request->isMethod('post')) {
            $validated = $request->validated();
            $records = @dns_get_record($validated['dns_name'], (int) $validated['record_type']);

            if (is_array($records)) {
                $results = $records;
            }
        }

        return Inertia::render('Tools/DnsLookup', [
            'dnsName' => $request->input('dns_name', ''),
            'recordType' => (int) $request->input('record_type', DNS_ALL),
            'results' => $results,
            'recordTypes' => [
                ['label' => 'All', 'value' => DNS_ALL],
                ['label' => 'MX - Mail records', 'value' => DNS_MX],
                ['label' => 'CNAME - Canonical names (aka. subdomains)', 'value' => DNS_CNAME],
                ['label' => 'A - IPV4 Addresses', 'value' => DNS_A],
                ['label' => 'AAAA - IPV6 Addresses', 'value' => DNS_AAAA],
            ],
        ]);
    }

    public function indenter(IndenterRequest $request): Response|RedirectResponse
    {
        $output = null;

        if ($request->isMethod('post')) {
            $validated = $request->validated();
            $content = e($validated['content']);
            $content = wordwrap($content, (int) $validated['line_width']);
            $prefix = $validated['prefix'] ?? '> ';

            $lines = trim($content);

            if ($request->boolean('remove_extra_newlines')) {
                $lines = str_replace("\n\n\n", "\n", $lines);
            }

            $output = '<pre>'.collect(explode("\n", $lines))
                ->map(fn (string $line): string => $prefix.$line)
                ->implode("\n").'</pre>';
        }

        return Inertia::render('Tools/Indenter', [
            'content' => $request->input('content', ''),
            'lineWidth' => (int) $request->input('line_width', 80),
            'prefix' => $request->input('prefix', '> '),
            'removeExtraNewlines' => $request->boolean('remove_extra_newlines', true),
            'output' => $output,
        ]);
    }

    public function teamMaker(TeamMakerRequest $request): Response
    {
        $teams = [];

        if ($request->isMethod('post')) {
            $validated = $request->validated();
            $members = array_values(array_filter(
                array_map('trim', explode("\n", trim($validated['team_list']))),
                fn (string $member): bool => $member !== '',
            ));

            shuffle($members);

            $teamCount = (int) $validated['team_count'] - 1;
            $currentTeam = 0;

            foreach ($members as $member) {
                $currentTeam = ($currentTeam === $teamCount) ? 0 : $currentTeam + 1;
                $teams[$currentTeam][] = $member;
            }
        }

        return Inertia::render('Tools/TeamMaker', [
            'teamList' => $request->input('team_list', ''),
            'teamCount' => (int) $request->input('team_count', 2),
            'teams' => array_values($teams),
        ]);
    }
}
