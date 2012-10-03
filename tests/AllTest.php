<?php
require_once 'bootstrap.php';

class AllTest {
    
    
    public static function main(){
        $parameters = array();
        PHPUnit_TextUI_TestRunner::run(self::suite(), $parameters);
    }
    
    public static function suite(){
        $suite = new PHPUnit_Framework_TestSuite('Vasabi');
        $suite->addTest(Test\Sticks\ControllerSuite::suite());
        return $suite;
    }
}
AllTest::main();
?>
