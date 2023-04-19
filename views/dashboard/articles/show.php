<?php     
    $articleId = $_GET['id'];
    $articles = new Article('articles','ArticlesErrors.log','aid');
    $article = $articles->getRecordByID($articleId)[0];
    $articles->likeArticle($articleId);
    $likeCount=$articles->displayLikes($articleId);
    $auth = new Auth();
    ob_start();
?>

<section class="groupSection">

    <div class="container d-flex justify-content-center">
        <div class="row ">
            <div class="col-lg-12">
                <div>
                    <div class="col-md-12 artcilesCard">
                        <div class="profile-card text-center">
                            <img class="img-responsive" src="../../../assets/Images/<?php echo $article['photo'] ?>"
                                alt="">
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
                                        <input type="checkbox" name="like_checkbox" onchange="this.form.submit()"
                                            <?php if(isset($_POST['like_checkbox'])) echo 'checked="checked"'; ?>>
                                        <div class="checkmark">
                                            <svg viewBox="0 0 256 256">
                                                <rect fill="none" height="256" width="256"></rect>
                                                <path
                                                    d="M224.6,51.9a59.5,59.5,0,0,0-43-19.9,60.5,60.5,0,0,0-44,17.6L128,59.1l-7.5-7.4C97.2,28.3,59.2,26.3,35.9,47.4a59.9,59.9,0,0,0-2.3,87l83.1,83.1a15.9,15.9,0,0,0,22.6,0l81-81C243.7,113.2,245.6,75.2,224.6,51.9Z"
                                                    stroke-width="20px" stroke="#FFF"
                                                    fill="<?php if($articles->hasUserLikedArticle($articleId, $auth->auth->getUserId())) { echo '#FF5353'; } else { echo 'none'; } ?>">
                                                </path>
                                            </svg>
                                        </div>
                                    </label>
                                </form>
                                <span class="likesCount text-white"><?php echo $likeCount . ' likes'; ?></span>
                            </div>
                        </div>
                    </div>
                </div>
</section>