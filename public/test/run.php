<?php
ini_set("error_reporting",E_ALL);
ini_set("display_errors", true);
ini_set("display_startup_errors",true);

//require_once 'autoload.php';
require_once 'Autoloader.php';

//add autoloader
spl_autoload_register(array('Autoloader','loadPackage'));
spl_autoload_register(array('Autoloader','loadPackagesAndLog'));

//remove autoloader
spl_autoload_unregister(array('Autoloader','loadPackagesAndLog'));

//add prepend!
spl_autoload_register(array('Autoloader','loadPackagesAndLog'),false,$prepend = true);
var_dump(spl_autoload_functions());


//remove all
spl_autoload_unregister(array('Autoloader','loadPackage'));
spl_autoload_unregister(array('Autoloader','loadPackagesAndLog'));
var_dump(spl_autoload_functions());


$class = '\Mama';
if ('\\' == $class[0]) {
            $class = substr($class, 1);
        }
echo $class[0];
?>
