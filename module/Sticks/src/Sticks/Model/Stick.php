<?php
namespace Sticks\Model;


/** @Entity
 *  @Table(name="stickers")
 *
 */
class Stick {

    
 const STATUS_RESOLVED = 1;
 const STATUS_DENIED   = 0;
// 
 private static $status_list = array(
     self::STATUS_DENIED,
     self::STATUS_RESOLVED
 );
    
 /** @Id
  *  @Column(type="integer")
  *  @GeneratedValue(strategy="AUTO")
  */
 private $id;
 /** @Column(length=100)*/
 private $title;
 

/**
 *
 * @OneToOne(targetEntity="Sticks\Model\Image",orphanRemoval=true,fetch="LAZY")
 * 
 */
 private $image;

 
 
 /** @Column(type="date",nullable=false)*/
 private $createDate;

 /** @Column(type="datetime",nullable=true)*/
 private $modify;
 
 /** @Column(type="integer", nullable=false) */
private $rate = 0;
 
 /** @Column(type="integer",nullable=false) */
 private $userId;

 
 /** @Column(type="integer",nullable=false) */
 private $status = 1;
 
 public function __construct() {
     
 }
 public function getId() {
     return $this->id;
 }

 public function getImage() {
     return $this->image;
 }

 public function setImage(\Sticks\Model\Image $image = null) {
     $this->image = $image;
 }

  public function getTitle() {
     return $this->title;
 }

 public function setTitle($title) {
     $this->title = $title;
 }

 

 public function getCreateDate() {
     return $this->createDate;
 }

 public function setCreateDate($createDate) {
     $this->createDate = $createDate;
 }

 public function getModify() {
     return $this->modify;
 }

 public function setModify($modify) {
     $this->modify = $modify;
 }

 public function getRate() {
     return $this->rate;
 }

 public function setRate($rate) {
     $this->rate = $rate;
 }

 public function getUserId() {
     return $this->userId;
 }

 public function setUserId($userId) {
     $this->userId = $userId;
 }

    public function getStatus() {
        return $this->status;
    }

    public function setStatus($status) {
        if(in_array($status,self::$status_list)){
          $this->status = $status;  
        }else{
            throw new \Exception('Status not exist for Stickers');
        }
    }


    
}



?>
