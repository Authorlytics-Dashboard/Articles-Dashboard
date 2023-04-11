<?php
class Group {
    private $name;
    private $description;
    private $avatar;
    
    public function __construct($name, $description, $avatar) {
        $this->name = $name;
        $this->description = $description;
        $this->avatar = $avatar;
    }
    
    public function getName() {
        return $this->name;
    }
    
    public function getDescription() {
        return $this->description;
    }
    
    public function getAvatar() {
        return $this->avatar;
    }
    
    public function setName($name) {
        $this->name = $name;
    }
    
    public function setDescription($description) {
        $this->description = $description;
    }
    
    public function setAvatar($avatar) {
        $this->avatar = $avatar;
    }
}
?>