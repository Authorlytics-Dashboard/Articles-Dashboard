<?php
    $error = array();
    if (isset($_SESSION['error'])) {
        $error = $_SESSION['error'];
        unset($_SESSION['error']);
        $data = $_SESSION['data'];
        unset($_SESSION['data']);
    }
?>

<section class="userSection">
    <div class="container py-4 border my-5 mx-auto">
        <form method="post" action="" class="w-75 mx-auto" enctype="multipart/form-data">
            <div class=" mb-3">
                <label for="name" class="form-label">Username</label>
                <input type="text" class="form-control" name="name" id="name" value="<?= htmlspecialchars($data['uname'] ?? '') ?>">
                <?php if( isset($error['nameErr']) ){ ?>
                    <p class="col-12 text-danger"><?= $error['nameErr'] ?></p>
                <?php } ?>
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" name="email" id="email" value="<?= htmlspecialchars($data['email'] ?? '') ?>">
                <?php if( isset($error['emailErr']) ){ ?>
                    <p class="col-12 text-danger"><?= $error['emailErr'] ?></p>
                <?php } ?>
            </div>

            <div class="mb-3">
                <label for="group_id" class="form-label">Group</label>
                <select class="form-control" name="group_id" id="group_id">
                    <?php
                        ob_start();
                        $group = new Group('groups',"GroupsErrors.log",'gid');
                        $groups = $group->getGroups();
                        foreach ($groups as $g) {
                            $gid = $g['gid'];
                            $gname = $g['gname'];
                            echo "<option value=\"$gid\"";
                            if(isset($data)){
                                if ($data['gid'] == $gid) {
                                    echo " selected";
                                }
                            }
                            echo ">$gname</option>";
                        }
                    ?>
                </select>
                <?php if( isset($error['groupErr']) ){ ?>
                    <p class="col-12 text-danger"><?= $error['groupErr'] ?></p>
                <?php } ?>
            </div>

            <div class=" mb-3">
                <label for="mobile" class="form-label">Mobile Number</label>
                <input type="text" class="form-control" name="mobile" id="mobile" value="<?= htmlspecialchars($data['mobile'] ?? '') ?>">
                <?php if( isset($error['mobileErr']) ){ ?>
                    <p class="col-12 text-danger"><?= $error['mobileErr'] ?></p>
                <?php } ?>
            </div>

            <div class=" mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" name="password" id="password" value="<?= htmlspecialchars($data['password'] ?? '') ?>">
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
                <input type="submit" class="btn createBtn me-1 rounded-1" name="action" value="Create">
                <a href="/home" class="btn cancelBtn">Cancel</a>
            </div>
        </form>
    </div>
</section>

<?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'Create') {
        $data = [
            'uname' => $_POST['name'],
            'email' => $_POST['email'],
            'gid' => $_POST['group_id'],
            'mobile' => $_POST['mobile'],
            'password' => $_POST['password'],
            'avatar' => $_FILES['avatar']['name']
        ];
        
        $userValidation = new UserValidator($data);
        if(! $userValidation->isValid()){
            $error = $userValidation->getErrorMessage();
            session_start();
            $_SESSION['data'] = $data;
            $_SESSION['error'] = $error;
            header("Location: /users/create");
            exit();
        } else {
            var_dump("Data Valid");
            $user = new User('users', "UsersErrors.log",'id');
            $user->create($data);
        }
    }
?>