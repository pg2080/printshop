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
            <h1 class="m-0 text-dark">Category List</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="admindash.php">Home</a></li>
              <li class="breadcrumb-item active">Category List</li>
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
                <section class="content">
                    <div class="row">
                      <div class="col-12">
                        <div class="card">
                          <div class="card-header">
                            <h3 class="card-title">Category List</h3>
                          </div>
                          <!-- /.card-header -->
                          <div class="card-body">
                            <table id="example2" class="table table-bordered table-hover">
                              <thead>
                              <tr>
                                <th>#</th>
                                <th>CategoryName</th>
                                <th>Status</th>
                                <th>Last Update Date</th>
                                <th colspan="2" class="text-center">Edit</th>
                              </tr>
                              </thead>
                              <tbody>
                              <?php 
                                 $selectquery="SELECT * FROM `tbl_category`";
                                 $result= mysqli_query($con, $selectquery);
                                 $i=1;
                                 while ($row= mysqli_fetch_assoc($result))
                                 {
                                     if($row['status']=='A')
                                         $var="ACTIVE";
                                     else
                                         $var="DEACTIVE";
                              ?>    
                              <tr>
                                  <td><?php echo "$i";?></td>
                                <td><?php echo $row['categoryname'];?></td>
                                <td><?php echo $var;?></td>
                                <td><?php echo $row['modifydate'];?></td>
                                <td class="text-center"><a href="updatecategory.php?type=cat&id=<?php echo $row['c_id'];?>&op=u"><button type="button" class="btn btn-sm btn-primary"><i class="fas fa-pencil-alt">
                              </i></button></a></td>
                              <td class="text-center"><a href="updatecategory.php?type=cat&id=<?php echo $row['c_id'];?>&op=d&st=<?php echo $row['status'];?>"><button type="button" class="btn btn-sm btn-warning"><i class="fas fa-sync-alt">
                              </i></button></a></td>
                              </tr>
                              </tbody>
                              <?php 
                                $i++;
                                 }
                              ?>
                              
                            </table>
                          </div>
                          <!-- /.card-body -->
                        </div>
                        <!-- /.card -->

                          <!-- /.card-body -->
                        </div>
                        <div class="col-12">
                        <div class="card">
                          <div class="card-header">
                            <h3 class="card-title">Sub-Category List</h3>
                          </div>
                          <!-- /.card-header -->
                          <div class="card-body">
                            <table id="example2" class="table table-bordered table-hover">
                              <thead>
                              <tr>
                                <th>#</th>
                                <th>Subcategory Name</th>
                                <th>Category Name</th>
                                <th>Status</th>
                                <th>Last Update Date</th>
                                <th colspan="2" class="text-center">Edit</th>
                              </tr>
                              </thead>
                              <tbody>
                              <?php 
                                 $selectquery="SELECT tbl_subcategory.sc_id, tbl_subcategory.subcategoryname, tbl_category.categoryname, tbl_subcategory.status, tbl_subcategory.modifydate"
                                         . " FROM `tbl_subcategory` INNER JOIN tbl_category ON tbl_subcategory.categoryid = tbl_category.c_id";
                                 $result= mysqli_query($con, $selectquery);
                                 $i=1;
                                 while ($row= mysqli_fetch_assoc($result))
                                 {
                                     if($row['status']=='A')
                                         $var="ACTIVE";
                                     else
                                         $var="DEACTIVE";
                              ?>    
                              <tr>
                                  <td><?php echo "$i";?></td>
                                <td><?php echo $row['subcategoryname'];?></td>
                                <td><?php echo $row['categoryname'];?></td>
                                <td><?php echo $var;?></td>
                                <td><?php echo $row['modifydate'];?></td>
                                <td class="text-center"><a href="updatecategory.php?type=subcat&id=<?php echo $row['sc_id'];?>&op=u"><button type="button" class="btn btn-sm btn-primary"><i class="fas fa-pencil-alt">
                              </i></button></a></td>
                              <td class="text-center"><a href="updatecategory.php?type=subcat&id=<?php echo $row['sc_id'];?>&op=d&st=<?php echo $row['status'];?>"><button type="button" class="btn btn-sm btn-warning"><i class="fas fa-sync-alt">
                              </i></button></a></td>
                              </tr>
                              </tbody>
                              <?php 
                                $i++;
                                 }
                              ?>
                              </tbody>
                            </table>
                          </div>
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