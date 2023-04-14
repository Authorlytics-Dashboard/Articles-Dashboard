<?php 
class Login extends MYSQLHandler{
  public $id;
  public function login($email, $password){

    $result = mysqli_query($this->_dbHandler, "SELECT * FROM users WHERE email = '$email'");
    $row = mysqli_fetch_assoc($result);

    if(mysqli_num_rows($result) > 0){
      if($password == $row["password"]){
        $this->id = $row["uid"];
        if($password == $row["password"]) {
          $this->id = $row["uid"];
          if($_POST['remember_me']) {
            $this->setUserCookie();
          }
        }
        return 1;
        // Login successful
      }
      else{
        return 10;
        // Wrong password
      }
    }
    else{
      return 100;
      // User not registered
    }
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