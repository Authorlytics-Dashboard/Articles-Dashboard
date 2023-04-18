<?php     
    $UserId = $_GET['id'];
    $user = new User('users', "UsersErrors.log",'id');
    $u = $user ->getRecordByID($UserId);
    $u = $u[0];
?>

<section class="userSection d-flex justify-content-center align-items-center">
    <div class="col-md-4 mt-4">
    	<div class="card profile-card-5">
    	    <div class="card-img-block">
                <img class="card-img-top" src="../../../assets/Images/<?php echo $u['avatar'] ?>" alt="">
    		</div>
            <div class="card-body pt-0">
                <h5 class="card-title"><?php echo $u["username"]; ?></h5>
                <hr>
                <p class="card-text"><?php echo "Email: " . $u["email"]; ?></p>
                <p class="card-text"><?php echo "Mobile Number: " . $u["mobile"]; ?></p>
                <p class="card-text"><?php echo "Subscription Date: " . date('F j, Y g:i A', strtotime($u["subscription_date"])); ?></p>
            </div>
        </div>
    </div>

</section>