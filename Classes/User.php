<?php

class User extends CRUD {
    public function create($data){
        try {    
            $this->connect();
            $userValidation = new UserValidator($data, "create");
            
            if( $userValidation->isValid()){
                $target_file = "../assets/Images/" . basename($_FILES["avatar"]["name"]);  
                move_uploaded_file($_FILES["avatar"]["tmp_name"],__DIR__ . '/' . $target_file);
                $data['avatar'] = basename($_FILES["avatar"]["name"]);
                $data['mobile'] = "+2".$data['mobile'];
                $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
                $this->save($data);
            }else{
                $_SESSION['data'] = $data;
                $this->showError($userValidation->getError());
            }
        
        }catch(Exception $e) {
            new Log($this->log_file, $e->getMessage());
            return false;
        }
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

    public function save($data){
        try{
            $this->connect();
            $username = $data['username'];
            $email = $data['email'];
            $avatar = $data['avatar'];
            $groupID = $data['gid'];
            $mobile = $data['mobile'];
            $password = $data['password'];
            $subscriptionDate = date('Y-m-d H:i:s'); 
            $table = 'users';

            $sql = "insert into `$table` (email, password,username,registered,last_login,subscription_date,avatar,mobile,gid) 
            values ('$email', '$password', '$username',  '$subscriptionDate ', '$subscriptionDate ','$subscriptionDate ', '$avatar', '$mobile' , '$groupID');";
            if (mysqli_query($this->_dbHandler, $sql)) {
                $id = mysqli_insert_id($this->_dbHandler);
                $this->assignRole($email,$groupID);
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