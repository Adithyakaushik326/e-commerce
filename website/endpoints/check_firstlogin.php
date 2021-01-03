<?php
    require_once '../db_connection.php';
    session_start();
    try
    {   
        if(!$conn){
            echo  json_encode(array("status" => "UNSUCCESSFUL", "message" => "Error connecting to database", "status_code" => 201));
            return;
        } 
        $user = $_SESSION['user'];
        $check_credentials_query="SELECT first_login  FROM user WHERE email='$user' ";
        $check_cred_res = mysqli_query($conn, $check_credentials_query);
        if($check_cred_res){
            if(mysqli_num_rows($check_cred_res) > 0){
                $row = mysqli_fetch_assoc($check_cred_res);
                $row = $row['first_login'];
                echo json_encode(array("status" => "SUCCESSFUL", "message" => "Successful login", "status_code" => 200,"data"=>$row));
                return;
            }
            else
        {
            echo json_encode(array("status" => "UNSUCCESSFUL", "message" => "Invalid credentials", "status_code" => 201));
            return;
        }
        }
        
    }
    catch(Exception $e){
        echo json_encode(array("status" => "UNSUCCESSFUL", "status_code" => 300, "message" => "Unknown Error: $e"));
        mysqli_rollback($conn);
        mysqli_close($conn);
        exit();
    }
?>