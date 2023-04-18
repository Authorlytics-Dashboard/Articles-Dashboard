<?php  
    $userId = $_GET['id'];
    $user = new User('users', "UsersErrors.log",'id');
    $userInfo = $user ->getRecordByID($userId);
    $userInfo = $userInfo[0];

    $error = array();
    if (isset($_SESSION['data'])) {
        $data = $_SESSION['data'];
        unset($_SESSION['data']);
    }
?>

<section class="userSection">
    <div class="container py-4 border my-5 mx-auto">
        <div style="display: flex; justify-content: center; align-items: center;">
            <img src="../../../assets/Images/<?php echo $userInfo['avatar'] ?>" alt=""
                class='rounded-circle img-thumbnail' style='width:150px; height:150px;'>
        </div>
        <form action="/users/edit/?id=<?php echo $userId ;?>" method="POST" class="w-75 mx-auto"
            enctype="multipart/form-data">
            <div class=" mb-3">
                <label for="name" class="form-label">Username</label>
                <input type="text" class="form-control" name="name" id="name" value="<?= htmlspecialchars($data['uname'] ?? $userInfo["username"]) ?>">
                <?php if( isset($error['nameErr']) ){ ?>
                    <p class="col-12 text-danger"><?= $error['nameErr'] ?></p>
                <?php } ?>
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" name="email" id="email"
                    value="<?= htmlspecialchars($data['email'] ?? $userInfo["email"]) ?>">
                <?php if( isset($error['emailErr']) ){ ?>
                    <p class="col-12 text-danger"><?= $error['emailErr'] ?></p>
                <?php } ?>
            </div>

            <div class="mb-3">
                <label for="mobile" class="form-label">Mobile</label>
                <input type="text" class="form-control" name="mobile" id="mobile"
                    value="<?= htmlspecialchars($data['mobile'] ?? $userInfo["mobile"]) ?>">
                <?php if( isset($error['mobileErr']) ){ ?>
                    <p class="col-12 text-danger"><?= $error['mobileErr'] ?></p>
                <?php } ?>
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" name="password" id="password"
                    value="<?= htmlspecialchars($data['password'] ?? $userInfo["password"]) ?>">
                <?php if( isset($error['passwordErr']) ){ ?>
                    <p class="col-12 text-danger"><?= $error['passwordErr'] ?></p>
                <?php } ?>
            </div>

            <div class="mb-3">
                <label for="avatar" class="form-label">Avatar</label>
                <input type="file" class="form-control" name="avatar" id="avatar">
                <?php if( isset($error['avatarErr']) ){ ?>
                    <p class="col-12 text-danger"><?= $error['avatarErr'] ?></p>
                <?php } ?>
            </div>
            <div class="mb-3 text-center mt-5 d-flex justify-content-end">
                <input type="submit" class="btn updateBtn me-1 rounded-1" name="update" value="Update">
                <a href="index.php" class="btn cancelBtn">Cancel</a>
            </div>
        </form>
    </div>
</section>

<?php
    if (isset($_POST["update"])) {
        $userID = $_GET['id'];
        $data = [
            'uid' => $userId = $userID,
            'uname' => $_POST['name'],
            'email' => $_POST['email'],
            'mobile' => $_POST['mobile'],
            'password' => $_POST['password'],
            'avatar' => $_FILES['avatar']['name']
        ];

        $user = new User('users', "UsersErrors.log", 'id');
        $user->update($data, $userID);
    }   
?>