<?php

class Group extends CRUD {
    public function getGroups(){
        try {
            $this->connect();
            $sql = "SELECT gname, gid FROM `$this->table`";
            $result = $this->_dbHandler->query($sql);
            $this->disconnect();
            if ($result->num_rows > 0) {
                $groups = array();
                while ($row = $result->fetch_assoc()) {
                    $groups[] = $row;
                }
                return $groups;
            } else {
                return false;
            }
        } catch (Exception $e) {
            new Log($this->log_file, $e->getMessage());
            return false;
        }
    }
    public function create($data)
{
    $validator = new GroupValidator();
    $validatedData = $this->validateGroupData($data, $validator);
    if (!$validatedData) {
        return false;
    }
    
    $uploadedFile = $this->uploadFile('avatar');
    if (!$uploadedFile) {
        return false;
    }
    
    $validatedData['avatar'] = $uploadedFile;
    
    return $this->save($validatedData, $this->table);
}

private function validateGroupData($data, $validator)
{    
    $gname = $data['name'];
    $nameError = $validator->validateGroupName($gname);
    if ($nameError) {
        $this->showError('name-error', $nameError);
        return false;
    }  

    $description = $data['description'];
    $descriptionError = $validator->validateGroupDescription($description);
    if($descriptionError){
        $this->showError('description-error', $descriptionError);
        return false;
    } 

    $avatar = $data['avatar'];
    $avatarError = $validator->validateGroupAvatar($avatar);
    if($avatarError){
        $this->showError('avatar-error', $avatarError);
        return false;
    }
    $validData = [
        'gname' => $data['name'],
        'description' => $data['description'],
    ];

    return $validData;

}

private function uploadFile($fieldName)
{
    $targetFile = "../assets/Images/" . basename($_FILES[$fieldName]["name"]);  
    if (!move_uploaded_file($_FILES[$fieldName]["tmp_name"],__DIR__ . '/' . $targetFile)) {
        $this->showError($fieldName . '-error', 'Failed to upload ' . $fieldName);
        return false;
    }
    return basename($_FILES[$fieldName]["name"]);
}
private function save($data, $tableName)
{
    try {
        $this->connect();
        $sql = $this->buildInsertStatement($this->table, $data);
        if (mysqli_query($this->_dbHandler, $sql)) {
            $id = mysqli_insert_id($this->_dbHandler);
            $this->disconnect();
            header('Location: /groups');
        }else {
                $this->disconnect();
                ob_flush();
                header('location:/articles');
                return false;
            }
    } catch(Exception $e) {
        new Log($this->log_file, $e->getMessage());
        return false;
    }
}

function buildInsertStatement($table, $data) {
    $columns = implode(", ", array_keys($data));
    $values = "'" . implode("', '", array_values($data)) . "'";
    return "INSERT INTO $table ($columns) VALUES ($values)";
}
    private function showError($type, $message) {
        echo "<script>document.getElementById('$type').innerHTML = '$message';</script>";
    }
    public function edit(){
        try{
            $this->connect();
            $avatar = $_FILES['avatar']['name'];
            $target_file = "../assets/Images/" . basename($_FILES["avatar"]["name"]);  
            move_uploaded_file($_FILES['avatar']['tmp_name'], __DIR__ . '/' . $target_file);
            $avatar = basename($_FILES["avatar"]["name"]);
            $id = $_GET['id'];
            $edited_values = array(
                'gname' => $_POST['name'],
                'description' => $_POST['description'],
                'avatar' => $avatar,
            );
            $update_group = $this->update($edited_values , $id);
            header('location:/groups');
        } catch(Exception $e) {
            new Log($this->log_file, $e->getMessage());
            return false;
        } 
    }
    public function getCount ($table){
        $this->connect();
        $sql = "select * from `$table` ";
        $_handler_results = mysqli_query($this->_dbHandler, $sql);
        $rowcount=mysqli_num_rows($_handler_results);
        return $rowcount;
    }

    public function getUserInGroup($groupId){
        $sql = "SELECT * FROM users INNER JOIN groups ON users.gid = groups.gid where groups.gid = $groupId";
        $results = $this->get_results($sql);

        return  $results;
    }
}

?>