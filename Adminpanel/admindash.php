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
  
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Dashboard</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="admindash.php">Home</a></li>
              <li class="breadcrumb-item active">Dashboard</li>
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
          <div class="col-lg-6 col-6">
            <!-- small box -->
            <div class="small-box bg-info">
              <div class="inner">
                <h3>150</h3>

                <p>New Orders</p>
              </div>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-6 col-6">
            <!-- small box -->
            <div class="small-box bg-success">
              <div class="inner">
                <h3>53</h3>

                <p>Total Orders</p>
              </div>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-6 col-6">
            <!-- small box -->
            <div class="small-box bg-warning">
              <div class="inner">
                  <?php 
                    $selectquery="select count(*) as count from tbl_user where role='C'";
                    
                    $result= mysqli_query($con, $selectquery);
                    
                    $row= mysqli_fetch_assoc($result);
                 ?>
                <h3><?php echo $row['count'];?></h3>
                 
                <p>Total Users</p>
              </div>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-6 col-6">
            <!-- small box -->
            <div class="small-box bg-danger ">
              <div class="inner">
                <?php 
                    $selectquery="select count(*) as count from tbl_design where status='A'";
                    
                    $result= mysqli_query($con, $selectquery);
                    
                    $row= mysqli_fetch_assoc($result);
                 ?>
                <h3><?php echo $row['count'];?></h3>
                <p>Design Avialable</p>
              </div>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-6 col-6">
            <!-- small box -->
            <div class="small-box bg-white">
              <div class="inner">
                 <?php 
                    $selectquery="select count(*) as count from tbl_user where role='D'";
                    
                    $result= mysqli_query($con, $selectquery);
                    
                    $row= mysqli_fetch_assoc($result);
                 ?>
                <h3><?php echo $row['count'];?></h3>

                <p>Total Designers</p>
              </div>
            </div>
          </div>
          <div class="col-lg-6 col-6">
            <!-- small box -->
            <div class="small-box bg-dark">
              <div class="inner">
                 <?php 
                    $selectquery="select count(*) as count from tbl_category where status='A'";
                    
                    $result= mysqli_query($con, $selectquery);
                    
                    $row= mysqli_fetch_assoc($result);
                 ?>
                <h3><?php echo $row['count'];?></h3>

                <p>Design Category</p>
              </div>
            </div>
          </div>
        <!-- /.row -->
       <!-- right col -->
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