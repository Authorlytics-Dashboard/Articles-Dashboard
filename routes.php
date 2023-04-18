<?php
    $uri = explode('/', $_SERVER['REQUEST_URI']);
<<<<<<< HEAD
    
    switch($uri[1]) {
        case 'home':
            include_once("./views/dashboard/home.php");
            break;
        case 'groups':
            if(isset($uri[2])) {
                switch($uri[2]) {
                    case 'create':
                        include_once("./views/dashboard/groups/create.php");
                        break;
                    case 'edit':
                        $groupId = $_GET['id'];
                        include_once("./views/dashboard/groups/edit.php");
                        break;
                    case 'update':
                        $groupId = $_GET['id'];
                        $group = new Group();
                        $group ->edit();
                        break;
                    case 'delete':
                        $groupId = $_GET['id'];
                        $group = new Group();
                        $group ->delete($groupId);
                        break;
                    case 'restore':
                        $groupId = $_GET['id'];
                        $group = new Group();
                        $group ->restore($groupId);
                        break;
                    case 'show':
                        include_once('./views/dashboard/groups/show.php');
                        break;
                    default:
                        include_once("./views/dashboard/groups/index.php");
                }
            } else {
                include_once("./views/dashboard/groups/index.php");
            }
            break;
        case 'articles':
            if(isset($uri[2])) {
                switch($uri[2]) {
                    case 'create':
                        include_once('./views/dashboard/articles/create.php');
                        break;
                    case 'show':
                        include_once('./views/dashboard/articles/show.php');
                        break;
                    case 'delete':
                        $articleId = $_GET['id'];
                        $article = new Article();
                        $article ->delete($articleId);
                        break;
                    case 'restore':
                        $articleId = $_GET['id'];
                        $article = new Article();
                        $article ->restore($articleId);
                        break;
                    default:
                        include_once("./views/dashboard/articles/index.php");
                }
            } else {
                include_once("./views/dashboard/articles/index.php");
            }
            break;
        case 'users':
            if(isset($uri[2])) {
                switch($uri[2]) {
                    case 'create':
                        include_once("./views/dashboard/users/create.php");
                        break;
                    case 'edit':
                        $userId = $_GET['id'];
                        include_once("./views/dashboard/users/edit.php");
                        break;
                    case 'update':
                        $userId = $_GET['id'];
                        $user = new User();
                        $user ->edit();
                        break;
                    case 'delete':
                        $userId = $_GET['id'];
                        $user = new User();
                        $user ->delete($userId);
                        break;
                    case 'restore':
                        $userId = $_GET['id'];
                        $user = new User();
                        $user ->restore($userId);
                        break;
                    case 'show':
                        include_once('./views/dashboard/users/show.php');
                        break;
                    default:
                        include_once("./views/dashboard/users/index.php");
                }
            } else {
                include_once("./views/dashboard/users/index.php");
            }
            break;
        case 'logout':
            $user = new User();
            $user->logout();
            break;
        case 'login':
            include_once("./views/login.php");
            break;
        case 'charts':
            include_once("./views/dashboard/charts/index.php");
            break;
        default:
            include_once("./views/errors.php");
    }
?>
=======
    $user = new User('users', "UsersErrors.log",'uid');
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
>>>>>>> 420778d09d58ab0250d19b6d8cee1bf1352d86ce
