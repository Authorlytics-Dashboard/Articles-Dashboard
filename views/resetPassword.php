<?php
    require_once('../vendor/autoload.php');
    $login = new Login();
    $userEmail = "";
    $error = "";
    $flag = 0;

    if(isset($_POST["sendAnOTP"])){
        $userEmail = urldecode($_POST["email"]);
        if(!empty($userEmail)){
            $correctEmail = $login->resetPassword($userEmail);
            if($correctEmail){
                $flag = 1;
            }else{
                $error = "Email not found.";
                $flag = 0;
            }
        }else{
            $error = "Email is required.";
        }
    }elseif(isset($_POST["reset"])){
        $otpCode = urldecode($_POST["OTP"]);
        if(!empty($otpCode)){
            $verifiedOtp = $login->verifyOTP($otpCode);
            if($verifiedOtp){
                $flag = 2;
            }else{
                $error = "OTP is incorrect.";
                $flag = 1;
            }
        }else{
            $error = "No OTP Entered.";
        }
    }elseif(isset($_POST["changePassword"])){
        $password = $_POST["password"];
        $confirmPassword = $_POST["confirmPassword"];
        if(!empty($password) && !empty($confirmPassword)){
            $confirmPass = $login->changePassword($userEmail, $password, $confirmPassword);
            if(! $confirmPass){
                $error = "Password doesnot match.";
                $flag = 2;
            }
        }
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="/assets/CSS/resetPassword.css">
</head>
<body class = "restPass">  
    <div class="container d-flex justify-content-center" style= "height: 100vh;">
        <div class="welcome">
            <div class="pinkbox">
                <form method="post" class="my-auto">
                    <h1>Reset password</h1>
                    <?php if($flag == 0){ ?>
                        <div class="SendTheOTP resetInp">
                            <p class="message">Enter your email to send an OTP.</p>
                            <div>
                                <input class="form-control rounded-0 border-0 border-bottom" type="text" name="email" id="userNameInp" placeholder="Email">
                                <p class="mt-0" style="color: #fb7e61"><?= $error?></p>
                            </div>
                            <button type="submit" class="btn" name="sendAnOTP">SEND OTP</button>
                        </div>
                    <?php } ?>

                    <?php if($flag == 1){ ?> 
                        <div class="VerifyTheOTP resetInp">
                            <p class="message">The OTP is send to your phone, please enter the code</p>
                            <div>
                                <input class="form-control rounded-0 border-0 border-bottom" type="number" name="OTP" id="OTP" placeholder="OTP">
                                <p class="mt-0" style="color: #fb7e61"><?= $error?></p>
                            </div>
                            <button type="submit" class="btn" name="reset" data-bs-target="#VerifyOTP" data-bs-toggle="modal">Submit</button>
                        </div>
                    <?php } ?>

                    <?php if($flag == 2){ ?>
                        <div class="ChangePassword resetInp">
                            <p class="message">Enter a new password</p>
                            <div class="loginInp input-group w-100 mb-3">
                                <input class="form-control rounded-0 border-0 border-bottom" type="password" name="password" id="passwordInp" placeholder="Enter Password"></input>
                                <i class='bx bxs-show fs-5 position-absolute top-50 start-100 translate-middle pe-4' style="z-index:1000; cursor: pointer;" onclick="togglePass()" id="togglePassword"></i>
                            </div>
                            <div class="loginInp input-group w-100 mb-3">
                                <input class="form-control rounded-0 border-0 border-bottom" type="password" name="confirmPassword" id="ConfPasswordInp" placeholder="Reenter Password"></input>
                                <i class='bx bxs-show fs-5 position-absolute top-50 start-100 translate-middle pe-4' style="z-index:1000; cursor: pointer;" id="toggleConfPassword" onclick="toggleConfPass()"></i>
                                <p class="mt-0" style="color: #fb7e61"><?= $error?></p>
                            </div>
                            <button type="submit" class="btn" name="changePassword" data-bs-target="#VerifyOTP" data-bs-toggle="modal">Submit</button>
                    </div>
                    <?php } ?>
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
    

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
    <script>
        let body = document.querySelector("body");
        const savedMode = localStorage.getItem("Mode");
        if(savedMode !== undefined || savedMode !== null){
            if(savedMode == "light"){
                body.classList.add('light-mode');
            }else{
                body.classList.add('dark-mode');
            }
        }

        function togglePass(){
            const togglePassword = document.querySelector('.ChangePassword #togglePassword');
            const password = document.querySelector('#passwordInp');

            const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
            password.setAttribute('type', type);
            togglePassword.classList.toggle('bxs-show');
            togglePassword.classList.toggle('bxs-hide');
        }

        function toggleConfPass(){
            const togglePassword = document.querySelector('.ChangePassword #toggleConfPassword');
            const password = document.querySelector('#ConfPasswordInp');

            const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
            password.setAttribute('type', type);
            togglePassword.classList.toggle('bxs-show');
            togglePassword.classList.toggle('bxs-hide');
        }
    </script>
</body>
</html>