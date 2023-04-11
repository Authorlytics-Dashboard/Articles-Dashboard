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
</head>

<body>
    <div class="container-fluid m-0 p-0">
        <div class="left-col">
            <nav style="display: flex; flex-direction: column; align-items: center; justify-content: space-between;">
                <img src="https://i.postimg.cc/JzKwwG16/arrow.png" class="back-btn">
                <ul>
                    <li><a href="#" class="active d-flex gap-1 "><i class='bx bxs-home my-auto'></i>Home</a></li>
                    <li><a href="group.php" class="d-flex gap-1"><i class='bx bxs-group my-auto'></i>Groups</a></li>
                    <li><a href="#" class="d-flex gap-1"><i class='bx bxs-user my-auto'></i>Users</a></li>
                    <li><a href="#" class="d-flex gap-1"><i class='bx bx-news my-auto'></i>Articles</a></li>
                    <li><a href="#" class="d-flex gap-1"><i class='bx bxs-log-out my-auto'></i>Logout</a></li>
                </ul>
                <div class="checkbox-wrapper-5">
                    <div class="check">
                        <input type="checkbox" id="check-5">
                        <label for="check-5"></label>
                    </div>
                </div>
            </nav>
        </div>
        <?php 
            // require ('Classes/Group.php');
            // $group = new Group();
            
            if (isset($_GET['page'])) {
                $page = $_GET['page'];
            } else {
                $page = 'home';
            }

            switch ($page) {
                
                case 'home':
                    include_once("./views/dashboard/home.php");
                    break;
                case 'groups':
                    include_once("./views/dashboard/group.php");
                    break;
                // Add cases for other views
            }        
        ?>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous">
    </script>
    <script src="/assets/JS/script.js"></script>
</body>

</html>