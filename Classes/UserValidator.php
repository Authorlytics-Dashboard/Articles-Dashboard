<?php
class UserValidator {
    public function __construct(private $data){
    }

    public function validateUserName() {
        if (empty($this->data['uname'])) {
            return "Name is required";
        } elseif (!preg_match('/^01[0-9]{9}$/', $this->data['mobile'])) {
            return "mobile should only contain numbers";
        } elseif (strlen($this->data['uname']) < 3) {
            return "Name should be at least 3 characters long";
        } else {
            return null; 
        }
    }
    
    public function validateUserEmail() {
        if (empty($this->data['email'])) {
            return "Email is required";
        } elseif(!filter_var($this->data['email'], FILTER_VALIDATE_EMAIL)){
            return "Invalid email format";
        } else {
            return null; 
        }
    }

    public function validateUserPassword() {
        if (empty($this->data['password'])) {
            return "password is required";
        } elseif (strlen($this->data['password']) < 6) {
            return "password should be at least 6 characters long";
        } else {
            return null; 
        }
    }
    
    public function validateUserMobile() {
        if (empty($this->data['mobile'])) {
            return "Mobile Number is required";
        } elseif (strlen($this->data['mobile']) == 10) {
            return "Mobile should be 10 digits";
        } elseif (!preg_match('/^(?:\+20|0)?1[0125]\d{8}$/', $this->data['mobile'])) {
            return "mobile should be a valid number";
        } else {
            return null; 
        }
    }

    public function validateUserGroup(){
        $groups = new User('groups', "GroupsErrors.log",'id');
        $group = $groups->search(array("column" => "gid", "value" => $this->data['gid']));
        if(!$group){
            return "Selected group does not exist";
        } else{
            return null;
        }
    }
    
    public function validateUserAvatar() {
        $allowedExtensions = ['png', 'jpeg', 'jpg', 'gif'];
        $extension = strtolower(pathinfo($this->data['avatar'], PATHINFO_EXTENSION));
        if (empty($this->data['avatar'])) {
            return "Avatar is required";
        } elseif (!in_array($extension, $allowedExtensions)) {
            return "Avatar should be png, jpeg, jpg or gif";
        } else {
            return null; 
        }
    }

    public function isValid(){
        if( is_null($this->validateUserName()) && is_null($this->validateUserEmail()) 
            && is_null($this->validateUserPassword()) && is_null($this->validateUserMobile())
            && is_null($this->validateUserGroup()) && is_null($this->validateUserAvatar()) ){
            return true;
        }else{
            return false;
        }
    }
    
    public function getErrorMessage(){
        return [
            'nameErr' => $this->validateUserName(), 
            'emailErr' => $this->validateUserEmail(), 
            'passwordErr' => $this->validateUserPassword(),
            'mobileErr' => $this->validateUserMobile(), 
            'groupErr' => $this->validateUserGroup(),
            'avatarErr' => $this->validateUserAvatar()
        ];
    }
}

?>