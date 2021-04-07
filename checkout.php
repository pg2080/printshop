<!DOCTYPE html>
<html lang="en">
  <head>
    <title></title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    
  </head>
  <body>
  
  <div class="site-wrap">
    <?php 
        session_start();
        ob_start();
        include './connection.php';
        include './redirect.php';
        include './stylelink.php';
        if (empty($_SESSION['emailid'])) {
            redirect("login.php");
        } else {
            include './userheader.php';
        }
    ?>
    <?php
    $total=0;
            $select="select user_id from tbl_user where email='".$_SESSION['emailid']."'";
            $result= mysqli_query($con, $select);
            $row= mysqli_fetch_assoc($result);
            $id=$row['user_id'];
            
            $select="select tbl_design.*,tbl_cartdetails.quantity,totalprice,cd_id,tbl_printdetails.nooflines from tbl_design inner join tbl_cartdetails on tbl_design.design_id=tbl_cartdetails.designid inner join tbl_cart on tbl_cart.cart_id=tbl_cartdetails.cartid inner join tbl_printdetails on tbl_printdetails.print_id=tbl_cartdetails.printdetailsid where tbl_cart.customerid='".$id."' and tbl_cart.status='A'";
            $result= mysqli_query($con, $select);
    ?>

    <div class="bg-light py-3">
      <div class="container">
        <div class="row">
          <div class="col-md-12 mb-0"><a href="index.html">Home</a> <span class="mx-2 mb-0">/</span> <a href="cart.php">Cart</a> <span class="mx-2 mb-0">/</span> <strong class="text-black">Checkout</strong></div>
        </div>
      </div>
    </div>

    <?php 
        if(isset($_POST['placeorder']))
        {
            $address=$_POST['address'].' '.$_POST['nearby'].','.$_POST['city'].','.$_POST['pincode'];
            $selectquery="select cart_id from tbl_cart where customerid='".$id."' and status='A'";
            $result= mysqli_query($con, $selectquery);
            $r= mysqli_fetch_assoc($result);
            
            $selectquery="select count(*) as count from tbl_order where cartid='".$r['cart_id']."'";
            $resultset= mysqli_query($con, $selectquery);
            $r2= mysqli_fetch_assoc($resultset);
            if($r2['count']=='0')
            {
             $insertquery="INSERT INTO `tbl_order`(`order_id`, `cartid`, `orderaddress`, `totalamount`,paymenttype) VALUES (null,'".$r['cart_id']."','".$address."','".$_POST['total']."','".$_POST['payment']."')";
             $result= mysqli_query($con, $insertquery);
            }
            else
            {
                echo "error";
            }
            $updatequery="update tbl_cart set status='O' where cart_id='".$r['cart_id']."'";
            $result= mysqli_query($con, $updatequery);
            
            if($_POST['payment']=='onp')
            {
                header("Location:PayUMoney_form.php?id=".$r['cart_id']."");
                ob_end_flush();
            }
            else
            {
                echo "<script>window.location='thankyou.php'</script>";
            }
        }
    ?>
      
    <div class="site-section">
      <div class="container">
       <form action="#" method="post">
        <div class="row">
          <div class="col-md-6 mb-5 mb-md-0">
            <h2 class="h3 mb-3 text-black">Billing Details</h2>
            <div class="p-3 p-lg-5 border">
              <div class="form-group row">
                <div class="col-md-12">
                  <label for="c_address" class="text-black">Address <span class="text-danger">*</span></label>
                  <input type="text" class="form-control" id="c_address" name="address" placeholder="Street address" required="">
                </div>
              </div>
    
              <div class="form-group">
                  <input type="text" class="form-control" name="nearby" placeholder="Apartment, suite, unit etc. (optional)">
              </div>
    
              <div class="form-group row">
                <div class="col-md-6">
                  <label for="c_state_country" class="text-black">City<span class="text-danger">*</span></label>
                  <input type="text" class="form-control" id="c_state_country" name="city" required="">
                </div>
                <div class="col-md-6">
                  <label for="c_postal_zip" class="text-black">Pincode<span class="text-danger">*</span></label>
                  <input type="text" class="form-control" id="c_postal_zip" name="pincode" required="">
                </div>
              </div>
    
            </div>
          </div>
          <div class="col-md-6">
            <div class="row mb-5">
              <div class="col-md-12">
                <h2 class="h3 mb-3 text-black">Your Order</h2>
                <div class="p-3 p-lg-5 border">
                  <table class="table site-block-order-table mb-5">
                    <thead>
                      <th>Product x Quantity x Nooflines</th>
                      <th>Total</th>
                    </thead>
                    <tbody>
                        <?php
                          while ($row = mysqli_fetch_assoc($result))
                          {
                              if($row['nooflines']!=NULL)
                              {
                        ?>
                      <tr>
                          <td><?php echo $row['designname'];?> <strong class="mx-2">x</strong><?php echo $row['quantity'];?><strong class="mx-2">x</strong><?php echo $row['nooflines'];?></td>
                              <?php }
                              else
                              {?>
                          <td><?php echo $row['designname'];?> <strong class="mx-2">x</strong><?php echo $row['quantity'];?></td>
                              <?php }?>
                          <td>Rs.<?php
                            $total=$total+$row['totalprice'];
                          echo $row['totalprice'];?></td>
                      </tr>
                      <?php 
                          }?>
                      <tr>
                        <td class="text-black font-weight-bold"><strong>Cart Subtotal</strong></td>
                        <td class="text-black">Rs.<?php echo $total;?></td>
                      </tr>
                      <tr>
                        <td class="text-black font-weight-bold"><strong>Order Total</strong></td>
                        <td class="text-black font-weight-bold"><strong>Rs.<?php echo $total?></strong></td>
                      </tr>
                    </tbody>
                  </table>

                  <div class="border mb-5">
                      <select class="form-control" name="payment">
                          <option value="cod">Cash On Delivery</option>
                          <option value="onp">Online Payment</option>
                      </select>
                  </div>  
                    <input type="hidden" value="<?php echo $total;?>" name="total">
                  <div class="form-group">
                      <button class="btn btn-primary btn-lg py-3 btn-block" type="submit" name="placeorder">Place Order</button>
                  </div>

                </div>
              </div>
            </div>

          </div>
        </div>
     </form>
        <!-- </form> -->
      </div>
    </div>

    <?php
        include './footer.php';
    ?>
  </div>
    
  </body>
</html>