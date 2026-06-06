<?php

require_once 'includes/widgets/header.php';

$featuredProjects = stmtFetchAll(
    'SELECT name, description, homepage_url, github_url, docs_url
     FROM featured_projects
     ORDER BY sort_order ASC, name ASC'
);

$tpl->assign('featuredProjects', $featuredProjects);
$tpl->display('featuredProjects.tpl');

require_once 'includes/widgets/footer.php';
