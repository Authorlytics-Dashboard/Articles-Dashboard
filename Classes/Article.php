<?php

class Article extends MYSQLHandler {
    private $table = 'articles';
    private $primary_key = 'aid';
    private $log_file="ArticlesErrors.log";

    public function getData($fields = array(), $start = 0) {
        try {
            $this->connect();
            if (empty($fields)) {
                $sql = "select * from `$this->table`";
            } else {
                $sql = "select ";
                foreach ($fields as $f) {
                    $sql .= " `$f`, ";
                }
                $sql .= "from  `$this->table` ";
                $sql = str_replace(", from", "from", $sql);
            }
            return $this->get_results($sql);

        }catch (Exception $e) {
            new Log($this->log_file, $e->getMessage());
            return false;
        }
    }

    public function showArticleByID($id) {
        try {
            $primary_key = $this->primary_key;
            $table = $this->table;
            $sql = "select * from `$table` where `$primary_key` = '$id' ";
            return $this->get_results($sql);

        }catch(Exception $e) {
            new Log($this->log_file, $e->getMessage());
            return false;
        }
    }

    public function delete($id) {
        try {
            $this->connect();
            $table = $this->table;
            $primary_key = $this->primary_key;
            $sql = "delete  from `" . $table . "` where `" . $primary_key . "` = $id";
            $this->debug($sql);

            if (mysqli_query($this->_dbHandler, $sql)) {
                $this->disconnect();
                header('location:/articles');
                return true;
            } else {
                $this->disconnect();
                header('location:/articles');
                return false;
            }

        } catch(Exception $e) {
            new Log($this->log_file, $e->getMessage());
            return false;
        }   
    }

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
            $title = $data['title'];
            $body = $data['body'];
            $photo = $data['photo'];
            $post_date = $data['post_date'];
            $table = 'articles';

            $sql = "insert into `$table` (title, body, photo, post_date) values ('$title', '$body', '$photo', $post_date)";
            if (mysqli_query($this->_dbHandler, $sql)) {
                $id = mysqli_insert_id($this->_dbHandler);
                $this->disconnect();
                header('Location:/articles');
                return $id;
            } else {
                $this->disconnect();
                header('location:/articles');
                return false;
            }
        }catch(Exception $e){
            new Log($this->log_file, $e->getMessage());
            return false;
        }
    }
}


?>