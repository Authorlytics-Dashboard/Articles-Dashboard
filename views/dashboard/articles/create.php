<?php         
    ob_start(); 
?>
<section class="articaleSection">
    <div class="container py-4 border my-5 mx-auto">
        <form method="post" action="" class="w-75 mx-auto" enctype="multipart/form-data">
            <div class=" mb-3">
                <label for="title" class="form-label">Title</label>
                <input type="text" class="form-control" name="title" id="title">
                <label class="error-message text-danger mt-2" id="name-error"></label>
            </div>

            <div class="mb-3">
                <label for="body" class="form-label">Body</label>
                <textarea name="body" id="body" cols="98" rows="5"></textarea>
                <label class="error-message text-danger mt-2" id="description-error"></label>
            </div>

            <div class="mb-3">
                <label for="photo" class="form-label">Photo</label>
                <input type="file" class="form-control" name="photo" id="photo">
                <label class="error-message text-danger mt-2" id="avatar-error"></label>
            </div>

            <div class="mb-3">
                <label for="post_date" class="form-label">Post date</label>
                <input type="date" class="form-control" name="post_date" id="post_date">
            </div>

            <div class="mb-3">
                <label for="uid" class="form-label">Username</label>
                <select name="uid" class="form-control" id="uid">
                    <?php
                        ob_start();
                        $users = new User('users', "UsersErrors.log",'uid');
                        $users = $users->getData();
                        foreach ($users as $user){
                    ?>
                    <option value="<?= $user['id']?>"><?= $user['username']?></option>
                    <?php
                    }
                ?>
                </select>
                
            </div>

            <div class="mb-3 text-center mt-5 d-flex justify-content-end">
                <input type="submit" class="btn createBtn me-1 rounded-1" name="action" value="Create">
                <a href="/articles" class="btn cancelBtn">Cancel</a>
            </div>
        </form>

    </div>
</section>
<?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'Create') {
        $article = new Article('articles','ArticlesErrors.log','aid');
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