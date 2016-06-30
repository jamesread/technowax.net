<?php

require_once 'includes/common.php';

global $tpl;

$tpl->assign('isLoggedIn', \libAllure\Session::isLoggedIn());

if (defined('REDIRECT')) {
	$tpl->assign('REDIRECT', REDIRECT);
}

$tpl->display('header.minimal.tpl');

?>
