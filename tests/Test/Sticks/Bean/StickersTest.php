<?php
namespace Test\Sticks\Bean;
use Test\Main;
use Sticks\Beans\Stickers;
use Sticks\Form;
/**
 * @backupGlobals disabled
 */
class StickersTest extends Main{
    
    
    public function setUp() {
        parent::setUp();
        /** @var $this->object Sticks\Beans\Stickers */
        $this->object = new Stickers($this->em);
        
    }



    /**
     * 
     * @xxxxdataProvider providerCreateStick
     */
    function testCreateStick(){
       $id =  $this->object->create(array('title'=>'Vasya'));
       $this->assertTrue($id > 0);
       return $id;
       
    }
    function providerCreateSticker(){
        return array(
            array(
                array('title'=>'Vasya')
                ),
            array(
                array('title'=>'Petya')
                ),
             array(
                array('title'=>'Nika')
                )
        );
    }
    
    /**
     * @depends testCreateStick
     */
    function testUpdateSticker($id){
       $obj = $this->object->update($id,array('title'=>'IAM NEW VASYA'));
       $this->assertTrue(true == $obj instanceof \Sticks\Model\Stick);
       $this->assertEquals('IAM NEW VASYA', $obj->getTitle());
       return $obj->getId();
    }
    
    /**
     * @depends testCreateStick
     */
    function testLikeSticker($id){
        $rate = $this->object->like($id);
        $this->assertEquals(1, $rate);
        
    }
    
    /**
     * @depends testCreateStick
     */
    function testUnlikeSticker($id){
        $rate = $this->object->unlike($id);
        $this->assertEquals(0, $rate);
    }
    
    
    /**
     * @depends testUpdateSticker
     */
    function testRemoveSticker($id){
        $this->assertTrue($this->object->delete($id));
    }
    
    
    
    
    
    public function tearDown() {
        parent::tearDown();
        unset($this->object);
    }
    
    
}
?>
