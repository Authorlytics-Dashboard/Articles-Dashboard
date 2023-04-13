<section class="articaleSection">
    <form method="get" action="/articles/">
        <div class="input-article mb-3">
            <input type="text" class="form-control" placeholder="Search" name="query" value="<?php echo isset($_GET['query']) ? htmlspecialchars($_GET['query']) : ''; ?>">
            <div class="input-article-append">
                <button class="btn btn-outline-secondary" type="submit">Search</button>
            </div>
        </div>
    </form>
    <form action="articles/create" method="post">
        <button type="submit" class="btn btn-success mb-5 mt-3">Add New Artilce</button>
    </form>


    <table class="table text-center">
        <thead>
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Title</th>
                <th scope="col">Photo</th>
                <th scope="col">Body</th>
                <th scope="col">Post Date</th>
                <th scope="col">user</th>
                <th scope="col">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php 
                
                $articles = new Article();
                $AllArticles = $articles->getData();
                foreach ($AllArticles as $article){
            ?>

            <tr>
                <th scope="row"><?php echo $article["aid"] ?></th>
                <td>
                    <?php if ($article["photo"]) { ?>
                    <img src='../assets/Images/<?php echo $article['photo'] ?>' class='rounded-circle img-thumbnail' alt='photo' style='width:30px; height:30px;'>
                    <?php } else { ?>
                    <p>No photo</p>
                    <?php } ?>
                </td>
                <td><?php echo $article["title"] ?></td>
                <td><?php echo $article["body"] ?></td>
                <td><?php echo $article["post_date"] ?></td>
                <td><?php echo $article["uid"] ?></td>
                <td>
                    <a href="/articles/delete/?id=<?php echo $article["aid"] ; ?>" class="btn btn-danger" ><i class='bx bx-trash' ></i></a>
                    <a href="/articles/edit/?id=<?php echo $article["aid"] ; ?>" class="btn btn-primary"><i class='bx bxs-edit'></i></a>
                    <a href="/articles/show/?id=<?php echo $article["aid"] ; ?>" class="btn btn-dark"><i class='bx bx-show-alt' style="color: #fff;"></i></a>
                </td>
            </tr>

            <?php 
                }
            ?>
        </tbody>
    </table>
</section>