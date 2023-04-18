<?php

class Article extends CRUD {
    public function create($data){
        try {
            $this->connect();
            $validator = new ArticleValidator();
             $gname = $data['title'];
            $nameError = $validator->validateArticleName($gname);
            if ($nameError) {
                $this->showError('name-error', $nameError);
                return false;
            }  

            $description = $data['body'];
            $descriptionError = $validator->validateArticleDescription($description);
            if($descriptionError){
                $this->showError('description-error', $descriptionError);
                return false;
            } 
             
            $avatar = $data['photo'];
            $avatarError = $validator->validateArticleAvatar($avatar);
            if($avatarError){
                $this->showError('avatar-error', $avatarError);
                return false;
            }
            $photo = $data['photo'];

            $target_file = "../assets/Images/" . basename($_FILES["photo"]["name"]);  
            move_uploaded_file($_FILES["photo"]["tmp_name"],__DIR__ . '/' . $target_file);
            $photo = basename($_FILES["photo"]["name"]);

            $data = [
                'title' => $data['title'],
                'body' => $data['body'],
                'photo' => $photo,
                'post_date' => $data['post_date']? $data['post_date']:  date('Y-m-d H:i:s') ,
                'uid' => $data['uid']
            ];
            $this->save($data);

        }catch(Exception $e) {
            new Log($this->log_file, $e->getMessage());
            return false;
        }
    }
   public function save($data){
        try{
            $this->connect();

            $title = $data['title'];
            $body = $data['body'];
            $photo = $data['photo'];
            $post_date = $data['post_date'];
            $uid = $data['uid'];
            $table = 'articles';

            $sql = "insert into `$table` (title, body, photo, post_date, uid) values ('$title', '$body', '$photo', '$post_date','$uid')";
            if (mysqli_query($this->_dbHandler, $sql)) {
                $id = mysqli_insert_id($this->_dbHandler);
                $this->disconnect();
                header('Location:/articles');
                return $id;
            } else {
                $this->disconnect();
                ob_flush();
                header('location:/articles');
                return false;
            }
        }catch(Exception $e){
            new Log($this->log_file, $e->getMessage());
            return false;
        }
    }

    public function displayLikes($id){
        $query = "SELECT  COUNT(*) AS num_likes FROM article_likes WHERE liked = true and article_id = $id";
        // $sql = "SELECT users.uname FROM articles INNER JOIN users ON articles.uid = users.uid;";
        $result = mysqli_query($this->_dbHandler, $query);
        $row = mysqli_fetch_assoc($result);
        return $likeCount =$row['num_likes'];

    }
    public function getCount ($table){
        $this->connect();
        $sql = "select * from `$table` ";
        $_handler_results = mysqli_query($this->_dbHandler, $sql);
        $rowcount=mysqli_num_rows($_handler_results);
        return $rowcount;
    }
    private function showError($type, $message) {
        echo "<script>document.getElementById('$type').innerHTML = '$message';</script>";
    }
}


?>