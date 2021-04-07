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
   <style>
      .imgdata img{
          width: 130px;
          height: 80px;
      }
  </style>
</head>
<body class="hold-transition sidebar-mini layout-fixed">
  <!-- Content Wrapper. Contains page content -->
  <?php 
    include './adminsidemenu.php';
    include '../connection.php';
  ?>
  <?php 
        if(isset($_REQUEST['id']))
        {
            if($_REQUEST['type']=='approve')
            {
                
            }
            else if($_REQUEST['type']=='decline')
            {
                $updatequery="update tbl_design set status='R' where design_id='".$_REQUEST['id']."'";
                $result= mysqli_query($con, $updatequery);
                
                $updatequery="update tbl_uploaddesign set status='D' where designid='".$_REQUEST['id']."'";
                $result= mysqli_query($con, $updatequery);
            }
        }
  ?>
  
   <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Design</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="admindash.php">Home</a></li>
              <li class="breadcrumb-item active">Design</li>
              <li class="breadcrumb-item active">Requested Design</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
            <div class="row imgdata">
                <section class="content">
                    <div class="row">
                     <?php
                        $selectquery="SELECT tbl_design.*,tbl_uploaddesign.uploaddate,tbl_uploaddesign.status as st,tbl_category.*,tbl_user.* FROM `tbl_design` inner join tbl_uploaddesign on tbl_uploaddesign.designid=tbl_design.design_id inner join tbl_category on tbl_category.c_id =tbl_design.categoryid inner join tbl_user on tbl_uploaddesign.designerid=tbl_user.user_id where tbl_design.status!='A'";
                        $result= mysqli_query($con, $selectquery);
                        $i=1;
                                 
                              if(mysqli_num_rows($result)>0)
                              {
                     ?>
                      <div class="col-md-12 p-4">
                        <div class="card">
                            <div class="card-header">
                              <h3 class="card-title">Design</h3>

                              <div class="card-tools">
                              </div>
                            </div>
                          <!-- /.card-header -->
                          <div class="card-body table-responsive p-0" style="height: 600px;">
                            <table class="table table-head-fixed">
                                <thead class="table-th-responsive">
                              <tr>
                                <th>#</th>
                                <th>Design image</th>
                                <th>Designer name</th>
                                <th>Designer Email</th>
                                <th>categoryname</th>
                                <th>Upload date</th>
                                <th>Status</th>
                                <th colspan="2" class="text-center">Approve/Decline</th>
                              </tr>
                              </thead>
                              <tbody>
                                  <?php 
                                 while ($row= mysqli_fetch_assoc($result))
                                 {
                                     ?>    
                              <tr>
                                  <td><?php echo "$i";?></td>
                                  <td> <?php
                                        $imagearr= explode(',', $row['designimage']);
                                        foreach ($imagearr as $val)
                                         {
                                             if(!preg_match('/back/', $val))
                                             {
                                         ?>
                                       <button class="btn btn-default imageclick" id="<?php echo $row['design_id'];?>"><img src="<?php echo $val;?>" class="img-responsive img"></button>
                                       <?php
                                             }
                                         }
                                       ?></td>
                                <td><?php echo $row['firstname']." ".$row['lastname'];?></td>
                                <td><?php echo $row['email'];?></td>
                                <td><?php echo $row['categoryname'];?></td>
                                <td><?php echo $row['uploaddate'];?></td>
                                <td><?php if($row['st']=='D')
                                            echo "Decline";
                                          else
                                            echo "Requested";  ?></td>
                                <td class="text-center"><a href="updatedesign.php?type=approve&id=<?php echo $row['design_id'];?>"><button type="button" class="btn btn-sm btn-success"><i class="fas fa-check"></i></button></a></td>
                                <td class="text-center"><a href="requestdesign.php?type=decline&id=<?php echo $row['design_id'];?>"><button type="button" class="btn btn-sm btn-danger"><i class="fas fa-times"></i></button></a></td>
                              </tr>
                              </tbody>
                              <?php 
                                $i++;
                                 }
                              ?>
                              
                            </table>
                          </div>
                          <div class="card-footer clearfix">
                <ul class="pagination pagination-sm m-0 float-right">
                  <li class="page-item"><a class="page-link" href="#">&laquo;</a></li>
                  <li class="page-item"><a class="page-link" href="#">1</a></li>
                  <li class="page-item"><a class="page-link" href="#">2</a></li>
                  <li class="page-item"><a class="page-link" href="#">3</a></li>
                  <li class="page-item"><a class="page-link" href="#">&raquo;</a></li>
                </ul>
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
    </section>
                <div id="myModal" class="modal" role="dialog">
            <div class="modal-dialog">

              <!-- Modal content-->
              <div class="modal-content">
                <div class="modal-header">
                  <h4 class="modal-title">Image</h4>
                </div>
                  <div class="modal-body" id="modalbody">
                      
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
              </div>

            </div>
          </div>
      </div>
  
  <?php 
  include './adminfooter.php';
  ?>
  <script>
    
    $(document).ready(function() {
        $('.imageclick').click(function() {
        var designid=$(this).attr("id");
        var type='image';
        $.ajax({
            url: "ajax.php",
            method:"post",
            data:{designid:designid,type:type},
            success: function (data) {
                        $('#modalbody').html(data);
                        $('#myModal').modal("show"); 
                    }
        }); 
    
});
    
});  
</script>
   <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.content-wrapper -->
</div>
<!-- ./wrapper -->

</body>
</html>