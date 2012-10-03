<?php


namespace Sticks\Beans;

use Sticks\Model\Stick;
use Sticks\Beans\Bean;
use Sticks\Exceptions;
use Zend\Form\Form;
use Custom\Bind\Binder;

class Stickers extends Bean {

    protected $_stickClass = 'Sticks\Model\Stick';
    protected $_form;
    protected $max_count = 10;
    
    public function __construct(\Doctrine\ORM\EntityManager $em){
        parent::__construct($em);
       
    }

   
    
    public function create(array $data){

             $data['createDate'] = new \DateTime($this->getDate());  
             $ent = Binder::bind($data, new Stick());
             $this->_em->persist($ent);
             $this->_em->flush();
             return $ent->getId();
         
    }
    public function delete($id){
        
          $row = $this->getIfExist($id);
          $this->_em->remove($row);
          $this->_em->flush();
          return true;
       
       
        
    }
    
    public function update($id,$data){
        
           $row = $this->getIfExist($id);
           Binder::bind($data, $row);
           $this->_em->flush();
           return $row;
        
    }
    
    public function getByUser($user_id,$page = 1){
        if($page <= 0){
            $page = 1;
        }
        return $this->_em->getRepository($this->_stickClass)
        ->findBy(array('userId'=>$user_id),array('createDate'=>'ASC'), $this->max_count, $this->max_count*($page-1));
    }
    
    public function like($id){
        $row = $this->getIfExist($id);
        $row->setRate($row->getRate()+1); 
        $this->_em->flush();
        return $row->getRate();
    }
    
    public function unlike($id){
        $row = $this->getIfExist($id);
        $row->setRate($row->getRate()-1); 
        $this->_em->flush();
        return $row->getRate();
    }
    
    /**
     * 
     * @param type $id
     * @return \Sticks\Model\Stick
     * @throws Exceptions\StickerNotExist
     */
    public function getIfExist($id){
        if($row = $this->_em->find($this->_stickClass, $id)){
            return $row;
        }
        throw new Exceptions\StickerNotExist;
    }
   
    
   

    






}

?>
