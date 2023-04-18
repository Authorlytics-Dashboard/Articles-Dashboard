<?php
class UserValidator {
    public function validateUserName($name) {
        if (empty($name)) {
            return "Name is required";
        } elseif (strlen($name) < 3) {
            return "Name should be at least 3 characters long";
        } else {
            return null; 
        }
    }
    
    public function validateUserEmail($email) {
        if (empty($email)) {
            return "email is required";
        } elseif(!filter_var($email, FILTER_VALIDATE_EMAIL)){
            $emailErr = "Invalid email format";
        } else {
            return null; 
        }
    }

}

?>