<?php

class Autoloader {

    private static $_lastLoaderFilename;


    public static function loadPackage($className){
        $path = explode('_', $className);
        self::$_lastLoaderFilename = implode(DIRECTORY_SEPARATOR, $path);
        require_once(self::$_lastLoaderFilename);
    }
    public static function loadPackagesAndLog($className)
    {
        self::loadPackages($className);
        printf("Class %s was loaded from %sn", $className, self::$_lastLoadedFilename);
    }
}

?>
