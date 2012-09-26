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
 
/** @Column(type="integer", nullable=true) */
 private $imgId;

 /** @Column(type="datetime",nullable=true)*/
 private $createDate;

 /** @Column(type="datetime",nullable=true)*/
 private $modify;
 
 /** @Column(type="integer", nullable=false) */
 private $rate = 0;

 public function getId(){
     return $this->id;
 }

 public function getTitle(){
     return $this->title;
 }

 public function setTitle($title){
     $this->title = $title;
 }

 public function getImgId(){
     return $this->img_id;
 }

 public function setImgId($img_id){
     $this->img_id = $img_id;
 }

 public function getCreateDate(){
     return $this->create_date;
 }

 public function setCreateDate($create_date){
     $this->create_date = $create_date;
 }

 public function getModify(){
     return $this->modify;
 }

 public function setModify($modify){
     $this->modify = $modify;
 }


 public function getRate() {
     return $this->rate;
 }

 public function setRate($rate) {
     $this->rate = $rate;
 }



    
}



?>
