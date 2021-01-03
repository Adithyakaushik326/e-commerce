<?php
    require_once '../db_connection.php';
    
    try
    {
        if(!$conn){
            echo  json_encode(array("status" => "UNSUCCESSFUL", "message" => "Error connecting to database", "status_code" => 201));
            return;
        } 
        $name = $_POST['name'];
        $mail = $_POST['email'];
        $pass = $_POST['pass'];
        $check_email_query = "SELECT *FROM `admin` WHERE email = '$mail'";
        $check_email_res = mysqli_query($conn, $check_email_query);
        if($check_email_res){
            if(mysqli_num_rows($check_email_res) > 0){
                echo json_encode(array("status" => "UNSUCCESSFUL", "message" => "Existing email-id", "status_code" => 202));
                return;
            }
        }
        $query = "INSERT INTO `admin`(`name`, email, `password`) VALUES ('$name', '$mail', '$pass')";
        $res = mysqli_query($conn, $query);
        if($res){
                echo json_encode(array("status" => "SUCCESSFUL", "message" => "Successful signup", "status_code" => 200));
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