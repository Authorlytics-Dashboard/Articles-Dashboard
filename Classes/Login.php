<?php 
class Login extends MYSQLHandler{
  public $id;
  private $log_file="loginError.log";
  public function login($email, $password){
    if(empty($email) || empty($password)){
      return "Please enter both email and password";
    }
    $user = $this->getUserByEmail($email);
    if($user){
      $isPasswordCorrect =$this->authenticateUser($password, $user);
      if($isPasswordCorrect){
        $this->id = $user["uid"];
        if(isset($_POST['remember_me'])) {
        $this->setUserCookie();
        }
        return 1;          // Login successful
      }
      else{
           return 10;          //Wrong password
      }
    }
    else{
      return 100;      // User not registered
    }
}

  private function getUserByEmail($email){
   try{
    $stmt = $this->_dbHandler->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc(); 
    return ($result->num_rows > 0) ? $row : null;
  }
  catch (Exception $e) {
    new Log($this->log_file, $e->getMessage());
     return false;
  }
  }
  
  private function authenticateUser($password, $user){
    return password_verify($password, $user["password"]);
  }
  public function idUser(){
    return $this->id;
  }

  public function setUserCookie(){
    $token = bin2hex(random_bytes(16)); 
    $expire = date('Y-m-d H:i:s', time() + 86400 * 30); 
    $user_id = $this->id ; 
    $stmt = $this->_dbHandler->prepare("INSERT INTO remember_tokens (token, expire, user_id) VALUES (?, ?, ?)");
    $stmt->bind_param("ssi", $token, $expire, $user_id);
    $stmt->execute();
    setcookie("remember_token", $token, time() + 86400 * 30, "/");
  }
}