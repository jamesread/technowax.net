<?php

use \libAllure\ElementAlphaNumeric;
use \libAllure\ElementTextbox;
use \libAllure\DatabaseFactory as DatabaseFactory;

class FormEditWikiPage extends libAllure\Form {
	public function __construct($pageTitle) {
		parent::__construct('editWikiPage', 'Edit Wiki Page');

		$this->wikiPage = $this->getWikiPage($pageTitle);
		$this->sanitizer = new \libAllure\Sanitizer();

		$this->addElement(new ElementAlphaNumeric('alt_title', 'Alt title', $this->sanitizer->escapeStringForHtml($this->wikiPage['alt_title'])));
		$this->getElement('alt_title')->setMinMaxLengths(0, 64);

		$this->addElement(new ElementTextbox('content', 'Content', $this->sanitizer->escapeStringForHtml($this->wikiPage['content'])));
		$this->addElementHidden('title', $this->sanitizer->escapeStringForHtml($this->wikiPage['title']));

		$this->addDefaultButtons();
	}

	private function getWikiPage($pageTitle) {
		$sql = 'SELECT w.title, w.alt_title, w.content FROM wiki_pages w WHERE w.title = :title ';
		$stmt = DatabaseFactory::getInstance()->prepare($sql);
		$stmt->bindValue(':title', $pageTitle);
		$stmt->execute();

		return $stmt->fetchRow();
	}

	public function process() {
		$sql = 'UPDATE wiki_pages SET alt_title = :alt_title, content = :content WHERE title = :title ';
		$stmt = DatabaseFactory::getInstance()->prepare($sql);
		$stmt->bindValue(':title', $this->sanitizer->escapeStringForDatabase($this->wikiPage['title']));
		$stmt->bindValue(':content', $this->sanitizer->escapeStringForDatabase($this->getElementValue('content')));
		$stmt->bindValue(':alt_title', $this->sanitizer->escapeStringForDatabase($this->getElementValue('alt_title')));
		$stmt->execute();
	}
}

?>
