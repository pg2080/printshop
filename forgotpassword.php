<?php 
    session_start();
    include_once './stylelink.php';
  ?>
<html>
    <head>
        <meta charset="UTF-8">
        <title>PrintShop</title>
    </head>
    <body>
        <?php
            include './header.php';
            include './redirect.php';
        ?>
        <?php
            if(isset($_POST['submit']))
            {
                include './connection.php';
                $_SESSION['email']=$_POST['f_email'];
                
                $selectquery="select count(*) as count from tbl_user where email='".$_SESSION['email']."'";
                $result= mysqli_query($con, $selectquery);
                
                $row= mysqli_fetch_assoc($result);
                if($row['count']==1)
                {
                redirect("./otpmail.php?op=forgotpass");
                }
                else {
                    echo "<script>alert('email id not found')</script>";
                }
            }
            
        ?>
        
        <div class="bg-light py-3">
            <div class="container">
              <div class="row">
                  <div class="col-md-12 mb-0"><a href="index.php">Home</a> <span class="mx-2 mb-0">/</span> <strong class="text-black">Forgot Password</strong></div>
              </div>
            </div>
          </div>
        <div class="site-section">
            
            
      <!-- otp form start-->      
      <div class="container">
        <div class="row">
          
          <div class="offset-3"></div>
          <div class="col-md-6">
             <h2 class="h3 mb-3 text-black">Forgot Password</h2>
            <form action="#" method="post">
              <div class="p-3 p-lg-5 border">
                <div class="form-group row">
                  <div class="col-md-12">
                      <label for="otp" class="text-black">Enter Email id here<span class="text-danger">*</span></label>
                      <input type="text" class="form-control" id="f_email" name="f_email" placeholder="">
                  </div>
                </div>
                <div class="form-group row">
                  <div class="col-lg-12">
                      <input type="submit" class="btn btn-primary btn-lg btn-block" value="OK" name="submit">
                  </div>
                </div>
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
