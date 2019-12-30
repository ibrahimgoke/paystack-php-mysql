<?php
// Include Database Configuration
include ("config.php");

// Get Payment Reference and other variables from confirm_payment.php page
$reference = $_GET['reference'];
$payer_email = $_GET['email'];
$date = date("m/d/y G.i:s", time());

$result = array();
//The parameter after verify/ is the transaction reference to be verified
$url = 'https://api.paystack.co/transaction/verify/'."$reference";

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt(
  $ch, CURLOPT_HTTPHEADER, [
    'Authorization: Bearer sk_test_xxxxxxxxxxxx']
);
$request = curl_exec($ch);
if(curl_error($ch)){
 echo 'error:' . curl_error($ch);
 }
curl_close($ch);

if ($request) {
  $result = json_decode($request, true);
}

if (array_key_exists('data', $result) && array_key_exists('status', $result['data']) && ($result['data']['status'] === 'success')) {
       
       // Update the database after successful payment
    $update_payment_status="UPDATE payment SET status='Paid' where email='$payer_email'";
   if(mysqli_query($conn, $update_payment_status)) {
   	echo "<script type=\"text/javascript\">
                        alert(\"Payment was successful.\");
                        window.location = \"index.html\"
                    </script>";
 }
}else{
	   	echo "<script type=\"text/javascript\">
                        alert(\"Payment was Unsuccessful.\");
                        window.location = \"index.html\"
                    </script>";
}
