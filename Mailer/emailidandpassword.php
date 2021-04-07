<?php
    
    
    define('EMAIL', 'xyz@gmail.com');
    define('PASS', 'xyz');
    
    $passcode="abcdefghijklmnopqrstuvwxyzA1B2CDEFGHIJ34KLMNOPQRSTU567890VWXYZ";
    
    $code= substr(str_shuffle($passcode),0,8);
    
    $_SESSION['otp']=$code;
    
    $string="
<html>
    <head>
        <title>TODO supply a title</title>
        <meta charset='UTF-8'>
        <meta name='viewport' content='width=device-width, initial-scale=1.0'>
        <link href='css/bootstrap.min.css' rel='stylesheet' type='text/css'/>
        <link href='css/bootstrap.css' rel='stylesheet' type='text/css'/>
        
        <style>
            img{
                width: 100px;
                height: 100px;
            }
            b{
                font-family: monospace;
                color: #444;
            }
        </style>
    </head>
    
    <body>
        <div class='bg-primary container'>
            <h2>
                THIS IS FROM PRINT SHOP</h2>
            <h3>
                YOUR OTP CODE IS :<b>".$code."</b>
            </h3>
        </div>
    </body>
</html>
";
    $string1="
<html>
    <head>
        <title>TODO supply a title</title>
        <meta charset='UTF-8'>
        <meta name='viewport' content='width=device-width, initial-scale=1.0'>
        <link href='css/bootstrap.min.css' rel='stylesheet' type='text/css'/>
        <link href='css/bootstrap.css' rel='stylesheet' type='text/css'/>
        
        <style>
            img{
                width: 100px;
                height: 100px;
            }
            b{
                font-family: monospace;
                color: #444;
            }
        </style>
    </head>
    
    <body>
        <div class='bg-primary container'>
            <h2>
                THIS IS FROM PRINT SHOP</h2>
            <h3>
                YOUR NEW PASSWORD IS :<b>".$code."</b>
            </h3>
        </div>
    </body>
</html>
";
    define('MSG',$string);
    define('MSGP', $string1);
?>

