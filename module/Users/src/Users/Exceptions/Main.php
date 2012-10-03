<?php
namespace Sticks\Exceptions;
abstract class Main extends \Exception{
    
    public function __construct($message) {
        parent::__construct($message, NULL, NULL);
    }
    
}
?>
