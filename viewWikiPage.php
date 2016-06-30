<?php

require_once 'includes/widgets/header.php';

use \libAllure\Session;

$sanitizer = new libAllure\Sanitizer();

$sql = 'SELECT w.title, w.alt_title, w.content FROM wiki_pages w WHERE w.title = :title ';
$stmt = libAllure\DatabaseFactory::getInstance()->prepare($sql);
$stmt->bindValue(':title', $sanitizer->filterString('title'));
$stmt->execute();

if ($stmt->numRows() == 0) {
	$tpl->assign('message', 'Wiki page not found. <a href = "createWikiPage.php?title=' . $sanitizer->filterString('title') . '">Create?</a>');
	$tpl->display('error.tpl');
} else {
	$wikiPage = $stmt->fetchRow();
	$wikiPage['title'] = $sanitizer->escapeStringForHtml($wikiPage['title']);
	$wikiPage['content'] = $sanitizer->escapeStringForHtml($wikiPage['content']);
	$wikiPage['content'] = wikify($wikiPage['content']);
	$wikiPage['displayTitle'] = (empty($wikiPage['alt_title']) ? $wikiPage['title'] : $wikiPage['alt_title']) ;
	$wikiPage['canEdit'] = Session::hasPriv('SUPERUSER');

	$tpl->assign('page', $wikiPage);
	$tpl->display('viewWikiPage.tpl');
}

require_once 'includes/widgets/footer.php';

?>
