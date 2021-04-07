<!DOCTYPE html>
<html lang="en">
  <head>
    <title>PrintShop</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  </head>
  <body>
  
    <div class="site-wrap"">
    <header class="site-navbar" role="banner">
      <div class="site-navbar-top">
        <div class="container" >
          <div class="row align-items-center">

            <div class="col-6 col-md-4 order-2 order-md-1 site-search-icon text-left">
              <form action="" class="site-block-top-search">
                <span class="icon icon-search2"></span>
                <input type="text" class="form-control border-0" placeholder="Search">
              </form>
            </div>

            <div class="col-12 mb-3 mb-md-0 col-md-4 order-1 order-md-2 text-center">
              <div class="site-logo">
                <a href="index.php" class="js-logo-clone">PRINT SHOP</a>
              </div>
            </div>

            <div class="col-6 col-md-4 order-3 order-md-3 text-right">
              <div class="site-top-icons">
                <ul>
                    <li> <span style="font-family: fantasy; font-size: 14px;"><?php echo $_SESSION['emailid'];?></span><a href="userpanel/customerdash.php"><span class="icon icon-person"></span></a></li>
                  <?php
                    $selectquery="select user_id,role from tbl_user where email='".$_SESSION['emailid']."'";
                    $result= mysqli_query($con, $selectquery);
                    $row= mysqli_fetch_assoc($result);
                    
                    if($row['role']=='C')
                    {
                  ?>
                    
                    <li><a href="wishlist.php"><span class="icon icon-heart-o"></span></a></li>
                  <li>
                    <a href="cart.php"class="site-cart">
                      <span class="icon icon-shopping_cart"></span>
                      <?php 
                        
                        $selectquery="select count(cd_id) as count from tbl_cartdetails inner join tbl_cart on tbl_cart.cart_id=tbl_cartdetails.cartid inner join tbl_user on tbl_user.user_id=tbl_cart.customerid where tbl_cart.status='A' and customerid='".$row['user_id']."'";
                        $result= mysqli_query($con, $selectquery);
                        $r1= mysqli_fetch_assoc($result);
                        if($r1['count']!='0')
                        {
                      ?>
                      <span class="count"><?php echo $r1['count'];?></span>
                      <?php 
                        }?>
                    </a>
                  </li> 
                  <?php
                    }
                  ?>
                  <li class="d-inline-block d-md-none ml-md-0"><a href="#" class="site-menu-toggle js-menu-toggle"><span class="icon-menu"></span></a></li>
                </ul>
              </div> 
            </div>

          </div>
        </div>
      </div> 
      <nav class="site-navigation text-right text-md-center" role="navigation">
        <div class="container">
          <ul class="site-menu js-clone-nav d-none d-md-block">
            <li class="active">
                <a href="index.php">Home</a>
            </li>
            <li class="">
                <a href="./about.php">About</a>
            </li>
            
            <?php 
                if($row['role']=='C')
                {
            ?>
            <li><a href="./designs.php">Designs</a></li>
            <li><a href="./userpanel/customerdash.php">My Profile</a></li>
            <?php
                }
                else
                {?>
            <li><a href="./userpanel/designerdash.php">My Profile</a></li>
            <?php 
                }?>
            <li><a href="./contact.php">Contact us</a></li>
            <li><a href="./logout.php">Logout</a></li>
          </ul>
        </div>
      </nav>
    </header>
  </div>
  </body>
</html>