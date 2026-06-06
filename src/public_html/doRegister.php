<?php

use libAllure\FormHandler;

require_once 'includes/widgets/header.php';

if ($cfg->get('ENABLE_REGISTRATION')) {
    $fh = new FormHandler('libAllure\util\FormRegister');
    $fh->handle();
} else {
    $tpl->assign('message', 'Registration is disabled');
    $tpl->display('error.tpl');
}

require_once 'includes/widgets/footer.php';
