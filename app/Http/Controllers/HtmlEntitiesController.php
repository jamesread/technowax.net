<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Inertia\Response;

class HtmlEntitiesController extends Controller
{
    public function index(): Response
    {
        $rows = [];

        foreach (get_html_translation_table(HTML_ENTITIES) as $entity => $markup) {
            $rows[] = [
                'index' => ord($entity),
                'markup' => '<tt>'.htmlspecialchars($markup).'</tt>',
                'entity' => $markup,
            ];
        }

        return Inertia::render('HtmlEntities/Index', [
            'rows' => $rows,
        ]);
    }
}
