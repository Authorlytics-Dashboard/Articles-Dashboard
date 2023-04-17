<?php     
    $UserId = $_GET['id'];
    $user = new User('users', "UsersErrors.log",'uid');
    $u = $user ->getRecordByID($UserId);
    $u = $u[0];
?>

<style>
    /*Profile Card 5*/
.profile-card-5{
    margin-top:20px;
}
.profile-card-5 .btn{
    border-radius:2px;
    text-transform:uppercase;
    font-size:12px;
    padding:7px 20px;
}
.profile-card-5 .card-img-block {
    width: 91%;
    margin: 0 auto;
    position: relative;
    top: -20px;
    
}
.profile-card-5 .card-img-block img{
    border-radius:5px;
    box-shadow:0 0 10px rgba(0,0,0,0.63);
}
.profile-card-5 h5{
    color:#4E5E30;
    font-weight:600;
}
.profile-card-5 p{
    font-size:14px;
    font-weight:300;
}
.profile-card-5 .btn-primary{
    background-color:#4E5E30;
    border-color:#4E5E30;
}
</style>

<section class="userSection d-flex justify-content-center align-items-center">
    		<div class="col-md-4 mt-4">
    		    <div class="card profile-card-5">
    		        <div class="card-img-block">
                        <img class="card-img-top" src="../../../assets/Images/<?php echo $u['avatar'] ?>" alt="">
    		        </div>
                    <div class="card-body pt-0">
                    <h5 class="card-title"><?php echo $u["uname"]; ?></h5>
                    <hr>
                    <p class="card-text"><?php echo "Email: " . $u["email"]; ?></p>
                    <p class="card-text"><?php echo "Mobile Number: " . $u["mobile"]; ?></p>
                    <p class="card-text"><?php echo "Subscription Date: " . date('F j, Y g:i A', strtotime($u["subscription_date"])); ?></p>
                  </div>
                </div>
    		</div>
    		
    	</div>
    </div>

</section>