<?php
    $uri = explode('/', $_SERVER['REQUEST_URI']);

    if($uri[1] == "home") {
        include_once("./views/dashboard/home.php");
    }elseif($uri[1] == "groups") {
        include_once("./views/dashboard/groups/groups.php");
    }elseif($uri[1] == "users") {
        include_once("./views/dashboard/users/user.php");
    }elseif($uri[1] == "articles") {
        include_once("./views/dashboard/articles/article.php");
    }elseif($uri[1] == "logout") {

    }
?>