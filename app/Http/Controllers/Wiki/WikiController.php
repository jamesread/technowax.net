<?php

namespace App\Http\Controllers\Wiki;

use App\Http\Controllers\Controller;
use App\Http\Requests\Wiki\UpdateWikiPageRequest;
use App\Models\WikiPage;
use App\Services\Wikifier;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;

class WikiController extends Controller
{
    public function __construct(private readonly Wikifier $wikifier) {}

    public function show(string $title): Response
    {
        $page = WikiPage::query()->where('title', $title)->first();

        if ($page === null) {
            return Inertia::render('Wiki/NotFound', [
                'title' => $title,
                'createUrl' => $this->wikifier->wikiCreateUrl($title),
            ]);
        }

        return Inertia::render('Wiki/Show', [
            'page' => [
                'title' => $page->title,
                'displayTitle' => $page->alt_title ?: $page->title,
                'content' => $page->content ? $this->wikifier->toHtml(e($page->content)) : '',
                'canEdit' => request()->user()?->hasPrivilege('SUPERUSER') ?? false,
            ],
        ]);
    }

    public function create(string $title): RedirectResponse
    {
        WikiPage::query()->firstOrCreate(['title' => $title]);

        return redirect($this->wikifier->wikiUrl($title))->with('status', 'Page created.');
    }

    public function editForm(string $title): Response
    {
        $page = WikiPage::query()->where('title', $title)->firstOrFail();

        return Inertia::render('Wiki/Edit', [
            'page' => [
                'title' => $page->title,
                'alt_title' => $page->alt_title,
                'content' => $page->content,
            ],
        ]);
    }

    public function update(string $title, UpdateWikiPageRequest $request): RedirectResponse
    {
        $page = WikiPage::query()->where('title', $title)->firstOrFail();
        $page->update($request->validated());

        return redirect($this->wikifier->wikiUrl($title))->with('status', 'Page edited.');
    }
}
