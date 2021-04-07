<?php 
    session_start();
    include './stylelink.php';
    include './redirect.php';
    include './connection.php';
?>
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
        <link href="css/bootstrap.css" rel="stylesheet" type="text/css"/>
        <link href="css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
    </head>
    
    
<?php
    
            require 'PHPMailerAutoload.php';
            require './Mailer/emailidandpassword.php';
            $mail = new PHPMailer;

           // $mail->SMTPDebug = 4;                               // Enable verbose debug output

            $mail->isSMTP();                                      // Set mailer to use SMTP
            $mail->Host = 'smtp.gmail.com';  // Specify main and backup SMTP servers
            $mail->SMTPAuth = true;                               // Enable SMTP authentication
            $mail->Username = EMAIL;                 // SMTP username
            $mail->Password = PASS;                           // SMTP password
            $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
            $mail->Port = 587;                                  // TCP port to connect to

            $mail->setFrom(EMAIL, 'PRINT SHOP');
            $mail->addAddress($_SESSION['email']); 
           
             // Add a recipient
            $mail->addReplyTo(EMAIL);

           // $mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
           // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name
            $mail->isHTML(true);                                  // Set email format to HTML

            $mail->Subject = 'PRINT SHOP VERIFICATION';
            if(isset($_GET['op']))
            {
                $mail->Body = MSGP;
            }
            else
            {
                $mail->Body = MSG;
            }
            $mail->AltBody = ' <b>saf8329fn8923</b>';

            if(!$mail->send()) {
                echo 'Message could not be sent.';
                echo 'Mailer Error: ' . $mail->ErrorInfo;
            } else {
                echo 'Message has been sent';
                if(empty($_GET['op']))
                {
                    echo "<script>window.location='otpverification.php'</script>";
                }
                else {
                    $updatesql="update tbl_user set password=md5('".$_SESSION['otp']."') where email='".$_SESSION['email']."'";
                    $result= mysqli_query($con, $updatesql);
                    redirect('./login.php'); 
                }
            }
        
    ?>


    <body>        
    </body>
</html>
