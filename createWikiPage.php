<?php

require_once 'includes/common.php';

use \libAllure\Sanitizer as Sanitizer;
use \libAllure\DatabaseFactory as DatabaseFactory;

$sanitizer = new Sanitizer();

$sql = 'INSERT INTO wiki_pages (title) VALUES (:title) ';
$stmt = DatabaseFactory::getInstance()->prepare($sql);
$stmt->bindValue(':title', $sanitizer->filterIdentifier('title'));
$stmt->execute();

redirect('viewWikiPage.php?title=' . $sanitizer->filterIdentifier('title'), 'Page created.');

?>
