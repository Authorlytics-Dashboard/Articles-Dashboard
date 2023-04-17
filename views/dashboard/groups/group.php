<section class="groupSection">
    <div class="container py-4 border my-5 mx-auto">
        <form method="post" action="" class="w-75 mx-auto" enctype="multipart/form-data">
            <div class=" mb-3">
                <label for="name" class="form-label">Group Name</label>
                <input type="text" class="form-control" name="name" id="name"
                    value="<?php echo isset($_POST['name']) ? $_POST['name'] : ''; ?>">
                <label class="error-message text-danger" id="name-error"></label>
            </div>

            <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <input type="text" class="form-control" name="description" id="description"
                    value="<?php echo isset($_POST['description']) ? $_POST['description'] : ''; ?>">
                <label class="error-message text-danger" id="description-error"></label>
            </div>

            <div class="mb-3">
                <label for="avatar" class="form-label">Avatar</label>
                <input type="file" class="form-control" name="avatar" id="avatar">
                <label class="error-message text-danger" id="avatar-error"></label>
            </div>

            <div class="mb-3 text-center mt-5">
                <input type="submit" class="btn btn-primary me-1 rounded-1" name="action" value="Create">
                <a href="/groups" class="btn btn-danger">cancel</a>
            </div>
        </form>

    </div>
</section>
<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'Create') {
$group = new Group();
$data = [
'name' => $_POST['name'],
'description' => $_POST['description'],
'avatar' => $_FILES['avatar']['name']
];
$group->create($data);
}
?>