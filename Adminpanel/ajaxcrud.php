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
           
        
        if(isset($_POST['orderid']))
        {
         $select="select status from tbl_order where order_id='".$_POST['orderid']."'";
         $r= mysqli_query($con, $select);
         $row= mysqli_fetch_assoc($r);
        ?>
         <form class="form-horizontal" action="#" method="post">
             <input type="hidden" value="<?php echo $_POST['orderid']?>" name="id">
                <div class="form-group">
                    <strong>Order Status</strong>
                      <div class="">
                          <select name="os" class="form-control">
                              <?php 
                                if($row['status']=='P')
                                  echo "<option value='P'>Pending</option>";
                                if($row['status']=='P' || $row['status']=='Di')
                                    echo "<option value='Di'>Designing</option>";
                                if($row['status']=='Pr' || $row['status']=='Di')
                                    echo "<option value='Pr'>Printing</option>";
                                if($row['status']=='Pr' || $row['status']=='Ds')
                                    echo "<option value='Ds'>Dispetched</option>";
                                if($row['status']=='Ds' || $row['status']=='D')
                                    echo "<option value='D'>Deliverd</option>";
                              ?>
                          </select>
                      </div>
                    </div>
                    <div class="form-group">        
                      <div class="">
                          <button type="submit" name="statuschange" class="btn btn-success">CHANGE</button>
                      </div>
                    </div>
         </form>
        <?php 
        }
        ?>
    </body>
</html>
