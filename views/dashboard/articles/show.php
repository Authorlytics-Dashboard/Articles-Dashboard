<?php     
    $articleId = $_GET['id'];
    $article = new Article();
    $article = $article->showArticleByID($articleId)[0];
?>

<section class="groupSection">
    <h5><?php echo $article["title"]; ?></h5>
    <h5><?php echo $article["body"]; ?></h5>
    <img src="../../../assets/Images/<?php echo $article['photo'] ?>" alt="">
    <h5><?php echo $article["post_date"]; ?></h5>
    <h5><?php echo $article["uid"]; ?></h5>
</section>