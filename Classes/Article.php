<?php

class Article extends MYSQLHandler {
    private $table = 'articles';
    private $primary_key = 'aid';
    private $log_file="ArticlesErrors.log";

    public function getData($fields = array(), $start = 0) {
        try {
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

        }catch (Exception $e) {
            new Log($this->log_file, $e->getMessage());
            return false;
        }
    }

    // adding functions using prepared statement

//     public function getData($fields = array(), $start = 0) {
//     try {
//         $this->connect();
//         if (empty($fields)) {
//             $sql = "SELECT * FROM `$this->table`";
//         } else {
//             $sql = "SELECT ";
//             foreach ($fields as $f) {
//                 $sql .= "`$f`, ";
//             }
//             $sql = rtrim($sql, ", ") . " FROM `$this->table`";
//         }

//         $stmt = $this->mysqli->prepare($sql);
//         if (!empty($fields)) {
//             $types = str_repeat('s', count($fields));
//             $args = array();
//             foreach ($fields as $f) {
//                 $args[] = &$f;
//             }
//             array_unshift($args, $types);
//             call_user_func_array(array($stmt, 'bind_param'), $args);
//         }
//         $stmt->execute();

//         $result = $stmt->get_result();

//         $data = array();
//         while ($row = $result->fetch_assoc()) {
//             $data[] = $row;
//         }

//         return $data;
//     } catch (Exception $e) {
//         new Log($this->log_file, $e->getMessage());
//         return false;
//     }
// }

    public function showArticleByID($id) {
        try {
            $primary_key = $this->primary_key;
            $table = $this->table;
            $sql = "select * from `$table` where `$primary_key` = '$id' ";
            return $this->get_results($sql);

        }catch(Exception $e) {
            new Log($this->log_file, $e->getMessage());
            return false;
        }
    }

// public function showArticleByID($id) {
//     try {
//         $this->connect();
//         $primary_key = $this->primary_key;
//         $table = $this->table;
//         $sql = "SELECT * FROM `$table` WHERE `$primary_key` = ?";
//         $stmt = $this->mysqli->prepare($sql);
//         $stmt->bind_param("s", $id);
//         $stmt->execute();
//         $result = $stmt->get_result();
//         $data = array();
//         while ($row = $result->fetch_assoc()) {
//             $data[] = $row;
//         }
//         return $data;
//     } catch (Exception $e) {
//         new Log($this->log_file, $e->getMessage());
//         return false;
//     }
// }

    public function delete($id) {
        try{
            $this->connect();
            $timestamp = date('Y-m-d H:i:s');
            $data = $this->showArticleByID($id)[0];
            $data['deleted_at'] = $timestamp;
            $this->update($data,$id);
            header('location:/articles');
        }catch(Exception $e) {
        new Log($this->log_file, $e->getMessage());
        return false;
     }
    }

//     public function delete($id) {
//     try {
//         $this->connect();
//         $timestamp = date('Y-m-d H:i:s');
//         $sql = "UPDATE `$this->table` SET deleted_at = ? WHERE `$this->primary_key` = ?";
//         $stmt = $this->mysqli->prepare($sql);
//         $stmt->bind_param("ss", $timestamp, $id);
//         $stmt->execute();
//         header('location:/articles');
//     } catch (Exception $e) {
//         new Log($this->log_file, $e->getMessage());
//         return false;
//     }
// }

    public function restore($id) {
        try{
            $this->connect();
            $data = $this->showArticleByID($id)[0];
            $data['deleted_at'] = null;
            $this->update($data,$id);
            header('location:/articles');
        }catch(Exception $e) {
        new Log($this->log_file, $e->getMessage());
        return false;
     }
    }

//     public function restore($id) {
//     try {
//         $this->connect();
//         $sql = "UPDATE `$this->table` SET deleted_at = NULL WHERE `$this->primary_key` = ?";
//         $stmt = $this->mysqli->prepare($sql);
//         $stmt->bind_param("s", $id);
//         $stmt->execute();
//         header('location:/articles');
//     } catch (Exception $e) {
//         new Log($this->log_file, $e->getMessage());
//         return false;
//     }
// }


