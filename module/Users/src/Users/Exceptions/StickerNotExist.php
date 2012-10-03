<?php
namespace Sticks\Exceptions;
class StickerNotExist extends Main{
    
    public function __construct($id) {
        parent::__construct("Sticker with id => $id not exist!");
    }
}
?>
