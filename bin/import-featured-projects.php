#!/usr/bin/env php
<?php

declare(strict_types=1);

use Jread\TechnowaxNet\FeaturedProjectImporter;

require dirname(__DIR__).'/vendor/autoload.php';

chdir(dirname(__DIR__).'/src/public_html');
require 'includes/common.php';

$sourceUrl = $argv[1] ?? null;

try {
    $count = (new FeaturedProjectImporter)->import($sourceUrl);
    fwrite(STDOUT, "Imported {$count} featured projects.\n");
} catch (Throwable $e) {
    fwrite(STDERR, 'Import failed: '.$e->getMessage().PHP_EOL);
    exit(1);
}
