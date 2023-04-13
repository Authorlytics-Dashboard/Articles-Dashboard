<?php

class User extends MYSQLHandler {
    private $table = 'user';
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
        try {
        $this->connect();
        $table = $this->table;
        $primary_key = $this->primary_key;
        $sql = "delete  from `" . $table . "` where `" . $primary_key . "` = $id";
        $this->debug($sql);
        if (mysqli_query($this->_dbHandler, $sql)) {
            $this->disconnect();
            header('location:/users');
            return true;
        } else {
            $this->disconnect();
            header('location:/users');
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
            $username = $data['username'];
            $email = $data['email'];
            $avatar = $data['avatar'];
            $groupID = $data['groupID'];
            $mobile = $data['mobile'];
            $password = $data['password'];
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
            $table = 'user';
            $sql = "insert into `$table` (uname, gid, email, password, mobile , avatar) values ('$username', '$groupID', '$email','$password', '$mobile', '$avatar')";
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
                'uname' => $_POST['name'],
                'email' => $_POST['email'],
                'mobile' => $_POST['mobile'],
                'password' => $_POST['password'],
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
            $sql .= "`" . $searchColumn["column"] . "` LIKE '%" . $searchColumn["value"] . "%'";
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
}


?>