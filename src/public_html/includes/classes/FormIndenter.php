<?php

use libAllure\ElementCheckbox;
use libAllure\ElementInput;
use libAllure\ElementNumeric;
use libAllure\ElementTextbox;
use libAllure\Form;
use libAllure\Sanitizer;

class FormIndenter extends Form
{
    private string $content = '';

    public function __construct()
    {
        parent::__construct('formIndenter', 'Indenter');

        $this->addElement(new ElementTextbox('content', 'Content'));
        $this->addElement(new ElementNumeric('lineWidth', 'Line width', 80));
        $this->addElement(new ElementInput('prefix', 'Prefix', '> '))->setMinMaxLengths(0, 10);
        $this->addElement(new ElementCheckbox('removeExtraNewlines', 'Remove extra newlines', true));

        $this->addDefaultButtons('Indent');
    }

    public function process()
    {
        $this->content = Sanitizer::getInstance()->escapeStringForHtml($this->getElementValue('content'));
        $this->content = wordwrap($this->content, $this->getElementValue('lineWidth'));

        $prefix = $this->getElementValue('prefix');

        $ret = '';
        $content = trim($this->content);

        if ($this->getElementValue('removeExtraNewlines')) {
            $content = str_replace("\r\n\r\n\r\n", "\n", $content);
        }

        foreach (explode("\n", $content) as $line) {
            $ret .= $prefix.$line."\n";
        }

        $ret = '<pre>'.$ret.'</pre>';
        $this->content = $ret;
    }

    public function renderOutput($tpl)
    {
        $tpl->assign('message', $this->content);
        $tpl->assign('title', 'Indented content');
        $tpl->display('notification.tpl');
    }
}
