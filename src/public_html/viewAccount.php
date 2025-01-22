<?php

require_once 'includes/common.php';

use libAllure\Session as Session;

if (!Session::isLoggedIn()) {
    simpleFatalError('You are not logged in.');
}

require_once 'includes/widgets/header.php';

$tpl->assign('user', Session::getUser()->getDataAll());
$tpl->assign('permissions', Session::getUser()->getPrivs());
$tpl->display('account.tpl');

require_once 'includes/widgets/footer.php';
