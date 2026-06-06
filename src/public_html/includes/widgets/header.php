<?php

require_once 'includes/common.php';

use libAllure\HtmlLinksCollection;
use libAllure\Session;

global $cfg, $tpl;

$menu = new HtmlLinksCollection;
$menu->add('/', 'Home');
$menu->add('/projects', 'Projects');
$menu->add('/tools', 'Tools');
$menu->add('/markdown', 'Document Repos');
$menu->add('/services', 'Services');

$menuAccount = new HtmlLinksCollection;

if (Session::isLoggedIn()) {

    $menuAccount->addIf(Session::isLoggedIn(), '/account', 'Account');
    $menuAccount->addIfPriv('SUPERUSER', '/users', 'Users');
    $menuAccount->add('/logout', 'Logout');
} else {
    $menuAccount->add('/login', 'Login');

    if ($cfg->get('ENABLE_REGISTRATION')) {
        $menuAccount->add('/register', 'Register');
    }
}

$tpl->assign('isLoggedIn', Session::isLoggedIn());
$tpl->assign('discordInviteUrl', $cfg->get('DISCORD_INVITE_URL'));
$tpl->assign('listLinks', $menu);
$tpl->assign('listLinksAccount', $menuAccount);
$tpl->display('header.tpl');
