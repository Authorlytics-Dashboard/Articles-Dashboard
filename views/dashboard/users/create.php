<section class="userSection">
    <div class="container py-4 border my-5 mx-auto">
        <form method="post" action="" class="w-75 mx-auto" enctype="multipart/form-data">
            <div class=" mb-3">
                <label for="name" class="form-label">Username</label>
                <input type="text" class="form-control" name="name" id="name">
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" name="email" id="email">
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
                            echo "<option value=\"$gid\">$gname</option>";
                        }
                    ?>
                </select>
            </div>


            <div class=" mb-3">
                <label for="mobile" class="form-label">Mobile Number</label>
                <input type="number" class="form-control" name="mobile" id="mobile">
            </div>
            <div class=" mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" name="password" id="password">
            </div>
            <div class="mb-3">
                <label for="avatar" class="form-label">Avatar</label>
                <input type="file" class="form-control" name="avatar" id="avatar">
            </div>

            <div class="mb-3 text-center mt-5">
                <input type="submit" class="btn btn-primary me-1 rounded-1" name="action" value="Create">
                <a href="/home" class="btn btn-danger">cancel</a>
            </div>
        </form>

    </div>
</section>
<?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'Create') {
    $user = new User('users', "UsersErrors.log",'uid');
    $data = [
        'uname' => $_POST['name'],
        'email' => $_POST['email'],
        'gid' => $_POST['group_id'],
        'mobile' => $_POST['mobile'],
        'password' => $_POST['password'],
        'avatar' => $_FILES['avatar']['name']
    ];
    $user->create($data);
}?>