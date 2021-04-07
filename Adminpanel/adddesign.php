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
  ?>
  
  <?php 
    
    if(isset($_POST['uploaddesign']))
    {
        
        $selectquery="select count(designname) as count from tbl_design where designname='".$_POST['designname']."'";
        $result= mysqli_query($con, $selectquery);
        $row= mysqli_fetch_assoc($result);
        if($row['count']=='0')
        {
            $imagearr=array();
            $imagestr='';
            $flag=0;
            $targetDir = "uploadimage/";
            $allowTypes = array('jpg','png','jpeg');

            $fileNames = array_filter($_FILES['designimage']['name']);
            if(!empty($fileNames))
            {
                    foreach($_FILES['designimage']['name'] as $key=>$val){ 
                            // File upload path 
                            $file = basename($_FILES['designimage']['name'][$key]);
                            $filename = pathinfo($file,PATHINFO_FILENAME);
                            $fileType = pathinfo($file,PATHINFO_EXTENSION);
                            $targetFilePath = $targetDir.$filename.'.png';

                            array_push($imagearr, $targetFilePath);

                            if(in_array($fileType, $allowTypes)){ 

                                if(!file_exists($targetFilePath))
                                {
                                   if(move_uploaded_file($_FILES["designimage"]["tmp_name"][$key], $targetFilePath))
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
                    if($_POST['subcat']!=NULL)
                        {
                            $insertsql="INSERT INTO `tbl_design`(`designname`, `subcategoryid`, `designimage`, `price`) VALUES ('".$_POST['designname']."','".$_POST['subcat']."','".$imagestr."','".$_POST['price']."')";
                        }
                        else
                        {
                            $insertsql="INSERT INTO `tbl_design`(`designname`, `categoryid`, `designimage`, `price`) VALUES ('".$_POST['designname']."','".$_POST['cat']."','".$imagestr."','".$_POST['price']."')";    
                        }
                        $result= mysqli_query($con, $insertsql);

                        if($result){
                            echo 'inserted';
                            redirect("./viewdesigns.php");
                        }
                        else
                            echo 'not inserted';
                }
            
        }
        else
        {
            echo "<script>alert('alreay exists designname')</script>";          
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
              <li class="breadcrumb-item active">Add Design</li>
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
                  </div>                         
                  </div>
                      <!-- /.info-box-content -->

                  <!-- /.col -->
                </div>
            <hr>
        </div>
        <!-- design menu end -->
        <!-- design entry start-->
        <section class="content">
          <form action="#" method="post" enctype='multipart/form-data'>
            <div class="row">
                <div class="offset-3"></div>
              <div class="col-md-6">
                <div class="card card-primary">
                    
                  <div class="card-header">
                    <h3 class="card-title">Design Details</h3>

                    <div class="card-tools">
                      <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                        <i class="fas fa-minus"></i></button>
                    </div>
                  </div>
                  <div class="card-body">
                    <div class="form-group">
                      <label for="inputName">Design Name</label>
                      <input type="text" name="designname" class="form-control" required="">
                    </div>
                    <div class="form-group">
                      <label for="inputStatus">Category</label>
                      <select class="form-control custom-select" name="cat" id="cat" onchange="getdata();" required="">
                        <option selected disabled>Select one</option>
                        <?php 
                           $selectquery="SELECT c_id,categoryname FROM `tbl_category` where status='A'";
                              $result= mysqli_query($con, $selectquery);
                                while ($row= mysqli_fetch_assoc($result))
                                {
                        ?>
                        <option value="<?php echo $row['c_id'];?>"><?php echo $row['categoryname'];?></option>
                        <?php 
                                }
                        ?>
                      </select>
                    </div>
                    <div class="form-group">
                      <label for="inputStatus">Sub-Category</label>
                      <select class="form-control custom-select" name="subcat" id="subcat">
                        <option selected disabled>Select one</option>
                      </select>
                    </div>
                    <div class="form-group">
                      <label for="inputClientCompany">Upload Design Image</label>
                      <input type="file" name="designimage[]" multiple class="form-control" required="">
                    </div>
                    <div class="form-group">
                      <label for="inputProjectLeader">Price</label>
                      <input type="text" name="price" class="form-control" required="">
                    </div>
                  </div>
                  <!-- /.card-body -->
                </div>
                <!-- /.card -->
                
              </div>
              <div class="col-12">
                  <a href="#"><input type="reset" value="cancel" class="btn btn-secondary"></a>
                <input type="submit" value="Upload Design" name='uploaddesign' class="btn btn-success float-right">
              </div>
            </div>
            </form>
          </section>
        <hr>
        <!-- design entry end-->
    </section>
  </div>
  <?php 
  include './adminfooter.php';
  ?>
  <!-- /.content-wrapper -->
</div>
<!-- ./wrapper -->

<script type="text/javascript">

    function getdata()
    {
        var XMLHttp=new XMLHttpRequest();
        XMLHttp.open("GET","ajax.php?type=cat&value="+document.getElementById('cat').value,false);
        XMLHttp.send(null);
        document.getElementById('subcat').innerHTML=XMLHttp.responseText;
    }

</script>
</body>
</html>