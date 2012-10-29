<?php
namespace Sticks\Beans;

use Doctrine\ORM\EntityManager;

abstract class Bean {

    /**
     *
     * @var EntityManager
     */
    protected $_em;
    
    /**
     *
     * @var ServiceLocatorInterface
     */
    protected $_sm;
    
    public function __construct(\Doctrine\ORM\EntityManager $em) {
        $this->_em = $em;
    }
  

    public function getDate(){
        return date("Y-m-d");
       
    }
    

    
    
}

?>
