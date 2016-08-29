<?php
require_once('PHPMailer/PHPMailerAutoload.php');
//include("PHPMailer/class.smtp.php"); // optional, gets called from within class.phpmailer.php if not already loaded

$mail = new PHPMailer(); 
$mail->IsSMTP();  // telling the class to use SMTP    <br/>
$mail->SMTPAuth = true;         // Enable SMTP authentication  <br/>
$mail->SMTPSecure = 'ssl' ;   
$mail->Host    = "smtp.gmail.com" ;// SMTP server <br/>
$mail->Port = 465; // or 587   <br/>

$mail->Username = 'team.abook@gmail.com';    // SMTP username <br/>
$mail->Password = 'eplab2016';     // SMTP password   <br/>

$mail -> IsHTML(true);  
$mail->From    = 'team.abook@gmail.com'; 
$mail->FromName = 'abook war';   
$mail->addAddress('gumellado@uc.cl','guido melladoo');  

$mail->WordWrap = 50;  
$mail->Subject  = "This mail send from  PhP code xampp"; 
$mail->Body     = "Hi! \n\n This is my first e-mail sent through PHPMailer."; 

if(!$mail->Send()) { 
echo 'Message was not sent.';   
echo 'Mailer error: ' . $mail->ErrorInfo;  

} else    
 {   
echo 'Message has been sent.';  
}  
?>  

