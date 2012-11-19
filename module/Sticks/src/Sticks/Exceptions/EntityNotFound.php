<?php
namespace Sticks\Exceptions;
class EntityNotFound extends Main{
    
    public function __construct($id) {
        $id = (int)$id;
        parent::__construct("Sticker with id => {$id} not exist!");
    }
}
?>
