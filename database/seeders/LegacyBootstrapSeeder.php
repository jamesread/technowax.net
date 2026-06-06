<?php

namespace Database\Seeders;

use App\Models\Group;
use App\Models\Permission;
use App\Models\WikiPage;
use Illuminate\Database\Seeder;

class LegacyBootstrapSeeder extends Seeder
{
    public function run(): void
    {
        Group::query()->firstOrCreate(['id' => 1], ['title' => 'Users']);

        Permission::query()->firstOrCreate(
            ['key' => 'SUPERUSER'],
            ['description' => 'Full administrative access'],
        );

        WikiPage::query()->firstOrCreate(
            ['title' => 'home'],
            [
                'alt_title' => 'technowax.net',
                'content' => <<<'WIKI'
# Welcome

technowax.net is for people who run their own software — homelabs, small servers, open source stacks, and modern infrastructure without the marketing fluff.

## Community

**Most conversation happens on [https://discord.gg/jhYWWpNJ3v|Discord]** (see also [https://matrix.to/#/#technowax:matrix.org|Matrix]). This site is utilities and documentation — DNS tools, dynamic DNS, document repos — not the social centre of the project.

## What you can use here

* {/services|Services overview} — DNS lookup, dynamic DNS, and document repos
* {/tools|Utilities} — sysadmin-oriented tools (plus a few dev leftovers)
* Document repos — markdown notes and manifests at `/markdown`

## Status

This is a **development instance**. Content is sparse by design while the platform is rebuilt. Register if you want to try dynamic DNS and account features; join Discord to talk to people.

*No nonsense. Self-hosted. Open source friendly.*
WIKI,
            ],
        );
    }
}
