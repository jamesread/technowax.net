<?php

return [
    'discord_invite_url' => env('DISCORD_INVITE_URL'),
    'enable_registration' => (bool) env('ENABLE_REGISTRATION', false),
    'markdown_repos_path' => env('MARKDOWN_REPOS_PATH', base_path('storage/app/markdown-repos')),
];
