<?php
    require_once '../db_connection.php';
    
    try
    {
        session_start();
        if(!$conn){
            echo  json_encode(array("status" => "UNSUCCESSFUL", "message" => "Error connecting to database", "status_code" => 201));
            return;
        } 
    
        if(isset($_SESSION['success']))
        {
        $user = $_POST['user'];
        $price = $_POST['price'];
        $date= date("d-m-Y h:i:sa ");
        $get_user_id_query = "SELECT * FROM user WHERE email = '$user'";
        $get_user_id = mysqli_query($conn,$get_user_id_query);
        if($get_user_id)
        {
            $user_id = mysqli_fetch_assoc($get_user_id);
            $user_id = $user_id['user_id'];
            $add_order_query = "INSERT INTO orders(`date`,`user_id`,price) VALUES ('$date','$user_id','$price')" ;
            $add_order=mysqli_query($conn,$add_order_query);
            if($add_order)
            {
                $get_order_id_query = "SELECT order_id FROM orders WHERE `date` = '$date' AND `user_id`= '$user_id' AND price = '$price'";
                $get_order_id = mysqli_query($conn,$get_order_id_query);
                if($get_order_id)
                {
                    $order_id = mysqli_fetch_assoc($get_order_id);
                    $order_id=$order_id['order_id'];
                    $get_cart_query = "SELECT c.product_id , c.quantity,p.price FROM cart c , product p WHERE c.user_email = '$user' AND c.deleted = 0 AND p.product_id = c.product_id";
                    $get_cart = mysqli_query($conn,$get_cart_query);
                    if($get_cart)
                    {
                        while($row=mysqli_fetch_array($get_cart))
                        {
                            
                            $product_id = $row['product_id'];
                            $pr = $row['price'];
                            $quant = $row['quantity'];
                            $insert_op_query = "INSERT INTO order_product(product_id,quantity,order_id,price) VALUES ('$product_id','$quant','$order_id','$pr')";
                            $insert_op = mysqli_query($conn,$insert_op_query);
                            $get_product_quant ="SELECT quantity FROM product WHERE product_id = '$product_id'";
                            $get_product = mysqli_query($conn,$get_product_quant);
                            if($get_product)
                            {
                                echo "hello";
                                $p_quant = mysqli_fetch_assoc($get_product);
                                $p_quant = $p_quant['quantity'];
                                $final_quant = $p_quant - $quant;
                                echo $final_quant; 
                                $update_product_query  = "UPDATE product SET quantity = $final_quant WHERE product_id = '$product_id'";
                                $update_product = mysqli_query($conn,$update_product_query);
                                if($update_product)
                                {
                                    echo "succeess";
                                    
                                }
                            } 
                         
                          
                        }
                        $update_cart_query= "UPDATE cart SET deleted = 1 WHERE user_email = '$user'";
                        $update_cart = mysqli_query($conn,$update_cart_query);
                        if($update_cart)
                        {
                            unset($_SESSION['success']);
                            echo json_encode(array("status" => "SUCCESSFUL", "status_code" => 200, "message" => "Successfully placed order"));
                            exit();
                        } 
                    }     
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