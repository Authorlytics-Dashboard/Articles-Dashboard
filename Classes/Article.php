<?php

class Article extends CRUD {
    public function create($data){
        try {
            $this->connect();
            $photo = $data['photo'];

            $target_file = "../assets/Images/" . basename($_FILES["photo"]["name"]);  
            move_uploaded_file($_FILES["photo"]["tmp_name"],__DIR__ . '/' . $target_file);
            $photo = basename($_FILES["photo"]["name"]);

            $data = [
                'title' => $data['title'],
                'body' => $data['body'],
                'photo' => $photo,
                'post_date' => $data['post_date'],
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
    public function likeArticle($id){
        $article = $this->getRecordByID($id)[0];
        $article_id = $article['aid'];
        // Check if the user has clicked the like button
        if (isset($_POST['like_checkbox'])) {          
          // Check if the user is logged in
          if (isset($_SESSION['id'])) {
            $user_id = $_SESSION['id'];    
            // Check if the user has already liked the article
            $query = "SELECT * FROM article_likes WHERE article_id = $article_id AND user_id = $user_id";
            // $result = mysqli_query($conn, $query);
            $result = mysqli_query($this->_dbHandler, $query);
            if (mysqli_num_rows($result) == 0) {
              // User has not liked the article yet, insert a new record
              $query = "INSERT INTO article_likes (article_id, user_id, liked) VALUES ($article_id, $user_id, true)";
              $result = mysqli_query($this->_dbHandler, $query);
            } else {
              // User has already liked the article, update the existing record
              $query = "UPDATE article_likes SET liked = true WHERE article_id = $article_id AND user_id = $user_id";
              $result = mysqli_query($this->_dbHandler, $query);
            }
          } else {
            // User is not logged in, redirect to login page
            header('login.php');
            exit;
          }
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

}


?>