<?php

require_once 'includes/common.php';

use \libAllure\DatabaseFactory;

$san = \libAllure\Sanitizer::getInstance();

if (isset($_REQUEST['update'])) {
    $sql = 'INSERT INTO dyndns (timestamp, ipAddress, ident, user) VALUES (now(), :ipAddress, :ident, :user) ';
    $stmt = DatabaseFactory::getInstance()->prepare($sql);
    $stmt->execute([
        'ipAddress' => $_SERVER['REMOTE_ADDR'],
        'user' => $san->filterUint('user'),
        'ident' => $san->filterString('ident', null),
    ]);
}

?>
