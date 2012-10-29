<?php


namespace Sticks\Beans;

use Sticks\Model\Stick;
use Sticks\Beans\Bean;
use Sticks\Exceptions;
use Zend\Form\Form;
use Custom\Bind\Binder;
use Zend\InputFilter\InputFilterAwareInterface;

class Stickers extends Bean {

    protected static $_stickClass = 'Sticks\Model\Stick';
    protected $_form;
    protected $max_count = 10;
    
    protected $offset = 0;
    protected $count = 10;
    
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
        return $this->_em->getRepository(self::$_stickClass)
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
        if($row = $this->_em->find(self::$_stickClass, $id)){
            return $row;
        }
        throw new Exceptions\StickerNotExist($id);
    }

    
    
    
    public  static function getInputFilter() {
        //if(!$this->inputFilter){
            $inputFilter = new \Zend\InputFilter\InputFilter();
            $factory     = new \Zend\InputFilter\Factory();
            
            $inputFilter->add($factory->createInput(array(
                'name'=>'title',
                'filters'=>array(
                    array('name'=>'StripTags'),
                    array('name'=>'StringTrim'),
                    array('name'=>'HtmlEntities')
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
            
            $inputFilter->add($factory->createInput(array(
                'name'=>'image',
                'required'=>true,
             )));
            
            $inputFilter->add($factory->createInput(array(
                'required'=>false,
                'name'=>'image-url',
                'validators'=>array(
                    array(
                        'name'=>'Uri'
                    )
                )
             )));
            
            
            return $inputFilter;
        //}
    }

    public function setInputFilter(\Zend\InputFilter\InputFilterInterface $inputFilter) {
         throw new \Exception("Not used");

    }
    
    
    
    public function setCount($int){
        if($int < $this->max_count ){
           $this->count = (int)$int; 
        }else{
            $this->count = $this->max_count;
        }
    }
    
    public function setOffset($int){
        $this->offset = (int)$int;
    }
    
    
    
    /**
     * $type ddefault - date DESC
     *       rate      - rate desc
     *       
     */
    public function getList($type = null,$ajax = false,$fields = array('s','i')){
        $list = array();
        switch ($type) {
            case 'hot':
                $list = $this->getBaseValidQuery($fields)->addOrderBy('s.createDate','DESC')->addOrderBy('s.rate', 'DESC')->getQuery();
                break;
            case 'best':
                $list = $this->getBaseValidQuery($fields)->orderBy('s.rate', 'DESC')->getQuery();
                break;
            case 'new':
                $list = $this->getBaseValidQuery($fields)->orderBy('s.createDate','DESC')->getQuery();
                break;
            default:
                $list = $this->getBaseValidQuery($fields)->getQuery();
                break;
        }
        //echo $list->getSQL();exit;
        if($ajax){
          return $list->getArrayResult();  
        }
        
        return $list->getResult();
    }
    
    
    
    
    /**
     * 
     * 
     * @param type $fields
     * @return type
     */
    protected function getBaseValidQuery($fields = array('s','i')){
        $q = $this->_em->createQueryBuilder();
        $q->select(implode(',',$fields))->from(self::$_stickClass,'s')
          ->leftjoin('s.image', 'i')    
          ->where('s.status = 1');
        $q->setFirstResult($this->offset);
        $q->setMaxResults($this->count);
        return $q;
    }
   
   

    
   

    






}

?>
