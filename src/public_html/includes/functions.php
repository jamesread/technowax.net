<?php

use libAllure\DatabaseFactory;
use libAllure\FormHandler;
use libAllure\Session;

function getEnclosedTag($content)
{
    $matches = [];

    preg_match('#<([\w\d]+[ =\"\w]?)>[\w\d ]+<\/\\1>#', $content, $matches) > 0;

    if (count($matches) == 2) {
        $tag = next($matches);

        return $tag;
    } else {
        return false;
    }
}

function isBlockTag($tag)
{
    if (empty($tag)) {
        return false;
    }

    return in_array($tag, [
        'p', 'h2', 'ul', 'li', 'h3',
    ]);
}

function nl2p($text)
{
    $ret = '';

    foreach (explode("\r\n\r\n", $text) as $paragraph) {
        $tag = getEnclosedTag($paragraph);

        if (isBlockTag($tag)) {
            $ret .= $paragraph;
        } else {
            $ret .= '<p>'.$paragraph.'</p>'."\n";
        }
    }

    $ret = str_replace("\r\n", '<br />', $ret);

    return $ret;
}

function wikiUrl(string $title): string
{
    return '/wiki/'.rawurlencode($title);
}

function wikiEditUrl(string $title): string
{
    return wikiUrl($title).'/edit';
}

function wikiCreateUrl(string $title): string
{
    return wikiUrl($title).'/create';
}

function wikify($content)
{
    $content = preg_replace_callback(
        '#\[\[([\w ]+?)\|([\w ]+?)\]\]#',
        static fn (array $matches): string => '<a href = "'.wikiUrl($matches[1]).'">'.$matches[2].'</a>',
        $content
    );

    $content = preg_replace_callback(
        '#\[\[(\w+)\]\]#',
        static fn (array $matches): string => '<a href = "'.wikiUrl($matches[1]).'">'.$matches[1].'</a>',
        $content
    );

    $replacements = [
        '#\[code\]#' => '<p class = "code">',
        '#\[\/code\]#' => '</p>',
        '#\*([\w ]+)\*#' => '<strong>$1</strong>',
        '#\n[\*-] ([\S ]+)#' => '<li>$1</li>',
        '#\_(\w+)\_#' => '<u>$1</u>',
        '#\/(\w+)\/#' => '<em>$1</em>',
        '#\[(\S+)\|([ \S]+)\]#' => '<a href = "$1" class = "external">$2</a>',
        '#\{([\S]+)\|([\S ]+)\}#' => '<a href = "$1">$2</a>',
        '#\#\#\# ([ \w]+)#' => '<h4>$1</h4>',
        '#\#\# ([ \w]+)#' => '<h3>$1</h3>',
        '#\# ([ \w]+)#' => '<h2>$1</h2>',
        '#\[list\]#' => '<ul>',
        '#\[\/list\]#' => '</ul>',
        '#\{\|#' => '<table>',
        '#\|\}#' => '</table>',
        '#\|([ \w\d]+)#' => '<td>$1</td>',
    ];

    $content = preg_replace(
        array_keys($replacements),
        array_values($replacements),
        $content
    );

    $content = nl2p($content);

    return $content;
}

function redirect($url, $reason)
{
    header('Location:'.$url);

    define('REDIRECT', $url);
    if (! in_array('includes/widgets/header.php', get_included_files())) {
        require_once 'includes/widgets/header.minimal.php';
    }

    $tpl->assign('title', 'Redirecting: '.$reason);
    $tpl->assign('message', '<p>You are being redirected to <a href = "'.$url.'">here</a>.</p>');
    $tpl->display('notification.tpl');

    require_once 'includes/widgets/footer.minimal.php';
}

function simpleFatalError($message)
{
    global $tpl;

    require_once 'includes/widgets/header.php';

    $tpl->assign('message', '<p>'.$message.'</p>');
    $tpl->display('notification.tpl');

    require_once 'includes/widgets/footer.minimal.php';
}

function requirePriv($priv, $redirect)
{
    if (! Session::hasPriv($priv)) {
        redirect($redirect, 'No permissions.');
    }
}

function stmt($sql)
{
    return DatabaseFactory::getInstance()->prepare($sql);
}

function stmtFetchAll($sql)
{
    $stmt = stmt($sql);
    $stmt->execute();

    return $stmt->fetchAll();
}

function newFormHandler($form)
{
    return new FormHandler($form);
}
