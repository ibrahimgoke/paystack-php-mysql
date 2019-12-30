 <?php
  if (isset($_POST['submit'])) {
  $name = $_POST['name'];
  $email =$_POST['email'];
  $amount = $_POST['amount'];
}
                           
?>
<!DOCTYPE html>
<html>
<head>
  <title>Confrim Payment</title>
</head>
<body>

<script src="https://js.paystack.co/v1/inline.js"></script>

  Name: <input readonly type="text" value="<?php echo $name ?>"> <br><br>
  Email: <input readonly type="email" value="<?php echo $email ?>"><br><br>
  Amount: <input readonly type="text" value="<?php echo $amount ?>"><br><br>
  
<button type="submit" name="submit" onclick="payWithPaystack()" class="btn btn-success">Pay Now</button>


 <script>
  function payWithPaystack(){
      var email = "<?php echo $email; ?>";
      var amount = "<?php echo $amount; ?>00";
      var name = "<?php echo $name; ?>";
        
    var handler = PaystackPop.setup({
      key: 'pk_test_xxxxxxxxxx',
      email: email,
      display_name: name,
      amount: amount,
      ref: ''+Math.floor((Math.random() * 1000000000) + 1), // generates a pseudo-unique reference. Please replace with a reference you generated. Or remove the line entirely so our API will generate one for you
      metadata: {
         custom_fields: [
            {
                display_name: name,
            }
         ]
      },
      callback: function(response){
          var queryString = "?reference=" + response.reference + "&email=" + email;
          window.location.href = "http://localhost/paystack-php-mysql/payment-key.php" + queryString;
},
      onClose: function(){
          alert('Payment cancelled');
      }
    });
    handler.openIframe();
  }
</script>
</body>
</html>
