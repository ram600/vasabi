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
        
        /** @var Sticks\Beans\Stickers $this->object  */
        $this->object = new Stickers($this->em);
        
    }



    /**
     * 
     * @xxxxdataProvider providerCreateStick
     */
    function testCreateStick(){
       $id =  $this->object->create(array('title'=>'Joke!!','userId'=>123546));
       $this->assertTrue($id > 0);
       return $id;
       
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
    function testListSticker($id){
        $list = $this->object->getList('rate_last_day');
        
        $this->assertTrue(is_array($list));
        $this->assertEquals(1, count($list));
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
     *  @depends testCreateStick
     */
    function testGetByUser($id) {
        $obj = $this->object->getIfExist($id);
        $data = $this->object->getByUser($obj->getUserId());
        $this->assertTrue(is_array($data));
        $this->assertTrue(count($data) > 0);
        $this->assertTrue(is_object($data[0]));
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
