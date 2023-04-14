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
        try{
            $this->connect();
            $timestamp = date('Y-m-d H:i:s');
            $data = $this->showArticleByID($id)[0];
            $data['deleted_at'] = $timestamp;
            $this->update($data,$id);
            header('location:/articles');
        }catch(Exception $e) {
        new Log($this->log_file, $e->getMessage());
        return false;
     }
    }
    public function restore($id) {
        try{
            $this->connect();
            $data = $this->showArticleByID($id)[0];
            $data['deleted_at'] = null;
            $this->update($data,$id);
            header('location:/articles');
        }catch(Exception $e) {
        new Log($this->log_file, $e->getMessage());
        return false;
     }
    }

        public function update($edited_values, $id){
        try{
            $this->connect();
            $table = $this->table;
            $primary_key = $this->primary_key;
            $sql = "UPDATE `" . $table . "` SET ";

            foreach ($edited_values as $key => $value) {
                if ($key != $primary_key) {
                    if (is_null($value) && $key == 'deleted_at') {
                        $sql .= " `$key` = NULL,";
                    }
                    elseif (!is_numeric($value)) {
                        $sql .= " `$key` = '" . mysqli_real_escape_string($this->_dbHandler, $value) . "',";
                    } else {
                        $sql .= " `$key` = $value ,";
                    }
                }
            }

            $sql = rtrim($sql, ',');
            $sql .= " WHERE `" . $primary_key . "` = " . intval($id);

            if (mysqli_query($this->_dbHandler, $sql)) {
                $this->disconnect();
                return true;
            } else {
                $this->disconnect();
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
                header('location:/articles');
                return false;
            }
        }catch(Exception $e){
            new Log($this->log_file, $e->getMessage());
            return false;
        }
    }

    public function search(...$searchColumns){
        $table = $this->table;
        $sql = "SELECT * FROM `$table` WHERE ";
        $params = array();
    
        foreach ($searchColumns as $index => $searchColumn) {
            $params[] = "%" . $searchColumn["value"] . "%";
            $sql .= "`" . $searchColumn["column"] . "` LIKE '" . $searchColumn["value"] . "%'";
            if ($index < count($searchColumns) - 1) {
                $sql .= " OR ";
            }
        }
        return $this->get_results($sql);
    }

    public function getCount ($table){
        $sql = "select * from `$table` ";
        $_handler_results = mysqli_query($this->_dbHandler, $sql);
        $rowcount=mysqli_num_rows($_handler_results);
        return $rowcount;
    }

    public function get_all_records_paginated($fields = array(), $start = 0){
        $table = $this->table;
        if(empty($fields)){
            $sql = "select * from `$table` ";
        } else {
            $sql = "select ";
            foreach($fields as $f){
                $sql .= " `$f`, ";
            }
            $sql .= "from `$table` ";
            $sql = str_replace(", from", "from", $sql );
        }

        $sql .= "limit $start," . 5;
        return $this->get_results($sql);
    }
}


?>