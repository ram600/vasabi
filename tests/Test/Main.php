<?php
namespace Test;
class Main extends \PHPUnit_Framework_TestCase{
    
    protected $em;
    protected $sm;
    protected $object;
    
    public function setUp() {
        parent::setUp();
        $this->sm = Loader::$sm;
        $this->em = $this->sm->get('em');
    }
    
    public function tearDown(){
        
    }
}
