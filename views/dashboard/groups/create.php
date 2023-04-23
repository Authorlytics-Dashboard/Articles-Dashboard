<?php

    if (isset($_SESSION['GroupData'])) {
        
        $data = $_SESSION['GroupData'];
   
        unset($_SESSION['GroupData']);
        
    }

    ob_start();
?>
<section class="groupSection">
    <div class="container py-4 border my-5 mx-auto">
        <form method="post" action="" class="w-75 mx-auto" enctype="multipart/form-data">
            <div class=" mb-3">
                <label for="name" class="form-label">Group Name</label>
                <input type="text" class="form-control" name="name" id="name"
                    value="<?= htmlspecialchars($data['gname'] ?? '');?>">
                <label class="error-message text-danger mt-2" id="nameErr"></label>
            </div>

            <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <input type="text" class="form-control" name="description" id="description"
                    value="<?= htmlspecialchars($data['description'] ?? '') ?>">
                <label class="error-message text-danger mt-2" id="descriptionErr"></label>
            </div>

            <div class="mb-3">
                <label for="avatar" class="form-label">Avatar</label>
                <input type="file" class="form-control" name="avatar" id="avatar">
                <label class="error-message text-danger mt-2" id="avatarErr"></label>
            </div>

            <div class="mb-3 text-center mt-5 d-flex justify-content-end">
                <input type="submit" class="btn createBtn me-1 rounded-1" name="action" value="Create">
                <a href="/groups" class="btn cancelBtn">Cancel</a>
            </div>
        </form>

    </div>
</section>
<?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'Create') {
        
        $data = [
            'gname' => $_POST['name'],
            'description' => $_POST['description'],
            'avatar' => $_FILES['avatar']['name']
        ];

        $group = new Group('groups',"GroupsErrors.log",'gid');
        $group->create($data);
       
    }
    
    if (isset($_SESSION['GroupErrors'])) {
        $errors = $_SESSION['GroupErrors'];
        unset($_SESSION['GroupErrors']);
        $group->showError($errors);
    }


?>