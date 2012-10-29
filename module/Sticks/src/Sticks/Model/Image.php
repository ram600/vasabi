<?php
namespace Sticks\Model;

/**
 * @Entity
 * @Table(name="images")
 */
class Image{
    
    /**
     *
     * @Column(type="integer")
     * @Id
     * @GeneratedValue(strategy="AUTO")
     */
    private $id;
    

    /**
     * @Column(type="string", length=10)
     */
    private $type;
    
    /**
     *
     * @Column(type="integer")
     */
    private $size;
    
    
    /**
     * @Column(type="integer")
     */
    private $width;
    public function getWidth() {
        return $this->width;
    }

    public function setWidth($width) {
        $this->width = $width;
    }

    public function getHeight() {
        return $this->height;
    }

    public function setHeight($height) {
        $this->height = $height;
    }

        /**
     * @Column(type="integer")
     */
    private $height;
    
    /**
     *
     * @Column(type="datetime")
     */
    private $createDate;
    
    
    public function __construct() {
        $this->createDate = new \DateTime(date("Y-m-d H:i:s"));
    }
    
    public function getId() {
        return $this->id;
    }

   

    public function getType() {
       return $this->type;
    }
    
    public function getMetaType(){
        return $this->type;
    }

    public function setType($type) {
        $this->type = $type;
    }
    public static function getTypeFromImagesizeConst($num){

        switch ($num) {
            case 1:
                return 'gif';
                break;
            case 2:
                return  'jpg';
                break;
            case 3:
                return 'png';
                break;
            default:
                return 'not_valid_image';
                break;
        }
    }

    public function getSize() {
        return $this->size;
    }

    public function setSize($size) {
        $this->size = $size;
    }

    public function getCreateDate() {
        return $this->createDate;
    }

    public function setCreateDate(\DateTime $createDate) {
        $this->createDate = $createDate;
    }


    
}
?>
