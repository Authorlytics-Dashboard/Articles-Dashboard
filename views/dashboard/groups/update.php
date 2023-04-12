<?php     require_once('Classes/Group.php'); ?>

<?php 

if (isset($_POST['update'])) {
    print_r($_POST);
	$avatar = $_FILES['avatar']['name'];
    print_r($avatar);
    $target_file = "../assets/Images/" . basename($_FILES["avatar"]["name"]);  
    move_uploaded_file($_FILES["avatar"]["tmp_name"], $target_file);
    $avatar = basename($_FILES["avatar"]["name"]);
    $id = $_GET['id'];
    $edited_values = array(
        'gname' => $_POST['name'],
        'description' => $_POST['description'],
        'avatar' => $avatar,
    );
    $group = new Group();
    $update_group = $group->update($edited_values , $id);
    header('location:/groups');

}



?>