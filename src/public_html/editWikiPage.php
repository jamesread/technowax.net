<?php

require_once 'includes/common.php';
require_once 'includes/classes/FormEditWikiPage.php';

use libAllure\Sanitizer;
use libAllure\Session;

if (! Session::hasPriv('SUPERUSER')) {
    redirect('/', 'You do not have the permissions for this.');
}

Session::requirePriv('SUPERUSER');

$sanitizer = Sanitizer::getInstance();

$f = new FormEditWikiPage($sanitizer->filterString('title'));

if ($f->validate()) {
    $f->process();
    redirect(wikiUrl($sanitizer->filterString('title')), 'Page edited.');
}

require_once 'includes/widgets/header.php';

$tpl->assignForm($f);
$tpl->display('form.tpl');

require_once 'includes/widgets/footer.php';
