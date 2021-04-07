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
  ?>
  
  
  <!--- Category Add Code Start-->
  
  <?php 
        if(isset($_POST['categoryadd']))
        {
            echo 'enterd';
            $selectquery="SELECT COUNT(*) AS count FROM `tbl_category` WHERE categoryname='".strtoupper($_POST['categoryname'])."'";
                
                $result= mysqli_query($con, $selectquery);
                
                while ($row= mysqli_fetch_assoc($result))
                {
                    if($row['count']=='0')
                    {
                        $insertsql="INSERT INTO `tbl_category`(`c_id`, `categoryname`)"
                     . " VALUES (null,'".strtoupper($_POST['categoryname'])."')";
                        $query= mysqli_query($con, $insertsql);
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
        if(isset($_POST['subcategoryadd']))
        {
            
            $selectquery="select c_id from tbl_category where categoryname='".strtoupper($_POST['categorylist'])."'";
            
            $result= mysqli_query($con, $selectquery);
            
                $rowid= mysqli_fetch_assoc($result);
                
                echo $rowid['c_id'];
                
            $selectquery="SELECT COUNT(*) AS count FROM `tbl_subcategory` WHERE subcategoryname='".strtoupper($_POST['subcategoryname'])."'";
                
                $result= mysqli_query($con, $selectquery);
                
                while ($row= mysqli_fetch_assoc($result))
                {
                    if($row['count']=='0')
                    {
                        $insertsql="INSERT INTO `tbl_subcategory`(`sc_id`, `subcategoryname`, `categoryid`)"
                                . " VALUES (null,'".strtoupper($_POST['subcategoryname'])."','".$rowid['c_id']."')";
                        $query= mysqli_query($con, $insertsql);
                        if($query)
                        echo 'inserted';
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
        <div class="col-md-6">
            <!-- general form elements -->
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Category</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form action="#" method="post">
                <div class="card-body">
                  <div class="form-group">
                    <label for="categoryname">Enter Category Name</label>
                    <input type="text" class="form-control" name="categoryname" value="<?php $value?>" placeholder="Enter Category Name" required="">
                  </div>
                  <!-- /.card-body -->

                <div class="card-footer">
                    <button type="submit" class="btn btn-success" name="categoryadd" value="catadd">Add</button>
                </div>
                </div>
              </form>
            </div>
        </div>
                <!-- View Table-->
        <div class="col-md-6">
            <div class="card card-warning">
                  <div class="card-header">
                    <h3 class="card-title">Subcategory</h3>
                  </div>
                  <!-- /.card-header -->
                  <!-- form start -->
                  <form action="#" method="post">
                    <div class="card-body">
                      <div class="form-group">
                        <label>Select Category</label>
                        <select class="form-control" name="categorylist">
                           <?php 
                           $selectquery="SELECT categoryname FROM `tbl_category`";
                              $result= mysqli_query($con, $selectquery);
                                while ($row= mysqli_fetch_assoc($result))
                                {
                            ?>
                          <option><?php echo $row['categoryname'];?></option>
                          <?php 
                                }
                          ?>
                        </select>
                      </div>
                      <div class="form-group">
                        <label for="subcategoryname">Enter Sub-category Name</label>
                        <input type="text" class="form-control" name="subcategoryname" placeholder="Enter Sub Category Name" required="">
                      </div>
                    </div>
                    <!-- /.card-body -->

                    <div class="card-footer">
                      <button type="submit" class="btn btn-success" name="subcategoryadd" value="scateadd">Add</button>
                    </div>
                  </form>
                </div>
            </div>
            <!--End -->
            
            
        </div>
        <!-- /.row (main row) -->
      </div><!-- /.container-fluid -->
    </section>
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