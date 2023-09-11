<?php

require_once 'includes/widgets/header.php';

use libAllure\Sanitizer as Sanitizer;
use libAllure\ElementHidden;

$form = Sanitizer::getInstance()->filterEnum('form', [
    'FormDnsLookup',
    'FormEditWikiPage',
    'FormIndenter',
    'FormNumberFormatter',
    'FormTeamMaker',
]);

if (!isset($form)) {
    $tpl->assign('message', 'Form Not Found: ' . $form);
    $tpl->display('error.tpl');

    require_once 'includes/widgets/footer.php';
}

require_once 'includes/classes/' . $form . '.php';

$form = new $form();
$form->addElement(new ElementHidden('form', null, get_class($form)));

if ($form->validate()) {
    $form->process();

    $form->renderOutput($tpl);
}

$tpl->assignForm($form);
$tpl->display('form.tpl');

require_once 'includes/widgets/footer.php';
