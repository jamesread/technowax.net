<?php

require_once 'includes/common.php';

use libAllure\DatabaseFactory;
use libAllure\Sanitizer;

$sanitizer = new Sanitizer;

$sql = 'INSERT INTO wiki_pages (title) VALUES (:title) ';
$stmt = DatabaseFactory::getInstance()->prepare($sql);
$stmt->bindValue(':title', $sanitizer->filterIdentifier('title'));
$stmt->execute();

redirect(wikiUrl($sanitizer->filterIdentifier('title')), 'Page created.');
