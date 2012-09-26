<?php
namespace Sticks\Form;
use Zend\Form\Element;
class Sticker extends \Zend\Form\Form {
    
    public function __construct($name = null){
        parent::__construct($name);
        
        $this->add(new Element\Text('title',
                array('label'=>'Title','required'=>true,
                 'validators'=>  array(new \Zend\Validator\EmailAddress())
            )));
        $this->add(new Element\Textarea('text',array('label'=>'Title','required'=>true)));
        
       // $this->add(new Element\Submit('stick',array('value'=>'Stick')));
        
        $this->add(array(
            'name' => 'stick',
            'attributes' => array(
                'type' => 'submit',
                'value'=>'Stick'
            )
        ));
        
        
        $this->setAttribute('method', 'POST');
        $this->setAttribute('action', 'stickers/create');
        
    }
    
}
?>
