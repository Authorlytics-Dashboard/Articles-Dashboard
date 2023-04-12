<?php

class GroupController implements CrudInterface {
    private $_dbHandler;

    public function __construct(){
        // connecting to DB 
        
        $MYSQL = new MYSQLHandler();
        $this->_dbHandler = $MYSQL->getConnection();
    }

    public function create($data){

    }
    public function show($id){

    }
    public function showAll(){

    }
    public function update($id, $data){

    }
    public function delete($id){
        
    }
}





?>