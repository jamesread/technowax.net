<?php

require_once 'includes/widgets/header.php';

$sanitizer = new Sanitizer();

$sql = 'SELECT w.title, w.content FROM wiki_pages w WHERE w.title = :title ';
$stmt = DatabaseFactory::getInstance()->prepare($sql);
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

	$tpl->assign('page', $wikiPage);
	$tpl->display('viewWikiPage.tpl');
}

require_once 'includes/widgets/footer.php';

?>
