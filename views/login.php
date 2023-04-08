<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="/assets/CSS/style.css">
</head>
<body class="login">
        <div class="container ">
        <div class="welcome">
            <div class="pinkbox">
            <div class="signup nodisplay">
                <h1>register</h1>
                <form autocomplete="off">
                <input type="text" placeholder="username">
                <input type="email" placeholder="email">
                <input type="password" placeholder="password">
                <input type="password" placeholder="confirm password">
                <button class="button submit">create account </button>
                </form>
            </div>
            <div class="signin">
                <h1>sign in</h1>
                <form class="more-padding" autocomplete="off">
                <input type="text" placeholder="username">
                <input type="password" placeholder="password">
                <div class="checkbox">
                    <input type="checkbox" id="remember" /><label for="remember">remember me</label>
                </div>

                <button class="button submit">login</button>
                </form>
            </div>
            </div>
            <div class="leftbox">
            <h2 class="title"><span>BLOOM</span>&<br>BOUQUET</h2>
            <p class="desc">pick your perfect <span>bouquet</span></p>
            <img class="flower smaller" src="https://image.ibb.co/d5X6pn/1357d638624297b.jpg" alt="1357d638624297b" border="0">
            <p class="account">have an account?</p>
            <button class="button" id="signin">login</button>
            </div>
            <div class="rightbox">
            <h2 class="title"><span>BLOOM</span>&<br>BOUQUET</h2>
            <p class="desc"> pick your perfect <span>bouquet</span></p>
            <img class="flower" src="https://preview.ibb.co/jvu2Un/0057c1c1bab51a0.jpg"/>
            <p class="account">don't have an account?</p>
            <button class="button" id="signup">sign up</button>
            </div>
        </div>
        </div>

        </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
    <!-- <script src="/assets/JS/script.js"></script> -->
</body>
</html>