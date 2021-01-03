<?php
require_once '../db_connection.php';
try{
    session_start();
    if(!$conn){
        echo  json_encode(array("status" => "UNSUCCESSFUL", "message" => "Error connecting to database", "status_code" => 201));
        return;
    } 
    
    $get_all_cat_query='SELECT cat_id ,`name` FROM category' ;
    $get_all_cat_res=mysqli_query($conn,$get_all_cat_query);
    if($get_all_cat_res)
    {
        $return_data=array();
        while($row=mysqli_fetch_assoc($get_all_cat_res))
        {
   
            $cat_id = $row['cat_id'];
            $get_sub_query = "SELECT sub_id ,`name` FROM subcategory WHERE cat_id ='$cat_id'";
            $get_sub_res = mysqli_query($conn,$get_sub_query);
            if($get_sub_res)
            {
                $return_sub_data = array();
                while($sub_row = mysqli_fetch_assoc($get_sub_res))
                {
                    array_push($return_sub_data,$sub_row);
                }
            $row['sub']=$return_sub_data;
            }
            else{
                $row['sub']='error';
            }
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