<?php
require_once '../db_connection.php';

try{
    session_start();
    if(!$conn){
        echo  json_encode(array("status" => "UNSUCCESSFUL", "message" => "Error connecting to database", "status_code" => 201));
        return;
    } 
    $user = $_GET['user'];
    // $check = $_SESSION['success'];
    if(isset($_SESSION['success']))
    {
    $get_all_cart_query="SELECT p.product_id,p.name , p.price , p.image,c.quantity  FROM product p , cart c WHERE p.product_id = c.product_id AND p.product_id IN (SELECT product_id FROM cart WHERE user_email = '$user' AND deleted=0)";
    $get_all_cart_res=mysqli_query($conn,$get_all_cart_query);
    if($get_all_cart_res)
    {
        $return_data=array();
        $get_user_query = "SELECT `name` , phone , `address` FROM user WHERE email='$user'";
        $res = mysqli_query($conn,$get_user_query);
        if($res)
        {
            $row1 = mysqli_fetch_assoc($res);
            while($row=mysqli_fetch_assoc($get_all_cart_res))
            {
                array_push($return_data,$row);
            }
            $d=strtotime("tomorrow");
            $row1['date']= date("d-m-Y ", $d);
        echo json_encode(array("status" => "SUCCESSFUL", "status_code" => 200, "message" => "Successfully retreived data from database", "data" => $return_data,"user"=>$row1));
        exit();
        }
      
       
    } 
    else
    {
        echo json_encode(array("status" => "UNSUCCESSFUL", "message" => "Invalid credentials", "status_code" => 201));
        return;
    }
    
}
else{
    echo  json_encode(array("status" => "UNSUCCESSFUL", "message" => "Error connecting to database", "status_code" => 201));
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