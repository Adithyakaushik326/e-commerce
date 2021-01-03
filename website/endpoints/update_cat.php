<?php
    require_once '../db_connection.php';
    
    try
    {
        if(!$conn){
            echo  json_encode(array("status" => "UNSUCCESSFUL", "message" => "Error connecting to database", "status_code" => 201));
            return;
        } 
        $type = $_POST['type'];
        if($type=='0')
        {
        $cat = $_POST['category'];
        $check_cat_query = "SELECT *FROM category WHERE `name` = '$cat'";
        $check_cat_res = mysqli_query($conn, $check_cat_query);
        if($check_cat_res){
            if(mysqli_num_rows($check_cat_res) > 0){
                echo json_encode(array("status" => "UNSUCCESSFUL", "message" => "Existing category", "status_code" => 202));
                return;
            }
            else{
                $query = "INSERT INTO category(`name`) VALUES ('$cat')";
                $res = mysqli_query($conn, $query);
                if($res){
                        echo json_encode(array("status" => "SUCCESSFUL", "message" => "Successfullly addded category", "status_code" => 200));
                        return;
                }
                }
        }
      
     }
     else if($type=='1')
     {
         $sub = $_POST['category'];
         $cat = $_POST['cat_id'];
         $check_cat_query = "SELECT *FROM subcategory WHERE `name` = '$sub'";
        $check_cat_res = mysqli_query($conn, $check_cat_query);
        if($check_cat_res){
            if(mysqli_num_rows($check_cat_res) > 0){
                echo json_encode(array("status" => "UNSUCCESSFUL", "message" => "Existing Sub category", "status_code" => 202));
                return;
            }
            else{
                $query = "INSERT INTO subcategory(`name`,cat_id) VALUES ('$sub','$cat')";
                $res = mysqli_query($conn, $query);
                if($res){
                        echo json_encode(array("status" => "SUCCESSFUL", "message" => "Successfullly added sub category", "status_code" => 200));
                        return;
                }
                }
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