<?php

namespace App\Services;

class Wikifier
{
    public function toHtml(string $content): string
    {
        $content = preg_replace_callback(
            '#\[\[([\w ]+?)\|([\w ]+?)\]\]#',
            fn (array $matches): string => '<a href="'.$this->wikiUrl($matches[1]).'">'.e($matches[2]).'</a>',
            $content,
        );

        $content = preg_replace_callback(
            '#\[\[(\w+)\]\]#',
            fn (array $matches): string => '<a href="'.$this->wikiUrl($matches[1]).'">'.e($matches[1]).'</a>',
            $content,
        );

        $replacements = [
            '#\[code\]#' => '<p class="code">',
            '#\[/code\]#' => '</p>',
            '#\*([\w ]+)\*#' => '<strong>$1</strong>',
            '#\n[\*-] ([\S ]+)#' => '<li>$1</li>',
            '#\_(\w+)\_#' => '<u>$1</u>',
            '#\/(\w+)\/#' => '<em>$1</em>',
            '#\[(\S+)\|([ \S]+)\]#' => '<a href="$1" class="external">$2</a>',
            '#\{([\S]+)\|([\S ]+)\}#' => '<a href="$1">$2</a>',
            '#\#\#\# ([ \w]+)#' => '<h4>$1</h4>',
            '#\#\# ([ \w]+)#' => '<h3>$1</h3>',
            '#\# ([ \w]+)#' => '<h2>$1</h2>',
            '#\[list\]#' => '<ul>',
            '#\[/list\]#' => '</ul>',
            '#\{\|#' => '<table>',
            '#\|\}#' => '</table>',
            '#\|([ \w\d]+)#' => '<td>$1</td>',
        ];

        $content = preg_replace(
            array_keys($replacements),
            array_values($replacements),
            $content,
        );

        return $this->nl2p($content);
    }

    public function wikiUrl(string $title): string
    {
        return '/wiki/'.rawurlencode($title);
    }

    public function wikiEditUrl(string $title): string
    {
        return $this->wikiUrl($title).'/edit';
    }

    public function wikiCreateUrl(string $title): string
    {
        return $this->wikiUrl($title).'/create';
    }

    private function nl2p(string $text): string
    {
        $ret = '';

        foreach (explode("\r\n\r\n", $text) as $paragraph) {
            $tag = $this->getEnclosedTag($paragraph);

            if ($this->isBlockTag($tag)) {
                $ret .= $paragraph;
            } else {
                $ret .= '<p>'.$paragraph.'</p>'."\n";
            }
        }

        return str_replace("\r\n", '<br />', $ret);
    }

    private function getEnclosedTag(string $content): string|false
    {
        if (preg_match('#<([\w\d]+[ =\"\w]?)>[\w\d ]+</\\1>#', $content, $matches) > 0) {
            return $matches[1];
        }

        return false;
    }

    private function isBlockTag(string|false $tag): bool
    {
        if ($tag === false || $tag === '') {
            return false;
        }

        return in_array($tag, ['p', 'h2', 'ul', 'li', 'h3'], true);
    }
}
