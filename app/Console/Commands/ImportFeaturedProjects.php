<?php

namespace App\Console\Commands;

use App\Models\FeaturedProject;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class ImportFeaturedProjects extends Command
{
    protected $signature = 'technowax:import-featured-projects';

    protected $description = 'Import featured projects from jread.com/projects';

    public function handle(): int
    {
        $response = Http::get('https://jread.com/projects');

        if (! $response->ok()) {
            $this->error('Failed to fetch projects page.');

            return self::FAILURE;
        }

        $imported = 0;

        foreach ($this->parseProjects($response->body()) as $index => $project) {
            FeaturedProject::query()->updateOrCreate(
                ['slug' => $project['slug']],
                [
                    'name' => $project['name'],
                    'description' => $project['description'],
                    'homepage_url' => $project['homepage_url'],
                    'github_url' => $project['github_url'],
                    'docs_url' => $project['docs_url'],
                    'sort_order' => $index,
                    'imported_at' => now(),
                ],
            );

            $imported++;
        }

        $this->info("Imported {$imported} featured projects.");

        return self::SUCCESS;
    }

    /**
     * @return list<array{slug: string, name: string, description: string|null, homepage_url: string|null, github_url: string|null, docs_url: string|null}>
     */
    private function parseProjects(string $html): array
    {
        $projects = [];

        if (preg_match_all('/<h3[^>]*>\s*<a[^>]+href="([^"]+)"[^>]*>([^<]+)<\/a>\s*<\/h3>\s*<p>([^<]*)<\/p>/i', $html, $matches, PREG_SET_ORDER)) {
            foreach ($matches as $match) {
                $homepage = $match[1];
                $projects[] = [
                    'slug' => basename(parse_url($homepage, PHP_URL_PATH) ?: $homepage),
                    'name' => trim($match[2]),
                    'description' => trim($match[3]) ?: null,
                    'homepage_url' => $homepage,
                    'github_url' => str_contains($homepage, 'github.com') ? $homepage : null,
                    'docs_url' => null,
                ];
            }
        }

        return $projects;
    }
}
