<?php  

    $groupId = $_GET['id'];
    $group = new Group('groups',"GroupsErrors.log",'gid');
    $groupInfo = $group ->getRecordByID($groupId);
    $groupInfo = $groupInfo[0];?>

<section class="groupSection">
    <div class="container py-4 border my-5 mx-auto">
    <div style="display: flex; justify-content: center; align-items: center;">
        <img src="../../../assets/Images/<?php echo $groupInfo['avatar'] ?>" alt="" class='rounded-circle img-thumbnail' style='width:150px; height:150px;'>
        </div>
        <form action="/groups/update/?id=<?php echo $groupId ;?>" method="POST" class="w-75 mx-auto" enctype="multipart/form-data">
            <div class=" mb-3">
                <label for="name" class="form-label">Group Name</label>
                <input type="text" class="form-control" name="name" id="name" value="<?php echo $groupInfo["gname"];?>">
            </div>

            <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <input type="text" class="form-control" name="description" id="description" value="<?php echo $groupInfo["description"];?>">
            </div>
            <div class="mb-3">
                <label for="avatar" class="form-label">Avatar</label>
                <input type="file" class="form-control" name="avatar" id="avatar">
            </div>
            <div class="mb-3 text-center mt-5 d-flex justify-content-end">
                <input type="submit" class="btn updateBtn me-1 rounded-1" name="update" value="Update">
                <a href="index.php" class="btn cancelBtn">Cancel</a>
            </div>
        </form>
    </div>
</section>