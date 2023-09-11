<?php

use libAllure\DatabaseFactory;
use libAllure\Session;

function getEnclosedTag($content)
{
    $matches = array();

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

    return in_array($tag, array(
        'p', 'h2', 'ul', 'li', 'h3',
    ));
}

function nl2p($text)
{
    $ret = '';

    foreach (explode("\r\n\r\n", $text) as $paragraph) {
        $tag = getEnclosedTag($paragraph);

        if (isBlockTag($tag)) {
            $ret .= $paragraph;
        } else {
            $ret .= '<p>' . $paragraph . '</p>' . "\n";
        }
    }

    $ret = str_replace("\r\n", '<br />', $ret);

    return $ret;
}

function wikify($content)
{
    $content = preg_replace(
        array(
            '#\[code\]#',
            '#\[\/code\]#',
            '#\*([\w ]+)\*#',
            '#\n[\*-] ([\S ]+)#',
            '#\_(\w+)\_#',
            '#\/(\w+)\/#',
            '#\[\[(\w+)\|([ \d\w]+)\]\]#',
            '#\[\[(\w+)\]\]#',
            '#\[(\S+)\|([ \S]+)\]#',
            '#\{([\S]+)\|([\S ]+)\}#',
            '#\#\#\# ([ \w]+)#',
                '#\#\# ([ \w]+)#',
                    '#\# ([ \w]+)#',
                        '#\[list\]#',
                        '#\[\/list\]#',
                        '#\{\|#',
                        '#\|\}#',
                        '#\|([ \w\d]+)#',
        ),
        array(
            '<p class = "code">',
            '</p>',
            '<strong>$1</strong>',
            '<li>$1</li>',
            '<u>$1</u>',
            '<em>$1</em>',
            '<a href = "viewWikiPage.php?title=$1">$2</a>',
            '<a href = "viewWikiPage.php?title=$1">$1</a>',
            '<a href = "$1" class = "external">$2</a>',
            '<a href = "$1">$2</a>',
            '<h4>$1</h4>',
            '<h3>$1</h3>',
            '<h2>$1</h2>',
            '<ul>',
            '</ul>',
            '<table>',
            '</table>',
            '<td>$1</td>',
        ),
        $content
    );

    $content = nl2p($content);

    return $content;
}

function redirect($url, $reason)
{
    define('REDIRECT', $url);
    if (!in_array('includes/widgets/header.php', get_included_files())) {
        require_once 'includes/widgets/header.minimal.php';
    }

    $tpl->assign('title', 'Redirecting: ' . $reason);
    $tpl->assign('message', '<p>You are being redirected to <a href = "' . $url . '">here</a>.</p>');
    $tpl->display('notification.tpl');

    require_once 'includes/widgets/footer.minimal.php';
}

function requirePriv($priv, $redirect)
{
    if (!Session::hasPriv($priv)) {
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
    require_once 'libAllure/FormHandler.php';

    return new \libAllure\FormHandler($form);
}
