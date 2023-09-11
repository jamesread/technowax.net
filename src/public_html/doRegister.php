<?php

require_once 'includes/widgets/header.php';

if ($cfg->get('ENABLE_REGISTRATION')) {
    // Hack because FormRegister needs a $db global.
    $db = \libAllure\DatabaseFactory::getInstance(); global $db;

    $fh = new \libAllure\FormHandler('libAllure\util\FormRegister');
    $fh->handle();
} else {
    $tpl->message('message', 'Registration is disabled');
    $tpl->display('error.tpl');
}

require_once 'includes/widgets/footer.php';
