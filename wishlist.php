<!DOCTYPE html>
<html lang="en">
  <head>
    <title>PrintShop</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  </head>
  <body>
  
  <div class="site-wrap">
    <?php
    session_start();
    include './stylelink.php';
    include './connection.php';
           if(empty($_SESSION['emailid']))
           {
               include 'header.php';
           }
           else
           {
               $select="select user_id from tbl_user where email='".$_SESSION['emailid']."'";
               $result= mysqli_query($con, $select);
               $row= mysqli_fetch_assoc($result);
               $id=$row['user_id'];
               include './userheader.php';
           }
      
    ?>
    <?php 
    if(isset($_GET['id']))
    {
        if(empty($_SESSION['emailid']))
        {
            echo "<script>window.location='login.php';</script>";
        }
        $select="select count(*) as count from tbl_wishlist where customerid='".$id."' and designid='".$_GET['id']."'";
        $result= mysqli_query($con, $select);
        $row = mysqli_fetch_assoc($result);
        
        if($row['count']=='0')
        {
            $insertquery="INSERT INTO `tbl_wishlist`(`wish_id`, `customerid`, `designid`)"
                    . " VALUES (null,'".$id."','".$_GET['id']."')";
            $result= mysqli_query($con, $insertquery);
        }
    }
    
    if(isset($_GET['op']))
    {
        $delete="delete from tbl_wishlist where wish_id='".$_GET['id']."'";
        $result= mysqli_query($con, $delete);
    } 
    ?>
    <?php
    
        $select="select tbl_design.*,wish_id from tbl_design inner join tbl_wishlist on tbl_wishlist.designid=tbl_design.design_id inner join tbl_user on tbl_user.user_id=tbl_wishlist.customerid where user_id='".$id."' order by insertdate desc";
        $result= mysqli_query($con, $select);
        ?>
      
      
    <div class="site-section block-3 site-blocks-2 bg-light">
      <div class="container">
        <div class="row justify-content-center">
          <div class="col-md-7 site-section-heading text-center pt-4">
            <h2>Your Favariots</h2>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12">
            <div class="nonloop-block-3 owl-carousel">
               <?php 
                while ($row= mysqli_fetch_assoc($result))
                {
               ?>   
                <div class="item">
                <div class="block-4 text-center">
                  <figure class="block-4-image">
                      <?php
                        $imagearr= explode(',', $row['designimage']);
                        foreach ($imagearr as $val)
                            {
                            if(!preg_match('/back/', $val))
                            {
                      ?>
                      <img src="Adminpanel/<?php echo $val;?>" alt="Image placeholder" class="img-fluid">
                      <?php
                      }
                      }?>
                  </figure>
                  <div class="block-4-text p-4">
                      <h3><a href=""><?php echo $row['designname'];?></a></h3>
                      <hr>
                      <p class="mb-0"><button class="btn btn-white"><a href="singledesign.php?id=<?php echo $row['design_id'];?>"><i class="text-info fas fa-eye"></i></a></button>&nbsp;<button class="btn btn-white"><a href="wishlist.php?id=<?php echo $row['wish_id'];?>&op=r"class="text-danger"><i class="fas fa-trash"></i></a></button></p>
                  </div>
                </div>
              </div>
              <?php }?>
            </div>
          </div>
        </div>
      </div>
    </div>

    <?php 
      include 'footer.php';
    ?>
  </div>    
  </body>
</html>