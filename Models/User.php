<?php
class User {
    private $name;
    private $email;
    private $mobile;
    private $username;
    private $password;
    private $group;
    private $subscriptionDate;
    
    public function __construct($name, $email, $mobile, $username, $password, $group, $subscriptionDate) {
        $this->name = $name;
        $this->email = $email;
        $this->mobile = $mobile;
        $this->username = $username;
        $this->password = $password;
        $this->group = $group;
        $this->subscriptionDate = $subscriptionDate;
    }
    
    public function getName() {
        return $this->name;
    }
    
    public function getEmail() {
        return $this->email;
    }
    
    public function getMobile() {
        return $this->mobile;
    }
    
    public function getUsername() {
        return $this->username;
    }
    
    public function getPassword() {
        return $this->password;
    }
    
    public function getGroup() {
        return $this->group;
    }
    
    public function getSubscriptionDate() {
        return $this->subscriptionDate;
    }
    
    public function setName($name) {
        $this->name = $name;
    }
    
    public function setEmail($email) {
        $this->email = $email;
    }
    
    public function setMobile($mobile) {
        $this->mobile = $mobile;
    }
    
    public function setUsername($username) {
        $this->username = $username;
    }
    
    public function setPassword($password) {
        $this->password = $password;
    }
    
    public function setGroup($group) {
        $this->group = $group;
    }
    
    public function setSubscriptionDate($subscriptionDate) {
        $this->subscriptionDate = $subscriptionDate;
    }
}

?>