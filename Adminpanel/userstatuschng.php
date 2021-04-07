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
            if($_GET['type']=='approve')
            {
                $sql="UPDATE `tbl_user` SET `role`='D', status='A',`modifydate`='".date('Y-m-d')."' WHERE user_id='".$_GET['id']."'";
                
                $result = mysqli_query($con, $sql);
                if($result)
                {
                    echo 'updated';
                    echo "<script>window.location='userlist.php?type=D'</script>";
                }
                else
                {
                    echo mysqli_error($result);    
                }
            }
            else if($_GET['type']=='reject')
            {
                $sql="UPDATE `tbl_user` SET role='N',`status`='R',`modifydate`='".date('Y-m-d')."' WHERE user_id='".$_GET['id']."'";
                
                $result = mysqli_query($con, $sql);
                if($result)
                {
                    echo 'updated';
                    echo "<script>window.location='userlist.php?type=".$_GET['src']."'</script>";
                }
                else
                {
                    echo mysqli_error($result);    
                }
            }
            else if($_GET['type']=='A')
            { 
                $sql="UPDATE `tbl_user` SET `status`='D',`modifydate`='".date('Y-m-d')."' WHERE user_id='".$_GET['id']."'";
                
                $result = mysqli_query($con, $sql);
                if($result)
                {
                    echo 'updated';
                    echo "<script>window.location='userlist.php?type=".$_GET['src']."'</script>";
                }
                else
                {
                    echo mysqli_error($result);    
                }
                
                
            }
            else
            {
                $sql="UPDATE `tbl_user` SET `status`='A',`modifydate`='".date('Y-m-d')."' WHERE user_id='".$_GET['id']."'";
                
                $result = mysqli_query($con, $sql);
                if($result)
                {
                    echo 'updated';
                    echo "<script>window.location='userlist.php?type=".$_GET['src']."'</script>";
                }
                else
                {
                    echo mysqli_error($result);    
                }
            }
        ?>
    </body>
</html>
