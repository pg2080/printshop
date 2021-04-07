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
$edit=$list=$pwd=$upload=null;
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
        <div class="card-body">
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
                
            $selectquery="select * from tbl_user where email='".$_SESSION['emailid']."' and role='D'";
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
                                </div>
                                <!-- /.card-body -->
                            </div>
                            <!-- /.card -->
                        </div>
                        <!-- /.col -->
                        <div class="col-md-10">
                            <div class="card">
                                <div class="card-header p-2 t">
                                    <ul class="nav nav-tabs">
                                        <li class="nav-item"><a class="nav-link active" href="#profile" data-index="0" data-toggle="tab">Profile</a></li>
                                        <li class="nav-item"><a class="nav-link" href="#changepass" data-index="0" data-toggle="tab">Change Password</a></li>
                                        <li class="nav-item"><a class="nav-link" href="#list" data-index="0" data-toggle="tab">View Design List</a></li>
                                        <li class="nav-item"><a class="nav-link" href="#design" data-index="0" data-toggle="tab">Add Design Request</a></li>
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
                                        <!--list tab-->
                                        <div class="tab-pane" id="list">
                                                 <div class="row">
                                                    <div class="container-fluid">
                                                        <div class="table-responsive">
                                                           <h2>Design List</h2>
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
                                                                                category
                                                                            </th>
                                                                            <th>
                                                                                Price
                                                                            </th>
                                                                            <th>
                                                                                Upload date
                                                                            </th>
                                                                            <th>
                                                                                Status
                                                                            </th>
                                                                            <th>Remove</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody style="font-size: 13px;">
                                                                        <?php 
                                                                        $no=1;
                                                                        $select="select tbl_design.*,tbl_uploaddesign.status as st,uploaddate,tbl_category.* from tbl_uploaddesign inner join tbl_design on tbl_uploaddesign.designid=tbl_design.design_id inner join tbl_category on tbl_category.c_id=tbl_design.categoryid inner join tbl_user on tbl_uploaddesign.designerid=tbl_user.user_id where tbl_user.email='".$_SESSION['emailid']."'";                                                                       
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
                                                                                 $imagearr= explode(',', $row['designimage']);
                                                                                    foreach ($imagearr as $val)
                                                                                     {
                                                                                         if(!preg_match('/back/', $val))
                                                                                         {
                                                                                ?>
                                                                                <a href="../Adminpanel/<?php echo $val;?>"><img src="../Adminpanel/<?php echo $val;?>" alt="Image placeholder" class="img-thumbnail" style="width: 150px; height: 100px;"></a><br>
                                                                                <?php 
                                                                                         }
                                                                                     }
                                                                                ?>
                                                                            </td>
                                                                            <td>
                                                                                <?php
                                                                                if($row['designname']==null)
                                                                                    echo 'processing';
                                                                                else
                                                                                    echo $row['designname'];
                                                                                ?>
                                                                            </td>
                                                                            <td>
                                                                                <?php
                                                                                    echo $row['categoryname'];
                                                                                ?>
                                                                            </td>
                                                                            <td>
                                                                                <?php
                                                                                    echo $row['price']    
                                                                                ?>
                                                                            </td>
                                                                            <td>
                                                                                <?php
                                                                                   echo $row['uploaddate'];     
                                                                                ?>
                                                                            </td>
                                                                            <td>
                                                                                <?php
                                                                                   if ($row['st']=='Rq')
                                                                                   {
                                                                                       echo 'Requeted';
                                                                                   }
                                                                                   else if($row['st']=='A')
                                                                                   {
                                                                                       echo 'Accepted';
                                                                                   }
                                                                                   else
                                                                                   {
                                                                                       echo 'Decline';
                                                                                   }
                                                                                       
                                                                                ?>
                                                                            </td>

                                                                            <td>
                                                                                <?php if($row['st']=='D')
                                                                                {
                                                                                 ?>
                                                                                <button class="btn"><i class="fas fa-trash text-danger"></i></button>
                                                                                <?php 
                                                                                }
                                                                                else {
                                                                                    ?>
                                                                                <button class="disabled btn"><i class="fas fa-trash text-danger"></i></button>
                                                                                <?php
                                                                                }
                                                                                ?>
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
                                        <!--add design-->
                                        <div class="tab-pane" id="design">
                                            <div class="row">
                                                <div class="offset-md-2">
                                                    <!--upload design start-->
                                                    <?php 
                                                    if(isset($_POST['uploadimage']))
                                                        {
                                                                $imagearr=array();
                                                                $imagestr='';
                                                                $flag=0;
                                                                $targetDir = "uploadimage/";
                                                                $allowTypes = array('jpg','png','jpeg');

                                                                $fileNames = array_filter($_FILES['uploadimage']['name']);
                                                                if(!empty($fileNames))
                                                                {
                                                                        foreach($_FILES['uploadimage']['name'] as $key=>$val){ 
                                                                                // File upload path 
                                                                                $file = basename($_FILES['uploadimage']['name'][$key]);
                                                                                $filename = pathinfo($file,PATHINFO_FILENAME);
                                                                                $fileType = pathinfo($file,PATHINFO_EXTENSION);
                                                                                $targetFilePath = $targetDir.$filename.'.png';

                                                                                array_push($imagearr, $targetFilePath);

                                                                                if(in_array($fileType, $allowTypes)){ 

                                                                                    if(!file_exists("../Adminpanel/".$targetFilePath))
                                                                                    {
                                                                                       if(move_uploaded_file($_FILES["uploadimage"]["tmp_name"][$key], "../Adminpanel/".$targetFilePath))
                                                                                       {
                                                                                           $flag=1;
                                                                                       }
                                                                                       else{
                                                                                           $flag=0;
                                                                                       }
                                                                                   }
                                                                                   else
                                                                                   {
                                                                                       echo "<script>alert('file alreay exists');</script>";
                                                                                   }
                                                                                }
                                                                                else
                                                                                {
                                                                                    echo "<script>alert('select image file only);</script>";
                                                                                }
                                                                            }
                                                                            $imagestr= implode(",", $imagearr);
                                                                    }
                                                                    else
                                                                    {
                                                                        echo "<script>alert('please select file');</script>";
                                                                    }
                                                                    if($flag==1)
                                                                    {
                                                                            $insertsql="INSERT INTO `tbl_design`(`categoryid`,`designimage`,`status`) VALUES ('".$_POST['category']."','".$imagestr."','Rq')";
                                                                            $result= mysqli_query($con, $insertsql);

                                                                            if($result){
                                                                               
                                                                                $selectquery="select design_id from tbl_design where designimage='".$imagestr."'";
                                                                                $result= mysqli_query($con, $selectquery);
                                                                                $row= mysqli_fetch_assoc($result);
                                                                                
                                                                                echo "<script>alert('".$row['design_id']."')</script>";
                                                                                $insertsql="INSERT INTO `tbl_uploaddesign`(`upload_id`, `designid`, `designerid`) VALUES ('','".$row['design_id']."','".$id."')";
                                                                                $result= mysqli_query($con, $insertsql);
                                                                                redirect('designerdash.php');
                                                                            }
                                                                            else
                                                                                echo 'not inserted';
                                                                            }
                                                    }
                                                    ?>
                                                    <!--upload design end-->
                                                 </div>
                                                <div class="col-md-8">
                                                    <?php 
                                                        $files= scandir("../sample");
                                                    ?>
                                                    <strong>Download sample size image&nbsp;<a download="<?php echo $files[3]; ?>" href="../sample/<?php echo $files[3];?>"><button type="button" class="btn-xs btn-success"><i class="fas fa-download"></i></button></a></strong>
                                                    <hr>
                                                    <form class="form-horizontal" action="#" method="post" enctype="multipart/form-data">
                                                        <div class="form-group row">
                                                            <label for="p_fname" class="col-form-label col-sm-3">Category</label>
                                                            <div class="col-sm-8">
                                                                <select name="category" class="form-control">
                                                                    
                                                               
                                                         
                                                        <?php 
                                                            $selectquery="select c_id,categoryname from tbl_category where status='A'";
                                                            $result= mysqli_query($con, $selectquery);
                                                            while($row= mysqli_fetch_assoc($result))
                                                            {
                                                         ?>
                                                                    <option value="<?php echo $row['c_id']?>"><?php echo $row['categoryname']; ?></option>
                                                        <?php
                                                            }
                                                        ?>
                                                            </select>
                                                           </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <label for="p_fname" class="col-form-label col-sm-3">Upload Design Image</label>
                                                            <div class="col-sm-8">
                                                                <input type="file" class="form-control" name="uploadimage[]" value="" multiple="" placeholder="Enter First Name" required="">
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <div class="offset-sm-2 col-sm-10">
                                                                <button type="submit" class="btn btn-success" name="uploadimage">Send Request <i class="fas fa-upload"></i></button>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                                
                                            </div>
                                        </div>
                                        <!--add design-->
                                    </div>
                                    <!-- /.tab-pane -->
                                </div>
                                <!-- /.tab-content -->
                            </div><!-- /.card-body -->
                        </div>
                        <!-- /.nav-tabs-custom -->
                    </div>
                    <!-- /.col -->
                </div>
                </section>
                <!-- /.row -->
        </div><!-- /.container-fluid -->


<?php
include './footer.php';
?>

<script>
    $(document).ready(function() {
        if(localStorage.getItem('value')!=null)
        {
            $('.nav-item')
        }
        $('.t').on('click','ul li',function (){
            var index=parseInt($(this).data('index'));
            localStorage.setItem("value",index);
        });
    });
</script>
        
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
