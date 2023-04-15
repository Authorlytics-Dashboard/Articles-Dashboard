<?php     
    $articleId = $_GET['id'];
    $article = new Article();
    $article = $article->showArticleByID($articleId)[0];
?>

<style>
    

.container {
  padding: 20px;
}

.profile-card {
	background-color: #222222;
  margin-bottom: 20px;
			
		}
		
.profile-pic {
  border-radius: 50%;
  position: absolute;
  top: -65px;
  left: 0;
  right: 0;
  margin: auto;
  z-index: 1;
  max-width: 100px;
  -webkit-transition: all 0.4s;
		  transition: all 0.4s;
				}

				
.profile-info {
		color: #BDBDBD;
		padding: 25px;
	    position: relative;
	    margin-top: 15px;
				}
		
.profile-info h2 {
	color: #E8E8E8;
    letter-spacing: 4px;
	  padding-bottom: 12px;
				}
				
.profile-info span {
	display: block;
    font-size: 12px;
    color: #4CB493;
	letter-spacing: 2px;
			}

.profile-info a {
	 color: #4CB493;
		}
.profile-info i {
	    padding: 15px 35px 0px 35px;
		}
		

.profile-card:hover .profile-pic {
	transform: scale(1.1);
		}

.profile-card:hover .profile-info hr  {
	opacity: 1;
		}
		
		
		
		
/* Underline From Center */
.hvr-underline-from-center {
  display: inline-block;
  vertical-align: middle;
  -webkit-transform: translateZ(0);
  transform: translateZ(0);
  box-shadow: 0 0 1px rgba(0, 0, 0, 0);
  -webkit-backface-visibility: hidden;
  backface-visibility: hidden;
  -moz-osx-font-smoothing: grayscale;
  position: relative;
  overflow: hidden;
}
.hvr-underline-from-center:before {
  content: "";
  position: absolute;
  z-index: -1;
  left: 52%;
  right: 52%;
  bottom: 0;
  background: #FFFFFF;
  border-radius: 50%;
  height: 3px;
  -webkit-transition-property: all;
  transition-property: all;
  -webkit-transition-duration: 0.2s;
  transition-duration: 0.2s;
  -webkit-transition-timing-function: ease-out;
  transition-timing-function: ease-out;
}
.profile-card:hover .hvr-underline-from-center:before, .profile-card:focus .hvr-underline-from-center:before, .profile-card:active .hvr-underline-from-center:before {
  left: 0;
  right: 0;
  height: 1px;
  background: #CECECE;
  border-radius: 0;
}

</style>

<section class="groupSection">
    <!-- <h5><?php echo $article["title"]; ?></h5>
    <h5><?php echo $article["body"]; ?></h5>
    <img src="../../../assets/Images/<?php echo $article['photo'] ?>" alt="">
    <h5><?php echo $article["post_date"]; ?></h5>
    <h5><?php echo $article["uid"]; ?></h5> -->

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">

<div class="container d-flex justify-content-center">
  <div class="row ">
    <div class="col-lg-12">
      <div>
        <div class="col-md-10">
          <div class="profile-card text-center">
            <img class="img-responsive" style="width:100%; height: 270px;" src="../../../assets/Images/<?php echo $article['photo'] ?>" alt="">
            <div class="profile-info">
                <h2 class="hvr-underline-from-center"><?php echo $article["title"]; ?></h2>
                <div><?php echo $article["body"]; ?></div>
                <br>
                <p><?php echo "Creator ID: " . $article["uid"]; ?></p>
                <p><?php echo "Created at: " . $article["post_date"]; ?></p>

            </div>

          </div>
        </div>


      </div>
    </div>
  </div>
</div>
</section>