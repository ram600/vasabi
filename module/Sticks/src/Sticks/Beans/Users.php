<?php

namespace Sticks\Beans;

use \Sticks\Beans\Bean;
use \Sticks\Model\User;

class Users extends Bean{

    
 public static $_stickClass = '\Sticks\Model\User';

 protected $_user;
/**
 * 
 * @param array $data
 * @return boolean
 * 
 * Create user only if
 */
 public function create(array $data,$confirm = false){
  
        $data['password'] = md5($data['password']);
        $data['token']  = md5(uniqid("superpuper".microtime()));
        $data['status'] = User::STATUS_NOT_CONFIRM;
        
        $this->_user =  parent::create($data); 
        
        if($confirm){
            $this->sendConfirmMail($this->_user); 
       }
        
        
        return $this->_user;
 }
 
 
 public function confirmUser($confirmToken,$id){
     
     $user = $this->getIfExist($id);
     if($user->getToken() == $confirmToken){
         $user->setStatus(User::STATUS_CONFIRM);
         $this->_em->flush($user);
         return $user;
     }
        return false;
 }
 
 
 
 
 public function sendConfirmMail(\Sticks\Model\User $user){

     
     
     return mail($user->getEmail(), 
                'Registration confirm mail!',
                "Hi.Confirm your account confirm url <a href='http://stat.kupa.lan/confirm?u={$user->getId()}&token={$user->getToken()}'></a><br/>
                or copy this url in yor adress browser http://stat.kupa.lan/confirm?u={$user->getId()}&token={$user->getToken()}
                ",
                "Content-Type:text/html; charset=utf-8 \r\n From: google.com \r\n ");
     
        
 }
 
 public function getLastCreateUser(){
     return $this->_user;
 }
 
 
 public function getUserByEmail($email){
     if(filter_var($email,FILTER_VALIDATE_EMAIL)){
      return $this->_em->getRepository(self::$_stickClass)->findBy(array('email'=>$email));
     }
     throw new \Exception('Email not valid!');
 }
    
 
 
   public  static function getInputFilter() {
        //if(!$this->inputFilter){
            $inputFilter = new \Zend\InputFilter\InputFilter();
            $factory     = new \Zend\InputFilter\Factory();
            
           
            $inputFilter->add($factory->createInput(array(
                'name'=>'username',
                'required'=>true,
                'filters'=>array(
                    array('name'=>'StringTrim'),
                    array('name'=>'HtmlEntities')
                ),
                'validators'=>array(
                    array(
                    'name'=>'StringLength',
                    'options'=>array(
                        'encoding'=>'UTF-8',
                        'min'=>3,
                        'max'=>70
                    )
                    )
                )
            )));
           
            $inputFilter->add($factory->createInput(array(
                'name'=>'email',
                'required'=>true,
                'filters'=>array(
                    array('name'=>'StringTrim')
                ),
                'validators'=>array(
                    array(
                        'name'=>'EmailAddress'
                    )
                )
             )));
            
            $inputFilter->add($factory->createInput(array(
                'required'=>true,
                'name'=>'password',
                 'filters'=>array(
                    array('name'=>'StringTrim')
                ),
                'validators'=>array(
                    array(
                    'name'=>'StringLength',
                    'options'=>array(
                        'encoding'=>'UTF-8',
                        'min'=>5,
                        'max'=>70
                    )
                   )
                    )
                )));
       
            $inputFilter->add($factory->createInput(array(
                'required'=>true,
                'name'=>'repassword',
                 'filters'=>array(
                    array('name'=>'StringTrim')
                ),
                'validators'=>array(
                    array(
                    'name'=>'StringLength',
                    'options'=>array(
                        'encoding'=>'UTF-8',
                        'min'=>5,
                        'max'=>70
                    )
                   )
                    )
                )));
             
            
            
            return $inputFilter;
        //}
    }
 
}

?>
