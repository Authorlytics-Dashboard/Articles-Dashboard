<?php
    $uri = explode('/', $_SERVER['REQUEST_URI']);
    $user = new User('users', "UsersErrors.log",'id');
    $group = new Group('groups',"GroupsErrors.log",'gid');
    if($uri[1] == "home") {
        include_once("./views/dashboard/home.php");
    }elseif ($uri[1] == "groups" && isset($uri[2]) && $uri[2] == "edit" && isset($uri[3])) {
        $groupId = $_GET['id'];
        include_once("./views/dashboard/groups/edit.php");
    }
    elseif ($uri[1] == "groups" && isset($uri[2]) &&  $uri[2] == "update" && isset($uri[3])) {
        $groupId = $_GET['id'];

        $group ->edit();
    }
    elseif ($uri[1] == "groups" && isset($uri[2]) &&  $uri[2] == "delete" && isset($uri[3])) {
        $groupId = $_GET['id'];
        $group ->delete($groupId);
    }
    elseif ($uri[1] == "groups" && isset($uri[2]) &&  $uri[2] == "restore" && isset($uri[3])) {
        $groupId = $_GET['id'];
        $group ->restore($groupId);
    }
    elseif ($uri[1] == "groups" && isset($uri[2]) &&  $uri[2] == "show" && isset($uri[3])) {
        include_once('./views/dashboard/groups/show.php');
    }
    elseif ($uri[1] == "articles" && isset($uri[2]) &&  $uri[2] == "create") {
        include_once('./views/dashboard/articles/create.php');
    }
    elseif ($uri[1] == "articles" && isset($uri[2]) &&  $uri[2] == "show" && isset($uri[3])) {
        include_once('./views/dashboard/articles/show.php');
    }
    elseif ($uri[1] == "articles" && isset($uri[2]) &&  $uri[2] == "delete" && isset($uri[3])) {
        $articleId = $_GET['id'];
        $article = new Article();
        $article ->delete($articleId);
    }
    elseif ($uri[1] == "articles" && isset($uri[2]) &&  $uri[2] == "restore" && isset($uri[3])) {
        $articleId = $_GET['id'];
        $article = new Article();
        $article ->restore($articleId);
    }
    elseif ($uri[1] == "users" && isset($uri[2]) && $uri[2] == "edit" && isset($uri[3])) {
        $userId = $_GET['id'];
        include_once("./views/dashboard/users/edit.php");
    }
    elseif ($uri[1] == "users" && isset($uri[2]) &&  $uri[2] == "update" && isset($uri[3])) {
        $userId = $_GET['id'];
 
        $user ->edit();
    }
    elseif ($uri[1] == "users" && isset($uri[2]) &&  $uri[2] == "delete" && isset($uri[3])) {
        $userId = $_GET['id'];
        $user ->delete($userId);
    }
    elseif ($uri[1] == "users" && isset($uri[2]) &&  $uri[2] == "restore" && isset($uri[3])) {
        $userId = $_GET['id'];
        $user ->restore($userId);
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
        include_once("./views/dashboard/articles/index.php");
    }elseif($uri[1] == "logout") {
        $user->logout();
    }
    elseif($uri[1] == "login") {
        include_once("./views/login.php"); 
    }
elseif($uri[1] == "charts") {
    include_once("./views/dashboard/charts/index.php");
}

?>