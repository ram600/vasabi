<?php
namespace Sticks\Model;


/** @Entity
 *   @Table(name="stickers")
 *
 */
class Stick {

 /** @Id
  *  @Column(type="integer")
  *  @GeneratedValue(strategy="AUTO")
  */
 private $id;
 /** @Column(length=100)*/
 private $title;
 

/**
 *
 * @OneToOne(targetEntity="\Sticks\Model\Image",inversedBy="id",orphanRemoval=true)
 * 
 */
 private $image;

 
 
 /** @Column(type="datetime",nullable=false)*/
 private $createDate;

 /** @Column(type="datetime",nullable=true)*/
 private $modify;
 
 /** @Column(type="integer", nullable=false) */
 private $rate = 0;
 
 /** @Column(type="integer",nullable=false) */
 private $userId;

 
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




    
}



?>
