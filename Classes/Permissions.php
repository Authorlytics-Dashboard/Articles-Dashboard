<?php
class Permissions{
    protected $handler;
    public function __construct(){
        $this->handler = new MYSQLHandler();
    }
    public function isViewer() {
        return $this->handler->_auth->hasAnyRole(
            \Delight\Auth\Role::EDITOR,
            \Delight\Auth\Role::ADMIN,
        );
    }
    public function isEditor(){
        return $this->handler->_auth->hasAnyRole(
            \Delight\Auth\Role::ADMIN,
            \Delight\Auth\Role::REVIEWER,
            
        );
    }
}
?>