<?php

declare(strict_types=1);

namespace Jread\TechnowaxNet;

final class Router
{
    public function __construct(
        private readonly string $publicHtmlDir = __DIR__.'/../public_html',
    ) {}

    public function dispatch(string $requestUri): void
    {
        $path = $this->normalizePath($requestUri);

        $_SERVER['PHP_SELF'] = $path;

        chdir($this->publicHtmlDir);

        match (true) {
            $path === '/' || $path === '/index.php' => $this->serve('viewHome.php'),

            $path === '/indenter' || $path === '/indent' => $this->serveForm('FormIndenter'),

            $path === '/tools' => $this->serve('viewTools.php'),
            $path === '/tools/dns-lookup' => $this->serveForm('FormDnsLookup'),
            $path === '/tools/indenter' => $this->serveForm('FormIndenter'),
            $path === '/tools/team-maker' => $this->serveForm('FormTeamMaker'),

            $path === '/services' => $this->serve('viewServices.php'),
            $path === '/projects' => $this->serve('viewProjects.php'),
            $path === '/account' => $this->serve('viewAccount.php'),
            $path === '/login' => $this->serve('doLogin.php'),
            $path === '/logout' => $this->serve('doLogout.php'),
            $path === '/register' => $this->serve('doRegister.php'),
            $path === '/change-password' => $this->serve('changePassword.php'),
            $path === '/users' => $this->serve('listUsers.php'),
            $path === '/dyndns/updates' => $this->serve('listDynamicDnsUpdates.php'),
            $path === '/dyndns' || $path === '/dyndns.php' => $this->serve('utils/dyndns.php'),
            $path === '/markdown' => $this->serve('viewMarkdown.php'),
            $path === '/html-entities' => $this->serve('listHtmlEntities.php'),

            preg_match('#^/wiki/([^/]+)$#', $path, $wikiViewMatch) === 1 => $this->serveWikiPage(
                urldecode($wikiViewMatch[1]),
                'viewWikiPage.php',
            ),

            preg_match('#^/wiki/([^/]+)/edit$#', $path, $wikiEditMatch) === 1 => $this->serveWikiPage(
                urldecode($wikiEditMatch[1]),
                'editWikiPage.php',
            ),

            preg_match('#^/wiki/([^/]+)/create$#', $path, $wikiCreateMatch) === 1 => $this->serveWikiPage(
                urldecode($wikiCreateMatch[1]),
                'createWikiPage.php',
            ),

            preg_match('#^/form/(Form\w+)$#', $path, $formMatch) === 1 => $this->serveForm($formMatch[1]),

            default => $this->notFound(),
        };
    }

    private function normalizePath(string $requestUri): string
    {
        $path = parse_url($requestUri, PHP_URL_PATH);

        if ($path === null || $path === '' || $path === '/') {
            return '/';
        }

        return '/'.trim($path, '/');
    }

    private function serve(string $script): never
    {
        require $this->publicHtmlDir.'/'.$script;
        exit;
    }

    private function serveForm(string $form): never
    {
        $_GET['form'] = $form;
        $_REQUEST['form'] = $form;

        $this->serve('doForm.php');
    }

    private function serveWikiPage(string $title, string $script): never
    {
        $_GET['title'] = $title;
        $_REQUEST['title'] = $title;

        $this->serve($script);
    }

    private function notFound(): never
    {
        http_response_code(404);
        require $this->publicHtmlDir.'/includes/common.php';
        simpleFatalError('Page not found.');

        exit;
    }
}
