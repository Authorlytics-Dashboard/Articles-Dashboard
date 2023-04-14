<?php 
class Login extends MYSQLHandler{
  public $id;
  public function login($email, $password){

    $result = mysqli_query($this->_dbHandler, "SELECT * FROM users WHERE email = '$email'");
    $row = mysqli_fetch_assoc($result);

    if(mysqli_num_rows($result) > 0){
        $isPasswordCorrect = password_verify($password, $row["password"]);
      if($isPasswordCorrect){
        $this->id = $row["uid"];
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
}