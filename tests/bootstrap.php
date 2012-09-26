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

$loader->add("PHPUnit_", __DIR__.'/../vendor');
$loader->add("Test\\", __DIR__);
set_include_path(get_include_path().":/home/admin/repo/j2ee/zf2/ZendSkeletonApplication/tests/../vendor/");

Test\Loader::$sm = $serviceManager;