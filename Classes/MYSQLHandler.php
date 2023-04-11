<?php
require_once('./config.php');

class MYSQLHandler
{
    protected $_dbHandler;

    public function __construct()
    {
        $this->connect();
    }

    public function connect()
    {
        try {
            $handler = mysqli_connect(_HOST_, _USER_, _PASSWORD_, _DB_NAME_);
            if($handler) {
                $this->_dbHandler = $handler;
            }
        } catch(Exception $e) {
            die("Could not connect to db, please come back later.");
        }
    }

    public function getConnection()
    {
        return $this->_dbHandler;
    }

    public function disconnect()
    {
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


    protected function debug($sql)
    {
        if (__Debug__Mode__ === 1) {
            return "<h5>Sent Query: </h5>" . $sql . "<br/> <br/>";
        }
    }
}

?> 