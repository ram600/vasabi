<?php

namespace Sticks\Controller;
use Zend\View\Model\ViewModel;
use Sticks\Beans\Users;
class Auth extends \Zend\Mvc\Controller\AbstractActionController {
    
    
    
    /**
     * Login from fb
     */
    
    private function auth($email,$password,$offHash = null){
        
        $authServ = $this->getServiceLocator()->get('auth-service');
        $adapter = $authServ->getAdapter()->setEm($this->getServiceLocator()->get('em'));
        if($offHash){
           $adapter->setHashFoo(null);
        }        
        $adapter->setIdentity($email)->setCredential(trim($password));
        
        
        $result = $authServ->authenticate();
        
        if($result->isValid()){
            $sess = $this->getServiceLocator()->get('auth-storage');
            $sess->rememberMe();
            //set storage
            $authServ->setStorage($sess);
            $ent = $adapter->getResultEntity();
            $authServ->getStorage()->write(array('email'=>$ent->getEmail(),'id'=>$ent->getId(),'name'=>$ent->getUsername()));
            return $this->redirect()->toUrl('/');
        }
        
        //$this->redirect()->toRoute('login')
        return "Wrong Email or Password!";
    }
    
    public function loginAction(){
        
       if($this->getServiceLocator()->get('auth-service')->hasIdentity()){
           print_r($this->getServiceLocator()->get('auth-service')->getIdentity());exit;
            $this->redirect()->toUrl('/');
        }
        $error = array();
        if($this->request->isPost()){
            if(filter_var( ($email = $this->request->getPost('email','')),FILTER_VALIDATE_EMAIL)){
                $error[] = $this->auth($email, $this->request->getPost('password'));
            }else{
                $error[] = 'Email not valid!';
            }
        }
        return array('errors'=>$error);
    }
    
    public function signupAction(){
        $errors = array();
        $success = array();
        $username = $this->request->getPost('username');
        if($this->request->isPost()){
             $filter = Users::getInputFilter();
             $filter->setData($this->request->getPost());
             $data = $filter->getValues();
          if($filter->isValid()){ 
            
        
           //check password 
            if($data['password']!== $data['repassword']){
               $errors[] = 'Enter password and repeat it!'; 
            }
            
            //if have not errors
            //captcha check after, if othe components is correct
            if(!count($errors)){
                require_once(APPLICATION_PATH.DIRECTORY_SEPARATOR.'public/recaptchalib.php');
                $privatekey = "6Lehd9gSAAAAAI8BYCbo0kgJ5W-S9VfKUT_6KMOC";
                $resp = recaptcha_check_answer($privatekey,
                                $_SERVER["REMOTE_ADDR"],
                                $_POST["recaptcha_challenge_field"],
                                $_POST["recaptcha_response_field"]);
                 if (!$resp->is_valid) {
                    // What happens when the CAPTCHA was entered incorrectly
                      $errors[] = "The reCAPTCHA wasn't entered correctly.Try it again."; 
                 } else {
                    //#####All good#######  
                    $usrs = new Users($this->getServiceLocator()->get('em'));
                    try{
                         $row = $usrs->create(array('email'=>$data['email'],'password'=>$data['password'],'username'=>$data['username']), true);
                         $success[] = 'The Confirmation sent to your email.';
                         
                    }catch(\Doctrine\DBAL\DBALException $e){
                     //Не возвращает номер ошибки =(..временное решение ниже
//                        if($e->getCode() == '23000'){
//                            $error[] = 'User already exist!';
//                        }else{
//                            throw  $e;
//                        }
                        
                        if(strpos($e->getMessage(),'23000',50)){
                            $errors[] = 'User already exist!<br/>Forgot password?';
                        }else{
                             throw  $e;
                        }
                        
                    }
                    
                  }
                  
            }
            
        }else{
            $errors = $filter->getMessages();
        }
        
            
   
            
            
        }
    
//        $view = new ViewModel(array('errors'=>$error));
//        $view->setTemplate('sticks/auth/login.phtml');
//        return $view;
        return array('errors'=>$errors,'success'=>$success,'data'=>(isset($data))?$data:false);
        
    }
    
    
    public function confirmAction(){
        if($token = $this->request->getQuery('token') && $user_id = $this->request->getQuery('u')){
            $usrs = new Users($this->getServiceLocator()->get('em'));
            if($entity = $usrs->confirmUser($token, $user_id)){
                $this->auth($entity->getEmail(), $entity->getPassword(),true);
            }
        }
        throw new \Exception('Not valid params!');
    }
    
    
    public function logoutAction(){
        $this->getServiceLocator()->get('auth-storage')->forgetMe();
        $this->getServiceLocator()->get('auth-service')->clearIdentity();
        return $this->redirect()->toUrl('/');
    }
    
    
    
    public function facebookAction(){
          
       $fb = new \Custom\Fb\Facebook(
               array('appId'=>'365454110216217','secret'=>'3bc33d7394eeb81d6d85f08faa429c5e','fileUpload'=>false)
               );
       
       if($fb->getUser() === 0){
           //
       }else{
           
           
           $user_data = $fb->api('/me','GET');
           if(userExist()){
               login();
           }else{
               createNewUser();
               login();
           }
           
           
       }
       print_r($fb->api('/me','GET'));exit;
       exit;
       
       
    }
    
    
}

?>
