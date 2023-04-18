<?php     
    $articleId = $_GET['id'];
    $articles = new Article('articles','ArticlesErrors.log','aid');
    $article = $article->getRecordByID($articleId)[0];
    $articles->likeArticle($articleId);
    $likeCount=$articles->displayLikes($articleId);

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

  .img-responsive{
    width:100%; 
    height: 330px;
  }
  .profile-info a {
    color: #4CB493;
  }
  .profile-info i {
    padding: 15px 35px 0px 35px;
  }

  .artcilesCard{
    width: 60em !important;
  }
  .profile-card:hover .profile-pic {
    transform: scale(1.1);
  }

  .profile-card:hover .profile-info hr {
    opacity: 1;
  }

  /* Underline From Center */
  .hvr-underline-from-center {
    display: inline-block;
    vertical-align: middle;
    transform: translateZ(0);
    box-shadow: 0 0 1px rgba(0, 0, 0, 0);
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
    transition-property: all;
    transition-duration: 0.2s;
    transition-timing-function: ease-out;
  }

  .profile-card:hover .hvr-underline-from-center:before,
  .profile-card:focus .hvr-underline-from-center:before, 
  .profile-card:active .hvr-underline-from-center:before {
    left: 0;
    right: 0;
    height: 1px;
    background: #CECECE;
    border-radius: 0;
  }

  /* likes button */
  .LikesContainer input {
    position: absolute;
    opacity: 0;
    cursor: pointer;
    height: 0;
    width: 0;
  }

  .LikesContainer {
    display: block;
    position: relative;
    cursor: pointer;
    font-size: 20px;
    user-select: none;
    transition: 100ms;
  }

  .checkmark {
    top: 0;
    left: 0;
    height: 2em;
    width: 2em;
    transition: 100ms;
    animation: dislike_effect 400ms ease;
  }

  .LikesContainer input:checked ~ .checkmark path {
    fill: #FF5353;
    stroke-width: 0;
  }

  .LikesContainer input:checked ~ .checkmark {
    animation: like_effect 400ms ease;
  }

  .likesCount{
    transform: translate(-380px, -30px);
  }

  @keyframes like_effect {
    0% {transform: scale(0);}
    50% {transform: scale(1.2);}
    100% {transform: scale(1);}
  }

  @keyframes dislike_effect {
    0% {transform: scale(0);}
    50% {transform: scale(1.2);}
    100% {transform: scale(1);}
  }

</style>

<section class="groupSection">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">

<div class="container d-flex justify-content-center">
  <div class="row ">
    <div class="col-lg-12">
      <div>
        <div class="col-md-12 artcilesCard">
          <div class="profile-card text-center">
            <img class="img-responsive" src="../../../assets/Images/<?php echo $article['photo'] ?>" alt="">
            <div class="profile-info">
                <h2 class="hvr-underline-from-center"><?php echo $article["title"]; ?></h2>
                <div><?php echo $article["body"]; ?></div>
                <br>
                <p><?php echo "Creator ID: " . $article["uid"]; ?></p>
                <p>
                  <?php echo "Creator Name: " ?> 
                  <?php $user = new User('users', "UsersErrors.log",'id');
                        $createdBy = $user->getRecordByID($article['uid']);
                        echo $createdBy[0]['username'];?>
                </p>
                <p><?php echo "Created at: " . $article["post_date"]; ?></p>
                <!-- Like Button -->
                <form method="post">
                  <label class="LikesContainer">
                    <input type="checkbox" name="like_checkbox" onchange="this.form.submit()" <?php if(isset($_POST['like_checkbox'])) echo 'checked="checked"'; ?> >
                    <div class="checkmark">
                      <svg viewBox="0 0 256 256">
                      <rect fill="none" height="256" width="256"></rect>
                      <path d="M224.6,51.9a59.5,59.5,0,0,0-43-19.9,60.5,60.5,0,0,0-44,17.6L128,59.1l-7.5-7.4C97.2,28.3,59.2,26.3,35.9,47.4a59.9,59.9,0,0,0-2.3,87l83.1,83.1a15.9,15.9,0,0,0,22.6,0l81-81C243.7,113.2,245.6,75.2,224.6,51.9Z" stroke-width="20px" stroke="#FFF" fill="none"></path></svg>
                    </div>
                  </label>
                </form>
                <span class="likesCount text-white" ><?php echo $likeCount . ' likes'; ?></span> 
              </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
</section>