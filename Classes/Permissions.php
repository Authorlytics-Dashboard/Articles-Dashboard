<?php
class Permissions{
    protected $auth;
    public function __construct(){
        $this->auth = new Auth();
    }
    public function isViewer() {
        return $this->auth->auth->hasAnyRole(
            \Delight\Auth\Role::EDITOR,
            \Delight\Auth\Role::ADMIN,
        );
    }
    public function isEditor(){
        return $this->auth->auth->hasAnyRole(
            \Delight\Auth\Role::ADMIN,
            \Delight\Auth\Role::REVIEWER,
            
        );
    }
}
?>