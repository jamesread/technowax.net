<?php

use libAllure\Form;
use libAllure\ElementNumeric;

class FormNumberFormatter extends Form
{
    public function __construct()
    {
        parent::__construct('formNumberFormatted', 'Number Formatter');

        $this->addElement(new ElementNumeric('number', 'Number'));
        $this->addDefaultButtons();
    }

    public function process()
    {
    }

    public function renderOutput()
    {
        echo 'TODO';
    }
}
