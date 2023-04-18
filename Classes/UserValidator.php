<?php
class UserValidator {
    private $error;

    public function __construct(private $data, private $operation){
        $this->validateUserName();
        $this->validateUserEmail();
        $this->validateUserPassword();
        $this->validateUserMobile();
        $this->validateUserGroup();
        $this->validateUserAvatar();
    }

    public function validateUserName() {
        if (empty($this->data['uname'])) {
            $this->error['nameErr'] =  "Name is required";
        } elseif (strlen($this->data['uname']) < 3) {
            $this->error['nameErr'] =  "Name should be at least 3 characters long";
        } else {
            return null; 
        }
        return true;
    }
    
    public function validateUserEmail() {
        $users = new User('users', "UsersErrors.log",'id');
        $user = $users->search(array("column" => "email", "value" => $this->data['email']));
        
        if($this->operation == "create"){
            if(!empty($user)){
                $this->error['emailErr'] = "Email is already token.";
            }
        }else{
            if(!empty($user) &&( $user['uid'] != $this->data['uid'])){
                $this->error['emailErr'] = "Email is already token.";
            }
        }

        if (empty($this->data['email'])) {
            $this->error['emailErr'] = "Email is required";
        } elseif(!filter_var($this->data['email'], FILTER_VALIDATE_EMAIL)){
            $this->error['emailErr'] = "Invalid email format";
        } else {
            return null; 
        }
        return true;
    }

    public function validateUserPassword() {
        if (empty($this->data['password'])) {
            $this->error['passwordErr'] = "Password is required";
        } elseif (strlen($this->data['password']) < 6) {
            $this->error['passwordErr'] = "Password should be at least 6 characters long";
        } else {
            return null; 
        }
        return true;
    }
    
    public function validateUserMobile() {
        if (empty($this->data['mobile'])) {
            $this->error['mobileErr'] = "Mobile Number is required";
        } elseif (!preg_match('/^01[0-9]\d{8}$/', $this->data['mobile'])) {
            $this->error['mobileErr'] = "Mobile should be a valid number";
        } else {
            return null; 
        }
        return true;
    }

    public function validateUserGroup(){
        $groups = new User('groups', "GroupsErrors.log",'id');
        $group = $groups->search(array("column" => "gid", "value" => $this->data['gid']));
        
        if(!$group){
            $this->error['groupErr'] = "Selected group does not exist";
        } else{
            return null;
        }
        return true;
    }
    
    public function validateUserAvatar() {
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
        if( is_null($this->validateUserName()) && is_null($this->validateUserEmail()) 
            && is_null($this->validateUserPassword()) && is_null($this->validateUserMobile())
            && is_null($this->validateUserGroup()) && is_null($this->validateUserAvatar()) ){
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