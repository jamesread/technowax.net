<?php

require_once 'includes/common.php';
require_once 'includes/classes/FormDnsLookup.php';
require_once 'includes/widgets/header.php';

$sanitizer = new Sanitizer();
$form = $sanitizer->filterIdentifier('form');
$form = new $form();
$form->addElement(Element::factory('hidden', 'form', null, get_class($form)));

$tpl->assignForm($form);
$tpl->display('form.tpl');

if ($form->validate()) {
	$form->process();

	$form->renderOutput($tpl);
}

require_once 'includes/widgets/footer.php';

?>
