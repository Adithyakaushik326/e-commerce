<?php
	session_start();
	
	header("Pragma: no-cache");
	header("Cache-Control: no-cache");
	header("Expires: 0");
	require_once("lib/config_paytm.php");
	require_once("lib/encdec_paytm.php");
	$checkSum = "";
	$user_email = 'adithyakaushik326@gmail';
	$user_name = 'adi';
	$paramList = array();
	$INDUSTRY_TYPE_ID = "Retail";
	//$CHANNEL_ID = $_POST["CHANNEL_ID"];
	$CHANNEL_ID = "WEB";
	//$TXN_AMOUNT = $_POST["TXN_AMOUNT"];
	$TXN_AMOUNT = $_POST['price'];
	// Create an array having all required parameters for creating checksum.
	$paramList["MID"] = PAYTM_MERCHANT_MID;
	// $paramList["ORDER_ID"] = $ORDER_ID;
	// $paramList["CUST_ID"] = $CUST_ID;
	$unique_id = time() . mt_rand();
	

	$date = date('Y-m-d H:i:s');
	$oid = $unique_id;
	$paramList["ORDER_ID"] = $oid;
	$paramList["CUST_ID"] = $unique_id;
	$paramList["INDUSTRY_TYPE_ID"] = $INDUSTRY_TYPE_ID;
	$paramList["CHANNEL_ID"] = $CHANNEL_ID;
	$paramList["TXN_AMOUNT"] = $TXN_AMOUNT;
	$paramList["WEBSITE"] = PAYTM_MERCHANT_WEBSITE;
	$paramList["CALLBACK_URL"] = "http://localhost:8099/website/callback.php";
	$paramList["EMAIL"] = $user_email;
	/*
	$paramList["CALLBACK_URL"] = "http://localhost/PaytmKit/pgResponse.php";
	$paramList["MSISDN"] = $MSISDN; //Mobile number of customer
	$paramList["EMAIL"] = $EMAIL; //Email ID of customer
	$paramList["VERIFIED_BY"] = "EMAIL"; //
	$paramList["IS_USER_VERIFIED"] = "YES"; //
	*/
	//Here checksum string will return by getChecksumFromArray() function.
	$checkSum = getChecksumFromArray($paramList,PAYTM_MERCHANT_KEY);

	// $conn = mysqli_connect('localhost','root', '', 'flights2');
	// $query = "INSERT INTO transaction(user_id, amount, order_id, `date`) VALUES ('$uid', '$TXN_AMOUNT', '$oid', '$date')";
	// mysqli_query($conn, $query);
?>
<html>
<head>
<title>Merchant Check Out Page</title>
</head>
<body>
	<center><h1>Please do not refresh this page...</h1></center>
		<form method="post" action="<?php echo PAYTM_TXN_URL ?>" name="f1">
		<table border="1">
			<tbody>
			<?php
			foreach($paramList as $name => $value) {
				echo '<input type="hidden" name="' . $name .'" value="' . $value . '">';
			}
			?>
			<input type="hidden" name="CHECKSUMHASH" value="<?php echo $checkSum ?>">
			</tbody>
		</table>
		<script type="text/javascript">
			document.f1.submit();
		</script>
	</form>
</body>
</html>