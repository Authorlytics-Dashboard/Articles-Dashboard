<?php
class Permissions{
    protected $handler;
    public function __construct(){
        $this->handler = new MYSQLHandler();
    }
    public function canViewArticle() {
        return $this->handler->_auth->hasAnyRole(
            \Delight\Auth\Role::EDITOR,
            \Delight\Auth\Role::ADMIN,
        );
    }
}
?>