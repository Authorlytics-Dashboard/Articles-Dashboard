<?php

class Group extends CRUD {
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
    public function create($data){
        try {    
            $validator = new GroupValidator();
            $this->connect();
            $gname = $data['name'];
            $description = $data['description'];
            $avatar = $data['avatar'];
            
            $target_file = "../assets/Images/" . basename($_FILES["avatar"]["name"]);  
            move_uploaded_file($_FILES["avatar"]["tmp_name"],__DIR__ . '/' . $target_file);
            $avatar = basename($_FILES["avatar"]["name"]);
            $data['avatar'] = $avatar;
            $isValid = $validator->validateGroup($data);
            if(!$isValid) return false;
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
            $this->connect();
            $name = $data['name'];
            $description = $data['description'];
            $avatar = $data['avatar'];
            $table = 'groups';
            $sql = "insert into `$table` (gname, description, avatar) values ('$name', '$description', '$avatar')";
            if (mysqli_query($this->_dbHandler, $sql)) {
                $id = mysqli_insert_id($this->_dbHandler);  
                $this->disconnect();    
                header('Location: /groups');
                ob_end_flush();
                return $id;
            } else {
                $this->disconnect();
                header('location:/groups');
                ob_end_flush();
                return false;
            }
        }catch(Exception $e){
            new Log($this->log_file, $e->getMessage());
            return false;
        }
    }

    public function edit(){
        try{
            $validator = new GroupValidator();
            $this->connect();
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
            $data = [
                'name' => $_POST['name'],
                'description' => $_POST['description'],
                'avatar' => $avatar
            ];
            
            $isValid = $validator->validateGroup($data);
         
            // $isValid = $validator->validateGroup($data);

            if (empty($isValid)) {
                $update_group = $this->update($edited_values , $id);
                header('location:/groups');
            } else {
         
               header("location: /groups/edit/?id=$id");
            }
            
            
        } catch(Exception $e) {
            new Log($this->log_file, $e->getMessage());
            return false;
        } 
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