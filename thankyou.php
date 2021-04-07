<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Shoppers &mdash; Colorlib e-Commerce Template</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    
  </head>
  <body>
  
  <?php
            session_start();
            include './connection.php';
            include './stylelink.php';
           if(empty($_SESSION['emailid']))
           {
               include 'header.php';
           }
           else
           {
               include './userheader.php';
           }
           
            if(isset($_GET['id']))
            {
                $updatequery="update tbl_order set paymentstatus='D',paymentdate='".date('Y-m-d')."' where order_id='".$_GET['id']."'";
                $result= mysqli_query($con, $updatequery);
            }
        ?>    
  <div class="site-wrap">

    <div class="bg-light py-3">
      <div class="container">
        <div class="row">
          <div class="col-md-12 mb-0"><a href="index.html">Home</a> <span class="mx-2 mb-0">/</span> <strong class="text-black">ThankYou</strong></div>
        </div>
      </div>
    </div>  

    <div class="site-section">
      <div class="container">
        <div class="row">
          <div class="col-md-12 text-center">
            <span class="icon-check_circle display-3 text-success"></span>
            <h2 class="display-3 text-black">Thank you!</h2>
            <p class="lead mb-5">You order was successfuly completed.</p>
            <p><a href="designs.php" class="btn btn-sm btn-primary">Back to shop</a></p>
          </div>
        </div>
      </div>
    </div>

    <?php 
        include './footer.php';
    ?>  
  </div>    
  </body>
</html>