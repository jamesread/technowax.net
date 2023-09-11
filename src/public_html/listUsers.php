<?php

require_once 'includes/common.php';

requirePriv('SUPERUSER', 'index.php');

require_once 'includes/widgets/header.php';

$sql = 'SELECT u.id, u.username, g.title AS groupName FROM users u LEFT JOIN groups g ON u.`group` = g.id';
$listUsers = stmtFetchAll($sql);

$tpl->assign('listUsers', $listUsers);
$tpl->display('listUsers.tpl');

require_once 'includes/widgets/footer.php';
