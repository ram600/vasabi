<?php

namespace Test\Sticks\Bean;
use Test\Main;
use Sticks\Beans\Users;
use Sticks\Beans\ImageLoader;

/**
 * @backupGlobals disabled
 */
class UserTest extends Main {
   
    
    
    public function setUp(){
        parent::setUp();
        $this->object = new Users($this->em);
        
    }
    public function tearDown(){
//        echo "x-x-x-x-x-x\n";
//        $this->em->remove($this->object->getLastCreateUser());
//        $this->em->flush();
        unset($this->object);
    }
    
    
    public function testCreate(){
        $il = new ImageLoader($this->em);
        $il->setDestination('/home/admin/repo/vasabi/public/source/users/');
        $il->loadFromUrl('http://cdn.techlineinfo.com/wp-content/uploads/2010/05/User.png');
        $this->assertCount(0,$il->getErrors());
        $data = array('username'=>'Вася','email'=>'ra@rasprodaga.ru','password'=>'aaa','image'=>$il->getLastSaveImage());
        $id = $this->object->create($data,true);
        $this->assertTrue($id->getId()>0);
        return $id;
    }
    
    /**
     * @depends testCreate
     */
    public function testConfirmTrue($row){
        
        $row = $this->object->confirmUser($row->getToken(),$row->getId());
        $this->assertEquals(1, $row->getStatus());
        
    }
     /**
     * @depends testCreate
     */
    public function testConfirmError($row){
        
        $row = $this->object->confirmUser($row->getToken().'x_X',$row->getId());
        $this->assertFalse($row);
        
    }
    
//    /**
//     * @depends testCreate
//     */
//    public function testLogin($ent){
//        $this->assertTrue($this->object->login($ent->getEmail(),$ent->getPassword()));
//    }
    
    
    
    
    
    
}

?>
