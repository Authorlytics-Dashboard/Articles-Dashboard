<?php

class Article extends CRUD {
    public function create($data) {
      try {
          $this->connect();
  
          $validator = new ArticleValidator();
          $validData = $this->validateArticleData($data, $validator);
          if (!$validData) {
              return false;
          }
  
          $photo = $this->uploadPhoto($_FILES['photo']);
          $validData['photo'] = $photo;
  
          $this->save($validData);
  
          return true;
      } catch (Exception $e) {
          new Log($this->log_file, $e->getMessage());
          return false;
      }
  }
  
  private function validateArticleData($data, $validator) {
      $titleError = $validator->validateArticleName($data['title']);
      if ($titleError) {
          $this->showError('name-error', $titleError);
          return false;
      }
  
      $bodyError = $validator->validateArticleDescription($data['body']);
      if ($bodyError) {
          $this->showError('description-error', $bodyError);
          return false;
      }
  
      $photoError = $validator->validateArticleAvatar($data['photo']);
      if ($photoError) {
          $this->showError('avatar-error', $photoError);
          return false;
      }
  
      $validData = [
          'title' => $data['title'],
          'body' => $data['body'],
          'post_date' => $data['post_date'] ? $data['post_date'] : date('Y-m-d H:i:s'),
          'uid' => $data['uid']
      ];
  
      return $validData;
  }
  
  private function uploadPhoto($file) {
      $target_file = "../assets/Images/" . basename($file["name"]);
      move_uploaded_file($file["tmp_name"], __DIR__ . '/' . $target_file);
  
      return basename($file["name"]);
  }
    private function save($data) {
      $sql = $this->buildInsertStatement($this->table, $data);
  
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
  }

  function buildInsertStatement($table, $data) {
    $columns = implode(", ", array_keys($data));
    $values = "'" . implode("', '", array_values($data)) . "'";
    return "INSERT INTO $table ($columns) VALUES ($values)";
}
    public function likeArticle($id) {
        $article = $this->getRecordByID($id)[0];
        $article_id = $article['aid'];
        if (isset($_POST['like_checkbox'])) {
          $this->handleLike($article_id);
        }
      }
      
      private function handleLike($article_id) {
        if (!$this->isLoggedIn()) {
          $this->redirectToLogin();
        }   
        $auth = new Auth();
        $user_id = $auth->auth->getUserId();
        if ($this->hasUserLikedArticle($article_id, $user_id)) {
            $this->deleteLike($article_id, $user_id);
          } else {
            $this->insertLike($article_id, $user_id, 1);
          }
        
      }
      private function deleteLike($article_id, $user_id) {
        $this->connect();
        $query = "DELETE FROM article_likes WHERE article_id = $article_id AND user_id = $user_id";
        $result = mysqli_query($this->_dbHandler, $query);
        $this->disconnect();
      }
      private function isLoggedIn() {
        $auth = new Auth();
        $user_id = $auth->auth->getUserId();
        return isset($user_id);
      }
      
      private function redirectToLogin() {
        header('login.php');
        exit;
      }
      
      public function hasUserLikedArticle($article_id, $user_id) {
        $this->connect();
        $query = "SELECT * FROM article_likes WHERE article_id = $article_id AND user_id = $user_id";
        $result = mysqli_query($this->_dbHandler, $query);
        $this->disconnect();
        return mysqli_num_rows($result) > 0;
      }
      
      private function insertLike($article_id, $user_id,$liked) {
        $this->connect();
        $query = "INSERT INTO article_likes (article_id, user_id, liked) VALUES ($article_id, $user_id, $liked)";
        $result = mysqli_query($this->_dbHandler, $query);
        $this->disconnect();
      }
    public function displayLikes($id){
        $this->connect();
        $query = "SELECT  COUNT(*) AS num_likes FROM article_likes WHERE liked = true and article_id = $id";
        $result = mysqli_query($this->_dbHandler, $query);
        $row = mysqli_fetch_assoc($result);
        $this->disconnect();
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