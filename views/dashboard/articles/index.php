<?php 
    $db = new Article();
    $current_index = isset($_GET["page"]) && is_numeric($_GET["page"])? (int)$_GET["page"]: 0;
    $rowCount = $db->getCount('articles');
    $next_index = $current_index + 5 <= $rowCount? $current_index + 5: $current_index;
    $previous_index = ($current_index - 5 > 0)? $current_index - 5 : 0;
?>  

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

    <?php 
        $articles=new Article();
        if(isset($_GET['query'])) {
            $items = $articles->search(array("column" => "title", "value" => $_GET['query']));
        } else{
            $items = $db->get_all_records_paginated(array(), $current_index);
        }

        if (count($items) > 0) {
    ?>

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
                foreach ($items as $item){
            ?>

            <tr>
                <th scope="row"><?php echo $item["aid"] ?></th>
                <td>
                    <?php if ($item["photo"]) { ?>
                    <img src='../assets/Images/<?php echo $item['photo'] ?>' class='rounded-circle img-thumbnail' alt='photo' style='width:30px; height:30px;'>
                    <?php } else { ?>
                    <p>No photo</p>
                    <?php } ?>
                </td>
                <td><?php echo $item["title"] ?></td>
                <td><?php echo $item["body"] ?></td>
                <td><?php echo $item["post_date"] ?></td>
                <td><?php echo $item["uid"] ?></td>
                <td>
                    <?php
                        if ($item["deleted_at"] == null) { ?>
                        <a href="/articles/delete/?id=<?php echo $item["aid"] ; ?>" class="btn btn-danger" ><i class='bx bx-trash' ></i></a>
                        <?php } 
                        else { ?>
                        <a href="/articles/restore/?id=<?php echo $item["aid"] ; ?>" class="btn btn-success" ><i class='bx bx-recycle'></i></a>
                        <?php }
                    ?>                    
                    <a href="/articles/edit/?id=<?php echo $item["aid"] ; ?>" class="btn btn-primary"><i class='bx bxs-edit'></i></a>
                    <a href="/articles/show/?id=<?php echo $item["aid"] ; ?>" class="btn btn-dark"><i class='bx bx-show-alt' style="color: #fff;"></i></a>
                </td>
            </tr>

            <?php 
                }
            ?>
        </tbody>
    </table>

    <?php
        } else {
            echo "No results found.";
        }
    ?>
    
    <div class="d-flex justify-content-center gap-2" >
        <button class="btn btn-dark">
            <a href="<?php echo "/articles/"."?page=".$previous_index; ?>" class="text-light"> << Previous</a>
        </button>
        <button class=" btn btn-dark" >        
            <a href="<?php echo "/articles/"."?page=".$next_index; ?>" class="text-light">Next >></a>
        </button>
    </div>
</section>
<?php
    if(isset($_POST['query'])){
        $title = $_POST['query'];
        $obj = new Article();
        $d=  $obj->search('title' , $title);
    }
?>