<?php


namespace Sticks\Beans;

use Sticks\Model\Stick;
use Sticks\Beans\Bean;
use Sticks\Exceptions;
use Zend\Form\Form;
use Custom\Bind\Binder;
use Zend\InputFilter\InputFilterAwareInterface;

class Stickers extends Bean {

    protected $_stickClass = 'Sticks\Model\Stick';
    protected $_form;
    protected $max_count = 10;
    
    static protected $_inputFilter;
    
    
    public function __construct(\Doctrine\ORM\EntityManager $em){
        parent::__construct($em);
       
    }

   
    
    public function create(array $data){

     
             $data['createDate'] = new \DateTime($this->getDate()); 
             $data['userId']=111;
             $ent = Binder::bind($data, new Stick());
             $this->_em->persist($ent);
             $this->_em->flush();
             return $ent->getId();
         
    }
    
    
    

    
    public function loadImage($img_form_name){
        
       
        
           echo $loader->getMessages();exit;
        
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

    
    
    
    public  static function getInputFilter() {
        //if(!$this->inputFilter){
            $inputFilter = new \Zend\InputFilter\InputFilter();
            $factory     = new \Zend\InputFilter\Factory();
            
            $inputFilter->add($factory->createInput(array(
                'name'=>'title',
                'required'=>true,
                'filters'=>array(
                    array('name'=>'StripTags'),
                    array('name'=>'StringTrim')
                ),
                'validators'=>array(
                    array(
                    'name'=>'StringLength',
                    'options'=>array(
                        'encoding'=>'UTF-8',
                        'min'=>5,
                        'max'=>100
                    )
                    )
                )
            )));
            
            
            return $inputFilter;
        //}
    }

    public function setInputFilter(\Zend\InputFilter\InputFilterInterface $inputFilter) {
         throw new \Exception("Not used");

    }
   

    
   

    






}

?>
