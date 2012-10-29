<?php
namespace Test\Sticks;

class ControllerSuite {
    
    public static function main()
    {
        \PHPUnit_TextUI_TestRunner::run(self::suite());
    }
    public static function suite()
    {
        $suite = new \PHPUnit_Framework_TestSuite();
        $suite->addTestSuite('Test\Sticks\Bean\StickersTest');
        $suite->addTestSuite('Test\Sticks\Bean\ImageLoaderTest');
        return $suite;
    }
    
}



?>
