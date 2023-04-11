<?php

class GroupController implements CrudInterface {
    private $_dbHandler;

    public function __construct(){
        $this->_dbHandler = new MYSQLHandler();
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