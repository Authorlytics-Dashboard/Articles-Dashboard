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
    <h5><?php echo date('F j, Y g:i A', strtotime($u["subscription_date"])); ?></h5>
    <img src="../../../assets/Images/<?php echo $u['avatar'] ?>" alt="">
</section>