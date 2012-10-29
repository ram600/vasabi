<?php
namespace Test\Sticks\Bean;
use Test\Main;
use Sticks\Beans\ImageLoader;
use Sticks\Form;
/**
 * @backupGlobals disabled
 */
class ImageLoaderTest extends Main{
    
    protected $path;
    
   
    
    public function setUp() {
        parent::setUp();
        $this->path = '/tmp/imageloadertest/';
        if(!is_dir($this->path)){
            mkdir($this->path);
        }
        
       
        $this->object = new ImageLoader($this->em,$this->path);
      
        $image = imagecreate(500, 500);
        $color = imagecolorallocate($image, 200, 100, 100);
        imagefilledrectangle($image, 0 , 0, 100, 100, $color);
        imagejpeg($image, '/tmp/testimage');
        
        $_FILES['image']['tmp_name'] = '/tmp/testimage';
    }
    public function tearDown() {
        parent::tearDown();
        unset($this->object);
        system('rm -rf '.escapeshellarg($this->path));
        
    }
    
    
    
    
    public function testSaveImageFromForm(){
        
        $this->assertTrue($this->object->loadFromForm('image'));
        $this->fileExist($this->object->getLastSaveImage());
        
    }
    public function testSaveImageFromUrl(){
        $this->assertTrue($this->object->loadFromUrl('http://cdn.phpmaster.com/files/2011/11/86893639-616x190.jpg'),implode("\n",$this->object->getErrors()));
        $this->fileExist($this->object->getLastSaveImage());
    }
    
  
    public function fileExist($img){
        $this->assertFileExists($this->path.$img->getId().'.'.$img->getType());
    }
    
   
    public function testSaveImageFromFormNotValid(){
        
        
        $f = fopen('/tmp/invalid.php',"w+");
        fwrite($f, "<?php echo 1; ?>");
        $_FILES['invalid_file']['tmp_name'] = '/tmp/invalid.php';
        
        $this->assertFalse($this->object->loadFromForm('invalid_file'),implode("\n",$this->object->getErrors()));
        
    }
    
    /**
     * @dataProvider getUrls
     */
    public function testSaveImageFromURLotValidUrl($url){
        
        $this->assertFalse($this->object->loadFromUrl($url),implode("\n",$this->object->getErrors()));
        
    }
    
    public function getUrls(){
        return array(
            array('http://google.ru/'),
            array('http://wfwfwfwfwf')
        );
    }
    
    
    
    
    
    
    
    
    
    
}

?>
