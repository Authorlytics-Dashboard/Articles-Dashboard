<?php

class CRUD extends MYSQLHandler {
    protected $table;
    protected $log_file;
    protected $primary_key;
    public function __construct($table, $log_file,$primary_key){
        $this->table = $table;
        $this->log_file = $log_file;
        $this->primary_key = $primary_key;
    }
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

    public function getRecordByID($id) {
        try {
            $this->connect();
            $primary_key = $this->primary_key;
            $table = $this->table;
            $sql = "select * from `$table` where `$primary_key` = '$id' ";

            return $this->get_results($sql);
        }catch(Exception $e) {
            new Log($this->log_file, $e->getMessage());
            return false;
        }
    }

    public function delete($id) {
        try{
            $this->connect();
            $timestamp = date('Y-m-d H:i:s');
            $data = $this->getRecordByID($id)[0];
            $data['deleted_at'] = $timestamp;
            $this->update($data,$id);
            header('Location: ' . $_SERVER['HTTP_REFERER']);
        }catch(Exception $e) {
            new Log($this->log_file, $e->getMessage());
            return false;
        }
    }

    public function restore($id) {
        try{
            $this->connect();
            $data = $this->getRecordByID($id)[0];
            $data['deleted_at'] = null;
            $this->update($data,$id);
            header('Location: ' . $_SERVER['HTTP_REFERER']);
        }catch(Exception $e) {
            new Log($this->log_file, $e->getMessage());
            return false;
        }
    }
    public function update($edited_values, $id) {
        $sql = $this->buildUpdateQuery( $edited_values,$id);
        return $this->executeQuery($sql);
    }
    private function buildUpdateQuery($edited_values,$id) {
        $sql = "UPDATE `" . $this->table . "` SET ";
    
        foreach ($edited_values as $key => $value) {
            if ($key != $this->primary_key) {
                $formattedValue = $this->formatValue($value);
                $sql .= " `$key` = " . $formattedValue . ",";
            }
        }
    
        $sql = rtrim($sql, ',');
        $sql .= " WHERE `" . $this->primary_key . "` = " . intval($id);
    
        return $sql;
    }   
    private function formatValue($value) {
        if (is_null($value)) {
            return "NULL";
        } elseif (!is_numeric($value)) {
            $this->connect();
            return "'" . mysqli_real_escape_string($this->_dbHandler, $value) . "'";
        } else {
            return $value;
        }
    }
    public function executeQuery($query) {
        try {
            $this->connect();
            $result = mysqli_query($this->_dbHandler, $query);
            $this->disconnect();
            return $result;
        } catch (Exception $e) {
            new Log($this->log_file, $e->getMessage());
            return false;
        }
    }
    public function search(...$searchColumns){
        $this->connect();
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

        $sql .= "limit $start," . _PAGE_RECORD_NUM_;
        return $this->get_results($sql);
    }



}