        public function update($edited_values, $id){
        try{
            $this->connect();
            $table = $this->table;
            $primary_key = $this->primary_key;
            $sql = "UPDATE `" . $table . "` SET ";

            foreach ($edited_values as $key => $value) {
                if ($key != $primary_key) {
                    if (is_null($value) && $key == 'deleted_at') {
                        $sql .= " `$key` = NULL,";
                    }
                    elseif (!is_numeric($value)) {
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
        } catch(Exception $e) {
            new Log($this->log_file, $e->getMessage());
            return false;
        }
    }

//     public function update($edited_values, $id) {
//     try {
//         $this->connect();
//         $table = $this->table;
//         $primary_key = $this->primary_key;
//         $sql = "UPDATE `$table` SET ";

//         $params = array();
//         $types = "";
//         foreach ($edited_values as $key => $value) {
//             if ($key != $primary_key) {
//                 if (is_null($value) && $key == 'deleted_at') {
//                     $sql .= " `$key` = NULL,";
//                 } elseif (!is_numeric($value)) {
//                     $sql .= " `$key` = ?,";
//                     $params[] = $value;
//                     $types .= "s";
//                 } else {
//                     $sql .= " `$key` = ?,";
//                     $params[] = $value;
//                     $types .= "i";
//                 }
//             }
//         }
//         $sql = rtrim($sql, ',');
//         $sql .= " WHERE `$primary_key` = ?";

//         $params[] = $id;
//         $types .= "s";
//         $stmt = $this->mysqli->prepare($sql);
//         $stmt->bind_param($types, ...$params);
//         $stmt->execute();

//         $this->disconnect();
//         return true;
//     } catch (Exception $e) {
//         new Log($this->log_file, $e->getMessage());
//         return false;
//     }
// }

    public function create($data){
        try {
            $this->connect();
            $photo = $data['photo'];

            $target_file = "../assets/Images/" . basename($_FILES["photo"]["name"]);  
            move_uploaded_file($_FILES["photo"]["tmp_name"],__DIR__ . '/' . $target_file);
            $photo = basename($_FILES["photo"]["name"]);

            $data = [
                'title' => $data['title'],
                'body' => $data['body'],
                'photo' => $photo,
                'post_date' => $data['post_date'],
                'uid' => $data['uid']
            ];
            $this->save($data);

        }catch(Exception $e) {
            new Log($this->log_file, $e->getMessage());
            return false;
        }
    }

//     public function create($data){
//     try {
//         $this->connect();
//         $photo = $data['photo'];

//         $target_file = "../assets/Images/" . basename($_FILES["photo"]["name"]);  
//         move_uploaded_file($_FILES["photo"]["tmp_name"],__DIR__ . '/' . $target_file);
//         $photo = basename($_FILES["photo"]["name"]);

//         $stmt = $this->_dbHandler->prepare("INSERT INTO `{$this->table}` (`title`, `body`, `photo`, `post_date`, `uid`) VALUES (?, ?, ?, ?, ?)");

//         $stmt->bind_param('ssssi', $data['title'], $data['body'], $photo, $data['post_date'], $data['uid']);

//         $stmt->execute();

//         $this->disconnect();
//     } catch(Exception $e) {
//         new Log($this->log_file, $e->getMessage());
//         return false;
//     }
// }


    public function save($data){
        try{
            $title = $data['title'];
            $body = $data['body'];
            $photo = $data['photo'];
            $post_date = $data['post_date'];
            $uid = $data['uid'];
            $table = 'articles';

            $sql = "insert into `$table` (title, body, photo, post_date, uid) values ('$title', '$body', '$photo', '$post_date','$uid')";
            if (mysqli_query($this->_dbHandler, $sql)) {
                $id = mysqli_insert_id($this->_dbHandler);
                $this->disconnect();
                header('Location:/articles');
                return $id;
            } else {
                $this->disconnect();
                ob_flush();
                header('location:/articles');
                return false;
            }
        }catch(Exception $e){
            new Log($this->log_file, $e->getMessage());
            return false;
        }
    }

//     public function save($data){
//     try{
//         $title = $data['title'];
//         $body = $data['body'];
//         $photo = $data['photo'];
//         $post_date = $data['post_date'];
//         $uid = $data['uid'];
//         $table = 'articles';

//         $sql = "INSERT INTO `$table` (title, body, photo, post_date, uid) VALUES (?, ?, ?, ?, ?)";

//         $stmt = mysqli_prepare($this->_dbHandler, $sql);
//         mysqli_stmt_bind_param($stmt, 'sssss', $title, $body, $photo, $post_date, $uid);
//         mysqli_stmt_execute($stmt);

//         if (mysqli_stmt_affected_rows($stmt) > 0) {
//             $id = mysqli_insert_id($this->_dbHandler);
//             $this->disconnect();
//             header('Location:/articles');
//             return $id;
//         } else {
//             $this->disconnect();
//             ob_flush();
//             header('location:/articles');
//             return false;
//         }
//     }catch(Exception $e){
//         new Log($this->log_file, $e->getMessage());
//         return false;
//     }
// }

    public function search(...$searchColumns){
        $table = $this->table;
        $sql = "SELECT * FROM `$table` WHERE ";
        $params = array();
    
        foreach ($searchColumns as $index => $searchColumn) {
            $params[] = "%" . $searchColumn["value"] . "%";
            $sql .= "`" . $searchColumn["column"] . "` LIKE '" . $searchColumn["value"] . "%'";
            if ($index < count($searchColumns) - 1) {
                $sql .= " OR ";
            }
        }
        return $this->get_results($sql);
    }

//     public function search(...$searchColumns){
//     try {
//         $this->connect();
//         $table = $this->table;
//         $sql = "SELECT * FROM `$table` WHERE ";
//         $params = array();
    
//         foreach ($searchColumns as $index => $searchColumn) {
//             $params[] = "%" . $searchColumn["value"] . "%";
//             $sql .= "`" . $searchColumn["column"] . "` LIKE ?";
//             if ($index < count($searchColumns) - 1) {
//                 $sql .= " OR ";
//             }
//         }
//         $stmt = $this->_dbHandler->prepare($sql);
//         $stmt->bind_param(str_repeat("s", count($searchColumns)), ...$params);
//         $stmt->execute();
//         $result = $stmt->get_result();
//         $data = $result->fetch_all(MYSQLI_ASSOC);
//         $stmt->close();
//         $this->disconnect();
//         return $data;
//     } catch(Exception $e){
//         new Log($this->log_file, $e->getMessage());
//         return false;
//     }
// }


    public function getCount ($table){
        $sql = "select * from `$table` ";
        $_handler_results = mysqli_query($this->_dbHandler, $sql);
        $rowcount=mysqli_num_rows($_handler_results);
        return $rowcount;
    }

//     public function getCount($table){
//     try {
//         $this->connect();
//         $sql = "SELECT COUNT(*) FROM `$table`";
//         $stmt = $this->_dbHandler->prepare($sql);
//         $stmt->execute();
//         $rowcount = $stmt->fetchColumn();
//         $this->disconnect();
//         return $rowcount;
//     } catch(Exception $e){
//         new Log($this->log_file, $e->getMessage());
//         return false;
//     }
// }


    public function get_all_records_paginated($fields = array(), $start = 0){
        $table = $this->table;
        if(empty($fields)){
            $sql = "select * from `$table` ";
        } else {
            $sql = "select ";
            foreach($fields as $f){
                $sql .= " `$f`, ";
            }
            $sql .= "from `$table` ";
            $sql = str_replace(", from", "from", $sql );
        }

        $sql .= "limit $start," . 5;
        return $this->get_results($sql);
    }
}

// public function get_all_records_paginated($fields = array(), $start = 0){
//     $table = $this->table;
//     if(empty($fields)){
//         $sql = "SELECT * FROM `$table` ";
//     } else {
//         $sql = "SELECT ";
//         foreach($fields as $f){
//             $sql .= " `$f`, ";
//         }
//         $sql .= "FROM `$table` ";
//         $sql = str_replace(", FROM", "FROM", $sql );
//     }

//     $sql .= "LIMIT ?, ?";
//     $stmt = $this->_dbHandler->prepare($sql);
//     $stmt->bind_param('ii', $start, 5);
//     $stmt->execute();
//     $result = $stmt->get_result();
//     $data = $result->fetch_all(MYSQLI_ASSOC);
//     $stmt->close();
//     return $data;
// }


?>