<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <?php
        session_start();
        include './connection.php';
        include './stylelink.php';
        include './redirect.php';
        if (empty($_SESSION['emailid'])) {
            include 'header.php';
        } else {
            include './userheader.php';
        }
        $details=array();
        ?>

        <?php
        if (isset($_GET['data'])) {
            
            $pd=array('name'=>'','pname'=>'','cname'=>'','designation'=>'','line1'=>'','line2'=>'','line3'=>'','line4'=>'','logo'=>'','id'=>'');
            $details = unserialize($_GET['data']);
            
            $pd['name']=$details['name'];
            $pd['pname']=$details['pname'];
            $pd['cname']=$details['cname'];
            $pd['designation']=$details['designation'];
            $pd['line1']=$details['line1'];
            $pd['line2']=$details['line2'];
            $pd['line3']=$details['line3'];
            $pd['line4']=$details['line4'];
            $pd['logo']=$details['logo'];
            $pd['id']=$details['id'];

            $selectquery="select * from tbl_design where design_id='".$pd['id']."'";
            $result= mysqli_query($con, $selectquery);
            $row= mysqli_fetch_assoc($result);
        ?>
                                <?php 
                                    if(isset($_POST['addtocart']))
                                    {
                                        if(!isset($_SESSION['emailid']))
                                        {
                                            redirect("login.php");
                                        }
                                        else
                                        {
                                             $select="select user_id from tbl_user where email='".$_SESSION['emailid']."'";
                                             $result= mysqli_query($con, $select);
                                             $id= mysqli_fetch_assoc($result);
                                        }
                                        
                                        
                                        $string= implode(",", $pd);
                                        $select="select count(cart_id) as count,cart_id from tbl_cart where status='A' and customerid='".$id['user_id']."'";
                                        $result= mysqli_query($con, $select);
                                        $rset1= mysqli_fetch_assoc($result);
                                        
                                        if($rset1['count']=='0')
                                        {
                                           $insertsql=" INSERT INTO `tbl_cart`(`cart_id`, `customerid`) VALUES (null,'".$id['user_id']."')";
                                           $result= mysqli_query($con, $insertsql);
                                        }
                                        $result= mysqli_query($con, $select);
                                        $rset1= mysqli_fetch_assoc($result);
                                             $select="select count(print_id)as count,print_id from tbl_printdetails where ordername='".$pd['pname']."'";
                                             $sult= mysqli_query($con, $select);
                                             $rset2= mysqli_fetch_assoc($sult);
                                            
                                             if($rset2['count']=='0')
                                             {
                                                $insertsql="INSERT INTO `tbl_printdetails`(`print_id`, `ordername`, `details`, `logoimage`,lamination,cornor) "
                                                . "VALUES (null,'".$pd['pname']."','".$string."','".$pd['logo']."','".$_POST['lamination']."','".$_POST['cornor']."')";
                                                $result= mysqli_query($con, $insertsql);
                                                
                                                $sult= mysqli_query($con, $select);
                                                 $rset2= mysqli_fetch_assoc($sult);
                                                
                                                $insertsql="INSERT INTO `tbl_cartdetails`(`cd_id`, `designid`, `cartid`, `quantity`, `totalprice`, `printdetailsid`) "
                                                        . "VALUES (null,'".$row['design_id']."','".$rset1['cart_id']."','".$_POST['quantity']."','".$_POST['quantity']*$row['price']."','".$rset2['print_id']."')";
                                                $result= mysqli_query($con, $insertsql);
                                                redirect("cart.php");
                                             }
                                             else
                                             {
                                                 echo "<script>alert('Already Exists')</script>";
                                             }
                                        
                                    }
                                    
                                    if(isset($_POST['change']))
                                    {
                                        $data= serialize($pd);
                                        redirect("addprintdetails.php?data=$data");
                                    }
                                ?>
        <div class="site-wrap">

            <div class="bg-light py-3">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12 mb-0"><a href="index.html">Home</a> <span class="mx-2 mb-0">/</span> <strong class="text-black">View Details</strong></div>
                    </div>
                </div>
            </div>  

            <div class="site-section">
                <div class="container">
                    <h3>Print Details</h3>
                    <div class="row">
                        <div class="col-md-4">
                            <?php
                                 $imagearr = explode(',', $row['designimage']);
                                        foreach ($imagearr as $val) {
                            ?>
                            <img src="Adminpanel/<?php echo $val;?>" class="img-thumbnail img-responsive">
                            <?php
                                        }
                            ?>
                            
                        </div>
                        <div class="well col-md-4 text-dark">
                                    <p><strong>Name: </strong><?php echo $pd['name']; ?></p>
                                    <p><strong>Designation: </strong><?php echo $pd['designation']; ?></p>
                                    <p><strong>Company Name: </strong><?php echo $pd['cname']; ?></p>
                                    <p><strong>Line 1: </strong><?php echo $pd['line1']; ?></p>
                                    <p><strong>Line 2: </strong><?php echo $pd['line2']; ?></p>
                                    <p><strong>Line 3: </strong><?php echo $pd['line3']; ?></p>
                                    <p><strong>Line 4: </strong><?php echo $pd['line4']; ?></p>
                                    <?php $arr= explode(",", $pd['logo']);
                                        foreach ($arr as $val)
                                        {
                                    ?>
                                    <img src="<?php echo $val ?>" class="img-thumbnail" style="width:100px;height: 120px;"/><br>
                                    <?php echo $val;?>
                                        <?php }?>
                                    <form action="#" method="post"><input type="submit" value="Change Details" name="change" class="btn btn-info"/></form>
                        </div>
                        <div class="col-md-4">
                            <div class="row"> 
                                <div class="col-md-12 text-dark">
                                    <form action="#" method="post" class="well">
                                        <h2 class="text-black"><?php echo $row['designname'];?></h2>
                                    <p><strong class="text-primary h4">Rs.<?php echo $row['price']?></strong></p>
                                    <strong>Lamination:</strong>
                                    <div class="mb-1 d-flex mb-4">
                                        <select class="form-control" name="lamination">
                                            <option value="No">No Lamination</option>
                                            <option value="Yes">Lamination</option>
                                            <option value="Matt">Matt Lamination</option>
                                            
                                        </select>
                                      </div>
                                    <strong>Card Cornor:</strong>
                                    <div class="mb-1 d-flex mb-5">
                                        <select class="form-control" name="cornor">
                                            <option value="square">Square Cornor</option>
                                            <option value="rounded">Rounded Cornor</option>
                                        </select>
                                    </div>
                                    <div class="mb-5">
                                      <div class="input-group" style="max-width: 160px">
                                      <div class="input-group-btn">
                                          <button class="btn btn-primary" type="button" onclick="minus()">&minus;</button>
                                      </div>
                                          <input type="text" class="form-control text-center" value="1" id="quantity" name="quantity" placeholder="">
                                      <div class="input-group-btn">
                                          <button class="btn btn-primary" type="button" onclick="plus()">&plus;</button>
                                      </div>
                                    </div>
                                    </div>
                                    <p><button class="buy-now btn btn-sm btn-primary" type="submit" name="addtocart" >Add To Cart</button></p>
                                    </form>
                                </div>
                                    
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            </div>
        <?php }
        else if(isset($_GET['multidata']))
        {
            $details = unserialize($_GET['multidata']);
            $selectquery="select * from tbl_design where design_id='".$details['id']."'";
            $result= mysqli_query($con, $selectquery);
            $row= mysqli_fetch_assoc($result);
            
                                    if(isset($_POST['back']))
                                    {
                                        redirect("addprintdetails.php?id=".$details['id']."");
                                    }
                                    if(isset($_POST['continue']))
                                    {
                                        if(!isset($_SESSION['emailid']))
                                        {
                                            redirect("login.php");
                                        }
                                        else
                                        {
                                             $select="select user_id from tbl_user where email='".$_SESSION['emailid']."'";
                                             $result= mysqli_query($con, $select);
                                             $id= mysqli_fetch_assoc($result);
                                        }
                                        $select="select count(cart_id) as count,cart_id from tbl_cart where status='A' and customerid='".$id['user_id']."'";
                                        $result= mysqli_query($con, $select);
                                        $rset1= mysqli_fetch_assoc($result);
                                        
                                        if($rset1['count']=='0')
                                        {
                                           $insertsql=" INSERT INTO `tbl_cart`(`cart_id`, `customerid`) VALUES (null,'".$id['user_id']."')";
                                           $result= mysqli_query($con, $insertsql);
                                        }
                                        $result= mysqli_query($con, $select);
                                        $rset1= mysqli_fetch_assoc($result);
                                             $select="select count(print_id)as count,print_id from tbl_printdetails where ordername='".$details['pname']."'";
                                             $sult= mysqli_query($con, $select);
                                             $rset2= mysqli_fetch_assoc($sult);
                                            
                                             if($rset2['count']=='0')
                                             {
                                                $insertsql="INSERT INTO `tbl_printdetails`(`print_id`,`ordername`,lamination,cornor,multiplename,multipleimage,nooflines) "
                                                . "VALUES (null,'".$details['pname']."','".$_POST['lamination']."','".$_POST['cornor']."','".$details['xml']."','".$details['zip']."','".$_POST['line']."')";
                                                $result= mysqli_query($con, $insertsql);
                                                
                                                if($result)
                                                {
                                                }
                                                else
                                                {
                                                    echo mysqli_error($result);
                                                }
                                                $sult= mysqli_query($con, $select);
                                                $rset2= mysqli_fetch_assoc($sult);
                                                
                                                $insertsql="INSERT INTO `tbl_cartdetails`(`cd_id`, `designid`, `cartid`, `quantity`, `totalprice`, `printdetailsid`) "
                                                        . "VALUES (null,'".$row['design_id']."','".$rset1['cart_id']."','".$_POST['quantity']."','".$_POST['quantity']*$_POST['line']*$row['price']."','".$rset2['print_id']."')";
                                                $result= mysqli_query($con, $insertsql);
                                                redirect("cart.php");
                                             }
                                             else
                                             {
                                                 echo "<script>alert('Already Exists')</script>";
                                             }
                                        
                                    }
        ?>
            <div class="site-wrap">
                <div class="bg-light py-3">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-12 mb-0"><a href="index.html">Home</a> <span class="mx-2 mb-0">/</span> <strong class="text-black">View Details</strong></div>
                        </div>
                    </div>
                </div>
                <div class="well">
                    <div class="row">
                        <div class="col-md-6">
                            <h2 class="">Check Your Uploaded File</h2>
                        <hr>
                        <strong>Project Name :</strong><?php echo $details['pname'];?><br>
                        Your Details XML File :
                        <a href="<?php echo $details['xml'];?>"><?php echo $details['xml'];?></a>
                        <br>
                        Your Image ZIP File :
                        <a href="<?php echo $details['zip'];?>"><?php echo $details['zip'];?></a>
                        <form action="#" method="post"><input type="submit" value="Change Details" name="back" class="btn btn-info"/></form>
                        
                        
                        </div>
                        <div class="col-md-6 row">
                        <form action="#" method="post" class="well">
                                        <h2 class="text-black"><?php echo $row['designname'];?></h2>
                                    <p><strong class="text-primary h4">Rs.<?php echo $row['price']?></strong></p>
                                    
                                    <div class="mb-1 d-flex mb-4 col-md-12">
                                        <strong>Lamination:</strong>
                                        <select class="form-control" name="lamination">
                                            <option value="No">No Lamination</option>
                                            <option value="Yes">Lamination</option>
                                            <option value="Matt">Matt Lamination</option>
                                            
                                        </select>
                                      </div>
                                    
                                    <div class="mb-1 d-flex mb-5 col-md-12">
                                        <strong>Card Cornor:</strong>
                                        <select class="form-control" name="cornor">
                                            <option value="square">Square Cornor</option>
                                            <option value="rounded">Rounded Cornor</option>
                                        </select>
                                    </div>
                                    <div class="mb-5 col-md-6">
                                       <strong>No of lines of xml/xls file's:</strong>
                                      <div class="input-group" style="max-width: 160px">
                                      <div class="input-group-btn">
                                          <button class="btn btn-primary" type="button" onclick="minus()">&minus;</button>
                                      </div>
                                          <input type="text" class="form-control text-center" value="1" id="quantity" name="line" placeholder="">
                                      <div class="input-group-btn">
                                          <button class="btn btn-primary" type="button" onclick="plus()">&plus;</button>
                                      </div>
                                    </div>
                                    </div>
                                    <div class="mb-5 col-md-6">
                                       <strong>No of Copies:</strong>
                                      <div class="input-group" style="max-width: 160px">
                                      <div class="input-group-btn">
                                          <button class="btn btn-primary" type="button" onclick="minus()">&minus;</button>
                                      </div>
                                          <input type="text" class="form-control text-center" value="1" id="quantity" name="quantity" placeholder="">
                                      <div class="input-group-btn">
                                          <button class="btn btn-primary" type="button" onclick="plus()">&plus;</button>
                                      </div>
                                    </div>
                                    </div>
                            <input type="submit" value="Continue" name="continue" class="btn btn-success"/>
                        </form>
                        </div>
                    </div>
                </div>
            </div>
            
        <?php
        }?>
           
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
    function plus()
    {
        var value=parseInt(document.getElementById('quantity').value);
        value++;
        document.getElementById('quantity').value=value;
    }
    function minus()
    {
        var value=parseInt(document.getElementById('quantity').value);
        if(value>1)
        value--;
        else
        value=1;    
        document.getElementById('quantity').value=value;
    }
    </script>
    </body>
</html>
