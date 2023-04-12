<?php     require_once('Classes/Group.php'); ?>

<?php 

if (isset($_POST['update'])) {
	
    $id = $_GET['id'];
    $edited_values = array(
        'gname' => $_POST['name'],
        'description' => $_POST['description'],
    );
    $group = new Group();
    $update_group = $group->update($edited_values , $id);
    header('location:/groups');

}



?>