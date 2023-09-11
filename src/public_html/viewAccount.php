<?php

require_once 'includes/common.php';

use \libAllure\Session as Session;

if (!Session::isLoggedIn()) {
	redirect('index.php', 'You need to be logged in to view your account.');
}

require_once 'includes/widgets/header.php';

$tpl->assign('user', Session::getUser()->getDataAll());
$tpl->display('account.tpl');

require_once 'includes/widgets/footer.php';

?>
