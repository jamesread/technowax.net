<?php

require_once 'includes/common.php';

use libAllure\Session as Session;
use libAllure\HtmlLinksCollection as HtmlLinksCollection;

$menu = new HtmlLinksCollection();
$menu->add('index.php', 'Home');
$menu->add('viewMarkdown.php', 'Document Repos');
$menu->add('viewTools.php', 'Tools');

$menuAccount = new HtmlLinksCollection();

if (Session::isLoggedIn()) {
    $menu->add('account.php', 'Services');

    $menuAccount->addIf(Session::isLoggedIn(), 'viewAccount.php', 'Account');
    $menuAccount->addIfPriv('SUPERUSER', 'listUsers.php', 'Users');
    $menuAccount->add('doLogout.php', 'Logout');
} else {
    $menuAccount->add('doLogin.php', 'Login');

    if ($cfg->get('ENABLE_REGISTRATION')) {
        $menuAccount->add('doRegister.php', 'Register');
    }
}

$tpl->assign('isLoggedIn', Session::isLoggedIn());
$tpl->assign('listLinks', $menu);
$tpl->assign('listLinksAccount', $menuAccount);
$tpl->display('header.tpl');
