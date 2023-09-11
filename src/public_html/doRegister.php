<?php

require_once 'includes/widgets/header.php';

// Hack because FormRegister needs a $db global.
$db = \libAllure\DatabaseFactory::getInstance();
global $db;

use libAllure\FormHandler;

$fh = new FormHandler('libAllure\util\FormRegister');
$fh->handle();


require_once 'includes/widgets/footer.php';
