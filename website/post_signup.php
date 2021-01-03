<?php
    require_once '../database_connection.php';
    if(!$conn){
        echo "ERROR";
        return;
    } 
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $username = $first_name." ".$last_name;
    $email_id = $_POST['email_id'];
    $password = $_POST['password'];
    $phone_no = $_POST['phone_no'];
    $address = $_POST['address'];
    $check_email_query = "SELECT *FROM user WHERE email_id = '$email_id'";
    $check_email_res = mysqli_query($conn, $check_email_query);
    if($check_email_res){
        if(mysqli_num_rows($check_email_res) > 0){
            echo "201";
            return;
        }
    }
    $query = "INSERT INTO user(username, email_id, `password`) VALUES ('$username', '$email_id', '$password')";
    $res = mysqli_query($conn, $query);
    if($res){
        $user_id = mysqli_insert_id($conn);
        $insert_user_details_query = "INSERT INTO user_details(`userid`, `address`, phonenumber) VALUES ($user_id, '$address', '$phone_no')";
        $insert_user_details_res = mysqli_query($conn, $insert_user_details_query);
        if($insert_user_details_res){
            echo '200';
            return;
        }
    }
    echo "500";
?>