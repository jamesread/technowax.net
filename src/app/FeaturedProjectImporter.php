<?php

declare(strict_types=1);

namespace Jread\TechnowaxNet;

use libAllure\DatabaseFactory;

final class FeaturedProjectImporter
{
    private const SOURCE_URL = 'https://jread.com/projects';

    public function import(?string $sourceUrl = null): int
    {
        $html = $this->fetch($sourceUrl ?? self::SOURCE_URL);
        $projects = $this->parseFeaturedProjects($html);

        return $this->save($projects);
    }

    /**
     * @return list<array{
     *     slug: string,
     *     name: string,
     *     description: string,
     *     homepage_url: ?string,
     *     github_url: ?string,
     *     docs_url: ?string,
     *     sort_order: int
     * }>
     */
    public function parseFeaturedProjects(string $html): array
    {
        if (! preg_match('/Featured projects(.*?)Browse by technologies/s', $html, $section)) {
            throw new \RuntimeException('Could not find featured projects section in source HTML.');
        }

        if (! preg_match_all('/<article class="project">(.*?)<\/article>/s', $section[1], $articles)) {
            throw new \RuntimeException('No featured project entries found in source HTML.');
        }

        $projects = [];

        foreach ($articles[1] as $index => $article) {
            if (! preg_match('/<h2><a href="[^"]+">([^<]+)<\/a><\/h2>/', $article, $titleMatch)) {
                continue;
            }

            preg_match('/<aside class="mt3">([^<]+)<\/aside>/', $article, $descriptionMatch);
            preg_match('/<h2><a href="(\/projects\/[^"]+)"/', $article, $homepageMatch);
            preg_match_all('/<li><a href="(https?:[^"]+)">([^<]+)<\/a><\/li>/', $article, $linkMatches, PREG_SET_ORDER);

            $githubUrl = null;
            $docsUrl = null;

            foreach ($linkMatches as $linkMatch) {
                $url = $linkMatch[1];
                $label = strtolower($linkMatch[2]);

                if (str_contains($label, 'github')) {
                    $githubUrl = $url;
                } elseif (str_contains($label, 'documentation') || str_contains($label, 'docs')) {
                    $docsUrl = $url;
                }
            }

            $homepagePath = $homepageMatch[1] ?? null;
            $name = html_entity_decode(trim($titleMatch[1]), ENT_QUOTES | ENT_HTML5, 'UTF-8');
            $slug = $homepagePath ? trim(str_replace('/projects/', '', rtrim($homepagePath, '/')), '/') : $this->slugify($name);

            $projects[] = [
                'slug' => $slug,
                'name' => $name,
                'description' => isset($descriptionMatch[1])
                    ? html_entity_decode(trim($descriptionMatch[1]), ENT_QUOTES | ENT_HTML5, 'UTF-8')
                    : '',
                'homepage_url' => $homepagePath ? 'https://jread.com'.$homepagePath : null,
                'github_url' => $githubUrl,
                'docs_url' => $docsUrl,
                'sort_order' => $index + 1,
            ];
        }

        return $projects;
    }

    /**
     * @param list<array{
     *     slug: string,
     *     name: string,
     *     description: string,
     *     homepage_url: ?string,
     *     github_url: ?string,
     *     docs_url: ?string,
     *     sort_order: int
     * }> $projects
     */
    public function save(array $projects): int
    {
        $db = DatabaseFactory::getInstance();
        $sql = 'INSERT INTO featured_projects (slug, name, description, homepage_url, github_url, docs_url, sort_order, imported_at)
            VALUES (:slug, :name, :description, :homepage_url, :github_url, :docs_url, :sort_order, NOW())
            ON DUPLICATE KEY UPDATE
                name = VALUES(name),
                description = VALUES(description),
                homepage_url = VALUES(homepage_url),
                github_url = VALUES(github_url),
                docs_url = VALUES(docs_url),
                sort_order = VALUES(sort_order),
                imported_at = NOW()';

        $stmt = $db->prepare($sql);

        foreach ($projects as $project) {
            $stmt->execute([
                'slug' => $project['slug'],
                'name' => $project['name'],
                'description' => $project['description'],
                'homepage_url' => $project['homepage_url'],
                'github_url' => $project['github_url'],
                'docs_url' => $project['docs_url'],
                'sort_order' => $project['sort_order'],
            ]);
        }

        return count($projects);
    }

    private function fetch(string $url): string
    {
        $context = stream_context_create([
            'http' => [
                'timeout' => 20,
                'header' => "User-Agent: technowax.net featured project importer\r\n",
            ],
            'ssl' => [
                'verify_peer' => true,
                'verify_peer_name' => true,
            ],
        ]);

        $html = @file_get_contents($url, false, $context);

        if ($html === false) {
            throw new \RuntimeException('Could not fetch projects from '.$url);
        }

        return $html;
    }

    private function slugify(string $name): string
    {
        $slug = strtolower($name);
        $slug = preg_replace('/[^a-z0-9]+/', '-', $slug) ?? $slug;

        return trim($slug, '-');
    }
}
