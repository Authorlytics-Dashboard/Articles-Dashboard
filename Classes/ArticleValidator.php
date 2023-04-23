<?php
class ArticleValidator {
    public function validateArticleName($name) {
        if (empty($name)) {
            return "Name is required";
        } elseif (!preg_match('/^[a-zA-Z]+$/', $name)) {
            return "Group name should only contain letters";
        } elseif (strlen($name) < 3) {
            return "Group name should be at least 3 characters long";
        } else {
            return null; 
        }
    }
    
    public function validateArticleDescription($description) {
        if (empty($description)) {
            return "Description is required";
        }
        elseif (strlen($description) < 3) {
            return "Description should be at least 3 characters long";
        } else {
            return null; 
        }
    }
    
    public function validateArticleAvatar($avatar) {
        $allowedExtensions = ['png', 'jpeg', 'jpg', 'gif'];
        $extension = strtolower(pathinfo($avatar, PATHINFO_EXTENSION));
        if (empty($avatar)) {
            return "Image is required";
        } elseif (!in_array($extension, $allowedExtensions)) {
            return "Image should be png, jpeg, jpg or gif";
        } else {
            return null; 
        }
    }
}

?>