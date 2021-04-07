<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Print Shop Admin | Dashboard</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="../../plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- DataTables -->
  <link rel="stylesheet" href="../../plugins/datatables-bs4/css/dataTables.bootstrap4.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../../dist/css/adminlte.min.css">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
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
            <h1 class="m-0 text-dark">User List</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="admindash.php">Home</a></li>
              <li class="breadcrumb-item active">User List</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <?php
        if($_GET['type']=="C")
        {
            $type="Customer List";
        }
        else if($_GET['type']=="D")
        {
            $type="Designer";
        }
        else
        {
            $type="Request List";
        }
    ?>
    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <!-- Small boxes (Stat box) -->
            <div class="row">
                <section class="content">
                    <div class="row">
                     <?php
                        $selectquery="SELECT * FROM `tbl_user` where role='".$_GET['type']."'";
                        $result= mysqli_query($con, $selectquery);
                        $i=1;
                                 
                              if(mysqli_num_rows($result)>0)
                              {
                     ?>
                      <div class="col-12 p-4">
                        <div class="card table-responsive">
                          <div class="card-header">
                              <h3 class="card-title"><?php echo $type; ?></h3>
                          </div>
                          <!-- /.card-header -->
                          
                          <div class="card-body table-responsive p-0" style="width: 100%">
                            <table class="table table-head-fixed">
                             <thead class="table-th-responsive">
                              <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Gender</th>
                                <th>Contact No</th>
                                <th>Address</th>
                                <th>Pincode</th>
                                <th>Status</th>
                                <th colspan="2" class="text-center">Operation</th>
                              </tr>
                              </thead>
                              <tbody>
                              
                                  <?php 
                                 while ($row= mysqli_fetch_assoc($result))
                                 {
                                     if($row['gender']=='M')
                                         $gen='Male';
                                     else
                                         $gen='Female';
                                     
                                     if($row['role']=='R')
                                         $var="Requested";
                                     else
                                     {
                                        if($row['status']=='A')
                                            $var="Active";
                                        else if($row['status']=='R')
                                            $var="Reject";
                                        else 
                                            $var="Deactive";
                                     }
                                     ?>    
                              <tr>
                                  <td><?php echo "$i";?></td>
                                <td><?php echo $row['firstname']." ".$row['lastname'];?></td>
                                <td><?php echo $row['email'];?></td>
                                <td><?php echo $gen;?></td>
                                <td><?php echo $row['contactno'];?></td>
                                <td><?php echo $row['address'];?></td>
                                <td><?php echo $row['pincode'];?></td>
                                <td><?php echo $var;?></td>
                                <?php 
                                if($row['role']=='R')
                                {
                                ?>
                                <td class="text-center"><a href="userstatuschng.php?type=approve&id=<?php echo $row['user_id'];?>&src=R"><button type="button" class="btn btn-sm btn-success"><i class="fas fa-check"></i></button></a></td>
                                <td class="text-center"><a href="userstatuschng.php?type=reject&id=<?php echo $row['user_id'];?>&src=R"><button type="button" class="btn btn-sm btn-danger"><i class="fas fa-times"></i></button></a></td>
                                <?php 
                                }
                                else {
                                ?>
                                <td class="text-center"><a href="userstatuschng.php?type=<?php echo $row['status'];?>&id=<?php echo $row['user_id']; ?>&src=<?php echo $_GET['type'];?>"><button type="button" class="btn btn-sm btn-success"><i class="fas fa-sync-alt"></i></button></a></td>
                                <?php
                                }
                                ?>
                              </tr>
                              </tbody>
                              <?php 
                                $i++;
                                 }
                              ?>
                              
                            </table>
                          </div>
                          <?php 
                                 }
                                 else {
                          ?>
                          <div>
                              <h1 class="text-danger">No Record Found !</h1>
                          </div>
                          <?php 
                                 }
                          ?>
                          <!-- /.card-body -->
                        </div>
                        <!-- /.card -->

                          <!-- /.card-body -->
                        </div>
                      <!-- /.col -->
                    </div>
                    <!-- /.row -->
                  </section>
                  <!-- /.content -->
                </div>
        </div>
    </section>
      </div>
  </div>
  <?php 
  include './adminfooter.php';
  ?>
   <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.content-wrapper -->
</div>
<!-- ./wrapper -->

</body>
</html>