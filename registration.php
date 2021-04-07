<!DOCTYPE html>
<?php 
    session_start();
?>
<html lang="en">
  <head>
    <title>Print Shop</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    
  </head>
  <body>
   <?php 
    include_once './stylelink.php';
  ?>
  <div class="site-wrap">
  <?php 
        include 'header.php';
        include './redirect.php';
        
        
    ?>
      <?php 
            if(isset($_POST['submit']))
            {
                    $_SESSION['fname']=$_REQUEST['r_fname'];
                    $_SESSION['lname']=$_REQUEST['r_lname'];
                    $_SESSION['email']=$_REQUEST['r_email'];
                    $_SESSION['contact']=$_REQUEST['r_contact'];
                    $_SESSION['address']=$_REQUEST['r_address'];
                    $_SESSION['pincode']=$_REQUEST['r_pincode'];
                    $_SESSION['gender']=$_REQUEST['r_gender'];
                    $_SESSION['role']=$_REQUEST['r_accounttype'];
                    $_SESSION['password']= md5($_REQUEST['r_password']);
                    
                    echo $_SESSION['email'];
                    include './connection.php';
                    
                $selectquery="SELECT count(user_id) as count FROM `tbl_user` WHERE email='".$_POST['r_email']."'";
                
                $result= mysqli_query($con, $selectquery);
                
                while ($row= mysqli_fetch_assoc($result))
                {
                    if($row['count']=='0')
                    {
                        echo "<script>window.location='otpmail.php'</script>";
                    } 
                    else 
                    {
                           echo "<script>alert('Already Registred')</script>";
                    }
                }   
                    
                    
                    
                    
                    /*$insertsql="INSERT INTO `tbl_user`(`user_id`, `firstname`, `lastname`, `gender`, `email`, `contactno`, `address`, `pincode`, `role`, `password`) VALUES "
                        . "(null,'".$fname."','".$lname."','".$gender."','".$email."','".$contact."','".$address."','".$pincode."','".$role."','".$password."')";

                        $query= mysqli_query($con, $insertsql);

                        if($query)
                        {
                            echo 'inserted';
                        }
                        else
                        {
                            echo 'not inserted';
                        }
                     */
                     
            }
      ?>

    <div class="bg-light py-3">
      <div class="container">
        <div class="row">
          <div class="col-md-12 mb-0"><a href="index.html">Home</a> <span class="mx-2 mb-0">/</span> <strong class="text-black">Registration</strong></div>
        </div>
      </div>
    </div>  

    <div class="site-section">
      <div class="container">
        <div class="row">
          <div class="col-md-12">
            <h2 class="h3 mb-3 text-black">Registration</h2>
          </div>
          <div class="col-md-7">

              <form action="#" onsubmit="return checkpassword()" method="post">
              
              <div class="p-3 p-lg-5 border">
                <div class="form-group row">
                  <div class="col-md-6">
                    <label for="r_fname" class="text-black">First Name <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="c_fname" name="r_fname" required="">
                  </div>
                  <div class="col-md-6">
                    <label for="r_lname" class="text-black">Last Name <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="c_lname" name="r_lname" required="">
                  </div>
                </div>
                <div class="form-group row">
                  <div class="col-md-12">
                    <label for="r_email" class="text-black">Email <span class="text-danger">*</span></label>
                    <input type="email" class="form-control" id="c_email" name="r_email" placeholder="" required="">
                  </div>
                </div>
                <div class="form-group row">
                  <div class="col-md-12">
                    <label for="r_contact" class="text-black">Contact </label>
                    <input type="text" class="form-control" id="c_subject" name="r_contact" required="" pattern="[0-9]{10,10}">
                  </div>
                </div>

                <div class="form-group row">
                  <div class="col-md-12">
                    <label for="r_address" class="text-black">Address </label>
                    <textarea name="r_address" id="c_message" cols="30" rows="5" class="form-control" required=""></textarea>
                  </div>
                </div>

                <div class="form-group row">
                  <div class="col-md-12">
                    <label for="r_pincode" class="text-black">Pincode </label>
                    <input type="text" class="form-control" id="c_subject" name="r_pincode" required="" pattern="[0-9]{6,6}">
                  </div>
                </div>


                <div class="form-group">
                  <label class="text-black">Gender</label>
                  <select class="form-control" name="r_gender" required="">
                    <option selected disabled>Select one</option>
                    <option>Male</option>
                    <option>Female</option>
                  </select>
                </div>  

                <div class="form-group">
                  <label class="text-black">Account Type</label>
                  <select class="form-control" name="r_accounttype" required="">
                      <option selected disabled>Select one</option>
                      <option value="C">Customer</option>
                      <option value="D">Designer</option>
                  </select>
                </div> 
                  
                <div class="form-group row">
                  <div class="col-md-12">
                    <label for="r_password" class="text-black">Password </label>
                    <input type="password" class="form-control" id="r_password" name="r_password" required="">
                  </div>
                </div>
                 
                <div class="form-group row">
                  <div class="col-md-12">
                    <label for="r_cpassword" class="text-black">ReType Password </label>
                    <input type="password" class="form-control" id="r_cpassword" name="r_cpassword" required="">
                  </div>
                </div>
                  
                <div class="form-group row">
                  <div class="col-lg-12">
                      <input type="submit" class="btn btn-info btn-lg btn-block" value="Registration" name="submit">
                  </div>
                </div>
              </div>
            </form>
          </div>
          <div class="col-md-5 ml-auto">
            <div class="p-4 border mb-3">
                <div class="block-38 text-center">
                <div class="block-38-img">
                  <div class="block-38-header">
                    <img src="images/team3.jpg" alt="Image placeholder" class="mb-4">
                    <h3 class="block-38-heading h4"><a href="login.php">Already Registred User</a></h3>
                  </div>
                </div>
              </div>
          </div>
        </div>
      </div>
    </div>
  </div>

      <script>
      
        function checkpassword()
        {
            var password=document.getElementById('r_password').value;
            var cpassword=document.getElementById('r_cpassword').value;
            
            if(password!=cpassword)
            {
                alert('password not matched');
                return false;
            }
            else
            {
                return true;
            }
        }
      
      </script> 
   <?php 
    include 'footer.php';
   ?>
  </div>

  <script src="js/jquery-3.3.1.min.js"></script>
  <script src="js/jquery-ui.js"></script>
  <script src="js/popper.min.js"></script>
  <script src="js/bootstrap.min.js"></script>
  <script src="js/owl.carousel.min.js"></script>
  <script src="js/jquery.magnific-popup.min.js"></script>
  <script src="js/aos.js"></script>

  <script src="js/main.js"></script>
    
  </body>
</html>