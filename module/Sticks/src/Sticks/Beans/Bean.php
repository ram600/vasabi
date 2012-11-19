<?php
namespace Sticks\Beans;

use Doctrine\ORM\EntityManager;
use Custom\Bind\Binder;

abstract class Bean {

    /**
     *
     * @var EntityManager
     */
    protected $_em;
    
    
    protected static $_stickClass;
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
    
    /**
     * 
     * @param array $data of Model
     * @return integer
     */
    public function create(array $data){
             $ent = Binder::bind($data, new static::$_stickClass());
             $this->_em->persist($ent);
             $this->_em->flush();
             return $ent;
    }

    
      /**
     * 
     * @param type $id
     * @return \Sticks\Model\Stick
     * @throws Exceptions\EntityNotFound
     */
    public function getIfExist($id){
        if($row = $this->_em->find(static::$_stickClass, $id)){
            return $row;
        }
        throw new Exceptions\EntityNotFound($id);
    }
    
}

?>
