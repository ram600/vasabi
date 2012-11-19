<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2012 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Sticks;

use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;
class Module
{
    public function onBootstrap($e)
    {
        $e->getApplication()->getServiceManager()->get('translator');
        $eventManager        = $e->getApplication()->getEventManager();
        $moduleRouteListener = new ModuleRouteListener();
        $moduleRouteListener->attach($eventManager);
        
        $eventManager->attach('dispatch', array($this, 'loadConfiguration'), 2);

    }

    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }
    
    public function getServiceConfig()
    {
        return array(
            'factories'=>array(
		'auth-storage'=>function($sm){
                    return  new \Sticks\Storage\Auth('user_auth');
                 },
		'auth-service' => function($sm) {
                    
                    $doctrineAdapter           = $adapter = new \Custom\Auth\Adapter\Doctrine(null,'\Sticks\Model\User', 'email', 'password','md5');
                    $authService = new \Zend\Authentication\AuthenticationService();
		    $authService->setAdapter($doctrineAdapter);
                    $authService->setStorage($sm->get('auth-storage'));
                    //$authService->setStorage(new \Zend\Authentication\Storage\Session('vasabi-auth'));
		    return $authService;
                    
                    
		},
                'user-session'  =>function($sm){
                    
                }
            ),
        );
    }
    
    public function loadConfiguration(MvcEvent $e){
        $app = $e->getApplication();
        $sm = $app->getServiceManager();
        $sharedManager = $app->getEventManager()->getSharedManager();
        
        $sharedManager->attach('Zend\Mvc\Controller\AbstractActionController','dispatch',function($e) use ($sm){
            $sm->get('ControllerPluginManager')->get('auth')->doAuthorization($e);
        });
        
    }

}
