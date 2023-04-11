<?php
    $uri = explode('/', $_SERVER['REQUEST_URI']);

    if(! isset($uri[2]))
    {
        include_once("./views/dashboard/home.php");
    }else{
        if($uri[2] == "groups") {
            include_once("./views/dashboard/group.php");
        }elseif($uri[2] == "users") {
            
        }elseif($uri[2] == "articles") {
            
        }
    }
?>