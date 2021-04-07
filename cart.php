<!DOCTYPE html>
<html lang="en">
  <head>
    <title>PrintShop</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">    
    <link href="css/style.css" rel="stylesheet" type="text/css"/>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Mukta:300,400,700"> 
    <link rel="stylesheet" href="fonts/icomoon/style.css">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/magnific-popup.css">
    <link rel="stylesheet" href="css/jquery-ui.css">
    <link rel="stylesheet" href="css/owl.carousel.min.css">
    <link rel="stylesheet" href="css/owl.theme.default.min.css">
    <link rel="stylesheet" href="css/aos.css">

    <link rel="stylesheet" href="css/style.css">
  </head>
  <body>
  
  <div class="site-wrap">
    <?php 
         session_start();
         $sub=NULL;
         $total=0;
        include './connection.php';
        include './redirect.php';
        if (empty($_SESSION['emailid'])) {
            redirect("login.php");
        } else {
            include './userheader.php';
            $select="select user_id from tbl_user where email='".$_SESSION['emailid']."'";
            $result= mysqli_query($con, $select);
            $row= mysqli_fetch_assoc($result);
            $id=$row['user_id'];
            
            $select="select cart_id from tbl_cart where customerid='".$id."' and status='A'";
            $result= mysqli_query($con, $select);
            if(mysqli_num_rows($result)!=0)
            {
                $row= mysqli_fetch_assoc($result);
                $cid=$row['cart_id'];
            }
            else
            {
                $cid=NULL;
            }
        }
    ?>
      
     <?php 
     
        if(isset($_GET['op']))
        {
            $select="select printdetailsid from tbl_cartdetails where cd_id='".$_GET['cid']."'";
            $result= mysqli_query($con, $select);
            $row= mysqli_fetch_assoc($result);
            
             $delete="delete from tbl_cartdetails where cd_id='".$_GET['cid']."'";
            $result= mysqli_query($con, $delete);
            
            $deletequary="DELETE FROM `tbl_printdetails` WHERE print_id='".$row['printdetailsid']."'";
            $re=mysqli_query($con, $deletequary);
        }
     
     
     ?> 
    <div class="bg-light py-3">
      <div class="container">
        <div class="row">
          <div class="col-md-12 mb-0"><a href="index.html">Home</a> <span class="mx-2 mb-0">/</span> <strong class="text-black">Cart</strong></div>
        </div>
      </div>
    </div>

    <div class="site-section">
      <div class="container">
        <div class="row mb-5">
          <form class="col-md-12" method="post">
            <div class="site-blocks-table">
              <table class="table table-bordered ">
                <thead>
                  <tr>
                    <th class="product-thumbnail">Image</th>
                    <th class="product-name">Name</th>
                    <th class="product-price">Price</th>
                    <th>Nooflines</th>
                    <th class="product-quantity">Quantity</th>
                    <th class="product-total">Total</th>
                    <th>Update</th>
                    <th class="product-remove">Remove</th>
                  </tr>
                </thead>
                <tbody>
                    <?php
                    if($cid!=NULL)
                    {
                        $select="select tbl_design.*,tbl_cartdetails.quantity,tbl_cartdetails.totalprice,tbl_cartdetails.cd_id,tbl_printdetails.nooflines from tbl_design inner join tbl_cartdetails on tbl_design.design_id=tbl_cartdetails.designid inner join tbl_printdetails on tbl_printdetails.print_id=tbl_cartdetails.printdetailsid inner join tbl_cart on tbl_cart.cart_id=tbl_cartdetails.cartid where cart_id='".$cid."'";
                        $result= mysqli_query($con, $select);
                        while ($row = mysqli_fetch_assoc($result)){
                    ?>
                  <tr>
                    <td class="">
                        <?php 
                            $imagearr= explode(',', $row['designimage']);
                            foreach ($imagearr as $val)
                                {
                                if(!preg_match('/back/', $val))
                                {
                        ?>
                        <img src="Adminpanel/<?php echo $val; ?>" alt="Image" class="img-fluid">
                        <?php 
                                }
                                }
                        ?>
                    </td>
                    <td class="">
                        <h2 class="h5 text-black"><?php echo $row['designname']; ?></h2>
                    </td>
                    <td>Rs.<?php echo $row['price'];?></td>
                    <?php 
                     if($row['nooflines']!=null)
                     {
                     ?>
                    <td>
                      <div class="input-group mb-3" style="width:auto;">
                        <div class="input-group-prepend">
                          <button class="btn btn-outline-primary" type="button" onclick="minus('lines','<?php echo $row['cd_id']?>')">&minus;</button>
                        </div>
                          <input type="text" class="form-control text-center" value="<?php echo $row['nooflines'];?>" id="lines<?php echo $row['cd_id'];?>" placeholder="" aria-label="Example text with button addon" aria-describedby="button-addon1">
                        <div class="input-group-append">
                          <button class="btn btn-outline-primary" type="button" onclick="plus('lines','<?php echo $row['cd_id']?>')">&plus;</button>
                        </div>
                      </div>

                    </td>
                    <?php
                       }
                       else
                       {
                           echo "<td></td>";
                       }
                    ?>
                    
                    <td>
                      <div class="input-group mb-3" style="max-width: available;">
                        <div class="input-group-prepend">
                          <button class="btn btn-outline-primary" type="button" onclick="minus('quantity','<?php echo $row['cd_id']?>')">&minus;</button>
                        </div>
                          <input type="text" class="form-control text-center" value="<?php echo $row['quantity'];?>" id="quantity<?php echo $row['cd_id'];?>" placeholder="" aria-label="Example text with button addon" aria-describedby="button-addon1">
                        <div class="input-group-append">
                          <button class="btn btn-outline-primary" type="button" onclick="plus('quantity','<?php echo $row['cd_id']?>')">&plus;</button>
                        </div>
                      </div>

                    </td>
                    <td>Rs.<?php 
                        $sub[$row['designname']]=$row['totalprice'];
                    echo $row['totalprice']; ?></td>
                    <?php if($row['nooflines']!=NULL)
                    {?>
                    <td><button class="btn btn-info" onclick="line('<?php echo $row['cd_id'];?>')">Edit</button></td>
                    <?php
                    }else{
                        ?>
                    <td><button class="btn btn-info" onclick="update('<?php echo $row['cd_id'];?>')">Edit</button></td>
                    <?php
                    }
                    ?>
                    
                    <td><a href="cart.php?op=r&cid=<?php echo $row['cd_id']?>"><button type="button" class="btn btn-danger" name="remove">X</button></a></td>
                  </tr>
                 <?php }
                    }
                    else
                    { 
                        echo "NO ITEM IN CART";
                    }
