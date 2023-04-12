<?php     require_once('Classes/Group.php');

    $groupId = $_GET['id'];
    // get data of group by its id and show it in fields 
?>

<section class="groupSection">
    <div class="container py-4 border my-5 mx-auto">
        <form action="/groups/update/?id=<?php echo $groupId ;?>" method="POST" class="w-75 mx-auto" enctype="multipart/form-data">
            <div class=" mb-3">
                <label for="name" class="form-label">Group Name</label>
                <input type="text" class="form-control" name="name" id="name">
            </div>

            <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <input type="text" class="form-control" name="description" id="description">
            </div>
            <div class="mb-3">
                <label for="avatar" class="form-label">Avatar</label>
                <input type="file" class="form-control" name="avatar" id="avatar">
            </div>
            <div class="mb-3 text-center mt-5">
                <input type="submit" class="btn btn-primary me-1 rounded-1" name="update">
                <a href="index.php" class="btn btn-danger">cancel</a>
            </div>
        </form>
    </div>
</section>