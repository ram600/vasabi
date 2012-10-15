<?php
namespace Sticks\Helper;  

use Zend\View\Helper\AbstractHelper;  
use Zend\ServiceManager\ServiceLocatorAwareInterface;  
use Zend\ServiceManager\ServiceLocatorInterface;


class Stick extends AbstractHelper  {
    
//    protected $serviceLocator;
//   /**
//    * 
//    * @param \Zend\ServiceManager\ServiceLocatorInterface $serviceLocator
//    * @return \Sticks\Helper\Stick
//    */
//    public function setServiceLocator(ServiceLocatorInterface $serviceLocator) {
//        $this->serviceLocator = $serviceLocator;
//        return $this;
//    }
//
//    public function getServiceLocator() {
//        return $this->serviceLocator;
//    }
//    
    public function __invoke() {
        return $this;
    }
    
    public function printStick(\Sticks\Model\Stick $stick){
        ob_start();
        ?>
            <div>
                <div>Rate:<?=$stick->getRate()?> Title:<?=htmlspecialchars($stick->getTitle())?></div>
                <div>
                    <?php $image = $stick->getImage(); ?>
                    <img src="/source/sticks/<?=$image->getId().".".$image->getType();?>" style="max-width: 700px">
                </div>    
                
            </div>    
        <?php
        return ob_get_clean();
    }
    
    
}
?>
