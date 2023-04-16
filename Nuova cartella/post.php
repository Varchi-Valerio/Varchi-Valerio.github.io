<?php
error_reporting(0);
function cleanData($dato)
{
  $dato = trim($dato);
  $dato = htmlspecialchars($dato);
  return $dato;
} 
if($_POST['name'] == '' || $_POST['email'] =='' || $_POST['message']==''){
    echo "Empty Field";
    }
else{    
    $name = cleanData($_POST['name']);
    $mail =  cleanData($_POST['email']);
    $text = cleanData($_POST['message']);
    $utf8 = "MIME-Version: 1.0\r\nContent-type: text/html; charset=\"UTF-8\"\r\nContent-Transfer-Encoding: 8bit\r\n";
    //Set the email where receive the message to.
    $myEmail = "webmaster@example.com";
    if (trim($myEmail) == ''){
        echo "<br>Please setup your email in post.php file";
    }
    else{
        $text = str_replace("\n", "<br>", $text);
        $message ="Sent data:<br>From: $mail<br> Name: $name<br> Subject: Contact <br>Message:<br>$text ";
        if (mail( $myEmail, "Mail From yor web", $message, $utf8))
            echo 'ok';
        else
            echo 'Mail error';
        }
    }
?>