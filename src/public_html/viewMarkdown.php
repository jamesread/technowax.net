<?php

require_once 'includes/widgets/header.php';

use \libAllure\Sanitizer;

$base = __DIR__ . '/repos/';

$path = Sanitizer::getInstance()->filterString('path');
$file = Sanitizer::getInstance()->filterString('file');

if ($file == '') {
    if (file_exists($base . $path . '/README.md')) {
        $file = 'README.md';
    } else if (file_exists($base . $path . '/index.md')) {
        $file = 'index.md';
    }
} else {
    $file = strip_tags($file);
    $file = htmlspecialchars($file);
}

if ($path != '') {
    if (substr($path, -1) != '/') {
        $path .= '/';
    }
}

echo '<section>';

if ($path == '') {
    echo '<h2>Repo browser</h2>';
} else {
    $pathComponents = explode('/', $path);

    echo '<h2><a href = "viewMarkdown.php">Repos</a> &raquo;';

    foreach ($pathComponents as $index => $component) {
        if ($index == count($pathComponents) - 1) {
            echo ' ' . $component;
        } else {
            echo ' <a href="viewMarkdown.php?path=' . implode('/', array_slice($pathComponents, 0, $index + 1)) . '/">' . $component . '</a> &raquo;';
        }
    }

    echo $file;

    echo '</h2>';
}

if (!file_exists($base . $path)) {
    throw new \libAllure\exceptions\SimpleFatalError('Path not found: ' . $base . $path);
}

$files = scandir($base . $path);

echo '<ul class = "no-bullets">';
foreach ($files as $dirfile) {
    if ($dirfile[0] == '.') {
        continue;
    }

    if (is_dir($base . $path . $dirfile)) {
        echo '<li><div class = "list-icon">&#128193;</div> <a href="viewMarkdown.php?path=' . $path . $dirfile . '/">' . $dirfile . '</a></li>';
    } else {
        $mimetype = mime_content_type($base . $path . $dirfile);

        if ($mimetype == 'text/plain') {
            echo '<li><div class = "list-icon">&#128441;</div> <a href="viewMarkdown.php?path=' . $path . '&amp;file=' . $dirfile . '">' . $dirfile . '</a></li>';
        } else {
            echo '<li><div class = "list-icon">&#128437;</div> <a href="repos/' . $path . '/' . $dirfile . '">' . $dirfile . '</a> (mimetype not supported)</li>';
        }
    }
}
echo '</ul>';

echo '</section><section>';

if ($file != '') {

    // check file mimetype
    $mimetype = mime_content_type($base . $path . $file);

    if ($mimetype != 'text/plain') {
        echo 'Mimetype not supported: ' . $mimetype;
        require_once 'includes/widgets/footer.php';
        die();
    }

    $filepath = $base . $path . $file;

    if (!file_exists($filepath)) {
        throw new \libAllure\exceptions\SimpleFatalError('File not found: ' . $filepath);
    }

    $content = file_get_contents($filepath);

    $parser = new \cebe\markdown\GithubMarkdown();
    $md = $parser->parse($content);

    echo $md;
}

echo '</section>';

require_once 'includes/widgets/footer.php';
