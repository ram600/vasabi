<?php
namespace Sticks\Plugin;

 
use Zend\Mvc\Controller\Plugin\AbstractPlugin,
    Zend\Session\Container as SessionContainer,
    Zend\Permissions\Acl\Acl,
    Zend\Permissions\Acl\Role\GenericRole as Role,
    Zend\Permissions\Acl\Resource\GenericResource as Resource;
class AuthPlugin extends AbstractPlugin {
    protected $sesscontainer;
    
    
      private function getSessContainer()
    {
        if (!$this->sesscontainer) {
            $this->sesscontainer = new SessionContainer('user_auth');
        }
        return $this->sesscontainer;
    }
    
    public function doAuthorization($e)
    {return;
        //setting ACL...
        $acl = new Acl();
        //add role ..
        $acl->addRole(new Role('anonymous'));
        $acl->addRole(new Role('user'),  'anonymous');
        $acl->addRole(new Role('admin'), 'user');
        
        $acl->addResource(new Resource('Stick'));
        $acl->addResource(new Resource('Auth'));
        
        $acl->deny('anonymous', 'Stick', 'list');
        $acl->allow('anonymous', 'Auth', 'login');
        $acl->allow('anonymous', 'Auth', 'signup');
        
        
        $acl->allow('user','Stick','add');
        $acl->allow('user','Auth','logout');
        //admin is child of user, can publish, edit, and view too !
        $acl->allow('admin','Stick');
        
        $controller = $e->getTarget();
        $controllerClass = get_class($controller);
        $namespace = substr($controllerClass,strrpos($controllerClass, '\\')+1);
        
       
        $role = (! $this->getSessContainer()->role ) ? 'anonymous' : $this->getSessContainer()->role;
        echo $role;exit;
        if ( ! $acl->isAllowed($role, $namespace, 'view')){
            $router = $e->getRouter();
            $url    = $router->assemble(array(), array('name' => 'Login/auth'));
        
            $response = $e->getResponse();
            $response->setStatusCode(302);
            //redirect to login route...
            $response->getHeaders()->addHeaderLine('Location', $url);            
        }
    }
    
    
    
    
    
    
}

?>
