<?php  

    $userId = $_GET['id'];
    $user = new User('users', "UsersErrors.log",'uid');
    $userInfo = $user ->getRecordByID($userId);
    $userInfo = $userInfo[0];?>

<section class="userSection">
    <div class="container py-4 border my-5 mx-auto">
        <div style="display: flex; justify-content: center; align-items: center;">
            <img src="../../../assets/Images/<?php echo $userInfo['avatar'] ?>" alt=""
                class='rounded-circle img-thumbnail' style='width:150px; height:150px;'>
        </div>
        <form action="/users/update/?id=<?php echo $userId ;?>" method="POST" class="w-75 mx-auto"
            enctype="multipart/form-data">
            <div class=" mb-3">
                <label for="name" class="form-label">Username</label>
                <input type="text" class="form-control" name="name" id="name" value="<?php echo $userInfo["uname"];?>">
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" name="email" id="email"
                    value="<?php echo $userInfo["email"];?>">
            </div>
            <div class="mb-3">
                <label for="mobile" class="form-label">Mobile</label>
                <input type="text" class="form-control" name="mobile" id="mobile"
                    value="<?php echo $userInfo["mobile"];?>">
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" name="password" id="password">
            </div>
            <div class="mb-3">
                <label for="avatar" class="form-label">Avatar</label>
                <input type="file" class="form-control" name="avatar" id="avatar">
            </div>
            <div class="mb-3 text-center mt-5">
                <input type="submit" class="btn btn-success me-1 rounded-1" name="update" value="update">
                <a href="index.php" class="btn btn-danger">cancel</a>
            </div>
        </form>
    </div>
</section>