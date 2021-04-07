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
        session_start();
         include '../connection.php';
//           if(isset($_SESSION['emailid']))
//           {
//               $select="select user_id from tbl_user where email='".$_SESSION['emailid']."'";
//               $result= mysqli_query($con, $select);
//               $row= mysqli_fetch_assoc($result);
//               $id=$row['user_id'];
//           }
           $pd=array();
                if(isset($_POST['id']))
                {
                    $select="select tbl_design.*,tbl_cartdetails.*,tbl_printdetails.* from tbl_cartdetails inner join tbl_cart on tbl_cart.cart_id=tbl_cartdetails.cartid inner join tbl_design on tbl_design.design_id=tbl_cartdetails.designid inner join tbl_printdetails on tbl_printdetails.print_id=tbl_cartdetails.printdetailsid where cart_id='".$_POST['id']."'";
                    $result= mysqli_query($con, $select);
                    while($row= mysqli_fetch_assoc($result))
                    {
                        
                        
            ?>
                   
        <div class="well">
            <div class="row text-black">
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
                    <p class="col-md-4"><strong>Price:</strong> Rs <?php echo $row['price'];?></p>
                    <p class="col-md-4"><strong>Total:</strong><?php echo $row['price']*$row['quantity'];
                     } else {
                         ?>
                   <p class="col-md-3"><strong>Quantity:</strong><?php echo $row['quantity']*$row['nooflines'];?></p>
                    <p class="col-md-4"><strong>Price:</strong> Rs<?php echo $row['price'];?></p>
                    <p class="col-md-4"><strong>Total:</strong><?php echo $row['price']*$row['quantity']*$row['nooflines'];
                     }?>
                </div>
            </div>            
        </div>
  
            
        
              <?php
                    }
                    
                }
        ?>
    </body>
</html>
