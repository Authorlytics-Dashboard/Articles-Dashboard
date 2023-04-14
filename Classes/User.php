<?php

class User extends MYSQLHandler {
    private $table = 'users';
    private $primary_key = 'uid';
    private $log_file="UsersErrors.log";

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

    public function showUserByID($id) {
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
            $data = $this->showUserByID($id)[0];
            $data['deleted_at'] = $timestamp;
            $this->update($data,$id);
            header('location:/users');
        }catch(Exception $e) {
        new Log($this->log_file, $e->getMessage());
        return false;
     }
    }
    public function restore($id) {
        try{
            $this->connect();
            $data = $this->showUserByID($id)[0];
            $data['deleted_at'] = null;
            $this->update($data,$id);
            header('location:/users');
        }catch(Exception $e) {
        new Log($this->log_file, $e->getMessage());
        return false;
     }
    }
    public function create($data){
        try {    
            $this->connect();
            $username = $data['username'];
            $email = $data['email'];
            $avatar = $data['avatar'];
            $groupID = $data['groupID'];
            $mobile = $data['mobile'];
            $password = password_hash($data['password'], PASSWORD_DEFAULT);
            $target_file = "../assets/Images/" . basename($_FILES["avatar"]["name"]);  
            move_uploaded_file($_FILES["avatar"]["tmp_name"],__DIR__ . '/' . $target_file);
            $avatar = basename($_FILES["avatar"]["name"]);
            $data = [
                'username' => $username,
                'email' => $email,
                'groupID' => $groupID, 
                'mobile' => $mobile,
                'password' => $password,
                'avatar' => $avatar,  
                ];
                
            $this->save($data);
        
        }catch(Exception $e) {
            new Log($this->log_file, $e->getMessage());
            return false;
        }
    }
    
    public function save($data){
        try{
            $username = $data['username'];
            $email = $data['email'];
            $avatar = $data['avatar'];
            $groupID = $data['groupID'];
            $mobile = $data['mobile'];
            $password = $data['password'];
            $subscriptionDate = date('Y-m-d H:i:s'); 
            $table = 'users';
            $sql = "insert into `$table` (uname, gid, email, password, mobile , avatar, subscription_date) values ('$username', '$groupID', '$email','$password', '$mobile', '$avatar', '$subscriptionDate')";
            if (mysqli_query($this->_dbHandler, $sql)) {
                $id = mysqli_insert_id($this->_dbHandler);
                $this->disconnect();
                header("Location:/users");
                return $id;
            } else {
                $this->disconnect();
                ob_end_flush();
                header("Location: /users");
    
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
    
    public function edit(){
        try{
            $avatar = $_FILES['avatar']['name'];
            $target_file = "../assets/Images/" . basename($_FILES["avatar"]["name"]);  
            move_uploaded_file($_FILES['avatar']['tmp_name'], __DIR__ . '/' . $target_file);
            $avatar = basename($_FILES["avatar"]["name"]);
            $id = $_GET['id'];
            $edited_values = array(
                'uname' => $_POST['name'],
                'email' => $_POST['email'],
                'mobile' => $_POST['mobile'],
                'password' => password_hash( $_POST['password'], PASSWORD_DEFAULT),
                'avatar' => $avatar
            );
            $update_group = $this->update($edited_values , $id);
            header('location: /users');
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
            $sql .= "`" . $searchColumn["column"] . "` LIKE '" . $searchColumn["value"] . "%'";
            if ($index < count($searchColumns) - 1) {
                $sql .= " OR ";
            }
        }
        return $this->get_results($sql);
    }
    public function filterUsersByGroup($groupName){
        try{

            $sql = "SELECT * FROM user INNER JOIN groups ON user.gid = groups.gid WHERE groups.gname = $groupName";
            return $this->get_results($sql);
        }
        catch(Exception $e) {
            new Log($this->log_file, $e->getMessage());
            return false;
        }
        
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