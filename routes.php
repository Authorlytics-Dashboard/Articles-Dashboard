<?php
    $uri = explode('/', $_SERVER['REQUEST_URI']);
    var_dump($uri);
    if($uri[1] == "home") {
        include_once("./views/dashboard/home.php");
    }elseif ($uri[1] == "groups" && isset($uri[2]) && $uri[2] == "edit" && isset($uri[3])) {
        $groupId = $_GET['id'];
        include_once("./views/dashboard/groups/edit.php");
    }
    elseif ($uri[1] == "groups" && isset($uri[2]) &&  $uri[2] == "update" && isset($uri[3])) {
        $groupId = $_GET['id'];
        include_once("./views/dashboard/groups/update.php");
    }
    elseif($uri[1] == "groups") {
        include_once("./views/dashboard/groups/index.php");
    }elseif($uri[1] == "CreateGroup") {
        include_once("./views/dashboard/groups/group.php");
    }elseif($uri[1] == "users") {
        include_once("./views/dashboard/users/user.php");
    }elseif($uri[1] == "articles") {
        include_once("./views/dashboard/articles/article.php");
    }elseif($uri[1] == "logout") {

    }
    
?>