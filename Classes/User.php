<?php

class User extends CRUD {
    public function create($data) {
        try {
            $this->connect();
            $userValidation = new UserValidator($data, "create");  
            if ($userValidation->isValid()) {
                $target_file = $this->uploadPhoto($_FILES["avatar"]);
                $data['avatar'] = basename($target_file);
                $data['mobile'] = "+2".$data['mobile'];
                $data['password'] = $this->hashPassword($data['password']);
                $this->save($data);
            } else {
                $_SESSION['data'] = $data;
                $this->showError($userValidation->getError());
            }
        } catch(Exception $e) {
            new Log($this->log_file, $e->getMessage());
            return false;
        }
    }
    
    private function uploadPhoto($file) {
        try {
            $target_file = "../assets/Images/" . basename($file["name"]);
            if (!move_uploaded_file($file["tmp_name"], __DIR__ . '/' . $target_file)) {
                throw new Exception('Error uploading file');
            }
            return basename($file["name"]);
        } catch (Exception $e) {
            new Log($this->log_file, $e->getMessage());
            return false;
        }
    }
    
    private function hashPassword($password) {
        return password_hash($password, PASSWORD_DEFAULT);
    }
    
    public function save( $data) {
        try {
            $this->connect();
            $this->insertData($this->table, $data);
            $id = $this->_dbHandler->insert_id;
            $this->assignRole($data['email'], $data['gid']);
            $this->disconnect();
            header("Location:/users");
            return $id;
        } catch(Exception $e) {
            new Log($this->log_file, $e->getMessage());
            return false;
        }
    }
    
    private function insertData($table, $data) {
        $fields = array('email', 'password', 'username', 'registered', 'last_login', 'subscription_date', 'avatar', 'mobile', 'gid');
        $values = array(
            $data['email'], $data['password'], $data['username'],
            date('Y-m-d H:i:s'), date('Y-m-d H:i:s'), date('Y-m-d H:i:s'),
            $data['avatar'], $data['mobile'], $data['gid']
        );
        $sql = "INSERT INTO `$table` (" . implode(',', $fields) . ") VALUES ('" . implode("','", $values) . "')";        mysqli_query($this->_dbHandler, $sql);
    }
    public function showError($error) {
        foreach ($error as $key => $value) {
            $script = "<script>";
            if (!empty($value)){
                $script .= "document.getElementById('$key').innerHTML = '$value';";
            }
            $script .= "</script>";
            echo $script;
        }
    }

    private function assignRole($email,$group){
        $auth = new Auth();
        try {
            switch($group){
                case 1:
                {
                    $auth->auth->admin()->addRoleForUserByEmail($email, \Delight\Auth\Role::ADMIN);
                    break;
                } 
                case 2:
                {
                    $auth->auth->admin()->addRoleForUserByEmail($email, \Delight\Auth\Role::EDITOR);
                    break;
                } 
                case 3:
                default:
                $auth->auth->admin()->addRoleForUserByEmail($email, \Delight\Auth\Role::REVIEWER);
            }
            
        }
        catch (\Delight\Auth\InvalidEmailException $e) {
            die('Unknown email address');
        }
    }



    public function edit(){
        try{
            $id = $_GET['id'];
            $user = $this->search(Array('column'=> 'id', 'value' => $id));
            
            $edited_values = array(
                'id' => $id,
                'username' => $_POST['name'],
                'email' => $_POST['email'],
                'mobile' => $_POST['mobile'],
                'password' => $_POST['password'],
                'gid' => $user[0]['gid'],
            );
            
            if(isset($_FILES['avatar']) && $_FILES['avatar']['error'] === UPLOAD_ERR_OK){
                $target_file = "../assets/Images/" . basename($_FILES["avatar"]["name"]);  
                move_uploaded_file($_FILES['avatar']['tmp_name'], __DIR__ . '/' . $target_file);
                $avatar = basename($_FILES["avatar"]["name"]);
                $edited_values['avatar'] = $avatar;
            }            
            $userValidation = new UserValidator($edited_values, "update");

            if( $userValidation->isValid()){
                $edited_values['password'] = password_hash( $_POST['password'], PASSWORD_DEFAULT);
                $edited_values['mobile'] = "+2".$edited_values['mobile'];
                $update_group = $this->update($edited_values , $id);
                header('location: /users');
            }else{
                $_SESSION['data'] = $edited_values;
                $_SESSION['errors'] = $userValidation->getError();
                header("location: /users/edit/?id=$id");
            }

        } catch(Exception $e) {
            new Log($this->log_file, $e->getMessage());
            return false;
        } 
    }
    
    public function filterUsersByGroup($groupName){
        try{
            $this->connect();
            $stmt = $this->_dbHandler->prepare("SELECT * FROM users INNER JOIN groups ON users.gid = groups.gid WHERE groups.gname = ?");
            $stmt->bind_param("s", $groupName);
            $stmt->execute();
            $result = $stmt->get_result();
            $users = array();
            while ($user = mysqli_fetch_assoc($result)) {
                $users[] = $user;
            }
            return $users;
        }
        catch(Exception $e) {
            new Log($this->log_file, $e->getMessage());
            return false;
        }
        
    }
    
    public function getCount ($table){
        $sql = "select * from `$table` ";
        $this->connect();
        $_handler_results = mysqli_query($this->_dbHandler, $sql);
        $rowcount=mysqli_num_rows($_handler_results);
        return $rowcount;
    }

    public function logout() {
        $auth  = new Auth();
        try {
            $auth->auth->logout();
        }
        catch (\Delight\Auth\NotLoggedInException $e) {
            die('Not logged in');
        }
        header('Location: /login');
        exit;
    }
}
?>