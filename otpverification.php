<?php 
    session_start();
    include './stylelink.php';
?>
<html>
    <head>
        <meta charset="UTF-8">
        <title>PrintShop</title>
    </head>
    <body>
        <?php
            include './header.php';
        ?>
        <?php
            if(isset($_POST['submit']))
            {
                include './connection.php';
                
                 $otp=$_REQUEST['otp'];
                 
                 if($otp==$_SESSION['otp'])
                 {
                        echo 'VERIFIED';
                       
                        if($_SESSION['role']=="D")
                        {
                            echo 'designer';
                            $_SESSION['role']='R';
                            $status='N';
                        }
                        else
                        {
                            echo 'customer';
                            $status='A';
                        }
                        
                        $insertsql="INSERT INTO `tbl_user`(`user_id`, `firstname`, `lastname`, `gender`, `email`, `contactno`, `address`, `pincode`, `role`, `password`, status) VALUES "
                        . "(null,'".$_SESSION['fname']."','".$_SESSION['lname']."','".$_SESSION['gender']."','".$_SESSION['email']."','".$_SESSION['contact']."','".$_SESSION['address']."','".$_SESSION['pincode']."','".$_SESSION['role']."','".$_SESSION['password']."','".$status."')";

                        $query= mysqli_query($con, $insertsql);

                        if($query)
                        {
                            unset($_SESSION['fname']);
                            unset($_SESSION['lname']);
                            unset($_SESSION['gender']);
                            unset($_SESSION['email']);
                            unset($_SESSION['contact']);
                            unset($_SESSION['address']);
                            unset($_SESSION['pincode']);
                            unset($_SESSION['role']);
                            unset($_SESSION['password']);
                            unset($_SESSION['otp']);
                            
                            session_destroy();
                            echo 'inserted';
                        }
                        else
                        {
                            echo mysqli_error($query);
                        }
                 }
                 else
                 {
                     echo 'WRONG OTP';
                 }
            }
            
        ?>
        
        <div class="bg-light py-3">
            <div class="container">
              <div class="row">
                  <div class="col-md-12 mb-0"><a href="index.php">Home</a> <span class="mx-2 mb-0">/</span> <strong class="text-black">OTP Verification</strong></div>
              </div>
            </div>
          </div>
        <div class="site-section">
            
            
      <!-- otp form start-->      
      <div class="container">
        <div class="row">
          
          <div class="offset-3"></div>
          <div class="col-md-6">
             <h2 class="h3 mb-3 text-black">OTP VERIFICATION</h2>
            <form action="#" method="post">
              <div class="p-3 p-lg-5 border">
                <div class="form-group row">
                  <div class="col-md-12">
                    <label for="otp" class="text-black">Enter Your OTP here<span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="otp" name="otp" placeholder="">
                  </div>
                </div>
                <div class="form-group row">
                  <div class="col-lg-12">
                      <input type="submit" class="btn btn-primary btn-lg btn-block" value="OK" name="submit">
                  </div>
                </div>
                  <h3 class="block-38-heading h4"><a href="otpmail.php">Resend OTP?</a></h3>  
              </div>
            </form>
          </div>
             </div>
      </div>
    </div>
        <!-- otp form end-->
        
        
        <?php 
             include './footer.php';
             ?>
    </body>
</html>
