<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2012 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Sticks\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Sticks\Beans\Stickers;
use Sticks\Beans\ImageLoader;

class Stick extends AbstractActionController
{
  

    public function likeAction(){
        $this->ajaxVote(true);
    }
    
    public function unlikeAction(){
        $this->ajaxVote(false);
    }
    protected function ajaxVote($like = true){
         if($this->request->isPost()){
            
            if($id = (int)$this->request->getPost('id')){
                if($like){
                    $method_name = 'like';
                }else{
                    $method_name = 'unlike';
                }
                $bean = new Stickers($this->getServiceLocator()->get('em'));
                return  \Custom\Ajax\Json::response($bean->$method_name($id),'Ок');
               
           }else{
              throw new \Exception('Not valid request!');  
            }
            
            
        }
        throw new \Exception('Not valid request!');
    }
    
    public function addAction(){
       
      if($this->request->isPost()){
        $data = $this->request->getPost();
        
        
        //load from url
        if($from_url = $this->request->getPost('from-url')){
           $data['image'] = $this->request->getPost('image-url'); 
        }else{
           $file = $this->getRequest()->getFiles('image');
           $data['image'] = 'image';
        }
        
        $validate = \Sticks\Beans\Stickers::getInputFilter();
        $validate->setData($data);
        $errors = array();
        
        if($validate->isValid()){
                $data = $validate->getValues();
                
                $img_path = APPLICATION_PATH.'/public/source/sticks/';
                $em =    $this->getServiceLocator()->get('em');
                
                $stick_bean = new Stickers($em);
                $imagebean =  new ImageLoader($em,$img_path);
                
                if($from_url == 1){
                    $imagebean->loadFromUrl($data['image']);
                    
                }else{
                   $imagebean->loadFromForm($data['image']);
                }
                
                if(!count($imagebean->getErrors())){
                    $data['image'] = $imagebean->getLastSaveImage();
                    $stick_bean->create($data); 
                }else{
                    $errors[] = $imagebean->getErrors();
                }
                
        }
       
        
        \Custom\Ajax\Json::response(1,'Sticked!',$validate->getMessages()+$errors);
       
       }
       
    }
    
    
    protected function loadImageFromForm($upload_name){
        
    }
    
    public function showAction(){
        
        $id = $this->getEvent()->getRouteMatch()->getParam('id');
        $em = $this->getServiceLocator()->get('em');
        $bean = new \Sticks\Beans\Stickers($em);
        
        
       return array('stick'=>$bean->getIfExist($id));
        
        
    }
    
    public function listAction(){
       
         $sb = new Stickers($this->getServiceLocator()->get('em'));
         $type = $this->getEvent()->getRouteMatch()->getParam('type', 'hot');
        //ajax
        if($this->request->isPost()){
            
            \Custom\Ajax\Json::response($sb->getList($type,true,array('s.id','s.title','i.type','i.id as image_id','s.rate')), 'ok');
        }
        
        
        return array('list'=>$sb->getList($type));
        
        
    }
    
    
    
}
