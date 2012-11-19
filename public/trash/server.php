<?php 
//emulate post data
global $HTTP_RAW_POST_DATA;
$HTTP_RAW_POST_DATA = file_get_contents("php://input");


ini_set('display_errors',1);
ini_set('display_startup_errors',1);
ini_set('error_reporting',E_ERROR);

set_include_path('/usr/share/pear/sharelib/pear/'.PATH_SEPARATOR.  get_include_path());


require_once 'sharelib/pear/XML/RPC2/Server.php';

 class ExampleServer {

     /**

      * hello says hello

      *

      * @param string  Name

      * @return string Greetings

      */

     public static function hello($name){

         return "Hello $name";

     }
     
     /**
      * 
      * Factorial
      * 
      * @param integer $int
      * @return integer
      */
     public static function factor($int){
         $int = (int)$int;
         if($int <= 1){
             return 1;
         }
         
         return $int * static::factor($int-1);
     }
 }
 
 class HiServer{
     
    /**
     * Say hi
     * 
     * @param String $word
     * @return string Hi Name!
     */ 
    public static function hi($name){
        return 'Hi! '.(string)$name;
    }
     
 }
 
 
$options = array(
'prefix' => 'time.'
);

$server = XML_RPC2_Server::create('ExampleServer',$options);
$server->handleCall();

//$hi = XML_RPC2_Server::create('HiServer',array('prefix'=>'hi.'));
//$hi->handleCall();


?>
