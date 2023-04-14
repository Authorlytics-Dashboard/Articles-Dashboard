<?php
class Log {
    private $handle;
    public function __construct($fileName,$message){
        $this->handle=fopen('logFiles/'.$fileName,"a");
        fwrite($this->handle,date('Y-m-d H:i:s').'-'.print_r($message,true)."\n");
    }
    public function __destruct(){
        fclose($this->handle);
    }
}