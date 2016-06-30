<?php

require_once 'includes/widgets/header.php';

$htmlEntities = array();

foreach (get_html_translation_table(HTML_ENTITIES) as $entity => $markup){
	$htmlEntities[] = array(
		'index' => ord($entity),
		'markup' => '<tt>' . htmlspecialchars($markup) . '</tt>',
		'entity' => $markup,
	);
}



$tpl->assign('title', 'List of html entities');
$tpl->assign('headers', array('Ordinal/Index', 'HTML Markup', 'Rendered Entity'));
$tpl->assign('rows', $htmlEntities);
$tpl->display('table.tpl');

require_once 'includes/widgets/footer.php';

?>
