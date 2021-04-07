<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<?php
session_start();
include '../connection.php';
include '../redirect.php';
include './style.php';
include './userheader.php';
$fname=$lname=$email=$contact=$add=$pincode='';
if(!isset($_SESSION['emailid']))
{
    redirect("../login.php");
}
?>
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <div class="bg-light py-3">
            <div class="container">
                <div class="row">
                    <div class="col-md-12 mb-0"><a href="index.php">Home</a> <span class="mx-2 mb-0">/</span> <strong class="text-black">My Profile</strong></div>
                </div>
            </div>
        </div>
        <!-- Content Wrapper. Contains page content -->
        <div class="">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1>Profile</h1>
                        </div>
                    </div>
                </div><!-- /.container-fluid -->
            </section>

            <!--about me details get start-->
            <?php 
                
            $selectquery="select * from tbl_user where email='".$_SESSION['emailid']."' and role='C'";
            $result= mysqli_query($con, $selectquery);
            $row= mysqli_fetch_assoc($result);
            
            if($row['gender']=='M')
                $gen='Male';
            else
                $gen='Female';
            $id=$row['user_id'];
            $fname= $row['firstname'];
            $lname=$row['lastname'];
            $contact=$row['contactno'];
            $email=$row['email'];
            $add=$row['address'];
            $pincode=$row['pincode'];
            ?>
            <!--about me details get end -->
            
            <!--on update button click start -->
            <?php 
                if(isset($_POST['update']))
                {
                    $selectquery="select count(email) as count from tbl_user where user_id!=$id and email='".$_POST['p_email']."'";
                    $result= mysqli_query($con, $selectquery);
                    $row= mysqli_fetch_assoc($result);
                    
                    if($row['count']=='0')
                    {
                        $updatesql="update tbl_user set firstname='".$_POST['p_fname']."',`lastname`='".$_POST['p_lname']."',`gender`='".$_POST['p_gender']."',`email`='".$_POST['p_email']."',`contactno`='".$_POST['p_contact']."',`address`='".$_POST['p_add']."',`pincode`='".$_POST['p_pincode']."',`modifydate`='". date('Y-m-d')."' where user_id=$id";
                    
                        $result= mysqli_query($con, $updatesql);
                        
                        if($result)
                        {
                            $_SESSION['emailid']=$_POST['p_email'];
                            
                              redirect("./customerdash.php");
                        }
                        else{
                            echo 'error';
                        }
                    }
                    else
                    {
                        echo "<script>alert('Email can not be updated!!')</script>";
                    }
                }
            ?>
            <!--on update button click end-->
            
            <!--on change password click start-->
            <?php 
                if(isset($_POST['changepass']))
                {
                    $selectquery="select count(*) as count from tbl_user where user_id=$id and password=md5('".$_POST['oldpass']."')";
                    $result= mysqli_query($con, $selectquery);
                    $row= mysqli_fetch_assoc($result);
                    
                    if($row['count']=='1')
                    {
                        $updatesql="update tbl_user set password=md5('".$_POST['newpass']."'),`modifydate`='". date('Y-m-d')."' where user_id=$id";
                        
                        $result= mysqli_query($con, $updatesql);
                    }
                    else
                    {
                        echo "<script>alert('Old Password is Wrong!!')</script>";
                    }
                }
            ?>
            <!--on change password click end-->
            
            
            
            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-2">

                            <!-- About Me Box -->
                            <div class="card card-primary">
                                <div class="card-header bg-info">
                                    <h3 class="card-title text-black">About Me</h3>
                                </div>
                                <!-- /.card-header -->
                                <div class="card-body text-black">
                                    <strong><i class="fas fa-user mr-1"></i>Personal Details</strong>

                                    <p class="text-muted" style="font-size: 13px;">
                                       <?php echo $fname." ".$lname;?><br>
                                       <?php echo $gen;?>
                                    </p>

                                    <hr>

                                    <strong><i class="fas fa-map-marker-alt mr-1"></i> Location</strong>
                                    <p class="text-muted" style="font-size: 13px;"><?php echo $add;?><br>
                                   <?php echo $pincode;?>
                                    </p>

                                    <hr>

                                    <strong><i class="fas fa-book mr-1"></i> Contact</strong>

                                    <p class="text-muted" style="font-size: 13px;">
                                       <?php echo $email?><br>
                                       <?php echo $contact;?>
                                    </p>

                                    <hr>

                                    <strong><i class="far fa-file-alt mr-1"></i> Total Orders</strong>

                                    <p class="text-muted" style="font-size: 13px;"></p>
                                </div>
                                <!-- /.card-body -->
                            </div>
                            <!-- /.card -->
                        </div>
                        <!-- /.col -->
                        <div class="col-md-10">
                            <div class="card">
                                <div class="card-header p-2">
                                    <ul class="nav nav-tabs">
                                        <li class="nav-item"><a class="nav-link active" href="#profile" data-toggle="tab">Profile</a></li>
                                        <li class="nav-item"><a class="nav-link" href="#changepass" data-toggle="tab">Change Password</a></li>
                                        <li class="nav-item"><a class="nav-link" href="#list" data-toggle="tab">Order List</a></li>
                                    </ul>
                                </div><!-- /.card-header -->
                                <div class="card-body">
                                    <div class="tab-content text-black">
                                        <!-- profile tab -->
                                        <div class="active tab-pane fade-in-up" id="profile">
                                            <form class="form-horizontal" action="#" method="post">
                                                <div class="form-group row">
                                                    <label for="p_fname" class="col-sm-2 col-form-label">First Name</label>
                                                    <div class="col-sm-10">
                                                        <input type="text" class="form-control" name="p_fname" value="<?php echo $fname;?>" placeholder="Enter First Name" required="">
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <label for="p_lname" class="col-sm-2 col-form-label">Last Name</label>
                                                    <div class="col-sm-10">
                                                        <input type="text" class="form-control" name="p_lname" placeholder="Enter Last Name" value="<?php echo $lname;?>" required="">
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <label for="p_gender" class="col-sm-2 col-form-label">Gender</label>
                                                    <div class="col-sm-10">
                                                        <select class="form-control" name="p_gender" require>
                                                            <option>Male</option>
                                                            <option>Female</option>
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <label for="p_email" class="col-sm-2 col-form-label">Email</label>
                                                    <div class="col-sm-10">
                                                        <input type="email" class="form-control" name="p_email" placeholder="Enter Email" value="<?php echo $email;?>" required="">
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <label for="p_contact" class="col-sm-2 col-form-label">Contact No</label>
                                                    <div class="col-sm-10">
                                                        <input type="text" class="form-control" name="p_contact" placeholder="Enter Contact No" value="<?php echo $contact;?>" required="">
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <label for="p_add" class="col-sm-2 col-form-label">Address</label>
                                                    <div class="col-sm-10">
                                                        <textarea class="form-control" name="p_add" placeholder="Address" required=""><?php echo $add;?></textarea>
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <label for="p_pincode" class="col-sm-2 col-form-label">Pincode</label>
                                                    <div class="col-sm-10">
                                                        <input type="text" class="form-control" name="p_pincode" placeholder="Enter Pincode" value="<?php echo $pincode;?>" required="">
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <div class="offset-sm-2 col-sm-10">
                                                        <button type="submit" class="btn btn-success" name="update">UPDATE <i class="fas fa-edit"></i></button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                        <!-- profile tab-->
                                        <!-- change password tab-->
                                        <div class="tab-pane" id="changepass">
                                            <form class="form-horizontal" action="#" method="post" onsubmit="return checkpass()">
                                                <div class="form-group row">
                                                    <label for="oldpass" class="col-sm-2 col-form-label">Old Password</label>
                                                    <div class="col-sm-10">
                                                        <input type="password" class="form-control" id="oldpass" name="oldpass" placeholder="Enter Old Password" required="">
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label for="newpass" class="col-sm-2 col-form-label">New Password</label>
                                                    <div class="col-sm-10">
                                                        <input type="password" class="form-control" id="newpass" name="newpass" placeholder="Enter New Password" required="">
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label for="repass" class="col-sm-2 col-form-label">Re-Enter Password</label>
                                                    <div class="col-sm-10">
                                                        <input type="password" class="form-control" id="repass" placeholder="Re-Enter Password" required="">
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <div class="offset-sm-2 col-sm-10">
                                                        <button type="submit" class="btn btn-success" name="changepass">change password <i class="fas fa-edit"></i></button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                        <!-- change password tab-->
                                        <?php 
                                                    if (isset($_GET['type']))
                                                    {
                                                        $updatesql="update tbl_order set status='C' where cartid='".$_GET['id']."'";
                                                        $result= mysqli_query($con, $updatesql);
                                                    }
                                        ?>
                                        
                                        <!--list tab-->
                                        <div class="tab-pane" id="list">
                                            <div class="row">
                                                <div class="container-fluid">
                                                    <div class="table-responsive">
                                                           <h2>Order List</h2>
                                                                <table class="table table-light table-hover">
                                                                    <thead>
                                                                        <tr>
                                                                            <th>
                                                                                #
                                                                            </th>
                                                                            <th>
                                                                                Design
                                                                            </th>
                                                                            <th>
                                                                                Design name
                                                                            </th>
                                                                            <th>
                                                                                Quantity
                                                                            </th>
                                                                            <th>
                                                                                Price
                                                                            </th>
                                                                            <th>
                                                                                Totalamount
                                                                            </th>
                                                                            <th>
                                                                                Orderdate
                                                                            </th>
                                                                            <th>
                                                                                Orderaddress
                                                                            </th>
                                                                            <th>
                                                                                Orderdstatus
                                                                            </th>
                                                                            <th>
                                                                                Paymentstatus
                                                                            </th>
                                                                            <th>
                                                                                View
                                                                            </th>
                                                                            <th>
                                                                                Cancle 
                                                                            </th>
                                                                            <th>Bill</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody style="font-size: 14px;">
                                                                        <?php 
                                                                        $no=1;
                                                                        $select="SELECT tbl_order.*,cart_id from tbl_order inner join tbl_cart on tbl_cart.cart_id=tbl_order.cartid inner join tbl_user on tbl_user.user_id=tbl_cart.customerid where email='".$_SESSION['emailid']."'";                                                                       
                                                                        $result= mysqli_query($con, $select);
                                                                        while ($row= mysqli_fetch_assoc($result))
                                                                        {
                                                                        ?>
                                                                        <tr>
                                                                            <td>
                                                                                <?php echo $no;?>
                                                                            </td>
                                                                            <td>
                                                                                
                                                                                <?php
                                                                                $select="select designimage,designname,price,tbl_cartdetails.quantity from tbl_design inner join tbl_cartdetails on tbl_design.design_id=tbl_cartdetails.designid inner join tbl_cart on tbl_cart.cart_id=tbl_cartdetails.cartid where cart_id='".$row['cart_id']."'";
                                                                                $re= mysqli_query($con, $select);
                                                                                
                                                                                while($r= mysqli_fetch_assoc($re))
                                                                                {   $imagearr= explode(',', $r['designimage']);
                                                                                    foreach ($imagearr as $val)
                                                                                     {
                                                                                         if(!preg_match('/back/', $val))
                                                                                         {
                                                                                ?>
                                                                                <a href="../Adminpanel/<?php echo $val;?>"><img src="../Adminpanel/<?php echo $val;?>" alt="Image placeholder" class="img-thumbnail img-responsive"></a><br>
                                                                                <?php 
                                                                                         }
                                                                                     }
                                                                                }
                                                                                ?>
                                                                            </td>
                                                                            <td>
                                                                                <?php
                                                                                $re= mysqli_query($con, $select);
                                                                                while($r= mysqli_fetch_assoc($re))
                                                                                {
                                                                                        echo $r['designname']."<br>";
                                                                                }
                                                                                ?>
                                                                            </td>
                                                                            <td>
                                                                                <?php
                                                                                $re= mysqli_query($con, $select);
                                                                                while($r= mysqli_fetch_assoc($re))
                                                                                {
                                                                                        echo $r['quantity']."<br>";
                                                                                }
                                                                                ?>
                                                                            </td>
                                                                            <td>
                                                                                <?php
                                                                                $re= mysqli_query($con, $select);
                                                                                while($r= mysqli_fetch_assoc($re))
                                                                                {
                                                                                        echo "Rs.".$r['price']."<br>";
                                                                                }
                                                                                ?>
                                                                            </td>
                                                                            <td>
                                                                                <?php echo $row['totalamount'];?>
                                                                            </td>
                                                                            <td>
                                                                                <?php echo $row['orderdate'];?>
                                                                            </td>
                                                                            <td class="align-content-md-start">
                                                                                <?php echo $row['orderaddress'];?>
                                                                            </td>
                                                                            <td>
                                                                                <?php if($row['status']=='P')
                                                                                      echo "Pending";
                                                                                else if($row['status']=='Di')
                                                                                    echo "In Designing";
                                                                                else if($row['status']=='Pr')
                                                                                    echo "In Printing";
                                                                                else if($row['status']=='Ds')
                                                                                    echo "Dispetched";
                                                                                else if($row['status']=='D')
                                                                                        echo "Delivered";
                                                                                else
                                                                                        echo "Cancel";
                                                                                    ?>
                                                                            </td>
                                                                            <td><?php if($row['paymentstatus']=='P')
                                                                                {
                                                                                      echo "Pending";
                                                                                }
                                                                                else {
                                                                                        echo "Complate";
                                                                                }
                                                                                ?>
                                                                            </td>
                                                                            <td>
                                                                                <button class="btn btn-info viewclick btn-xs" id="<?php echo $row['cart_id'];?>"><i class="fas fa-eye"></i></button>
                                                                            </td>
                                                                            <td>
                                                                                <?php if($row['status']=='Pr' || $row['status']=='Ds' || $row['status']=='D' || $row['status']=='C')
                                                                                {
                                                                                 ?>
                                                                                <button class="btn btn-danger btn-xs disabled"><i class="fas fa-trash"></i></button>
                                                                                <?php 
                                                                                }
                                                                                else {
                                                                                    ?>
                                                                                <a href="customerdash.php?type=C&id=<?php echo $row['cart_id'];?>"><button class="btn btn-danger btn-xs"><i class="fas fa-trash"></i></button></a>
                                                                                <?php
                                                                                }
                                                                                ?>
                                                                            </td>
                                                                            <td>
                                                                                <a href="pdf.php?id=<?php echo $row['cart_id'];?>"><button class="btn btn-xs btn-success"><i class="fas fa-print"></i></button></a>
                                                                            </td>
                                                                        </tr>
                                                                        <?php 
                                                                        $no++;
                                                                            }
                                                                        ?>
                                                                    </tbody>
                                                                </table>
                                                    </div>
                                                    </div>
                                            </div>
                                        </div>
                                        <!--list tab-->
                                    </div>
                                    <!-- /.tab-pane -->
                                </div>
                                <!-- /.tab-content -->
                            </div><!-- /.card-body -->
                        </div>
                        <div id="myModal" class="modal fade-in-up" role="dialog">
                                <div class="modal-dialog">
                                  <!-- Modal content-->
                                  <div class="modal-content">
                                    <div class="modal-header">
                                      <h4 class="modal-title">Details</h4>
                                    </div>
                                      <div class="modal-body" id="modalbody" style="height: 300px; overflow-y: scroll;">

                                    </div>
                                    <div class="modal-footer">
                                      <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                    </div>
                                  </div>
                                </div>
                        </div>
                        <!-- /.nav-tabs-custom -->
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
    
    <!--model-->
    
    <!--end model-->
<script>
    $(document).ready(function() {
        $('.viewclick').click(function() {
        var id=$(this).attr("id");
        $.ajax({
            url: "ajaxview.php",
            method:"post",
            data:{id:id},
            success: function (data) {
                        $('#modalbody').html(data);
                        $('#myModal').modal("show"); 
                    }
        }); 
    
});
    
});  
</script>
    
</div>
<?php
include './footer.php';
?>




<script>

    function checkpass()
    {
        var newp=document.getElementById('newpass').value;
        var repass=document.getElementById('repass').value;
        
        if(newp!=repass)
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
<!-- jQuery -->
<script src="../Adminpanel/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="../Adminpanel/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="../Adminpanel/dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="../Adminpanel/dist/js/demo.js"></script>
</body>
</html>
