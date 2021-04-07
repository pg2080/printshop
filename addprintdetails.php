<!DOCTYPE html>
<html>
  <head>
    <title>PrintShop</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <?php 
    session_start();
    include './connection.php';
    include './stylelink.php';
    include './redirect.php';
    
           if(empty($_SESSION['emailid']))
           {
               include 'header.php';
           }
           else
           {
               include './userheader.php';
           }
    ?>
    <?php
//  pd means print details
    $pd=array('name'=>'','pname'=>'','cname'=>'','designation'=>'','line1'=>'','line2'=>'','line3'=>'','line4'=>'','logo'=>'','id'=>'');
    $multi=array('xml'=>'','zip'=>'','id'=>'','pname'=>'');
    $str='';
    if(isset($_GET['id']))
        $id=$_GET['id'];
    if(isset($_GET['data']))
    {
        $data= unserialize($_GET['data']);
                
        $pd['name']=$data['name'];
        $pd['pname']=$data['pname'];
        $pd['cname']=$data['cname'];
        $pd['designation']=$data['designation'];
        $pd['line1']=$data['line1'];
        $pd['line2']=$data['line2'];
        $pd['line3']=$data['line3'];
        $pd['line4']=$data['line4'];
        $pd['logo']=$data['logo'];
        $str=$pd['logo'];
        $pd['id']=$data['id'];
        $id=$pd['id'];
    }
    ?>
    <style>
        .imagesize{
            width: 25%;
            height: 50%;
            align-content: center;
        }
    </style>
    <link href="css/bootstrap/image.css" rel="stylesheet" type="text/css"/>
    <link href="css/bootstrap/upload.css" rel="stylesheet" type="text/css"/>
  </head>
  <body>
  <?php 
        $flag=1;
        $plogo=array();
         function getimage($name,$tempname)
         {
                      $imagearr=array();
                      $imagestr='';
                      $targetDir = "uploadlogo/";
                      $allowTypes = array('jpg','png','jpeg');
                      $fileNames = array_filter($name);
                      if(!empty($fileNames))
                      {
                              foreach($name as $key=>$val){ 
                                      // File upload path 
                                      $file = basename($name[$key]);
                                      $filename = pathinfo($file,PATHINFO_FILENAME);
                                      $fileType = pathinfo($file,PATHINFO_EXTENSION);
                                      $targetFilePath = $targetDir.$filename.'.png';

                                      array_push($imagearr, $targetFilePath);

                                      if(in_array($fileType, $allowTypes)){
                                          
                                          if(!file_exists($targetFilePath))
                                          {
                                                if(move_uploaded_file($tempname[$key], $targetFilePath))
                                                    {
                                                        $flag=1;
                                                    }
                                                    else
                                                    { 
                                                        $flag=0;
                                                    }
                                          }
                                          else
                                          {
                                              echo "<script>alert('file already exists');</script>";
                                          }
                                      }
                                      else
                                      {
                                          echo "<script>alert('select image file only);</script>";
                                      }
                                  }
                                  return $imagestr= implode(",", $imagearr);
                       }
                       else
                       {
                           return $pd['logo'];
                       }
  }
  if(isset($_POST['datasubmit']))
    {
        $pd['name']=$_POST['name'];
        $pd['pname']=$_POST['pname'];
        $pd['cname']=$_POST['cname'];
        $pd['designation']=$_POST['designation'];
        $pd['line1']=$_POST['line1'];
        $pd['line2']=$_POST['line2'];
        $pd['line3']=$_POST['line3'];
        $pd['line4']=$_POST['line4'];
        $pd['logo']=$_POST['image'];
        $pd['id']=$id;
        $data= serialize($pd);
        redirect("viewprintdetails.php?data=$data");
    }
    else if(isset ($_POST['uploadimage']))
    {
        $str=getimage($_FILES['imagefile']['name'], $_FILES['imagefile']['tmp_name']);
        $pd['logo']=$str;
        echo $pd['logo'];   
    }
  ?>
      <!--multiple print option code-->
      <?php
        function getxmlfiles($name,$tempname)
         {
                      $imagearr=array();
                      $imagestr='';
                      $targetDir = "uploadfile/";
                      $allowTypes = array('xml','xlsx','xls');
                      $fileNames = array_filter($name);
                      if(!empty($fileNames))
                      {
                              foreach($name as $key=>$val){ 
                                      // File upload path 
                                      $file = basename($name[$key]);
                                      $filename = pathinfo($file,PATHINFO_FILENAME);
                                      $fileType = pathinfo($file,PATHINFO_EXTENSION);
                                      $targetFilePath = $targetDir.$filename.".".$fileType;

                                      array_push($imagearr, $targetFilePath);

                                      if(in_array($fileType, $allowTypes)){
                                          
                                          if(!file_exists($targetFilePath))
                                          {
                                                if(move_uploaded_file($tempname[$key], $targetFilePath))
                                                    {
                                                        return $imagestr= implode(",", $imagearr);
                                                    }
                                                    else
                                                    { 
                                                        $flag=0;
                                                    }
                                          }
                                          else
                                          {
                                              echo "<script>alert('file already exists');</script>";
                                          }
                                      }
                                      else
                                      {
                                          echo "<script>alert('select xml or zip file only file only');</script>";
                                      }
                                  }
                                  
                       }
                       else
                       {
                           //return $pd['logo'];
                       }
            }
         function getzipfiles($name,$tempname)
         {
                      $imagearr=array();
                      $imagestr='';
                      $targetDir = "uploadfile/";
                      $allowTypes = array('zip','rar');
                      $fileNames = array_filter($name);
                      if(!empty($fileNames))
                      {
                              foreach($name as $key=>$val){ 
                                      // File upload path 
                                      $file = basename($name[$key]);
                                      $filename = pathinfo($file,PATHINFO_FILENAME);
                                      $fileType = pathinfo($file,PATHINFO_EXTENSION);
                                      $targetFilePath = $targetDir.$filename.".".$fileType;

                                      array_push($imagearr, $targetFilePath);

                                      if(in_array($fileType, $allowTypes)){
                                          
                                          if(!file_exists($targetFilePath))
                                          {
                                                if(move_uploaded_file($tempname[$key], $targetFilePath))
                                                    {
                                                        return $imagestr= implode(",", $imagearr);
                                                    }
                                                    else
                                                    { 
                                                        $flag=0;
                                                    }
                                          }
                                          else
                                          {
                                              echo "<script>alert('file already exists');</script>";
                                          }
                                      }
                                      else
                                      {
                                          echo "<script>alert('select xml or zip file only file only');</script>";
                                      }
                                  }
                                  
                       }
                       else
                       {
                           //return $pd['logo'];
                       }
            }
      
      
        if(isset($_POST['uploadmultiple']))
        {
            
            $strxml= getxmlfiles($_FILES['xmlfile']['name'], $_FILES['xmlfile']['tmp_name']);
            $strzip= getzipfiles($_FILES['zipfile']['name'], $_FILES['zipfile']['tmp_name']);
            
            $multi['pname']=$_POST['pname'];
            $multi['xml']=$strxml;
            $multi['zip']=$strzip;
            $multi['id']=$id;
            $data= serialize($multi);
            
            if($strxml!=NULL && $strzip!=NULL)
            {
            redirect("viewprintdetails.php?multidata=$data");
            }
        }      

      ?>
      
  <div class="site-wrap">
    <div class="bg-light py-3">
      <div class="container">
        <div class="row">
          <div class="col-md-12 mb-0"><a href="index.html">Home</a><span class="mx-2 mb-0">/</span><a class="text-black">Designs</a><span class="mx-2 mb-0">/</span><strong class="text-black">Add Print Detail</strong></div>
        </div>
      </div>
    </div>  
  </div>
      <hr>
      <!-- add details start -->
      <section class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="">
                                    <ul class="nav nav-tabs nav-justified">
                                        <li class="nav-item "><a class="nav-link active" href="#printdetails" data-toggle="tab"><img src="./images/texticon.png" class="img-responsive imagesize">Details</a></li>
                                        <li class="nav-item "><a class="nav-link" href="#uploadlogo" data-toggle="tab"><img src="./images/imageicon.png" class="img-responsive imagesize">Logo</a></li>
                                        <li class="nav-item "><a class="nav-link" href="#multiple" data-toggle="tab"><img src="./images/uploadicon.png" class="img-responsive imagesize">Multiple</a></li>
                                    </ul>
                            </div>
                            <!--- print details -->
                            <div class="tab-content text-black">
                                <div class="active tab-pane fade-in-up" id="printdetails">
                                    <form action="#" method="post">
                                        <div class="form-group row">
                                                <div class="col-md-12">
                                                    <label for="name" class="text-black">Project Name: <span class="text-danger"></span></label>
                                                    <input type="text" class="form-control" name="pname" pattern="[a-zA-Z0-9 ]{0,20}" value="<?php echo $pd['pname']; ?>" required="">
                                                </div>
                                            </div>
                                        <div class="p-3 p-lg-5 border">
                                            <div class="form-group row">
                                                <div class="col-md-12">
                                                    <label for="name" class="text-black">Name <span class="text-danger"></span></label>
                                                    <input type="text" class="form-control" name="name" pattern="[a-zA-Z ]{0,20}" value="<?php echo $pd['name']; ?>" required="">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <div class="col-md-12">
                                                    <label for="designation" class="text-black">Designation <span class="text-danger"></span></label>
                                                    <input type="text" class="form-control" name="designation" placeholder="" pattern="[a-zA-Z0-9 /-]{0,20}" value="<?php echo $pd['designation']; ?>" required="">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <div class="col-md-12">
                                                    <label for="line1" class="text-black">Company Name</label>
                                                    <input type="text" class="form-control" id="c_subject" name="cname" pattern="[a-zA-Z0-9 .-]{0,30}" value="<?php echo $pd['cname']; ?>" required="">
                                                </div>
                                            </div>
                                            <div class="form-group row well-sm">
                                                <div class="col-md-12">
                                                    <label for="line1" class="text-black">Line 1 </label>
                                                    <input type="text" class="form-control" id="c_subject" name="line1" maxlength="30" value="<?php echo $pd['line1']; ?>">
                                                </div>
                                                <div class="col-md-12">
                                                    <label for="line2" class="text-black">Line 2 </label>
                                                    <input type="text" class="form-control" id="c_subject" name="line2" maxlength="30" value="<?php echo $pd['line2']; ?>">
                                                </div>
                                                <div class="col-md-12">
                                                    <label for="line3" class="text-black">Line 3 </label>
                                                    <input type="text" class="form-control" id="c_subject" name="line3" maxlength="30" value="<?php echo $pd['line3']; ?>" >
                                                </div>
                                                <div class="col-md-12">
                                                    <label for="line4" class="text-black">Line 4 </label>
                                                    <input type="text" class="form-control" id="c_subject" name="line4" maxlength="30" value="<?php echo $pd['line4']; ?>">
                                                </div>
                                                <input type="hidden" name="image" value="<?php echo $str;?>"/>
                                            </div>

                                            <div class="form-group row">
                                                <div class="col-lg-12">
                                                    <input type="submit" class="btn btn-info btn-lg btn-block" value="continue" name="datasubmit" >
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <!--end print details-->
                                <div class="tab-pane fade-in-up" id="uploadlogo">
                                    <form action="#" method="post" enctype='multipart/form-data'>   
                                    <div class="text-center well">
                                            <div class="title">
                                                <h1>Drop file to upload</h1>
                                            </div>
                                        <hr>
                                            <div class="dropzone center-block">
                                                <img src="./images/uploadicon.png" class="img-responsive" />
                                                <input type="file" name="imagefile[]" class="upload-input" multiple="" required=""/>
                                            </div>
                                            
                                        <hr>
                                        <button type="submit" class="btn center-block" name="uploadimage">Upload file</button>
                                        <hr>
                                        <div class="col-12 well text-left">
                                                <p>
                                                    <strong>1</strong> Upload Logo image with imagename as "logo"<br>
                                                    <strong>2</strong> Upload Person image with imagename as "person"<br>
                                                </p>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div class="tab-pane fade-in-up" id="multiple">
                                    <form action="#" method="post" class="row" enctype="multipart/form-data">   
                                        <div class="col-md-12">
                                                    <label for="name" class="text-black">Project Name: <span class="text-danger"></span></label>
                                                    <input type="text" class="form-control" name="pname" pattern="[a-zA-Z0-9]{0,20}" value="<?php echo $multi['pname']; ?>" required="">
                                        </div>
                                        <div class="text-center well-sm">
                                            <div class="title">
                                                <h1>Upload Files</h1>
                                            </div>
                                        <div class="row">
                                            <div class="col-6 text-info">
                                                Upload .xml/.xls file here
                                            </div>
                                            <div class="col-6 text-info">
                                                Upload .zip file of image file here
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="row col-md-12">
                                            <div class="dropzone center-block col-md-6">
                                                <img src="./images/uploadicon.png" class="img-responsive" />
                                                <input type="file" name="xmlfile[]" class="upload-input" required=""/>
                                            </div>
                                         <div class="dropzone center-block col-md-6">
                                                <img src="./images/uploadicon.png" class="img-responsive" />
                                                <input type="file" name="zipfile[]" class="upload-input" required=""/>
                                            </div>
                                        </div>
                                        <hr>
                                        <button type="submit" class="btn center-block" name="uploadmultiple">Upload file</button>
                                        <hr>
                                        <div class="col-12 well-sm">
                                            <div col-12>
                                                <?php 
                                                    $files= scandir("sample");
                                                ?>
                                                Download sample XLS file &nbsp;<a download="<?php echo $files[2]; ?>" href="sample/<?php echo $files[2];?>"><button type="button" class="btn-xs btn-success"><i class="fas fa-download"></i></button></a>
                                            </div>
                                            <div class="col-12 well text-left">
                                                <h3>How it Works?</h3>
                                                <p>
                                                    <strong>1</strong> Download sample excel file.<br>
                                                    <strong>2</strong> Please dont edit the first row of sample file.<br>
                                                    <strong>3</strong> Fill up xls file and upload xls file in first upload button.<br>
                                                    <strong>4</strong> Please zip all your image and upload in second button.<br>
                                                    <strong>5</strong> In the Excel please mention image name for each row.
                                                </p>
                                            </div>
                                        </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-9">
                            <div class="well-sm">
                             <?php 
                                $selectquery="select designimage from tbl_design where design_id='".$id."'";
                                $result= mysqli_query($con, $selectquery);
                                $row= mysqli_fetch_assoc($result);
                             ?>      
                            <?php
                                        $imagearr = explode(',', $row['designimage']);
                                        foreach ($imagearr as $val) {
                                            if (!preg_match('/back/', $val))
                                            {
                                  ?>
                                    <img src="Adminpanel/<?php echo $val;?>" class="product-image img-responsive img-thumbnail" alt="Product Image">
                              <?php
                                break;
                                            }
                                        }
                                ?>
                              </div>
                              <div class="col-12 product-image-thumbs">
                                  <?php
                                        foreach ($imagearr as $val) {
                                                ?>
                                  <div class="product-image-thumb"><img src="Adminpanel/<?php echo $val;?>" alt="Product Image"></div>
                                  <?php
                                    }
                                  ?>
                              </div>
                            <br>
                            <div class="well">
                                <span class="text-danger">*</span><strong>NOTE:</strong><span class="text-danger"> You will get your design in same font type and size for your details.</span>
                            </div>
                            
                            </div>
                        </div>
                    </div>
      </section>
      <hr>
      <!-- add details end -->
    <?php 
        include './footer.php';
    ?>
    <script src="./Adminpanel/plugins/jquery/jquery.min.js"></script>
            <!-- Bootstrap 4 -->
            <script src="./Adminpanel/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
            <!-- AdminLTE App -->
            <script src="./Adminpanel/dist/js/adminlte.min.js"></script>
          <!-- AdminLTE for demo purposes -->
          <script src="./Adminpanel/dist/js/demo.js"></script>
  </div>    
  </body>
</html>