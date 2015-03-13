<?php

/**
 * Runner for all offline import tests.
 *
 * To run the offline test suites (assuming the Phlickr installation is in the
 * include path) run:
 *      phpunit Phlickr_Tests_Offline_Import_AllTests
 *
 * @version $Id: AllTests.php 537 2008-12-09 23:32:59Z edwardotis $
 * @copyright 2005
 */


if (!defined('PHPUnit_MAIN_METHOD')) {
    define('PHPUnit_MAIN_METHOD', 'Phlickr_Tests_Offline_Import_AllTests::main');
}

class Phlickr_Tests_Offline_Import_AllTests {
    public static function main() {
        PHPUnit_TextUI_TestRunner::run(self::suite());
    }

    public static function suite() {
        $suite = new PHPUnit_Framework_TestSuite('Phlickr Offline Import Tests');

//        $suite->addTestSuite('Phlickr_Tests_Offline_Import_Gallery');
//        $suite->addTestSuite('Phlickr_Tests_Offline_Import_Makethumbs');

        return $suite;
    }
}

if (PHPUnit_MAIN_METHOD == 'Phlickr_Tests_Offline_Import_AllTests::main') {
    Phlickr_Tests_Offline_Import_AllTests::main();
}

?>
