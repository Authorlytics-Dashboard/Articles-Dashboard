<?php
    if (isset($_SESSION['data'])) {
        $data = $_SESSION['data'];
        unset($_SESSION['data']);
    }
    ob_start();
?>

<section class="userSection">
    <div class="container py-4 border my-5 mx-auto">
        <form method="post" action="" class="w-75 mx-auto" enctype="multipart/form-data">
            <div class=" mb-3">
                <label for="name" class="form-label">Username</label>
                <input type="text" class="form-control" name="name" id="name" value="<?= htmlspecialchars($data['username'] ?? '') ?>">
                <p class="col-12 text-danger" id="nameErr"></p>
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" name="email" id="email" value="<?= htmlspecialchars($data['email'] ?? '') ?>">
                <p class="col-12 text-danger" id="emailErr"></p>
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
                <p class="col-12 text-danger" id="groupErr"></p>
            </div>

            <div class=" mb-3">
                <label for="mobile" class="form-label">Mobile Number</label>
                <input type="text" class="form-control" name="mobile" id="mobile" value="<?= htmlspecialchars($data['mobile'] ?? '') ?>">
                <p class="col-12 text-danger" id="mobileErr"></p>
            </div>

            <div class=" mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" name="password" id="password" value="<?= htmlspecialchars($data['password'] ?? '') ?>">
                <p class="col-12 text-danger" id="passwordErr"></p>
            </div>

            <div class="mb-3">
                <label for="avatar" class="form-label">Avatar</label>
                <input type="file" class="form-control" name="avatar" id="avatar">
                <p class="col-12 text-danger" id="avatarErr"></p>
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
            'username' => $_POST['name'],
            'email' => $_POST['email'],
            'gid' => $_POST['group_id'],
            'mobile' => $_POST['mobile'],
            'password' => $_POST['password'],
            'avatar' => $_FILES['avatar']['name']
        ];

        $user = new User('users', "UsersErrors.log",'id');
        $user->create($data);
    }
?>