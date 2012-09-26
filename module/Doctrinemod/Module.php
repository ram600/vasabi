<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2012 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Doctrinemod;

use Zend\Mvc\ModuleRouteListener;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Configuration;
use Zend\ModuleManager\ModuleManager;
use Zend\EventManager\EventInterface as Event;
class Module
{
    protected $conf = null;

    public function onBootstrap(Event $e)
    {
        $conf = $this->getConfig();
        $e->getApplication()->getServiceManager()->setFactory('em',function($sm) use ($conf){

                    $cache = new $conf['options']['cache'];

                    $config = new Configuration;
                    $config->setMetadataCacheImpl($cache);
                    $driverImpl = $config->newDefaultAnnotationDriver($conf['options']['path_to_entities']);
                    $config->setMetadataDriverImpl($driverImpl);
                    $config->setQueryCacheImpl($cache);
                    $config->setProxyDir($conf['options']['path_to_proxy']);
                    $config->setProxyNamespace($conf['options']['proxy_namespace']);
                    $config->setAutoGenerateProxyClasses($conf['options']['autogenerate_proxy']);

                    return EntityManager::create($conf['db'], $config);
        });
     

    }

    public function getConfig()
    {
        if(null == $this->conf){
            $this->conf = include __DIR__ . '/config/module.config.php';
        }
        return $this->conf;
    }

//    public function getAutoloaderConfig()
//    {
//        return array(
//            'Zend\Loader\StandardAutoloader' => array(
//                'namespaces' => array(
//                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
//                ),
//            ),
//        );
//    }
}
