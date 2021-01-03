<?php
require_once '../db_connection.php';

try{
    session_start();
    if(!$conn){
        echo  json_encode(array("status" => "UNSUCCESSFUL", "message" => "Error connecting to database", "status_code" => 201));
        return;
    } 
    $user = $_SESSION['user'];
    $get_all_cat_query="SELECT `name` , cat_id FROM category";
    $get_all_cat_res=mysqli_query($conn,$get_all_cat_query);
    if($get_all_cat_res)
    {
        $return_data=array();
        while($row=mysqli_fetch_assoc($get_all_cat_res))
        {
            array_push($return_data,$row);
        }
        
        echo json_encode(array("status" => "SUCCESSFUL", "status_code" => 200, "message" => "Successfully retreived data from database", "data" => $return_data));
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