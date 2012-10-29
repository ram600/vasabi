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
            <div class="stick" id="<?=$stick->getId()?>">
                <div>Rate:<b id="rate-counter-<?=$stick->getId()?>"><?=$stick->getRate()?></b>(<a href="#"  onclick="vote(<?=$stick->getId()?>,'rate-counter-','like');return false;">+</a><a href="#" id="unlike-counter" onclick="vote(<?=$stick->getId()?>,'rate-counter-','unlike');return false;">-</a>) Title:<?=htmlspecialchars($stick->getTitle())?></div>
                <div>
                    <?php if($image = $stick->getImage()):?>
                     <img src="/source/sticks/<?=$image->getId().".".$image->getType();?>" style="max-width: 700px">
                    <?php endif; ?>
                </div>    
                
            </div>    
        <?php
        return ob_get_clean();
    }
    
    
}
?>
