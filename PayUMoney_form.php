 <?php 
    session_start();
    include './connection.php';
    include './stylelink.php';
    include './redirect.php';
    
           if(empty($_SESSION['emailid']))
           {
               include 'header.php';
           }
           else
           {
               include './userheader.php';
           }

$MERCHANT_KEY = "";
$SALT = "";
// Merchant Key and Salt as provided by Payu.

$PAYU_BASE_URL = "https://sandboxsecure.payu.in";		// For Sandbox Mode
//$PAYU_BASE_URL = "https://secure.payu.in";			// For Production Mode

$action = '';

$posted = array();
if(!empty($_POST)) {
    //print_r($_POST);
  foreach($_POST as $key => $value) {    
    $posted[$key] = $value; 
	
  }
}

$formError = 0;

if(empty($posted['txnid'])) {
  // Generate random transaction id
  $txnid = substr(hash('sha256', mt_rand() . microtime()), 0, 20);
} else {
  $txnid = $posted['txnid'];
}
$hash = '';
// Hash Sequence
$hashSequence = "key|txnid|amount|productinfo|firstname|email|udf1|udf2|udf3|udf4|udf5|udf6|udf7|udf8|udf9|udf10";
if(empty($posted['hash']) && sizeof($posted) > 0) {
  if(
          empty($posted['key'])
          || empty($posted['txnid'])
          || empty($posted['amount'])
          || empty($posted['firstname'])
          || empty($posted['email'])
          || empty($posted['phone'])
          || empty($posted['productinfo'])
          || empty($posted['surl'])
          || empty($posted['furl'])
		  || empty($posted['service_provider'])
  ) {
    $formError = 1;
  } else {
    //$posted['productinfo'] = json_encode(json_decode('[{"name":"tutionfee","description":"","value":"500","isRequired":"false"},{"name":"developmentfee","description":"monthly tution fee","value":"1500","isRequired":"false"}]'));
	$hashVarsSeq = explode('|', $hashSequence);
    $hash_string = '';	
	foreach($hashVarsSeq as $hash_var) {
      $hash_string .= isset($posted[$hash_var]) ? $posted[$hash_var] : '';
      $hash_string .= '|';
    }

    $hash_string .= $SALT;


    $hash = strtolower(hash('sha512', $hash_string));
    $action = $PAYU_BASE_URL . '/_payment';
  }
} elseif(!empty($posted['hash'])) {
  $hash = $posted['hash'];
  $action = $PAYU_BASE_URL . '/_payment';
}
?>
<html>
  <head>
  <script>
    var hash = '<?php echo $hash ?>';
    function submitPayuForm() {
      if(hash == '') {
        return;
      }
      var payuForm = document.forms.payuForm;
      payuForm.submit();
    }
  </script>
  </head>
   
  <!--payment amount details get-->
    <?php
    if(isset($_GET['type']))
    {
        $updatequery="update tbl_cart set status='A' where cart_id='".$_GET['id']."'";
        $result= mysqli_query($con, $updatequery);
        
        $delete="delete from tbl_order where cartid='".$_GET['id']."'";
        $result= mysqli_query($con, $delete);
        
        echo "<script>window.location='checkout.php'</script>";
    }
    else if(isset ($_GET['id']))
    {
     $selectquery="select order_id,totalamount,firstname,email,contactno from tbl_order inner join tbl_cart on tbl_order.cartid=tbl_cart.cart_id inner join tbl_user on tbl_cart.customerid=tbl_user.user_id where cartid ='".$_GET['id']."'";
     $result= mysqli_query($con, $selectquery);
     $row = mysqli_fetch_assoc($result);
    }
    else
    {
        echo "<script>window.location='design.php'</script>";
    }
    ?>
  <!--payment amount details get-->
  
  
  
  
  
  <body onload="submitPayuForm()">
      <div class="bg-light py-3">
      <div class="container">
        <div class="row">
          <div class="col-md-12 mb-0"><a href="index.php">Home</a> <span class="mx-2 mb-0">/</span> <strong
              class="text-black">PayUMoney</strong></div>
        </div>
      </div>
    </div>
    <br/>
    <?php if($formError) { ?>
      <span style="color:red">Please fill all mandatory fields.</span>
      <br/>
      <br/>
    <?php } ?>
      <div class="card-body">
          <a href="PayUMoney_form.php?type=b&id=<?php echo $_GET['id'];?>"><button class="btn btn-warning">Back</button></a>
    <form action="<?php echo $action; ?>" method="post" name="payuForm">
            
      <input type="hidden" name="key" value="<?php echo $MERCHANT_KEY ?>" />
      <input type="hidden" name="hash" value="<?php echo $hash ?>"/>
      <input type="hidden" name="txnid" value="<?php echo $txnid ?>" />
      <div class="row">
          <div class="offset-3"></div>
          <div class="col-md-6 mb-5 mb-md-0">
              <center><img src="images/payumoney.png" alt=""/></center>
              <hr>
            <div class="p-3 p-lg-5 border">
              <div class="form-group row">
                <div class="col-md-12">
                  <label for="c_address" class="text-black">Amount <span class="text-danger">*</span></label>
                  <input type="text" readonly="" name="amount" class="form-control" id="c_address" value="<?php echo (empty($posted['amount'])) ? $row['totalamount'] : $posted['amount'] ?>" required="">
                </div>
              </div>
              <div class="form-group row">
                <div class="col-md-6">
                  <label for="c_state_country" class="text-black">Name<span class="text-danger">*</span></label>
                  <input type="text" class="form-control" id="firstname" name="firstname" required="" value="<?php echo (empty($posted['firstname'])) ? $row['firstname'] : $posted['firstname']; ?>" >
                </div>
                <div class="col-md-6">
                  <label for="c_postal_zip" class="text-black">Phone NO<span class="text-danger">*</span></label>
                  <input type="text" class="form-control" name="phone" value="<?php echo (empty($posted['phone'])) ? $row['contactno'] : $posted['phone']; ?>" required="">
                </div>
              </div>  
              <div class="form-group row">
                <div class="col-md-12">
                  <label for="c_address" class="text-black">Email <span class="text-danger">*</span></label>
                  <input name="email" id="email" class="form-control" value="<?php echo (empty($posted['email'])) ? $row['email'] : $posted['email']; ?>" required="">
                </div>
              </div>
              <div class="form-group row">
                <div class="col-md-12">
                  <!--<label for="c_address" class="text-black">Product Info <span class="text-danger">*</span></label>-->
                    <input type="text" class="form-control" hidden="" name="productinfo" value="<?php echo (empty($posted['productinfo'])) ? 'IndiaPharma' : $posted['productinfo'] ?>" required="">
                </div>
              </div>
                <input type="hidden" name="surl" value="http://localhost/printshop/thankyou.php?id=<?php echo $row['order_id'];?>" size="64" />
                <input type="hidden" name="furl" value="http://localhost/printshop/fail.php" size="64" />
                <input type="hidden" name="service_provider" value="payu_paisa" size="64" />
                 <?php if(!$hash) { ?>
                <div class="form-group">
                      <button type="submit" name="submit" class="btn btn-success btn-lg btn-block">Pay</button>
                  </div>
                 <?php } ?>
            </div>
          </div>
        </div>
    </form>
      </div>
      <?php include './footer.php';?>
  </body>
</html>
