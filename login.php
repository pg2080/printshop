<!DOCTYPE html>
<html lang="en">
  <head>
    <title>PrintShop</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <body>
  
  <div class="site-wrap">
    <?php 
        session_start();
        include './stylelink.php';
        include './header.php';
        include './redirect.php';
    ?>
    <?php 
        
            if(isset($_POST['submit']))
            {
                include './connection.php';
                
                $email=$_POST['l_email'];
                $password=$_POST['l_password'];
                
                if($email=='admin@gmail.com' && $password=='admin')
                {
                    $_SESSION['emailid']=$email;
                    redirect("./Adminpanel/admindash.php");
                }
                else
                {
                    $selectquery="SELECT count(user_id) as count,role  FROM `tbl_user` WHERE email='".$email."' and password=md5('".$password."') and status='A'";

                    $result= mysqli_query($con, $selectquery);

                    $value= mysqli_fetch_object($result);


                        if ($value->count == 1) {

                            $_SESSION['emailid']=$_POST['l_email'];

                            echo $_SESSION['emailid'];
                            if($value->role=='C')
                                redirect ("index.php");
                            else
                                redirect ("index.php");
                            
                        } 
                        else 
                        {
                            echo "<script>alert('Wrong Email and Password')</script>";
                        }
                }
            }
    
    ?>

    <div class="bg-light py-3">
      <div class="container">
        <div class="row">
          <div class="col-md-12 mb-0"><a href="index.html">Home</a> <span class="mx-2 mb-0">/</span> <strong class="text-black">Login</strong></div>
        </div>
      </div>
    </div>  

    <div class="site-section">
      <div class="container">
        <div class="row">
          <div class="col-md-12">
            <h2 class="h3 mb-3 text-black">Login</h2>
          </div>
          <div class="col-md-7">

            <form action="#" method="post">
              
              <div class="p-3 p-lg-5 border">
                <div class="form-group row">
                  <div class="col-md-12">
                    <label for="l_email" class="text-black">Email <span class="text-danger">*</span></label>
                    <input type="email" class="form-control" id="c_email" name="l_email" placeholder="" required="">
                  </div>
                </div>
                <div class="form-group row">
                  <div class="col-md-12">
                    <label for="l_password" class="text-black">Password <span class="text-danger">*</span> </label>
                    <input type="Password" class="form-control" id="c_subject" name="l_password" required="">
                  </div>
                </div>
                <div class="form-group row">
                  <div class="col-lg-12">
                      <input type="submit" class="btn btn-lg text-white btn-block submitbutton" value="Login" name="submit">
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
                    <img src="images/team2.jpg" alt="Image placeholder" class="mb-4">
                    <h3 class="block-38-heading h4"><a href="registration.php">Create New Profile</a></h3>
                    <p class="block-38-subheading"><a href="forgotpassword.php">forgot password?</a></p>
                  </div>
                </div>
              </div>
            </div>
        </div>
      </div>
    </div>
  </div>

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