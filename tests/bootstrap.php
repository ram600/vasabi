<?php
use Zend\ServiceManager\ServiceManager;
use Zend\Mvc\Service\ServiceManagerConfig;

require_once __DIR__ . '/../init_autoloader.php';


$configuration = include __DIR__.'/../config/application.config.php';
$smConfig = isset($configuration['service_manager']) ? $configuration['service_manager'] : array();

$serviceManager = new ServiceManager(new ServiceManagerConfig($smConfig));
$serviceManager->setService('ApplicationConfig', $configuration);
$serviceManager->get('ModuleManager')->loadModules();
$serviceManager->get('Application')->bootstrap();


$loader->add("Test\\", __DIR__);


Test\Loader::$sm = $serviceManager;