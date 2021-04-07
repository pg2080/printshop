<!DOCTYPE html>
<html>
    
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Print Shop Admin | Dashboard</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
  
  <style>
      .imgdata img{
          width: 80px;
          height: 60px;
      }
  </style>
</head>
<body class="hold-transition sidebar-mini layout-fixed">
  <!-- Content Wrapper. Contains page content -->
  <?php 
    include './adminsidemenu.php';
    $i=1;
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
              <li class="breadcrumb-item active">View Design</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
        <!-- design menu start -->
        <div class="container-fluid">
                <div class="row">
                  <div class="col-md-3 col-sm-6 col-12">
                    <div class="info-box">
                        <span class="info-box-icon bg-info"><a href="adddesign.php"><i class="fas fa-plus"></i></a></span>
                      <div class="info-box-content">
                        <span class="info-box-text">Add Design</span>
                      </div>
                      <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                  </div>
                  <!-- /.col -->
                  <div class="col-md-3 col-sm-6 col-12">
                    <div class="info-box">
                        <span class="info-box-icon bg-success"><a href="viewdesigns.php"><i class="fas fa-eye"></i></a></span>

                      <div class="info-box-content">
                        <span class="info-box-text">View Design</span>
                    </div>
                    <!-- /.info-box -->
                  </div>                          </div>
                      <!-- /.info-box-content -->

                  <!-- /.col -->
                </div>
        </div>
        <!-- design menu end -->
        
        
        <!-- design view table start -->
        <div class="row imgdata">
          <div class="col-12">
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
                      <th>Designname</th>
                      <th>DesignImg</th>
                      <th>Categoryname</th>
                      <th>Subcategoryname</th>
                      <th>Status</th>
                      <th>Price</th>
                      <th>Designer</th>
                      <th>Date</th>
                      <th colspan="2">Edit</th>
                    </tr>
                  </thead>
                  <tbody style="font-size: 14px;">
                  <?php 
                    $selectquery="select * from tbl_design where status='A'||status='D' order by modifydate desc";
                    $result= mysqli_query($con, $selectquery);
                    
                    while($row= mysqli_fetch_assoc($result))
                    {
                        if($row['status']=='A')
                            $status='Active';
                        else
                            $status='Deactive';
                        
                        if($row['subcategoryid']!=null)
                        {
                            $query1="SELECT tbl_subcategory.subcategoryname,tbl_category.categoryname FROM `tbl_subcategory` INNER JOIN tbl_category ON tbl_subcategory.categoryid = tbl_category.c_id where sc_id='".$row['subcategoryid']."'";
                            $rs1= mysqli_query($con, $query1);
                            $r1= mysqli_fetch_assoc($rs1);
                            $catname=$r1['categoryname'];
                            $subcatname=$r1['subcategoryname'];
                        }
                        else
                        {
                            $query1="SELECT categoryname FROM tbl_category where c_id='".$row['categoryid']."'";
                            $rs1= mysqli_query($con, $query1);
                            $r1= mysqli_fetch_assoc($rs1);
                            $catname=$r1['categoryname'];
                            $subcatname='none';
                        }
//                        start to get designer email
                        
                            $query1="select count(*) as count,firstname,lastname from tbl_user inner join tbl_uploaddesign on tbl_user.user_id=tbl_uploaddesign.designerid inner join tbl_design on tbl_uploaddesign.designid=tbl_design.design_id where tbl_uploaddesign.designid='".$row['design_id']."'";
                            $rs1= mysqli_query($con, $query1);
                            $r1= mysqli_fetch_assoc($rs1);
                            
                        if($r1['count']=="1")
                        {
                            $designername=$r1['firstname'].' '.$r1['lastname'];
                        }
                        else{
                            $designername='Admin';
                        }
//                        end 
                        
                        
                    ?>
                  
                    <tr>
                        <td><?php echo $i;?></td>
                      <td><?php echo $row['designname'];?></td>
                      <td>
                          <?php
                           $imagearr= explode(',', $row['designimage']);
                           foreach ($imagearr as $val)
                            {
                                if(!preg_match('/back/', $val))
                                {
                            ?>
                          <button class="btn btn-default imageclick" id="<?php echo $row['design_id'];?>"><img src="<?php echo $val;?>" class="img-responsive"></button>
                          <?php
                                }
                            }
                          ?>
                      </td>
                      <td><?php echo $catname?></td>
                      <td><?php echo $subcatname?></td>
                      <td><?php echo $status;?></td>
                      <td><i class="fas fa-rupee-sign"></i>&nbsp;<?php echo $row['price'];?></td>
                      <td><?php echo $designername;?></td>
                      <td><?php echo $row['modifydate'];?></td>
                      <td><a href="updatedesign.php?type=edit&id=<?php echo $row['design_id']?>"><button class="btn btn-primary btn-sm"><i class="fas fa-pencil-alt"></i></button></a></td>
                      <td><a href="updatedesign.php?type=change&id=<?php echo $row['design_id']?>&st=<?php echo $row['status'];?>"><button class="btn btn-warning btn-sm"><i class="fas fa-sync-alt"></i></button></a></td>
                    </tr>
                    <?php
                        $i++;
                    }
                    ?>
                  </tbody>
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
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
        </div>
         <!-- design view table end -->
        <!-- start image model-->
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
        <!--end image model-->
       
    </section>
  </div>
  <?php 
  include './adminfooter.php';
  ?>
  <!-- /.content-wrapper -->
</div>

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
<!-- ./wrapper -->
</body>
</html>