<!DOCTYPE html>
<html lang="en">
  <head>
    <title>PrintShop</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <style>
    </style>
  </head>
  <body>
   <?php 
    include_once './stylelink.php';
  ?>
  <div class="site-wrap">
    <?php
        session_start();
        include './connection.php';
        if(empty($_SESSION['emailid']))
           {
               include 'header.php';
           }
           else
           {
               include './userheader.php';
           }
    ?>
      
      
    <!--Add wishlist-->  
    
    <!--end wishlist-->
    <div class="bg-light py-3">
      <div class="container">
        <div class="row">
          <div class="col-md-12 mb-0"><a href="index.php">Home</a> <span class="mx-2 mb-0">/</span> <strong class="text-black">Designs</strong></div>
        </div>
      </div>
    </div>

    <div class="site-section">
      <div class="container">

        <div class="row mb-5">
          <div class="col-md-9 order-2">

            <div class="row">
              <div class="col-md-12 mb-5">
                  <?php 
                    if(empty($_GET['type']))
                    {
                        $temp='All Design';
                    }
                    else
                    {
                        $temp=$_GET['type'];
                    }
                  ?>
                  <div class="float-md-left mb-4"><h2 class="text-black"><?php echo $temp;?></h2></div>
                <div class="d-flex">
                  <div class="dropdown mr-1 ml-md-auto">
                    <button type="button" class="btn btn-secondary btn-sm dropdown-toggle" id="dropdownMenuOffset" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                      Select Category
                    </button>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuOffset">
                        <?php 
                            
                            $selectquery="select categoryname from tbl_category where status='A'";
                            
                            $result= mysqli_query($con, $selectquery);
                            
                            while($row= mysqli_fetch_assoc($result))
                            {
                            
                        ?>
                        <a class="dropdown-item" href="designs.php?type=<?php echo $row['categoryname'];?>"><?php echo $row['categoryname'];?></a>
                      <?php
                            }
                     ?>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="row mb-5">
            <?php 
                if(isset($_GET['type']))
                {
                    $selectquery="select design_id,designimage,designname,price from tbl_design inner join tbl_subcategory on tbl_design.subcategoryid=tbl_subcategory.sc_id inner join tbl_category on tbl_subcategory.categoryid=tbl_category.c_id where categoryname='".$_GET['type']."' and tbl_design.status='A' order by design_id desc";
                    $result= mysqli_query($con, $selectquery);
                    
                    if(mysqli_num_rows($result)==0)
                    {
                        $selectquery="select design_id,designimage,designname,price from tbl_design inner join tbl_category on tbl_design.categoryid=tbl_category.c_id where categoryname='".$_GET['type']."' and tbl_design.status='A' order by design_id desc";
                        $result= mysqli_query($con, $selectquery);
                    }
                    if(mysqli_num_rows($result)>0)
                    {
                        while($row= mysqli_fetch_assoc($result))
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
                        <div class="col-sm-6 col-lg-4 mb-4">
                                <div class="block-4 text-center border" data-aos="fade" data-aos-delay="100">
                                    <figure class="block-4-image">
                                        <?php 
                                            $imagearr= explode(',', $row['designimage']);
                                            foreach ($imagearr as $val)
                                             {
                                                 if(!preg_match('/back/', $val))
                                                 {
                                        ?>
                                        <a href="singledesign.php?id=<?php echo $row['design_id'];?>"><img src="Adminpanel/<?php echo $val;?>" alt="Image placeholder" class="img-fluid"></a>
                                        <?php 
                                                 }
                                             }
                                        ?>
                                    </figure>
                                    <div class="block-4-text p-1">
                                        <h4><a href="singledesign.php?id=<?php echo $row['design_id'];?>"><?php echo $row['designname']; ?></a></h4>
                                        <p class="text-black font-weight-bold">Rs.<?php echo $row['price'];?></p>
                                        <P><a href="singledesign.php?id=<?php echo $row['design_id'];?>"><button class="btn btn-white"><i class="fas fa-eye"></i></button></a>&nbsp;<a href="wishlist.php?id=<?php echo $row['design_id'];?>"><button type="button" class="btn btn-white" name="wish"><i class="icon-heart"></i></button></a>&nbsp;<a href="singledesign.php?id=<?php echo $row['design_id'];?>"><button type="button" class="btn btn-white"><i class="fas fa-star"></i><?php echo $avgrate;?></button></a></P>
                                    </div>
                                </div>
                            </div>
                <?php
                            
                        }
                    }
                    else
                    {
                        echo '<h1>Record Not Found!!</h1>';
                    }
                }
                else
                {
            ?>
              <div class="col-sm-6 col-lg-4 mb-4" data-aos="fade-up">
                <div class="block-4 text-center border">
                  <figure class="block-4-image">
                    <a href=""><img src="images/vcard6.jpg" alt="Image placeholder" class="img-fluid" style="height: 230px;"></a>
                  </figure>
                  <div class="block-4-text p-4">
                      <h3><a href="designs.php?type=VISITING CARD">Visiting card</a></h3>
                    
                    <p class="text-primary font-weight-bold">Rs.12</p>
                  </div>
                </div>
              </div>
              <div class="col-sm-6 col-lg-4 mb-4" data-aos="fade-up">
                <div class="block-4 text-center border">
                  <figure class="block-4-image">
                    <a href=""><img src="images/vcard3.jpg" alt="Image placeholder" class="img-fluid" style="height: 230px;"></a>
                  </figure>
                  <div class="block-4-text p-4">
                    <h3><a href="designs.php?type=VISITING CARD">Visiting Card</a></h3>
                  
                    <p class="text-primary font-weight-bold">Rs 20</p>
                  </div>
                </div>
              </div>
              <div class="col-sm-6 col-lg-4 mb-4" data-aos="fade-up">
                <div class="block-4 text-center border">
                  <figure class="block-4-image">
                    <a href=""><img src="images/vcard4.jpg" alt="Image placeholder" class="img-fluid" style="height: 230px;"></a>
                  </figure>
                  <div class="block-4-text p-4">
                    <h3><a href="designs.php?type=VISITING CARD">Visiting Card</a></h3>
                    <p class="text-primary font-weight-bold">Rs50</p>
                  </div>
                </div>
              </div>

              <div class="col-sm-6 col-lg-4 mb-4" data-aos="fade-up">
                <div class="block-4 text-center border">
                  <figure class="block-4-image">
                    <a href=""><img src="images/envlop2.jpg" alt="Image placeholder" class="img-fluid" style="height: 230px;"></a>
                  </figure>
                  <div class="block-4-text p-4">
                    <h3><a href="designs.php?type=ENVELOPER">Enveloper</a></h3>
                    <p class="text-primary font-weight-bold">Rs50</p>
                  </div>
                </div>
              </div>
              <div class="col-sm-6 col-lg-4 mb-4" data-aos="fade-up">
                <div class="block-4 text-center border">
                  <figure class="block-4-image">
                    <a href=""><img src="images/envlop5.jpg" alt="Image placeholder" class="img-fluid" style="height: 230px;"></a>
                  </figure>
                  <div class="block-4-text p-4">
                    <h3><a href="designs.php?type=ENVELOPER">Enveloper</a></h3>
                    <p class="text-primary font-weight-bold">Rs50</p>
                  </div>
                </div>
              </div>
              <div class="col-sm-6 col-lg-4 mb-4" data-aos="fade-up">
                <div class="block-4 text-center border">
                  <figure class="block-4-image">
                    <a href=""><img src="images/envlop4.jpg" alt="Image placeholder" class="img-fluid" style="height: 230px;"></a>
                  </figure>
                  <div class="block-4-text p-4">
                    <h3><a href="designs.php?type=ENVELOPER">Enveloper</a></h3>
                    <p class="text-primary font-weight-bold">Rs50</p>
                  </div>
                </div>
              </div>
              <div class="col-sm-6 col-lg-4 mb-4" data-aos="fade-up">
                <div class="block-4 text-center border">
                  <figure class="block-4-image">
                    <a href=""><img src="images/incard5.jpg" alt="Image placeholder" class="img-fluid" style="height: 230px;"></a>
                  </figure>
                  <div class="block-4-text p-4">
                    <h3><a href="designs.php?type=INVITATION CARD">Invitation Card</a></h3>
                    <p class="text-primary font-weight-bold">Rs50</p>
                  </div>
                </div>
              </div>
              <div class="col-sm-6 col-lg-4 mb-4" data-aos="fade-up">
                <div class="block-4 text-center border">
                  <figure class="block-4-image">
                    <a href=""><img src="images/incard3.jpg" alt="Image placeholder" class="img-fluid" style="height: 230px;"></a>
                  </figure>
                  <div class="block-4-text p-4">
                    <h3><a href="designs.php?type=INVITATION CARD">Invitation Card</a></h3>
                    <p class="text-primary font-weight-bold">Rs50</p>
                  </div>
                </div>
              </div>
              <div class="col-sm-6 col-lg-4 mb-4" data-aos="fade-up">
                <div class="block-4 text-center border">
                  <figure class="block-4-image">
                    <a href=""><img src="images/incard6.jpg" alt="Image placeholder" class="img-fluid" style="height: 230px;"></a>
                  </figure>
                  <div class="block-4-text p-4">
                    <h3><a href="designs.php?type=INVITATION CARD">Invitation Card</a></h3>
                    <p class="text-primary font-weight-bold">Rs50</p>
                  </div>
                </div>
              </div>
               <?php 
                }
               ?>
            </div>
          </div>
              <div class="mb-4">
              <div class="p-4 border mb-4">
                <h3 class="mb-3 h6 text-uppercase text-black d-block">Available Designs</h3>
                <a href="designs.php?type=VISITING CARD" class="d-flex color-item align-items-center" >
                  <span class="bg-danger color d-inline-block rounded-circle mr-2"></span> <span class="text-black">Visiting card</span>
                </a>
                <a href="designs.php?type=TAG" class="d-flex color-item align-items-center" >
                  <span class="bg-success color d-inline-block rounded-circle mr-2"></span> <span class="text-black">Tag</span>
                </a>
                <a href="designs.php?type=I-CARD" class="d-flex color-item align-items-center" >
                  <span class="bg-info color d-inline-block rounded-circle mr-2"></span> <span class="text-black">I-card </span>
                </a>
                <a href="designs.php?type=ENVELOPER" class="d-flex color-item align-items-center" >
                  <span class="bg-primary color d-inline-block rounded-circle mr-2"></span> <span class="text-black">Enveloper</span>
                </a>
              </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <?php 
            include 'footer.php';
    ?>
  </div>
  </body>
</html>