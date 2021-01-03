<?php
require_once '../db_connection.php';
try{
    session_start();
    if(!$conn){
        echo  json_encode(array("status" => "UNSUCCESSFUL", "message" => "Error connecting to database", "status_code" => 201));
        return;
    } 
    $product_id = $_POST['product_id'];
    $user_id = $_SESSION['user'];
    $quantity = $_POST['quantity'];
    $add_cart_query = "INSERT INTO cart(product_id,user_email,quantity) VALUES ('$product_id','$user_id','$quantity')";
    $res = mysqli_query($conn,$add_cart_query);
    if($res)
    {
        echo "200";
        return;
    }
    echo"404";
    return;
    
}
catch(Exception $e){
    echo json_encode(array("status" => "UNSUCCESSFUL", "status_code" => 300, "message" => "Unknown Error: $e"));
    mysqli_rollback($conn);
    mysqli_close($conn);
    exit();
}
?>