<?php 
    session_start();
    $login = new Login();
    if (isset($_COOKIE["remember_token"])) {
        $token = $login -> getUserToken();
        if ($token && time() < strtotime($token["expire"])) {
            $user_id = $token["user_id"];
            $_SESSION["id"] = $user_id ;
        }
    }

    $login->checkLoggedIn();

    if(isset($_POST["login"])){
        $result = $login->login(urldecode($_POST["email"]), $_POST["password"]);

        if($result == 1){
            $_SESSION["login"] = true;
            $_SESSION["id"] = $login->idUser();
            $lastVisit = $login->getLastVisit($_POST["email"]);
            if($lastVisit){
                echo "
                <div class='modal fade show in' tabindex='-1' id='welcome'>
                        <div class='modal-dialog'>
                            <div class='modal-content'>
                            <div class='modal-body'style='color:black'>
                            Hello and welcome back! We hope you've been well since your last visit on<span style='color:red'> $lastVisit</span>
                            </div>
                            <div class='modal-footer'>
                                <button type='button' class='btn btn-secondary' data-bs-dismiss='modal'>Close</button>
                            </div>
                            </div>
                        </div>
                        </div>
                ";
            }
            else{
                echo "Welcome! This is your first visit.";
            }
            $login->setLastVisit();
            require_once("./views/dashboard.php");
        }
        elseif($result == 10){
            http_response_code(401); // Unauthorized
            $errorMessage = "";
            $errorMessage = "Wrong password";
        }
        elseif($result == 100){
        $errorMessage = "User not registered";
        }
    }elseif(isset($_POST["forgetPass"])){
        header("Location: /views/resetPassword.php");
    }

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="/assets/CSS/login.css">
</head>

<body class="login">
    <?php if(isset($errorMessage)): ?>
    <div class="error-message"><?php echo htmlspecialchars($errorMessage, ENT_QUOTES); ?></div>
    <?php endif; ?>

    <div class="container ">
        <div class="welcome">
            <div class="pinkbox">
                <form class="h-100 d-flex flex-column justify-content-between" autocomplete="off" method="post">
                    <h1 class="m-0">sign in</h1>

                    <div class="inputContainer">
                        <div class="loginInp input-group w-100 mb-3">
                            <input class="form-control rounded-0 border-0 border-bottom" type="text" name="email" id="userNameInp" placeholder="user email">
                        </div>

                        <div class="loginInp input-group w-100 mb-3">
                            <input class="form-control rounded-0 border-0 border-bottom" type="password" name="password" id="passwordInp" placeholder="Password"></input>
                            <i class='bx bxs-show fs-5 position-absolute top-50 start-100 translate-middle pe-4' style="z-index:1000; cursor: pointer;" id="togglePassword"></i>
                        </div>

                        <div class="form-check form-check-inline mb-4">
                            <input class="form-check-input" type="checkbox" id="remember_me" name="remember_me" style="background-color: transparent;" >
                            <label class="form-check-label ps-2" style="cursor: pointer;" for="remember_me">Remember me</label>
                        </div>
                    </div>

                    <div class="btns text-center">
                        <button class="loginBtn button submit w-100 mb-2" name="login" type="submit">login</button>
                        <button class="forgetPass text-decoration-none text-white" name="forgetPass" style="font-size: 15px; border: none;">Forgot your password?</button>
                    </div>
                </form>
            </div>

            <div class="rightbox">
                <h2 class="title"><span>AUTHOR</span>-<br>LYTICS</h2>
                <p class="desc"> Streamline your <span> writing process</span></p>
                <div class="logo d-flex justify-content-center">
                    <svg width="100px" height="100px" viewBox="0 0 220 265" id="logoSvg">
                        <path class="stroke1" fill="none" stroke="#70353e" stroke-width="32" stroke-dasharray="240" stroke-dashoffset="0" stroke-miterlimit="10" d="M50,0v136.9c0,17.7,14.5,32.2,32.2,32.2l52.5,0" 
                        />
                        <line class="stroke2" fill="none" stroke="#70353e" stroke-width="32" stroke-dasharray="50" stroke-dashoffset="0" stroke-stroke-miterlimit="10" x2="219.8" y2="169.2" x1="169.9" y1="169.2" />
                        <path class="stroke3" fill="none" stroke="#70353e" stroke-width="32" stroke-dasharray="240" stroke-dashoffset="0" stroke-miterlimit="10" d="M169.8,216.1V79.2c0-17.7-14.5-32.2-32.2-32.2
                        l-52.5,0"/>
                        <line class="stroke4" fill="none" stroke="#70353e" stroke-width="32" stroke-dasharray="50" stroke-dashoffset="0" stroke-miterlimit="10" x2="0" y2="46.9" x1="50" y1="46.9"/>
                    </svg>                    
                </div>
            </div>
        
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.4.min.js" integrity="sha256-oP6HI9z1XaZNBrJURtCoUT5SUnxFr8s3BzRl+cbzUq8=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
    
    <script>
        $(document).ready(function(){
            $("#welcome").modal('show');
        });
        
        const togglePassword = document.querySelector('#togglePassword');
        const password = document.querySelector('#passwordInp');

        togglePassword.addEventListener('click', function (e) {
            const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
            password.setAttribute('type', type);
            this.classList.toggle('bxs-show');
            this.classList.toggle('bxs-hide');
        });

        let body = document.querySelector("body");
        const savedMode = localStorage.getItem("Mode");
        if(savedMode !== undefined || savedMode !== null){
            if(savedMode == "light"){
                body.classList.add('light-mode');
            }else{
                body.classList.add('dark-mode');
            }
        }
    </script>
</body>
</html>