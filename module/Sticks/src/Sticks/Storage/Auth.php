<?php
namespace Sticks\Storage;
use Zend\Authentication\Storage;
class Auth extends Storage\Session {
    public function rememberMe($time = 1209600){
        $this->session->getManager()->rememberMe($time);
    }
    
    public function forgetMe(){
        $this->session->getManager()->forgetMe();
      
       
    }
}

?>
