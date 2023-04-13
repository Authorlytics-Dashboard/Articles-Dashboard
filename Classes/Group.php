<?php

class Group extends MYSQLHandler {
    private $table = 'groups';
    private $primary_key = 'gid';
    private $log_file="GroupsErrors.log";
    
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
            // $sql .= "limit $start," . 5;
            return $this->get_results($sql);
        }catch (Exception $e) {
            new Log($this->log_file, $e->getMessage());
            return false;
        }
    }

    public function getGroups(){
        try {
            $this->connect();
            $sql = "SELECT gname, gid FROM `$this->table`";
            $result = $this->_dbHandler->query($sql);
            $this->disconnect();
            if ($result->num_rows > 0) {
                $groups = array();
                while ($row = $result->fetch_assoc()) {
                    $groups[] = $row;
                }
                return $groups;
            } else {
                return false;
            }
        } catch (Exception $e) {
            new Log($this->log_file, $e->getMessage());
            return false;
        }
    }
    
    public function showGroupByID($id) {
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
                header('location:/groups');
                return true;
            } else {
                $this->disconnect();
                header('location:/groups');
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
            $gname = $data['name'];
            $description = $data['description'];
            $avatar = $data['avatar'];
            $target_file = "../assets/Images/" . basename($_FILES["avatar"]["name"]);  
            move_uploaded_file($_FILES["avatar"]["tmp_name"],__DIR__ . '/' . $target_file);
            $avatar = basename($_FILES["avatar"]["name"]);
            $data = [
                'name' => $gname,
                'description' => $description,
                'avatar' => $avatar
                ];
            $this->save($data);
        }catch(Exception $e) {
            new Log($this->log_file, $e->getMessage());
            return false;
        }
    }

    public function save($data){
        try{
            $name = $data['name'];
            $description = $data['description'];
            $avatar = $data['avatar'];
            $table = 'groups';
            $sql = "insert into `$table` (gname, description, avatar) values ('$name', '$description', '$avatar')";
            if (mysqli_query($this->_dbHandler, $sql)) {
                $id = mysqli_insert_id($this->_dbHandler);
                $this->disconnect();
                header('Location: /groups');
                return $id;
            } else {
                $this->disconnect();
                header('location:/groups');
                return false;
            }
        }catch(Exception $e){
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
                    if (!is_numeric($value)) {
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

    public function edit(){
        try{
            $avatar = $_FILES['avatar']['name'];
            $target_file = "../assets/Images/" . basename($_FILES["avatar"]["name"]);  
            move_uploaded_file($_FILES['avatar']['tmp_name'], __DIR__ . '/' . $target_file);
            $avatar = basename($_FILES["avatar"]["name"]);
            $id = $_GET['id'];
            $edited_values = array(
                'gname' => $_POST['name'],
                'description' => $_POST['description'],
                'avatar' => $avatar,
            );
            $update_group = $this->update($edited_values , $id);
            header('location:/groups');
        } catch(Exception $e) {
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
            $sql .= "`" . $searchColumn["column"] . "` LIKE '%" . $searchColumn["value"] . "%'";
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