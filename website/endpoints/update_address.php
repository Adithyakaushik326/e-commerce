<?php
require_once '../db_connection.php';

try{
    session_start();
    if(!$conn){
        echo  json_encode(array("status" => "UNSUCCESSFUL", "message" => "Error connecting to database", "status_code" => 201));
        return;
    } 
    $user = $_SESSION['user'];
    $address = $_POST['address'];
    $phone = $_POST['phone'];
    $update_query="UPDATE user SET `address`='$address' , `phone` = '$phone' , first_login = 0 WHERE  email = '$user' ";
    $res=mysqli_query($conn,$update_query);
    if($res)
    {
        
        echo json_encode(array("status" => "SUCCESSFUL", "status_code" => 200, "message" => "Successfully updated data to database"));
            exit();
    } 
    else
    {
        echo json_encode(array("status" => "UNSUCCESSFUL", "message" => "Invalid credentials", "status_code" => 201));
        return;
    }
    
   
}
catch(Exception $e){
    echo json_encode(array("status" => "UNSUCCESSFUL", "status_code" => 300, "message" => "Unknown Error: $e"));
    mysqli_rollback($conn);
    mysqli_close($conn);
    exit();
}
?>