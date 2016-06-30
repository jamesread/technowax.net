<?php

require_once 'includes/common.php';
require_once 'includes/classes/FormEditWikiPage.php';

Session::requirePriv('SUPERUSER');

$sanitizer = new Sanitizer();

$f = new FormEditWikiPage($sanitizer->filterString('title'));

if ($f->validate()) {
	$f->process();
	redirect('viewWikiPage.php?title=' . $sanitizer->filterString('title'), 'Page edited.');
}

require_once 'includes/widgets/header.php';

$tpl->assignForm($f);
$tpl->display('form.tpl');

require_once 'includes/widgets/footer.php';

?>
