<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Wiki\WikiController;

class HomeController extends Controller
{
    public function __invoke(WikiController $wiki): mixed
    {
        return $wiki->show('home');
    }
}
