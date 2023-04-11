<?php
require_once('MYSQLHandler.php');

class Group extends MYSQLHandler {
    private $table = 'groups';
    private $primary_key = 'gid';
    public function get_data($fields = array(), $start = 0) {
        $this->connect();
        if (empty($fields)) {
            $sql = "select * from `$this->table`";
        } else {
            $sql = "select ";
            foreach ($fields as $f) {
                $sql .= " `$f`, ";
            }
            $sql .= "from  `$this->table` ";
            $sql = str_replace(", from", "from", $sql);
        }
        return $this->get_results($sql);
    }

    public function delete($id) {
        $this->connect();
        $table = 'groups';
        $primary_key = $this->primary_key;
        $sql = "delete  from `" . $table . "` where `" . $primary_key . "` = $id";
        $this->debug($sql);
        if (mysqli_query($this->_dbHandler, $sql)) {
            $this->disconnect();
            return true;
        } else {
            $this->disconnect();
            return false;
        }
    }

}
?>