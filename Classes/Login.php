<?php 

use Twilio\Rest\Client;

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

  public function checkLoggedIn() {
    if(!empty($_SESSION["id"])){
      require_once("./views/dashboard.php");
    }
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
  
  public function getUserToken(){
    $stmt = $this->_dbHandler->prepare("SELECT * FROM remember_tokens WHERE token = ?");
    $stmt->bind_param("s", $_COOKIE["remember_token"]);
    $stmt->execute();
    $result = $stmt->get_result();
    $token = $result->fetch_assoc();
    return $token ; 
  }

  public  function getLastVisit($email){
    $user = $this->getUserByEmail($email);
    if($user){
      return $user["last_visit"];
    }
  }
  
  public  function setLastVisit(){
    $userId = $this->id;
    $currentDate = date("Y-m-d H:i:s");
    $stmt = $this->_dbHandler->prepare("UPDATE users SET last_visit = ? WHERE uid = ?");
    $stmt->bind_param("ss", $currentDate, $userId);
    $stmt->execute();
  }
  

  public function resetPassword($userEmail){
    $users = new User('users', "UsersErrors.log",'uid');
    $user = $users->search(array("column" => "email", "value" => $userEmail));
    
    if(!empty($user)){
      $user = $user[0];
      $userMobile = $user["mobile"];

      $client = new Client(_ACCOUNT_SID_, _AUTH_TOKEN_);
      $sentOTP = mt_rand(100000, 999999);
      $message = "Hello " . $user["uname"] . " your Verification OTP code is: " . $sentOTP;
      
      try {
        $message = $client->messages->create(
        $userMobile,
        array(
            'body' => $message,
            'from' => _SENDER_
          )
        );
        
        setcookie('otp', $sentOTP);
        return true;
      } catch (Exception $e) {
        die('Error: ' . $e->getMessage());
      }
    }
    return false;
  }

  public function verifyOTP($otp){
    $sentOTP = $_COOKIE['otp'];
    if($sentOTP == $otp){
      return true;
    }
    return false;
  }

  public function changePassword($userEmail ,$password, $confirmedPass){
    if($password === $confirmedPass) {
        $users = new User('users', "UsersErrors.log",'uid');
        $user = $users->search(array("column" => "email", "value" => $userEmail));

        $data = [
          'uname' => $user[0]['uname'],
          'email' => $user[0]['email'],
          'gid' => $user[0]['gid'],
          'mobile' => $user[0]['mobile'],
          'password' => password_hash($password, PASSWORD_DEFAULT),
          'avatar' => $user[0]['avatar'],
          'deleted_at' => $user[0]['deleted_at'],
          'subscription_date' => $user[0]['subscription_date'],
        ];

        $users->update($data, $user[0]['uid']);
        return true;
    }
    return false;
  }
}