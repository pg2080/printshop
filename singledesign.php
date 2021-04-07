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
           if(empty($_SESSION['emailid']))
           {
               include 'header.php';
           }
           else
           {
               $select="select user_id from tbl_user where email='".$_SESSION['emailid']."'";
                    $result= mysqli_query($con, $select);
                    $row= mysqli_fetch_assoc($result);
                    $id=$row['user_id'];
               include './userheader.php';
           }
           
           if(!isset($_GET['id']))
           {
               echo "<script>window.location='login.php'</script>";
           }
    ?>
    <style>
    </style>
    <link href="css/bootstrap/image.css" rel="stylesheet" type="text/css"/>
  </head>
  <body>
  
      
  <div class="site-wrap">
    <div class="bg-light py-3">
      <div class="container">
        <div class="row">
          <div class="col-md-12 mb-0"><a href="index.html">Home</a><span class="mx-2 mb-0">/</span><strong class="text-black">Designs</strong></div>
        </div>
      </div>
    </div>  
      <?php 
                    
                    
      
      
                    $selectquery="select * from tbl_design where design_id='".$_GET['id']."'";
                    $result= mysqli_query($con, $selectquery);
                    $row= mysqli_fetch_assoc($result);
                        
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
                            $subcatname='';
                        }
//                        start to get designer email
                        
                       
                    ?>

    <div class="site-section">
      <div class="container">
        <div class="row">
              <!-- Main content -->
                    <section class="content">
                      <!-- Default box -->
                      <div class="card card-solid">
                        <div class="card-body">
                          <div class="row">
                            <div class="col-8">
                                <input type="hidden" id="did" value="<?php echo $_GET['id']?>"/>
                                <input type="hidden" id="uid" value="<?php echo $id?>"/>
                              <div class="col-12">
                                  <?php
                                        $imagearr = explode(',', $row['designimage']);
                                  ?>
                                  <img src="Adminpanel/<?php echo $imagearr[0];?>" class="product-image img-responsive img-thumbnail" alt="Product Image">
                              </div>
                              <div class="col-12 product-image-thumbs">
                                  <?php
                                        foreach ($imagearr as $val) {
//                                            if (!preg_match('/back/', $val))
//                                            {
                                                ?>
                                  <div class="product-image-thumb"><img src="Adminpanel/<?php echo $val;?>" alt="Product Image"></div>
                                  <?php
//                                        }
                                        }
                                  ?>
                              </div>
                              </div>
                              <div class="col-4">
                                  <div class="well bg-info">
                                      <div class="">
                                          <h4 class="card-title text-black">About Design</h4>
                                </div>
                                <!-- /.card-header -->
                                <div class="card-body text-black">
                                    
                                    <p class="text-black">
                                        <strong>Details :</strong>
                                        <?php echo $row['designname']; ?>
                                          <hr>
                                    </p>
                                  
                                    
                                    <p class="text-black">
                                        <strong> Category :</strong>
                                        <?php echo $catname; ?>
                                          <hr>
                                    </p>
                                    
                                    <p class="text-black"> 
                                        <strong> Price :</strong>
                                        <i class="fas fa-rupee-sign"></i>
                                        <?php echo $row['price']; ?>
                                          <hr>
                                    </p>
                                    <?php 
                                        $query1="select count(*) as count,firstname,lastname from tbl_user inner join tbl_uploaddesign on tbl_user.user_id=tbl_uploaddesign.designerid inner join tbl_design on tbl_uploaddesign.designid=tbl_design.design_id where tbl_uploaddesign.designid='".$row['design_id']."'";
                                            $rs1= mysqli_query($con, $query1);
                                            $r1= mysqli_fetch_assoc($rs1);

                                        if($r1['count']=="1")
                                        {
                                            ?>
                                            <p class="text-black"> 
                                                <strong> Designer :</strong>
                                                <?php echo $r1['firstname'].' '.$r1['lastname']; ?>
                                                  <hr>
                                            </p>
                                    <?php
                                        }
                                    ?>
                                    
                                        <?php 
                                        if(!empty($id))
                                        {
                                        ?>
                                            
                                            <p>
                                                <strong>Rate-us </strong>
                                                <i class="f fas fa-star " data-index="0" style="color: white"></i> 
                                                <i class="f fas fa-star " data-index="1" style="color: white"></i>
                                                <i class="f fas fa-star " data-index="2" style="color: white"></i>
                                                <i class="f fas fa-star " data-index="3" style="color: white"></i>
                                                <i class="f fas fa-star " data-index="4" style="color: white"></i>
                                            </p>
                                        <?php
                                                $select="select cast(avg(ratepoint)as decimal(10,1)) as avgrate from tbl_rate where designid='".$_GET['id']."'";
                                                $result= mysqli_query($con, $select);
                                                $r= mysqli_fetch_assoc($result);
                                                ?>
                                                
                                                <p>
                                                    <strong>Design rate </strong>
                                                <i class="fas fa-star fa-2x text-warning" style="color: black"></i>&nbsp;<strong><?php echo $r['avgrate']?></strong>
                                        <?php
                                        }
                                        else
                                        {
                                            $select="select cast(avg(ratepoint) as decimal(10,1)) as avgrate from tbl_rate where designid='".$row['design_id']."'";
                                            $res= mysqli_query($con, $select);
                                            $r= mysqli_fetch_assoc($res);
                                            if($r['avgrate']=="0")
                                            {
                                                $avgrate=NULL;
                                            }
                                            else
                                            {
                                                $avgrate=$r['avgrate'];
                                            }
                                            ?>
                                                
                                                <p>
                                                    <strong>Design rate :</strong>
                                                <i class="fas fa-star fa-2x text-warning" style="color: black"></i>&nbsp;<strong><?php echo $avgrate?></strong>
                                        <?php
                                        }
                                        ?>
                                    </p>
                                    <p class="text-black"></p>
                                </div>
                                <?php 
                                if(!empty($id))
                                        {
                                ?>
                                <p><a href="addprintdetails.php?id=<?php echo $row['design_id'];?>" class="buy-now btn btn-sm btn-warning">Continue <i class="fas fa-arrow-circle-right"></i></a></p>
                                <?php }?>
                                  </div>
                              </div>
                          </div>
                        </div>
                      </div>
                    </section>
            </div>
          </div>
        </div>
      </div>
    </div>

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
          
     <!--rating jquery-->
     <script>
         $(document).ready(function() {
             var ratedpoint=-1;
             var did=document.getElementById('did').value;
             var uid=document.getElementById('uid').value;
             
               if(localStorage.getItem('ratedpoint')!=null)
               {
               }
                $('.f').on('click',function() {
                    ratedpoint=parseInt($(this).data('index'));
                    savedata();
                    });
             
                $('.f').mouseover(function() {
                    var currentindex=parseInt($(this).data('index'));
                    set(currentindex);
                    });
                    
                $('.f').mouseleave(function() {
                        reset();
                        if(ratedpoint!=-1)
                        {
                           set(ratedpoint);
                        }
                    });
                    
                function savedata()
                {
                    $.ajax({
                       url: "rateajax.php",
                       method:"POST",
                       data:{ratepoint:ratedpoint+1,designid:did,userid:uid},
                       success: function (data) { 
                           setTimeout(function(){// wait for 5 secs(2)
                                    location.reload(); // then reload the page.(3)
                               },10);
                             }
                    });
                }
                    
                function set(max)
                {
                     for(var i=0;i<=max;i++)
                            {
                                $('.f:eq('+i+')').css('color','gold');
                            }
                }
                function reset()
                {
                    $('.f').css('color','white');
                }
         });
     </script>
     <!--rating jquery-->
  </div>    
  </body>
</html>