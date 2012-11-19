<?php

namespace Sticks\Model;

/**
 * @Entity
 * @Table(name="users")
 */
class User 
{
    
    
    const STATUS_CONFIRM = 1;
    const STATUS_NOT_CONFIRM = 0;
    
    /**
     *
     * @Id
     * @Column(type="integer")
     * @GeneratedValue(strategy="AUTO")
     *
     * 
     */
    protected $id;

    /**
     * @Column(length=150)
     */
    public $username;

    /**
     * @Column(length=150,unique=true)
     */
    public $email;


    /**
     *  @Column(length=150)
     */
    public $password;
    
   /**
     *
     * @OneToOne(targetEntity="Sticks\Model\Image",orphanRemoval=true,fetch="LAZY")
     * 
    */
    private $image;
    
    /** @Column(type="date",nullable=false)*/
    private $createDate;

    /**
     * @Column(length=150)
     */
    private $token;
    
    /**
     * @Column(type="integer")
     */
    private $status;
    
    /** @Column(type="datetime",nullable=true)*/
    private $lastLogin;
    
    
    /**
     * @Column(length=150)
     */
    private $role = 'user';
    
    
    
    
    
    
    public function __construct() {
        $this->createDate = new \DateTime(date("Y-m-d"));
    }
    public function getId() {
        return $this->id;
    }
    
    public function getToken() {
        return $this->token;
    }

    public function setToken($token) {
        $this->token = $token;
    }
    public function getRole() {
        return $this->role;
    }

    public function setRole($role) {
        $this->role = $role;
    }

        public function getStatus() {
        return $this->status;
    }

    public function setStatus($status) {
        $this->status = $status;
    }

    public function getLastLogin() {
        return $this->lastLogin;
    }

    public function setLastLogin(\DateTime $last_login) {
        $this->lastLogin = $last_login;
    }

    public function getCreateDate() {
        return $this->createDate;
    }

    public function getUsername() {
        return $this->username;
    }
    public function getImage() {
        return $this->image;
    }

    public function setImage(\Sticks\Model\Image $image = null) {
        $this->image = $image;
    }

    public function setUsername($username) {
        $this->username = $username;
    }

    public function getEmail() {
        return $this->email;
    }

    public function setEmail($email) {
        $this->email = $email;
    }

    public function getPassword() {
        return $this->password;
    }

    public function setPassword($password) {
        $this->password = $password;
    }


}