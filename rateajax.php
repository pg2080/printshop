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
            include './connection.php';
                if(isset($_POST['ratepoint']))
                {
                    $select="select count(*) as count from tbl_rate where customerid='".$_POST['userid']."' and designid='".$_POST['designid']."'";
                    $result= mysqli_query($con, $select);
                    $row= mysqli_fetch_assoc($result);
                    
                    if($row['count']=="0")
                    {
                        $insertquery="INSERT INTO `tbl_rate`(`rate_id`, `designid`, `customerid`, `ratepoint`) VALUES ('','".$_POST['designid']."','".$_POST['userid']."','".$_POST['ratepoint']."')";
                        $result= mysqli_query($con, $insertquery);
                    }
                    else
                    {
                        $updatequery="UPDATE `tbl_rate` SET `ratepoint`='".$_POST['ratepoint']."',`insertdate`='".date('Y-m-d')."' WHERE `designid`='".$_POST['designid']."' and`customerid`='".$_POST['userid']."'";
                        $result= mysqli_query($con, $updatequery);
                    }
                }
        ?>
    </body>
</html>
