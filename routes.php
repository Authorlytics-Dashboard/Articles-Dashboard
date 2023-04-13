<?php
require_once('Classes/Group.php'); 
require_once('Classes/User.php');
    $uri = explode('/', $_SERVER['REQUEST_URI']);
    // var_dump($uri);
    if($uri[1] == "home") {
        include_once("./views/dashboard/home.php");
    }elseif ($uri[1] == "groups" && isset($uri[2]) && $uri[2] == "edit" && isset($uri[3])) {
        $groupId = $_GET['id'];
        include_once("./views/dashboard/groups/edit.php");
    }
    elseif ($uri[1] == "groups" && isset($uri[2]) &&  $uri[2] == "update" && isset($uri[3])) {
        $groupId = $_GET['id'];
        $group = new Group();
        $group ->edit();
    }
    elseif ($uri[1] == "groups" && isset($uri[2]) &&  $uri[2] == "delete" && isset($uri[3])) {
        $groupId = $_GET['id'];
        $group = new Group();
        $group ->delete($groupId);
    }
    elseif ($uri[1] == "groups" && isset($uri[2]) &&  $uri[2] == "show" && isset($uri[3])) {
        include_once('./views/dashboard/groups/show.php');
        $groupId = $_GET['id'];
    

    }elseif ($uri[1] == "users" && isset($uri[2]) && $uri[2] == "edit" && isset($uri[3])) {
        $userId = $_GET['id'];
        include_once("./views/dashboard/users/edit.php");
    }
    elseif ($uri[1] == "users" && isset($uri[2]) &&  $uri[2] == "update" && isset($uri[3])) {
        $userId = $_GET['id'];
        $user = new User();
        $user ->edit();
    }
    elseif ($uri[1] == "users" && isset($uri[2]) &&  $uri[2] == "delete" && isset($uri[3])) {
        $userId = $_GET['id'];
        $user = new User();
        $user ->delete($userId);
    }
    elseif ($uri[1] == "users" && isset($uri[2]) &&  $uri[2] == "show" && isset($uri[3])) {
        include_once('./views/dashboard/users/show.php');
        $userId = $_GET['id'];
    }   
    elseif($uri[1] == "groups") {
        include_once("./views/dashboard/groups/index.php");
    }elseif($uri[1] == "CreateGroup") {
        include_once("./views/dashboard/groups/group.php");
        
    }elseif($uri[1] == "users") {
        include_once("./views/dashboard/users/index.php");
    }
    elseif($uri[1] == "CreateUser") {
        include_once("./views/dashboard/users/user.php");
    }elseif($uri[1] == "articles") {
        include_once("./views/dashboard/articles/article.php");
    }elseif($uri[1] == "logout") {

    }
    
?>