<?php
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Configuration;

                    $conf = require __DIR__.'/../../module/Doctrinemod/config/module.config.php';
    
                    $cache = new $conf['options']['cache'];

                    $config = new Configuration;
                    $config->setMetadataCacheImpl($cache);
                    $driverImpl = $config->newDefaultAnnotationDriver($conf['options']['path_to_entities']);
                    $config->setMetadataDriverImpl($driverImpl);
                    $config->setQueryCacheImpl($cache);
                    $config->setProxyDir($conf['options']['path_to_proxy']);
                    $config->setProxyNamespace($conf['options']['proxy_namespace']);
                    $config->setAutoGenerateProxyClasses($conf['options']['autogenerate_proxy']);

                    $em =  EntityManager::create($conf['db'], $config);
                    
        $helperSet = new \Symfony\Component\Console\Helper\HelperSet(array(
            'db' => new \Doctrine\DBAL\Tools\Console\Helper\ConnectionHelper($em->getConnection()),
            'em' => new \Doctrine\ORM\Tools\Console\Helper\EntityManagerHelper($em)
        ));

?>
