<?php

require_once 'common.php';
require_once 'PublicFilenamesTest.php';

use \PHPUnit\Framework\TestCase;

class BadCodePatternsTest extends TestCase {
    /**
     * @dataProvider PublicFilenamesTest::getPublicFilenames
     */
    public function testFormDirectRender($filename) {
        $this->assertNotContains('->display', file_get_contents(APPLICATION_BASEDIR . $filename));
    }
}

?>
