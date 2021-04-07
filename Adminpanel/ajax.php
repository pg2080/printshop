<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <?php
        include '../connection.php';
        $pd=array();
        $total=0;
        if(isset($_POST['id']))
        {
            $select="select tbl_design.*,tbl_cartdetails.*,tbl_printdetails.* from tbl_cartdetails inner join tbl_cart on tbl_cart.cart_id=tbl_cartdetails.cartid inner join tbl_design on tbl_design.design_id=tbl_cartdetails.designid inner join tbl_printdetails on tbl_printdetails.print_id=tbl_cartdetails.printdetailsid where cart_id='".$_POST['id']."'";
                    $result= mysqli_query($con, $select);
                    while($row= mysqli_fetch_assoc($result))
                    {   
            ?>
                   
        <div class="card-body">
            <div class="row text-black bg-warning p-2">
                <?php if($row['details']!=NULL)
                        {
                            $pd= explode(",", $row['details']);
                    ?>
                <div class="col-md-6">
                    <p> <strong class="text-black"><?php echo $row['designname'];?></strong></p>
                    <p> <strong>Projectname :</strong><?php echo $row['ordername'];?></p>
                    <P> <strong>Name:</strong><?php echo $pd[0];?></p>
                    <p> <strong>Designation:</strong><?php echo $pd[3];?></p>
                    <p><strong>Company Name:</strong><?php echo $pd[2];?></p>
                </div>
                <div class="col-md-6">
                        <p><strong class="">Details</strong><br><?php echo $pd[4]."<br>".$pd[5]."<br>".$pd[6]."<br>".$pd[7];?></p>
                <?php }
                    else
                    {?>
                    <div class="col-md-6">
                    <p> <strong class="text-black"><?php echo $row['designname'];?></strong></p>
                    <p> <strong>Projectname :</strong><?php echo $row['ordername'];?></p>   
                    </div>
                    <div class="col-md-12">    
                        <p> <strong>Details File:</strong><?php echo $row['multiplename']?></p>
                      <p><strong>Image File :</strong><?php echo $row['multipleimage'];?></p>
                    <?php }?>
                    <p><strong>Lamination:</strong><?php echo $row['lamination'];?></p>
                    <p><strong>Cornor:</strong><?php echo $row['cornor'];?></p>
                </div>
                <div class="col-md-12 row">
                    <?php 
                        if($row['details']!=NULL)
                        {
                    ?>
                    <p class="col-md-3"><strong>Quantity:</strong><?php echo $row['quantity'];?></p>
                    <p class="col-md-3"><strong>Price:</strong> Rs <?php echo $row['price'];?></p>
                    <p class="col-md-4"><strong>TotalAmount:</strong><?php echo $row['price']*$row['quantity'];
                    $total=$total+($row['price']*$row['quantity']);
                     } else {
                         ?>
                   <p class="col-md-3"><strong>Quantity:</strong><?php echo $row['quantity']*$row['nooflines'];?></p>
                    <p class="col-md-3"><strong>Price:</strong> Rs <?php echo $row['price'];?></p>
                    <p class="col-md-4"><strong>TotalAmount:</strong><?php echo $row['price']*$row['quantity']*$row['nooflines'];
                    $total=$total+($row['price']*$row['quantity']*$row['nooflines']);
                     }?>
                    </p>
                </div>
            </div>            
        </div>
        </div>
  
            
        
              <?php
                    }
                    ?>
            <strong class="bg-dark col-md-12">Total Amount : Rs <?php echo $total;?></strong>
                <?php     
        }
        if(isset($_REQUEST['type']))
        {
            if($_REQUEST['type']=='cat')
            {
                echo 'step 1';
                $catid=$_GET['value'];
                
                $selectquery="SELECT sc_id,subcategoryname FROM tbl_subcategory where categoryid=$catid and status='A'";
                $result= mysqli_query($con, $selectquery);
                
        ?>
                      <select class="form-control custom-select" name="subcat" id='subcat'>
                        <option selected disabled>Select one</option>
                        <?php 
                        while ($row= mysqli_fetch_assoc($result))
                        {
                        ?>
                        <option value="<?php echo $row['sc_id'];?>"><?php echo $row['subcategoryname'];?></option>
                        <?php 
                        }
                        ?>
                      </select>
        <?php
            }
            if($_REQUEST['type']=='image'){
                $imageid=$_REQUEST['designid'];
                $selectquery="SELECT designimage from tbl_design where design_id=$imageid";
                $result= mysqli_query($con, $selectquery);
                
                $row= mysqli_fetch_assoc($result);
                $imagearr= explode(',', $row['designimage']);
                    foreach ($imagearr as $val)
                     {
                        if(!preg_match('/back/', $val))
                        {
                  ?>
                  <img src="<?php echo $val;?>" class="img-thumbnail"></button>
                 <?php
                        }
                                
                   }
            }
        }
        ?>
    </body>
</html>
