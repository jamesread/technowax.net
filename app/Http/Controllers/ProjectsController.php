<?php

namespace App\Http\Controllers;

use App\Models\FeaturedProject;
use Inertia\Inertia;
use Inertia\Response;

class ProjectsController extends Controller
{
    public function index(): Response
    {
        $projects = FeaturedProject::query()
            ->orderBy('sort_order')
            ->orderBy('name')
            ->get(['name', 'description', 'homepage_url', 'github_url', 'docs_url']);

        return Inertia::render('Projects/Index', [
            'projects' => $projects,
        ]);
    }
}
