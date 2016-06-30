<?php

use \libAllure\Form;

class FormNumberFormatter extends Form {
	public function __construct() {
		$this->addElement(new ElementNumeric('number', 'Number'));
		$this->addDefaultButtons();
	}

	public function process() {}
}

?>
