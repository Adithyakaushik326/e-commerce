<?php
require_once '../db_connection.php';
try{
    if(!$conn){
        echo  json_encode(array("status" => "UNSUCCESSFUL", "message" => "Error connecting to database", "status_code" => 201));
        return;
    } 
    

    $product = $_GET['product'];
    $sub_id = $_GET['sub'];
    $get_product_query="SELECT *  FROM product WHERE product_id = '$product'" ;
    $get_product_res=mysqli_query($conn,$get_product_query);
   
    if($get_product_res)
    {
        
        $get_some_more="SELECT `name`, product_id ,price, `image` FROM product WHERE sub_id = '$sub_id' ";
        $get_res = mysqli_query($conn,$get_some_more);
        if($get_res)
            {

                $return_data=array();
                while($row=mysqli_fetch_assoc($get_res))
                {
                    array_push($return_data,$row);
                }
                $random_id = array_rand($return_data,4);

                $return_array = array();
                for ($i=0;$i<count($random_id);$i++)
                {
                    array_push($return_array,$return_data[$random_id[$i]]);
                }
            }
        
        $row=mysqli_fetch_assoc($get_product_res);
        
        
        echo json_encode(array("status" => "SUCCESSFUL", "status_code" => 200, "message" => "Successfully retreived data from database", "data" => $row,"more"=>$return_array));
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

else
    {
        $get_products_query='SELECT *  FROM product WHERE product_id = '$product' ' ;
        $get_all_product_res=mysqli_query($conn,$get_products_query);
        if($get_product_res)
        {
            $return_data=array();
            while($row=mysqli_fetch_assoc($get_product_res))
            {
                array_push($return_data,$row);
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