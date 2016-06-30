<?php

require_once 'includes/common.php';

use \libAllure\DatabaseFactory;
use \libAllure\Sanitizer;

if (isset($_REQUEST['update'])) {
	$sql = 'INSERT INTO dyndns (timestamp, ipAddress, ident, user) VALUES (now(), :ipAddress, :ident, :user) ';
	$stmt = DatabaseFactory::getInstance()->prepare($sql);
	$stmt->bindValue('ipAddress', $_SERVER['REMOTE_ADDR']);
	$stmt->bindValue('user', Sanitizer::getInstance()->filterUint('user'));

	if (!empty($_REQUEST['ident'])) {
		$stmt->bindValue('ident', Sanitizer::getInstance()->filterString('ident'));
	} else {
		$stmt->bindValue('ident', null);
	}

	$stmt->execute();
}

?>
