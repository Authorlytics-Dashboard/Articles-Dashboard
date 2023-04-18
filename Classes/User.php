<?php

class User extends CRUD {
    public function create($data){
        try {    
            $this->connect();
            $uname = $data['uname'];
            $email = $data['email'];
            $avatar = $data['avatar'];
            $gid = $data['gid'];
            $mobile = "+2".$data['mobile'];
            $password = password_hash($data['password'], PASSWORD_DEFAULT);
            $target_file = "../assets/Images/" . basename($_FILES["avatar"]["name"]);  
            move_uploaded_file($_FILES["avatar"]["tmp_name"],__DIR__ . '/' . $target_file);
            $avatar = basename($_FILES["avatar"]["name"]);
            $data = [
                'username' => $uname,
                'email' => $email,
                'gid' => $gid, 
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
    private function assignRole($email,$group){

        try {
            switch($group){
                case 1:
                {
                    $this->_auth->admin()->addRoleForUserByEmail($email, \Delight\Auth\Role::ADMIN);
                    break;
                } 
                case 2:
                {
                    $this->_auth->admin()->addRoleForUserByEmail($email, \Delight\Auth\Role::EDITOR);
                    break;
                } 
                case 3:
                default:
                $this->_auth->admin()->addRoleForUserByEmail($email, \Delight\Auth\Role::REVIEWER);
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
            $avatar = $_FILES['avatar']['name'];
            $target_file = "../assets/Images/" . basename($_FILES["avatar"]["name"]);  
            move_uploaded_file($_FILES['avatar']['tmp_name'], __DIR__ . '/' . $target_file);
            $avatar = basename($_FILES["avatar"]["name"]);
            $id = $_GET['id'];
            $edited_values = array(
                'username' => $_POST['name'],
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
        $_SESSION = array(); // reset session array
        session_destroy(); 
        setcookie("remember_token", "", time() - 3600);  // destroy session     
        header('Location: /login');
        exit;
    }
}
?>