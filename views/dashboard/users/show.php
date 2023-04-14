<?php     
    $UserId = $_GET['id'];
    $user = new User();
    $u = $user ->showUserByID($UserId);
    $u = $u[0];
?>

<section class="userSection">
    <h5><?php echo $u["uname"]; ?></h5>
    <h5><?php echo $u["email"]; ?></h5>
    <h5><?php echo $u["mobile"]; ?></h5>
    <img src="../../../assets/Images/<?php echo $u['avatar'] ?>" alt="">
</section>