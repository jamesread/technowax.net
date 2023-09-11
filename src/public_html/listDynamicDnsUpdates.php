<?php

require_once 'includes/widgets/header.php';

use libAllure\DatabaseFactory;
use libAllure\Session;

$sql = 'SELECT d.ident, d.ipAddress, d.timestamp FROM dyndns d WHERE d.user = :userId ORDER BY d.timestamp DESC LIMIT 15';
$stmt = DatabaseFactory::getInstance()->prepare($sql);
$stmt->bindValue(':userId', Session::getUser()->getId());
$stmt->execute();

$tpl->assign('listDdUpdates', $stmt->fetchAll());
$tpl->assign('userId', Session::getUser()->getId());
$tpl->display('listDynamicDnsUpdates.tpl');

require_once 'includes/widgets/footer.php';
