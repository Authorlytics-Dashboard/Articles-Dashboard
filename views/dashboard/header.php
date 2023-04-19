<?php $permission = new Permissions(); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@200;400;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="/assets/CSS/style.css">
    <link rel="stylesheet" href="/assets/CSS/darkMode.css">
    <link rel="stylesheet" href="/assets/CSS/lightMode.css">
    <link rel="stylesheet" href="/assets/CSS/buttons.css">
    <link rel="stylesheet" href="/assets/CSS/showCard.css">
    <link rel="stylesheet" href="/assets/CSS/errorPage.css">
    <link rel="stylesheet" href="/assets/CSS/CurrentUserAvatar.css">


</head>
<?php 
    $loggedIn = new Auth();
    $CurrentUserName = $loggedIn->auth->getUserName();
    $UID = $loggedIn->auth->getUserId();
    $user = new User('users', "UsersErrors.log",'id');
    $u = $user ->getRecordByID($UID);
    $u = $u[0];
?>

<body>
    <div class="container-fluid m-0 p-0">
        <div class="left-col">
            <nav style="display: flex; flex-direction: column; align-items: center; justify-content: space-between;">
                <img src="https://i.postimg.cc/JzKwwG16/arrow.png" class="back-btn">
                <div class="d-flex justify-content-center flex-column align-items-center" >
                    <div class="Useravatar">
                        <a href="">
                            <img src="../../../assets/Images/<?php echo $u['avatar'] ?>" alt="Skytsunami" style="width: 100%; height:100%;">
                        </a>
                    </div>
                    <li class="mt-1 d-flex justify-content-center gap-1" ><?php echo "Current User:  "?><i class='bx bx-crown my-auto'></i><?php echo $CurrentUserName ?></li>
                </div>
                <ul>
                    <li><a href="/home" class="d-flex gap-1 home"><i class='bx bxs-home my-auto'></i>Home</a></li>
                    <?php if($permission->isViewer() && $permission->isEditor()){?>
                    <li><a href="/groups" class="d-flex gap-1 groups"><i class='bx bxs-group my-auto'></i>Groups</a>
                    </li>
                    <li><a href="/users" class="d-flex gap-1 users"><i class='bx bxs-user my-auto'></i>Users</a></li>
                    <?php } ?>
                    <li><a href="/articles" class="d-flex gap-1 articles"><i class='bx bx-news my-auto'></i>Articles</a>
                    </li>
                    <?php if($permission->isViewer() && $permission->isEditor()){?>
                    <li><a href="/charts" class="d-flex gap-1 charts"><i
                                class='bx bxs-bar-chart-alt-2 my-auto'></i>Charts</a>
                    </li>
                    <?php } ?>
                    <li><a href="/logout" class="d-flex gap-1"><i class='bx bxs-log-out my-auto'></i>Logout</a></li>
                </ul>
                <div class="checkbox-wrapper-5">
                    <div class="check">
                        <input type="checkbox" id="check-5">
                        <label for="check-5"></label>
                    </div>
                </div>
            </nav>
        </div>
        <svg  class="menu-btn" style="position: absolute; margin:20px; cursor: pointer;" width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M20 5V2H0V5H20ZM20 11V8H0V11H20ZM20 17V14H0V17H20Z" fill="white"/>
        </svg>