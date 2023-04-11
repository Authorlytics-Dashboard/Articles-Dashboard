<?php require '../../../Classes/Group.php'; ?>

<?php 

if (isset($_POST['update'])) {
	
	$id = $_POST['id'];
	// $name = $_POST['name'];
	// $description = $_POST['description'];
    $updatedData = json_decode(file_get_contents('php://input'), true);
    $group = new Group();
    $update_group = $group->update($updatedData , $id);

// header('location:single_post.php?id='.$id);

}



?>