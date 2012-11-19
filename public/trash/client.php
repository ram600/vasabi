<?php
ini_set('display_errors',1);
ini_set('display_startup_errors',1);
ini_set('error_reporting',E_ERROR);

set_include_path('/usr/share/pear/sharelib/pear/'.PATH_SEPARATOR.  get_include_path());

require "XML/RPC2/Client.php";

$options = array(
'prefix' => 'time.',
 'debug'=>true
);
$client = XML_RPC2_Client::create('http://stat.kupa.lan/trash/server.php',$options);
$result = $client->hello('Sergio');
$factor = $client->factor(20);
echo $result.'-'.$factor;


//
//$client = XML_RPC2_Client::create('http://stat.kupa.lan/trash/server.php',array('prefix'=>'system.','debug'=>true));
//$res = $client->listMethods();
//echo $res;
?>
    