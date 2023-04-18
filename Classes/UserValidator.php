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
}

?>