<section class="articaleSection">
    <div class="container py-4 border my-5 mx-auto">
        <form method="post" action="" class="w-75 mx-auto" enctype="multipart/form-data">
            <div class=" mb-3">
                <label for="title" class="form-label">Title</label>
                <input type="text" class="form-control" name="title" id="title">
            </div>

            <div class="mb-3">
                <label for="body" class="form-label">Body</label>
                <input type="text" class="form-control" name="body" id="body">
            </div>

            <div class="mb-3">
                <label for="photo" class="form-label">Photo</label>
                <input type="file" class="form-control" name="photo" id="photo">
            </div>

            <div class="mb-3">
                <label for="post_date" class="form-label">Post date</label>
                <input type="date" class="form-control" name="post_date" id="post_date">
            </div>

            <div class="mb-3">
                <label for="uid" class="form-label">user id</label>
                <select name="uid" class="form-control" id="uid">
                <?php
                    $users = new User();
                    $users = $users->getData();
                    foreach ($users as $user){
                ?>
                    <option value="<?= $user['uid']?>"><?= $user['uname']?></option>
                <?php
                    }
                ?>
            </div>

            <div class="mb-3 text-center mt-5">
                <input type="submit" class="btn btn-primary me-1 rounded-1" name="action" value="Create">
                <a href="/articles" class="btn btn-danger">cancel</a>
            </div>
        </form>

    </div>
</section>
<?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'Create') {
        $article = new Article();
        $data = [
            'title' => $_POST['title'],
            'body' => $_POST['body'],
            'photo' => $_FILES['photo']['name'],
            'post_date' => $_POST['post_date'],
            'uid' => $_POST['uid']
        ];
        $article->create($data);
    }
?>