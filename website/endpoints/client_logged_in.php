<?php
    session_start();
    
    if(isset($_SESSION['user'])){
        
        echo json_encode(array("status" => "SUCCESSFUL", "message" => "Client session Variable is set", "status_code" => 200));
    }
    else{
        echo json_encode(array("status" => "SUCCESSFUL", "message" => "SESSION NOT SET", "status_code" => 213));
    }
?>