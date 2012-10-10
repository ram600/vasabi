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


class Stick extends AbstractActionController
{
  

    
    
    
    public function addAction(){
       
        $form = new \Sticks\Form\Sticker();
        $data = $this->request->getPost();
        $file = $this->getRequest()->getFiles('image');
        $data['image'] = $file['name'];
        $form->setData($data);
        $form->setInputFilter(\Sticks\Beans\Stickers::getInputFilter());
        
        if($form->isValid()){
           
                $em =    $this->getServiceLocator()->get('em');
                $stick_bean = new \Sticks\Beans\Stickers($em);
                $data = $form->getData();
               
                
                $loader = new \Zend\File\Transfer\Adapter\Http();
             
                $loader->setDestination(APPLICATION_PATH.'/public/source/sticks/');
                
                $info = $loader->getFileInfo('image');
                
                $img  =  \Custom\Bind\Binder::bind($info['image'], new \Sticks\Model\Image());
                $em->persist($img);
                $em->flush();
                
                $loader->addFilter(new \Zend\Filter\File\Rename(array(
                     'target'=>$img->getId().'.'.substr($info['image']['type'], strpos($info['image']['type'], "/")+1)))
                     ,null,
                     'image'
                     );
                $loader->addValidator(new \Zend\Validator\File\FilesSize(array('min'=>100,'max'=>'2MB')));
                $loader->addValidator(new \Zend\Validator\File\Extension(array('jpg','jpeg','png','gif')));
                
                if($loader->receive(array('image'))){
                    $data['image'] = $img;
                    echo $stick_bean->create($data);
                }else{
                    $form->get('image')->setMessages($loader->getMessages());
                }
              
             
            
            
        }
        
        return array('form'=>$form);
     
       
    }
    
    public function showAction(){
        
        $id = $this->getEvent()->getRouteMatch()->getParam('id');
        $em = $this->getServiceLocator()->get('em');
        $bean = new \Sticks\Beans\Stickers($em);
        
        
       return array('stick'=>$bean->getIfExist($id));
        
       
        
        
    }
    
    
    
}
