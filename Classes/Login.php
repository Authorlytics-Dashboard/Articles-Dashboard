<?php 

use Twilio\Rest\Client;

class Login extends MYSQLHandler{
  public $id;

  public function login($email, $password){

    $result = mysqli_query($this->_dbHandler, "SELECT * FROM users WHERE email = '$email'");
    $row = mysqli_fetch_assoc($result);

    if(mysqli_num_rows($result) > 0){
        $isPasswordCorrect = password_verify($password, $row["password"]);
      if($isPasswordCorrect){
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

  public function resetPassword($userEmail){
    $users = new User();
    $user = $users->search(array("column" => "email", "value" => $userEmail));
    
    if(!empty($user)){
      $user = $user[0];
      $userMobile = $user["mobile"];

      // $client = new Client(_ACCOUNT_SID_, _AUTH_TOKEN_);
      $sentOTP = mt_rand(100000, 999999);
      $message = "Hello " . $user["uname"] . " your Verification OTP code is: " . $sentOTP;
      var_dump($message);
      
      try {
  //       $message = $client->messages->create(
  //     $userMobile,
  // array(
  //           'body' => $message,
  //           'from' => '+16205228490'
  //         )
        // );
        
        setcookie('otp', $sentOTP);
        echo "OTP successfully send..";
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
    if($password === $confirmedPass){
      $users = new User();
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