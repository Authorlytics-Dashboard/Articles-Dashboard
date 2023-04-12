<?php 
require_once("../config.php");

class MYSQLHandler{
    private $_dbHandler;
    
    public function __construct(){
        $this->connect();
    }

    private function connect(){
        try{
            $handler = mysqli_connect(_HOST_,_USER_,_PASSWORD_,_DB_NAME_);
            if($handler){
                $this->_dbHandler = $handler;
            }
        }catch(Exception $e){
            die("Could not connect to db, please come back later.");
        }
    }

    public function getConnection(){
        return $this->_dbHandler;
    }
}

?> 