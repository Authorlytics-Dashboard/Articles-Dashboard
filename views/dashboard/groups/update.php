<?php require '../../../Classes/Group.php'; ?>

<?php 

if (isset($_POST['update'])) {
	
	// $id = $_POST['id'];
    $id = 1;

	// $name = $_POST['name'];
	// $description = $_POST['description'];
    // $updatedData = json_decode(file_get_contents('php://input'), true);
    // var_dump($updatedData);
    $edited_values = array(
        'gname' => $_POST['name'],
        'description' => $_POST['description'],
    );
    $group = new Group();
    $update_group = $group->update($edited_values , $id);

// header('location:single_post.php?id='.$id);

}



?>