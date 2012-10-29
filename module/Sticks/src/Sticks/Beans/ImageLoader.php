<?php
namespace Sticks\Beans;
use Sticks\Model\Image;

class ImageLoader extends Bean {
    
    
    protected $_destination;
    protected $_errors = array();
    protected $_info;
     /**
     *
     * @var \Sticks\Model\Image;
     */
    protected $last_image;
    
    public function __construct(\Doctrine\ORM\EntityManager $em,$destination) {
        parent::__construct($em);
        $this->setDestination($destination);
    }
    public function setDestination($dest){
        if(is_dir($dest) && is_writable($dest)){
            $this->_destination = rtrim($dest,'/\\');
            return;
        }
        throw new \Exception('Dir name not exist or not writable!');
    }
    
    
    /**
     * 
     * @param type $form_name
     * @param type $name
     */
    public function loadFromForm($form_name){
        
      if(isset($_FILES[$form_name])){
          $info = $this->getInfo($_FILES[$form_name]['tmp_name']);
          
          $name = $_FILES[$form_name]['tmp_name'].'.'.Image::getTypeFromImagesizeConst($info[2]);
          
          rename($_FILES[$form_name]['tmp_name'],$name);
          if($this->isValid($name)){
              if($this->save($name)){
                  return true;
              }
          }else{
              return false;
          }
      }
      throw new Exception('Image not exist in form!');
    }
    
    /**
     * 
     * @param type $url
     * @param type $gif_save   not convert gif to jpeg? if url have gif extension
     * @return boolean
     */
    public function loadFromUrl($url,$gif_save = true){
        
        if(filter_var($url,FILTER_VALIDATE_URL,FILTER_FLAG_PATH_REQUIRED) && ($data = @file_get_contents($url))){
            
            $tmp_name = '/tmp/'.uniqid(time());
            file_put_contents($tmp_name,$data);
            
            $info = $this->getInfo($tmp_name);
            //save gif
            if(($gif_save) && (Image::getTypeFromImagesizeConst($info[2]) == 'gif')){
                  rename($tmp_name,$tmp_name .='.gif'); 
             }else{
                  if($img = @imagecreatefromstring(file_get_contents($tmp_name))){
                    imagejpeg($img, $tmp_name.='.jpeg');  
                  }else{
                      $this->_errors[] = 'Not valid image!';
                  }
                  
             }
             
             if(count($this->_errors)){
                 return false;
             }
                if($this->isValid($tmp_name)){
                   if($this->save($tmp_name)){
                        return true;
                    } 
                } 
             
            
            
        }else{
            $this->_errors[] = 'It is not valid url!';
        }
        return false;
        
    }
    public function getLastSaveImage(){
        return $this->last_image;
    }
    
    
   protected  function getInfo($path_to_file){
       if(!$this->_info){
           $this->_info = getimagesize($path_to_file);
       }
       return $this->_info;
   }
    protected function save($tmp_name){
        
        $info = $this->getInfo($tmp_name);
        
        $img = new Image();
        $img->setSize(filesize($tmp_name));
        $img->setHeight($info[1]);
        $img->setWidth($info[0]);
        $img->setType($img->getTypeFromImagesizeConst($info[2]));
        $this->_em->persist($img);
        $this->_em->flush();
        
        if (rename($tmp_name, $this->generateFileName($img->getId(),$img->getType()))) {
            $this->last_image = $img;
            return true;
        }else{
            $this->_errors[] = 'Image save error!';
            return false;
        }
    }
    
    
    protected function generateFileName($name,$type){
       
        return $this->_destination.DIRECTORY_SEPARATOR.$name.'.'.$type;
    }
    
    
    
    
    public function isValid($tmp_name){
        
        $chain = new \Zend\Validator\ValidatorChain();
        $chain->addValidator(new \Zend\Validator\File\FilesSize(array('min'=>100,'max'=>'2MB')));
        $chain->addValidator(new \Zend\Validator\File\Extension(array('jpg','jpeg','png','gif')));
        $chain->addValidator(new \Zend\Validator\File\MimeType(array('image/jpeg','image/png','image/jpg','image/gif')));
        
        if($chain->isValid($tmp_name)){
            return true;
        }
        
        $this->_errors = $chain->getMessages();
        return false;

        
    }
    
    
    public function getErrors(){
        return $this->_errors;
    }
    
    
    
    
    
    
    
    
    
    
    
    
    
}
?>
