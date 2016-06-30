<?php

require_once 'includes/common.php';
require_once 'includes/classes/FormDnsLookup.php';
require_once 'includes/classes/FormTeamMaker.php';
require_once 'includes/classes/FormIndenter.php';
require_once 'includes/widgets/header.php';

use \libAllure\Sanitizer as Sanitizer;
use \libAllure\ElementHidden;

$sanitizer = new Sanitizer();
$form = $sanitizer->filterIdentifier('form');
$form = new $form();
$form->addElement(new ElementHidden('form', null, get_class($form)));

if ($form->validate()) {
	$form->process();

	$form->renderOutput($tpl);
}

$tpl->assignForm($form);
$tpl->display('form.tpl');

require_once 'includes/widgets/footer.php';

?>
