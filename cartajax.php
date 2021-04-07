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
            $line=1;
            if(isset($_GET['cid']))
            {
                $select="select tbl_cartdetails.*,tbl_design.* from tbl_cartdetails inner join tbl_design on tbl_cartdetails.designid=tbl_design.design_id where cd_id='".$_GET['cid']."'";
                $result= mysqli_query($con, $select);
                $row= mysqli_fetch_assoc($result);
                if(isset($_GET['lines']))
                {
                    $line=$_GET['lines'];
                    $updatesql="update tbl_printdetails set nooflines='".$line."' where print_id='".$row['printdetailsid']."'";
                    $result= mysqli_query($con, $updatesql);
                }
                $updatequery="update tbl_cartdetails set quantity='".$_GET['quantity']."',totalprice='".$row['price']*($_GET['quantity']*$line)."' where cd_id='".$_GET['cid']."'";
                $result=mysqli_query($con, $updatequery);
                echo 'DONE';
            }
        ?>
    </body>
</html>
