<?php
class MYSQLHandler
{
    public $_dbHandler;
    protected $_auth ; 
    public function __construct(){
        $this->connect();
    }
    function authConnection() {
        $dsn = 'mysql:host=' . _HOST_ . ':'. _PORT_ . ';dbname=' . _DB_NAME_ .'';
        try{
            $pdo = new PDO($dsn, _USER_, _PASSWORD_); 
        }catch(PDOException $e){
            die($e->getMessage());
        }
        $this->_auth = new \Delight\Auth\Auth($pdo);
    }

    public function connect(){
        try {
            $handler = mysqli_connect(_HOST_, _USER_, _PASSWORD_, _DB_NAME_);
            if($handler) {
                $this->_dbHandler = $handler;
                $this->authConnection();
            }
        } catch(Exception $e) {
            header("Location: /error");
        }
    }

    public function getConnection(){
        return $this->_dbHandler;
    }

    public function disconnect(){
        if ($this->_dbHandler) {
            mysqli_close($this->_dbHandler);
        }
    }

    public function get_results($sql)
    {
        $this->debug($sql);
        $_handler_results = mysqli_query($this->_dbHandler, $sql);
        $_arr_results = array();

        if ($_handler_results) {
            while ($row = mysqli_fetch_array($_handler_results, MYSQLI_ASSOC)) {
                $_arr_results[] = array_change_key_case($row);
            }
            // $this->disconnect();
            return $_arr_results;
        } else {
            // $this->disconnect();
            return false;
        }
    }

    protected function debug($sql){
        if (_Debug_Mode_ === 1) {
            return "<h5>Sent Query: </h5>" . $sql . "<br/> <br/>";
        }
    }

}
?>