<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\DynDnsController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\HtmlEntitiesController;
use App\Http\Controllers\MarkdownController;
use App\Http\Controllers\ProjectsController;
use App\Http\Controllers\ServicesController;
use App\Http\Controllers\ToolsController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\Wiki\WikiController;
use Illuminate\Support\Facades\Route;

Route::get('/', HomeController::class)->name('home');
Route::get('/projects', [ProjectsController::class, 'index'])->name('projects');
Route::get('/services', [ServicesController::class, 'index'])->name('services');
Route::get('/tools', [ToolsController::class, 'index'])->name('tools');
Route::match(['get', 'post'], '/tools/dns-lookup', [ToolsController::class, 'dnsLookup'])->name('tools.dns-lookup');
Route::match(['get', 'post'], '/tools/indenter', [ToolsController::class, 'indenter'])->name('tools.indenter');
Route::match(['get', 'post'], '/indenter', [ToolsController::class, 'indenter']);
Route::match(['get', 'post'], '/tools/team-maker', [ToolsController::class, 'teamMaker'])->name('tools.team-maker');
Route::get('/markdown', [MarkdownController::class, 'index'])->name('markdown');
Route::get('/html-entities', [HtmlEntitiesController::class, 'index'])->name('html-entities');

Route::get('/dyndns', [DynDnsController::class, 'update'])->name('dyndns.update');
Route::get('/dyndns.php', [DynDnsController::class, 'update']);
Route::get('/dyndns/updates', [DynDnsController::class, 'updates'])->middleware('auth')->name('dyndns.updates');

Route::get('/wiki/{title}', [WikiController::class, 'show'])->name('wiki.show');
Route::get('/wiki/{title}/create', [WikiController::class, 'create'])->name('wiki.create');
Route::middleware('privilege:SUPERUSER')->group(function () {
    Route::get('/wiki/{title}/edit', [WikiController::class, 'editForm'])->name('wiki.edit');
    Route::post('/wiki/{title}/edit', [WikiController::class, 'update'])->name('wiki.update');
    Route::get('/users', [UsersController::class, 'index'])->name('users.index');
});

Route::get('/account', [AccountController::class, 'show'])->middleware('auth')->name('account');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::inertia('dashboard', 'Dashboard')->name('dashboard');
});

require __DIR__.'/settings.php';
