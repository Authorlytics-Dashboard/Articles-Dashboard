<?php

class GroupController implements CrudInterface {
    private $_dbHandler;

    public function __construct(){
        $MYSQL = new MYSQLHandler();
        $this->_dbHandler = $MYSQL->getConnection();
    }

    public function create($data){
        // if(isset($_POST['action']) && $_POST['action'] == 'Create') {
        //     $name = $_POST['name'];
        //     $description = $_POST['description'];
        //     $avatar = $_POST['avatar'];
            
        //     $sql = "INSERT INTO groups (name, description, avatar) VALUES ('$name', '$description', '$avatar')";
            
        // }
        
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