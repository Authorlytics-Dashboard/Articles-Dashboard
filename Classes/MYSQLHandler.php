<?php
class MYSQLHandler
{
    public $_dbHandler;
    protected $_auth ; 
    public function __construct(){
        $this->connect();
    }
    public function connect(){
        try {
            $handler = mysqli_connect(_HOST_, _USER_, _PASSWORD_, _DB_NAME_);
            if($handler) {
                $this->_dbHandler = $handler;
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
        try{
        $this->debug($sql);
        $_handler_results = mysqli_query($this->_dbHandler, $sql);
        $_arr_results = array();

        if ($_handler_results) {
            while ($row = mysqli_fetch_array($_handler_results, MYSQLI_ASSOC)) {
                $_arr_results[] = array_change_key_case($row);
            }
            return $_arr_results;
        } else {
            return false;
        }
    } catch (Exception $e) {
        new Log('error.log', $e->getMessage());
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