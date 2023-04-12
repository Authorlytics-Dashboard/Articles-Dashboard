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
    public function create($data){
        $this->connect();
        $table = 'groups';
        $gname = $data['name'];
        $description = $data['description'];
        
        $avatar = $data['avatar'];
        $target_file = "../assets/Images/" . basename($_FILES["avatar"]["name"]);  
        move_uploaded_file($_FILES["avatar"]["tmp_name"], $target_file);
        $avatar = basename($_FILES["avatar"]["name"]);
    
        $sql = "insert into `$table` (gname, description, avatar) values ('$gname', '$description', '$avatar')";
        if (mysqli_query($this->_dbHandler, $sql)) {
            $id = mysqli_insert_id($this->_dbHandler);
            $this->disconnect();
            return $id;
        } else {
            $this->disconnect();
            return false;
        }
    }
    public function update($edited_values, $id)
    {
        $this->connect();
        $table = $this->table;
        $primary_key = $this->primary_key;
        $sql = "UPDATE `" . $table . "` SET ";

        foreach ($edited_values as $key => $value) {
            if ($key != $primary_key) {
                if (!is_numeric($value)) {
                    $sql .= " `$key` = '" . mysqli_real_escape_string($this->_dbHandler, $value) . "',";
                } else {
                    $sql .= " `$key` = $value ,";
                }
            }
        }

        $sql = rtrim($sql, ',');
        $sql .= " WHERE `" . $primary_key . "` = " . intval($id);

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