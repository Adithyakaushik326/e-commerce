
<?php
session_start();
if($_POST['STATUS']=='TXN_SUCCESS')
{
    $_SESSION['success']=1;
    header('location:invoice.html');
}
else{
    header('location:cart.php');
}
?>