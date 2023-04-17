<?php 

class Message{
    public function __construct($message) {
        echo "
        <div class='modal fade show in' tabindex='-1' id='welcome'>
                <div class='modal-dialog'>
                    <div class='modal-content'>
                    <div class='modal-body'style='color:black'>
                        $message
                    </div>
                    <div class='modal-footer'>
                        <button type='button' class='btn btn-secondary' data-bs-dismiss='modal'>Close</button>
                    </div>
                    </div>
                </div>
                </div>
        ";
    }
}