?>
                </tbody>
              </table>
            </div>
          </form>
        </div>

        <div class="row">
          <div class="col-md-6">
            <div class="row mb-5">
              <div class="col-md-6">
                  <a href="designs.php"><button class="btn btn-outline-primary btn-sm btn-block">Continue Shopping</button></a>
              </div>
            </div>
          </div>
          <div class="col-md-6 pl-5">
            <div class="row justify-content-end">
              <div class="col-md-7">
                <div class="row">
                  <div class="col-md-12 text-right border-bottom mb-5">
                    <h3 class="text-black h4 text-uppercase">Cart Totals</h3>
                  </div>
                </div>
                  <?php
                  if($sub!=NULL)
                  {
                    foreach ($sub as $key => $value) {
                        $total=$total+$value;
                  ?>
                <div class="row mb-3">
                  <div class="col-md-6">
                      <span class="text-black"><?php echo $key; ?></span>
                  </div>
                  <div class="col-md-6 text-right">
                      <strong class="text-black">Rs<?php echo $value;?></strong>
                  </div>
                </div>
                 <?php 
                    }
                  }?>
                <div class="row mb-5">
                  <div class="col-md-6">
                    <span class="text-black">Total</span>
                  </div>
                  <div class="col-md-6 text-right">
                      <strong class="text-black">Rs<?php echo $total;?></strong>
                  </div>
                </div>

                <div class="row">
                  <div class="col-md-12">
                      <a href="checkout.php"><button class="btn btn-primary btn-lg py-3 btn-block">Proceed To Checkout</button></a>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <?php 
        include './footer.php';
    ?>
      <script src="js/jquery-3.3.1.min.js"></script>
  <script src="js/jquery-ui.js"></script>
  <script src="js/popper.min.js"></script>
  <script src="js/bootstrap.min.js"></script>
  <script src="js/owl.carousel.min.js"></script>
  <script src="js/jquery.magnific-popup.min.js"></script>
  <script src="js/aos.js"></script>

  <script src="js/main.js"></script>
  <script>
  function update(id)
    {
        var XMLHttp=new XMLHttpRequest();
        XMLHttp.open("POST","cartajax.php?cid="+id+"&quantity="+document.getElementById('quantity'+id).value,false);
        XMLHttp.send(null);
    }
  function line(id)
    {
        var XMLHttp=new XMLHttpRequest();
        XMLHttp.open("POST","cartajax.php?cid="+id+"&quantity="+document.getElementById('quantity'+id).value+"&lines="+document.getElementById('lines'+id).value,false);
        XMLHttp.send(null);
    }   

    function plus(type,id)
    {
        var value=parseInt(document.getElementById(type+id).value);
        value++;
        document.getElementById(type+id).value=value;
    }
    function minus(type,id)
    {
        var value=parseInt(document.getElementById(type+id).value);
        if(value>1)
        value--;
        else
        value=1;    
        document.getElementById(type+id).value=value;
    }
    
    </script>
  </div>
    
  </body>
</html>