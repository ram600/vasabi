<?php

ini_set('display_errors',1);
ini_set('display_strtup_errors',1);
ini_set('error_reporting',E_ALL);

////$connect = new PDO("mysql://192.168.1.145:3600",'r2', 'domodomo1');
//
//
$connect = new PDO("mysql:host=192.168.1.145;dbname=supra",'r2','domodomo1',array(PDO::MYSQL_ATTR_INIT_COMMAND=>'SET NAMES utf8'));
//
for($i = 0;$i < 10000;$i++){
    $id = rand(1,10);
    $val1 = rand(1,10);
    $val2 = rand(1,10);
    $connect->query("INSERT INTO users VALUES ($id,'$val1','$val2')");
}

//    $key = "KKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKK";
//    $pass = "KK";
//    if ( strcasecmp( $_GET['pass'], $pass ) === 0 ) {
//        echo($key);
//    }

?>
