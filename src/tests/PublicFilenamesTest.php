<?php

require_once 'common.php';

use \PHPUnit\Framework\TestCase;

class PublicFilenamesTest extends TestCase {
    public static function getPublicFilenames() {
        $ret = array();

        foreach (scandir(APPLICATION_BASEDIR) as $filename) {
            if (substr($filename, 0, 1) == '.') {
                continue;
            }

            if (is_dir(APPLICATION_BASEDIR . $filename)) {
                continue;
            }

            $ret[] = array($filename);
        }

        return $ret;
    }

    /**
     * @dataProvider getPublicFilenames
     */
    public function testFilenameValid($filename) {
        $validStartingFilenames = array(
            'index', 
            'view', 
            'do', 
            'edit', 
            'list', 
            'change', 
            'create',
        );

        $this->assertTrue($this->startsWith($validStartingFilenames, $filename), 'Invalid public filename: ' . $filename);
    }

    private function startsWith(array $options, $filename) {
        foreach ($options as $option) {
            if (strpos($filename, $option) === 0) {
                return true;
            }
        }

        return false;
    }
}

?>
