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
    public function indexAction()
    {  
     echo 2;
    }
    public function addAction(){
       
        $form = new \Sticks\Form\Sticker();
        $form->setData($this->request->getPost());
        $form->setInputFilter(\Sticks\Beans\Stickers::getInputFilter());
        
        if($form->isValid()){
           
             $em =    $this->getServiceLocator()->get('em');
             $stick_bean = new \Sticks\Beans\Stickers($em);
             $data = $form->getData();
            
             
                $img = new \Sticks\Model\Image();
                $loader = new \Zend\File\Transfer\Adapter\Http();
                
                $loader->setDestination("/tmp/ooo");
                $info = $loader->getFileInfo('image');
                
                \Custom\Bind\Binder::bind($info['image'], $img);
                print_r($info);
                $em->persist($img);
                $em->flush();
                
                $loader->addFilter(new \Zend\Filter\File\Rename(array('target'=>$img->getId())),null,'image');

                
                
                if($loader->receive(array('sticker_image'))){
                    $data['image'] = $img;
                }else{
                    $data['image'] = null;
                }
              
             echo $stick_bean->create($data);
            
            
        }
        
        return array('form'=>$form);
     
       
                
        
    }
    
}
