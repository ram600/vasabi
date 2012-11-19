<?php
namespace Sticks\Helper;  

use Zend\View\Helper\AbstractHelper;  
use Zend\ServiceManager\ServiceLocatorAwareInterface;  
use Zend\ServiceManager\ServiceLocatorInterface;

class User extends AbstractHelper implements ServiceLocatorAwareInterface {
    
    protected $_serviceLocator;
    protected $_authServ;
    protected $_user = null;
    public function __invoke(){
        return $this;
    }
    
    
    public function getAuthService(){
        if(!$this->_authServ){
            $this->_authServ = $this->_serviceLocator->getServiceLocator()->get('auth-service');
        }
        return $this->_authServ;
    }
    
    public function getCurrent(){
        if(!$this->_user){
          if($this->getAuthService()->hasIdentity()){
            $this->_user = $this->getAuthService()->getIdentity();
          }  
        }
        return $this->_user;
    }
    
    
    
    public function getMenuButton(){
        
        if($user = $this->getCurrent()):
           
        ?>
              <div class="btn-group">
                <button class="btn btn-info"><?=$user['name']?></button>
                <button class="btn btn-info dropdown-toggle" data-toggle="dropdown"><span class="caret"></span></button>
                <ul class="dropdown-menu">
                  <li><a href="#">Settings</a></li>
                   <li class="divider"></li>
                  <li><a href="/logout">Logout</a></li>
                 
                </ul>
              </div>
        <?php else: ?>
            <button type="button" class="btn btn-danger btn-mini"><a href="/login" style="color:white">Login</a></button>

        <?php endif;
        
       
        
    }
    

    /**
     * 
     * @return 
     */
    public function getServiceLocator() {
        return $this->_serviceLocator;
    }

    /**
     * 
     * @param \Zend\ServiceManager\ServiceLocatorInterface $serviceLocator
     * @return \Sticks\Helper\User
     */
    public function setServiceLocator(ServiceLocatorInterface $serviceLocator) {
       
        //Only ViewPluginManager?if you want get App ServLocator you must call getSercvicewLoator  again!!!
        $this->_serviceLocator = $serviceLocator;
        return $this;
    }
}

?>
