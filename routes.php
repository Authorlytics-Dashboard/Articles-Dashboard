<?php
    $uri = explode('/', $_SERVER['REQUEST_URI']);

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
                        $group = new Group('groups',"GroupsErrors.log",'gid');
                        $group ->edit();
                        break;
                    case 'delete':
                        $groupId = $_GET['id'];
                        $group = new Group('groups',"GroupsErrors.log",'gid');
                        $group ->delete($groupId);
                        break;
                    case 'restore':
                        $groupId = $_GET['id'];
                        $group = new Group('groups',"GroupsErrors.log",'gid');
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
                        $article = new Article('articles','ArticlesErrors.log','aid');
                        $article ->delete($articleId);
                        break;
                    case 'restore':
                        $articleId = $_GET['id'];
                        $article = new Article('articles','ArticlesErrors.log','aid');
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
                        $user = new User('users', "UsersErrors.log",'uid');
                        $user ->edit();
                        break;
                    case 'delete':
                        $userId = $_GET['id'];
                        $user = new User('users', "UsersErrors.log",'uid');
                        $user ->delete($userId);
                        break;
                    case 'restore':
                        $userId = $_GET['id'];
                        $user = new User('users', "UsersErrors.log",'uid');
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
            $user = new User('users', "UsersErrors.log",'uid');
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