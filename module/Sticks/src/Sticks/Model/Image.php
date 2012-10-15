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
     *
     * @Column(type="string", length=100)
     */
    private $name;
    
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

   

    public function getName() {
        return $this->name;
    }

    public function setName($name) {
        $this->name = $name;
    }

    public function getType() {
        return substr($this->type, strpos($this->type, '/')+1);
    }
    
    public function getMetaType(){
        return $this->type;
    }

    public function setType($type) {
        $this->type = $type;
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
