<?php

require_once 'includes/common.php';
require_once 'libAllure/HtmlLinksCollection.php';

use libAllure\Session as Session;
use libAllure\HtmlLinksCollection as HtmlLinksCollection;

$menu = new HtmlLinksCollection();
$menu->add('index.php', 'Home');
$menu->add('viewWikiPage.php?title=tools', 'Tools');
$menu->addIf(Session::isLoggedIn(), 'account.php', 'Account');
$menu->addIfPriv('SUPERUSER', 'listUsers.php', 'Users');
$menu->addIf(Session::isLoggedIn(), 'doLogout.php', 'Logout');
$menu->addIf(!Session::isLoggedIn(), 'doLogin.php', 'Login');
$menu->addIf(!Session::isLoggedIn(), 'doRegister.php', 'Register');

$tpl->assign('isLoggedIn', Session::isLoggedIn());
$tpl->assign('listLinks', $menu);
$tpl->display('header.tpl');

?>
