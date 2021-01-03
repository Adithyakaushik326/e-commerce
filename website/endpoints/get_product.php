<?php
require_once '../db_connection.php';
try{
    session_start();
    if(!$conn){
        echo  json_encode(array("status" => "UNSUCCESSFUL", "message" => "Error connecting to database", "status_code" => 201));
        return;
    } 
    $product = $_GET['product'];
    $user = $_SESSION['user'];
    if ($product=='ALL')
    {
        $get_all_products_query='SELECT product_id,`name` , review , price , `image`,sub_id  FROM product WHERE quantity>0' ;
        $get_all_product_res=mysqli_query($conn,$get_all_products_query);
        if($get_all_product_res)
        {
            $return_data=array();
            while($row=mysqli_fetch_assoc($get_all_product_res))
            {
                array_push($return_data,$row);
            }
            $random_id = array_rand($return_data,20);

            $return_array = array();
            for ($i=0;$i<count($random_id);$i++)
            {
                array_push($return_array,$return_data[$random_id[$i]]);
            }
           
           
                
            echo json_encode(array("status" => "SUCCESSFUL", "status_code" => 200, "message" => "Successfully retreived data from database", "data" => $return_array));
            exit();
            
           
            
        }
        else
        {
            echo json_encode(array("status" => "UNSUCCESSFUL", "message" => "Invalid credentials", "status_code" => 201));
            return;
        }
    
    }
    else if($product=='cat')
    {
        $cat_id = $_GET['cat_id'];
        $get_all_products_query="SELECT product_id,`name` , review , price , `image`,sub_id  FROM product WHERE quantity>0 AND sub_id IN (SELECT sub_id FROM subcategory WHERE cat_id = $cat_id)" ;
        $get_all_product_res=mysqli_query($conn,$get_all_products_query);
        if($get_all_product_res)
        {
            
            $return_data=array();
            while($row=mysqli_fetch_assoc($get_all_product_res))
            {
                array_push($return_data,$row);
            }
            
            $random_id = array_rand($return_data,40);

            $return_array = array();
            for ($i=0;$i<count($random_id);$i++)
            {
                array_push($return_array,$return_data[$random_id[$i]]);
            }
            echo json_encode(array("status" => "SUCCESSFUL", "status_code" => 200, "message" => "Successfully retreived data from database", "data" => $return_array));
            exit();    
        }
        else
        {
            echo json_encode(array("status" => "UNSUCCESSFUL", "message" => "Invalid credentials", "status_code" => 201));
            return;
        }
    }
    else if($product=='sub')
    {
        $sub_id = $_GET['sub_id'];
        $get_all_products_query="SELECT product_id,`name` , review , price , `image`,sub_id  FROM product WHERE quantity>0 AND sub_id =$sub_id" ;
        $get_all_product_res=mysqli_query($conn,$get_all_products_query);
        if($get_all_product_res)
        {
            
            $return_data=array();
            while($row=mysqli_fetch_assoc($get_all_product_res))
            {
                array_push($return_data,$row);
            }
            // print_r($return_data);
          
            echo json_encode(array("status" => "SUCCESSFUL _sub", "status_code" => 200, "message" => "Successfully retreived data from database", "data" => $return_data),JSON_UNESCAPED_UNICODE);
            // echo json_last_error_msg();
            exit();    
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