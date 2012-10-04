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
             
             if($data['img_form_name']){
                 $img = $this->loadIMage($data['img_form_name']);
                 $ent->setImage($group);
             }
             
             
             $this->_em->persist($ent);
             $this->_em->flush();
             return $ent->getId();
         
    }
    
    
    

    
    public function loadImage($img_form_name){
        
        $img = new \Sticks\Model\Image();
        
        $loader = new \Zend\File\Transfer\Adapter\Http();
        $loader->setDestination("/tmp/ooo");
        $info = $loader->getFileInfo($img_form_name);
        
        \Custom\Bind\Binder::bind($info, $img);
        
        $this->_em->persist($img);
        $this->_em->flush();
        
        $loader->addFilter(new \Zend\Filter\File\Rename(array('target'=>$img->getId())),null,$img_form_name);
  
        if($loader->receive(array('sticker_image'))){
            return $img;
        }
            return null;
        
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
