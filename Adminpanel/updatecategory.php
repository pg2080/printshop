<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Print Shop Admin | Dashboard</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body class="hold-transition sidebar-mini layout-fixed">
  <!-- Content Wrapper. Contains page content -->
  <?php 
    include './adminsidemenu.php';
    include '../connection.php';
    
    
    $value='';
    $catvalue='';
    if($_GET['op']=='u')
    {
  ?>
  
  
  <!--- Category Add Code Start-->
  
            <?php 
                  if(isset($_POST['categoryup']))
                  {
                      $selectquery="SELECT COUNT(*) AS count FROM `tbl_category` WHERE categoryname='".strtoupper($_POST['categoryname'])."'";

                          $result= mysqli_query($con, $selectquery);

                          while ($row= mysqli_fetch_assoc($result))
                          {
                              if($row['count']=='0')
                              {
                                  $updatesql="update `tbl_category` set `categoryname`='".strtoupper($_POST['categoryname'])."', modifydate='".date('Y-m-d')."' where `c_id`='".$_GET['id']."'";
                                  $query= mysqli_query($con, $updatesql);
                                  redirect("./viewcategory.php");
                              } 
                              else 
                              {
                                     echo "<script>alert('Already Added')</script>";
                              }
                          }  
                  }
            ?>
            <!--- Category Add Code End -->
            <!--- subCategory Add Code Start -->
            <?php 
                  if(isset($_POST['subcategoryup']))
                  {

                          $selectquery="SELECT COUNT(*) AS count FROM `tbl_subcategory` WHERE subcategoryname='".strtoupper($_POST['subcategoryname'])."'";

                          $result= mysqli_query($con, $selectquery);

                          while ($row= mysqli_fetch_assoc($result))
                          {
                              if($row['count']=='0')
                              {
                                  $updatesql="update `tbl_subcategory` set `subcategoryname`='".strtoupper($_POST['subcategoryname'])."', modifydate='".date('Y-m-d')."' where `sc_id`='".$_GET['id']."'";
                                  $query= mysqli_query($con, $updatesql);

                                  if($query)
                                      redirect("./viewcategory.php");
                                  else
                                      echo mysqli_error($query);
                              } 
                              else 
                              {
                                     echo "<script>alert('Already Added')</script>";
                              }
                          }  
                  }
            ?>
           <!--- subCategory Add Code End --> 

            <div class="content-wrapper">
              <!-- Content Header (Page header) -->
              <div class="content-header">
                <div class="container-fluid">
                  <div class="row mb-2">
                    <div class="col-sm-6">
                      <h1 class="m-0 text-dark">Category</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                      <ol class="breadcrumb float-sm-right">
                          <li class="breadcrumb-item"><a href="admindash.php">Home</a></li>
                        <li class="breadcrumb-item active">Category</li>
                      </ol>
                    </div><!-- /.col -->
                  </div><!-- /.row -->
                </div><!-- /.container-fluid -->
              </div>
              <!-- /.content-header -->

              <!-- Main content -->
              <section class="content">
                <div class="container-fluid">
                  <!-- Small boxes (Stat box) -->
                  <div class="row">
                      <div class="offset-3"></div>
                     <?php 
                     if($_GET['type']=='cat')
                     {
                         $selectquery="select categoryname from tbl_category where c_id='".$_GET['id']."'";

                         $result= mysqli_query($con, $selectquery);

                         $row= mysqli_fetch_assoc($result);

                         $value=$row['categoryname'];
                     ?>
                      <div class="col-md-6">
                      <!-- general form elements -->
                          <div class="card card-primary">
                            <div class="card-header">
                              <h3 class="card-title">Update Category</h3>
                            </div>
                            <!-- /.card-header -->
                            <!-- form start -->
                            <form action="#" method="post">
                              <div class="card-body">
                                <div class="form-group">
                                  <label for="categoryname">Enter Category Name</label>
                                  <input type="text" class="form-control" name="categoryname" value="<?php echo $value;?>" placeholder="Enter Category Name" required="">
                                </div>
                                <!-- /.card-body -->

                              <div class="card-footer">
                                  <button type="submit" class="btn btn-success" name="categoryup" value="catadd">Update</button>
                              </div>
                              </div>
                            </form>
                          </div>
                      </div>

                      <?php 
                     }
                     else
                     {
                         $selectquery="select tbl_subcategory.subcategoryname,tbl_category.categoryname from tbl_category inner join tbl_subcategory on tbl_category.c_id=tbl_subcategory.categoryid where sc_id='".$_GET['id']."'";

                         $result= mysqli_query($con, $selectquery);

                         $row= mysqli_fetch_assoc($result);

                         $catvalue=$row['categoryname'];
                         $value=$row['subcategoryname'];

                      ?>
                      <div class="col-md-6">
                      <div class="card card-warning">
                            <div class="card-header">
                              <h3 class="card-title">Update Subcategory</h3>
                            </div>
                            <!-- /.card-header -->
                            <!-- form start -->
                            <form action="#" method="post">
                              <div class="card-body">
                                  <span>Current Category &nbsp;:&nbsp;<b><?php echo $catvalue;?></b></span>
                                  <br>
                                <div class="form-group">
                                  <label for="subcategoryname">Enter Sub-category Name</label>
                                  <input type="text" class="form-control" name="subcategoryname" placeholder="Enter Sub Category Name" value="<?php echo $value;?>" required="">
                                </div>
                              </div>
                              <!-- /.card-body -->

                              <div class="card-footer">
                                <button type="submit" class="btn btn-success" name="subcategoryup" value="scateadd">Update</button>
                              </div>
                            </form>
                          </div>
                      </div>
                      <?php 
                       }
                      ?>

                          <!-- View Table-->
                  <!-- /.row (main row) -->
                </div><!-- /.container-fluid -->
              </section>
    <?php 
    }
 else {
        if($_GET['type']=='cat')
        {
            if($_GET['st']=='A')
            {
                $updatesql="update tbl_category set status='D' where c_id='".$_GET['id']."'";
                $result= mysqli_query($con, $updatesql);
                redirect("./viewcategory.php");
            }
            else
            {
                $updatesql="update tbl_category set status='A' where c_id='".$_GET['id']."'";
                $result= mysqli_query($con, $updatesql);
                redirect("./viewcategory.php");
            }
        }
        else
        {
            if($_GET['st']=='A')
            {
                $updatesql="update tbl_subcategory set status='D' where sc_id='".$_GET['id']."'";
                $result= mysqli_query($con, $updatesql);
                redirect("./viewcategory.php");
            }
            else
            {
                $updatesql="update tbl_subcategory set status='A' where sc_id='".$_GET['id']."'";
                $result= mysqli_query($con, $updatesql);
                redirect("./viewcategory.php");
            }
            
        }
    }
              ?>
    <!-- /.content -->
  </div>
  <?php 
  include './adminfooter.php';
  ?>
  <!-- /.content-wrapper -->
</div>

<!-- ./wrapper -->
</body>
</html>