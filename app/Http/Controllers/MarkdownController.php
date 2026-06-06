<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Inertia\Inertia;
use Inertia\Response;
use League\CommonMark\CommonMarkConverter;

class MarkdownController extends Controller
{
    public function index(Request $request): Response
    {
        $base = config('technowax.markdown_repos_path');
        $path = trim($request->string('path')->toString(), '/');
        $file = $request->string('file')->toString();

        if ($file === '' && $path !== '') {
            if (File::exists("{$base}/{$path}/README.md")) {
                $file = 'README.md';
            } elseif (File::exists("{$base}/{$path}/index.md")) {
                $file = 'index.md';
            }
        }

        $entries = [];
        $content = null;
        $breadcrumbs = [];

        if ($path !== '') {
            $breadcrumbs = $this->breadcrumbs($path);
        }

        $directory = $path === '' ? $base : "{$base}/{$path}";

        if (File::isDirectory($directory)) {
            foreach (File::files($directory) as $entry) {
                if (str_starts_with($entry->getFilename(), '.')) {
                    continue;
                }

                $entries[] = [
                    'name' => $entry->getFilename(),
                    'type' => 'file',
                    'mime' => File::mimeType($entry->getPathname()),
                ];
            }

            foreach (File::directories($directory) as $entry) {
                if (str_starts_with(basename($entry), '.')) {
                    continue;
                }

                $entries[] = [
                    'name' => basename($entry),
                    'type' => 'directory',
                    'mime' => null,
                ];
            }
        }

        if ($file !== '' && $path !== '') {
            $filepath = "{$base}/{$path}/{$file}";

            if (File::exists($filepath) && File::mimeType($filepath) === 'text/plain') {
                $converter = new CommonMarkConverter;
                $content = $converter->convert(File::get($filepath))->getContent();
            }
        }

        return Inertia::render('Markdown/Index', [
            'path' => $path,
            'file' => $file,
            'entries' => $entries,
            'breadcrumbs' => $breadcrumbs,
            'content' => $content,
        ]);
    }

    /**
     * @return list<array{name: string, path: string}>
     */
    private function breadcrumbs(string $path): array
    {
        $parts = explode('/', trim($path, '/'));
        $breadcrumbs = [];

        foreach ($parts as $index => $part) {
            $breadcrumbs[] = [
                'name' => $part,
                'path' => implode('/', array_slice($parts, 0, $index + 1)),
            ];
        }

        return $breadcrumbs;
    }
}
