<?php
class GroupValidator {

    private $error;

    public function __construct(private $data){
        $this->validateGroupName();
        $this->validateGroupAvatar();
        $this->validateGroupDescription();
    }

    public function validateGroupName() {
   
            if (empty($this->data['gname'])) {
                $this->error['nameErr'] =  "Group Name is required";
            } elseif (strlen($this->data['gname']) < 3) {
                $this->error['nameErr'] =  "Group Name should be at least 3 characters long";
            } elseif (!preg_match('/^[a-zA-Z]+$/', $this->data['gname'])) {
                $this->error['nameErr'] =  "Group name should only contain letters";
            } else {
                return null; 
            }
        return true;
    }
    public function validateGroupDescription() {
        if (empty($this->data['description'])) {
            $this->error['descriptionErr'] =  "Description is required";
        } elseif (strlen($this->data['description']) < 3) {
            $this->error['descriptionErr'] =  "Description should be at least 3 characters long";
        } 
        elseif (!preg_match('/^[a-zA-Z\s]+$/', $this->data['description'])) {
            $this->error['descriptionErr'] =  "Group name should only contain letters";
        } else {
            return null; 
        }
        return true;
    }

    
    public function validateGroupAvatar() {
        $allowedExtensions = ['png', 'jpeg', 'jpg', 'gif'];
        $extension = strtolower(pathinfo($this->data['avatar'], PATHINFO_EXTENSION));

        if (empty($this->data['avatar'])) {
            $this->error['avatarErr'] = "Avatar is required";
        } elseif (!in_array($extension, $allowedExtensions)) {
            $this->error['avatarErr']=  "Avatar should be png, jpeg, jpg or gif";
        } else {
            return null; 
        }
        return true;
    }

    public function isValid(){
        if( is_null($this->validateGroupName()) && is_null($this->validateGroupAvatar())
         && is_null($this->validateGroupDescription())){
            return true;
        }else{
            return false;
        }
    }

    public function getError(){
        return $this->error;
    }
}

?>