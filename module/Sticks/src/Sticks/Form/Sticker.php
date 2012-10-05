<?php
namespace Sticks\Form;

use Zend\Form\Form;


class Sticker extends Form
{
    public function __construct($name = 'Sticker')
    {
        parent::__construct($name);
        $this->setAttribute('method', 'post');
        $this->setAttribute('enctype','multipart/form-data');
        
        $this->add(array(
            'name' => 'title',
            'attributes' => array(
                'type'  => 'text',
            ),
            'options' => array(
                'label' => 'Title'
                
            )
        ));

        
        $this->add(array(
            'name' => 'image',
            'attributes' => array(
                'type'  => 'file',
            ),
            'options' => array(
                'label' => 'Image Upload',
            ),
        )); 
        
        
        $this->add(array(
            'name' => 'submit',
            'attributes' => array(
                'type'  => 'submit',
                'value' => 'Stick!'
            ),
        )); 
    }
}