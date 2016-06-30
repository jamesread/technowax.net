<?php

require_once 'common.php';
require_once 'PublicFilenamesTest.php';


class BadCodePatternsTest extends PHPUnit_Framework_TestCase {
	/**
	* @dataProvider PublicFilenamesTest::getPublicFilenames
	*/
	public function testFormDirectRender($filename) {
		$this->assertNotContains('->display', file_get_contents(APPLICATION_BASEDIR . $filename));
	}
}

?>
