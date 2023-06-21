<?php

    //include('/usr/share/phpqrcode/qrlib.php');
    //include('/var/www/phpqrcode/qrlib.php');
    //include ('/var/www/lib/qrlib/phpqrcode/qrlib.php');
    include('/var/www/html/mutualweb/lib/qrlib/phpqrcode/qrlib.php');

  
    $text = "PHP QR Code Generator";

 
    if(class_exists('QRcode'))
    {
        //Generate QR
        QRcode::png($text, 'QRImage.png');
    }else{
        //Print error message
        echo 'class is not loaded properly';
    }

?>
<html>
    <head>
    <title>QR Code Generator</title>
    </head>
    <body>
        <!-- display the QR image -->
        <img src="QRImage.png" />
    </body>
</html>