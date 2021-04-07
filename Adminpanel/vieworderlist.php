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
          width: 100px;
          height: 60px;
      }
  </style>
</head>
<body class="hold-transition sidebar-mini layout-fixed">
  <!-- Content Wrapper. Contains page content -->
  <?php 
    include './adminsidemenu.php';
  ?>
  <?php 
        if(isset($_GET['id']))
        {
            $select="select * from tbl_order where order_id='".$_GET['id']."'";
            $result= mysqli_query($con, $select);
            $row= mysqli_fetch_assoc($result);
            
            if($row['status']=='P')
            {
                $updatequery="update tbl_order set status='D' where order_id='".$_GET['id']."'";
                $result= mysqli_query($con, $updatequery);
            }
            if ($row['paymentstatus']=='P') {
                $updatequery="update tbl_order set paymentstatus='D' where order_id='".$_GET['id']."'";
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
            <h1 class="m-0 text-dark">Order</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="admindash.php">Home</a></li>
              <li class="breadcrumb-item active">Order</li>
              <li class="breadcrumb-item active">View order list</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
        <!-- design view table start -->
        <div class="row imgdata">
          <div class="col-12">
            <div class="card">
              <!-- /.card-header -->
              <div class="row">
                <div class="col-12">
                  <div class="card">
                    <div class="card-header">
                        <h3 class="card-title"><a href="vieworderlist.php"><button class="btn">Order List</button></a><a href="vieworderlist.php?type=c"><button class="btn">Cancel Order List</button></a><a href="vieworderlist.php?type=n"><button class="btn">New Order List</button></a></h3>

                      <div class="card-tools">
                        <div class="input-group input-group-sm" style="width: 150px;">
                          <input type="text" name="table_search" class="form-control float-right" placeholder="Search">

                          <div class="input-group-append">
                            <button type="submit" class="btn btn-default"><i class="fas fa-search"></i></button>
                          </div>
                        </div>
                      </div>
                    </div>
                    <?php  if(isset($_POST['statuschange']) && isset($_POST['id']))
                    {
                        if($_POST['os']=='D')
                        {
                            $st='D';
                        }
                        else
                        {
                            $st='P';
                        }
                        $update="update tbl_order set status='".$_POST['os']."',paymentstatus='".$st."'where order_id='".$_POST['id']."'";
                        $result= mysqli_query($con, $update);
                        if($result)
                        {
                            echo "<script>location.reload();</script>";
                        }
                        else
                        {
                            echo "<script>alert('not done');</script>";
                        }
                    }?>
                    <!-- /.card-header -->
                    <div class="card-body table-responsive p-0" style="height: 420px;">
                      <table class="table table-head-fixed">
                        <thead class="table-th-responsive">
                          <tr>
                            <th>#</th>
                            <th>Design</th>
                            <th>Designname</th>
                            <th>Orderdate</th>
                            <th>Order Address</th>
                            <th>status</th>
                            <th>payment status</th>
                            <th>View</th>
                            <th><i class="fas fa-edit"></i></th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php
                          $no=1;
                                                                       if(!isset($_GET['type']))
                                                                       {
                                                                        $select="SELECT tbl_order.*,cart_id from tbl_order inner join tbl_cart on tbl_cart.cart_id=tbl_order.cartid inner join tbl_user on tbl_user.user_id=tbl_cart.customerid where tbl_order.status!='C'";                                                                       
                                                                       }
                                                                       else if($_GET['type']=='c')
                                                                       {
                                                                           $select="SELECT tbl_order.*,cart_id from tbl_order inner join tbl_cart on tbl_cart.cart_id=tbl_order.cartid inner join tbl_user on tbl_user.user_id=tbl_cart.customerid where tbl_order.status='C'";
                                                                       }
                                                                       else if($_GET['type']=='n')
                                                                       {
                                                                           $select="SELECT tbl_order.*,cart_id from tbl_order inner join tbl_cart on tbl_cart.cart_id=tbl_order.cartid inner join tbl_user on tbl_user.user_id=tbl_cart.customerid where orderdate='".date('Y-m-d')."'";
                                                                       }
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
                                                                                $select="select design_id,designimage,designname,price,tbl_cartdetails.quantity from tbl_design inner join tbl_cartdetails on tbl_design.design_id=tbl_cartdetails.designid inner join tbl_cart on tbl_cart.cart_id=tbl_cartdetails.cartid where cart_id='".$row['cart_id']."'";
                                                                                $re= mysqli_query($con, $select);
                                                                                
                                                                                while($r= mysqli_fetch_assoc($re))
                                                                                {   $imagearr= explode(',', $r['designimage']);
                                                                                    foreach ($imagearr as $val)
                                                                                     {
                                                                                         if(!preg_match('/back/', $val))
                                                                                         {
                                                                                ?>
                                                                                <button class="btn btn-default btn-xs imageclick" id="<?php echo $r['design_id'];?>"><img src="../Adminpanel/<?php echo $val;?>" alt="Image placeholder" class="img-thumbnail img-responsive"></button><br>
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
                                                                                <?php echo $row['orderdate'];?>
                                                                            </td>
                                                                            <td>
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
                                                                                        echo 'Cancel';
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
                                                                            <td><button class="btn btn-white btn-xs viewclick" id="<?php echo $row['cart_id']?>"><i class="fas fa-eye"></i></button></td>
                                                                            <!--<td><a href="vieworderlist.php?id=<?php echo $row['order_id']?>"><button class="btn btn-default btn-xs"><i class="fas fa-sync-alt"></i></button></a></td>-->
                                                                            <?php
                                                                                if($row['status']=='D' || $row['status']=='C'){
                                                                            ?>
                                                                               <td><a><button class="btn btn-xs disabled" id="<?php echo $row['order_id']?>"><i class="fas fa-sync-alt"></i></button></a></td>
                                                                            <?php }
                                                                            else
                                                                            {?>
                                                                              <td><a><button class="click btn btn-xs" id="<?php echo $row['order_id']?>"><i class="fas fa-sync-alt"></i></button></a></td>
                                                                        <?php }?>
                                                                        </tr>
                                                                        <?php 
                                                                        $no++;
                                                                            }
                                                                        ?>
                        </tbody>
                      </table>
                    </div>
                    <!-- /.card-body -->
                  </div>
                  <!-- /.card -->
                </div>
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
                    <h4 class="modal-title" id="modaltitle"></h4>
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
  
<!-- ./wrapper -->
          
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
                        $('#modaltitle').html('Image');
                        $('#modalbody').html(data);
                        $('#myModal').modal("show"); 
                    }
        }); 
    
});
    
});  
</script>
<script>
    $(document).ready(function() {
        $('.viewclick').click(function() {
        var id=$(this).attr("id");
        $.ajax({
            url: "ajax.php",
            method:"post",
            data:{id:id},
            success: function (data) {
                        $('#modaltitle').html('Details');
                        $('#modalbody').html(data);
                        $('#myModal').modal("show"); 
                    }
        }); 
    
});
});  
</script>
<script>
            $(document).ready(function() {
                $('.click').click(function() {
                var id=$(this).attr("id");
                $.ajax({
                    url: "ajaxcrud.php",
                    method:"post",
                    data:{orderid:id},
                    success: function (data) {
                                $('#modaltitle').html('Status');
                                $('#modalbody').html(data);
                                $('#myModal').modal("show"); 
                            }
                }); 
 });
 });  
        </script>
    </body>
</html>
