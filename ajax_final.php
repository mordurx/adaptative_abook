<?php
session_start();   
include("ConectarBaseDatos.php");
include("check_end.php");
require_once('PHPMailer/PHPMailerAutoload.php');
$con=ConectarDB();
$con->set_charset("utf8");

$id_cuento=$_POST['id_cuento'];
$id_numeracion=$_POST['id_numeracion'];
$username=$_SESSION['username'];
$termino=Is_End($con,$username,$id_cuento);
if ($termino==true) 
{
	$sql="SELECT veces_leido FROM Cuento_por_Usuario WHERE id_usuario='$username' and id_cuento=$id_cuento";
	     if (!$resultado = $con->query($sql)) 
    {
         $error=mysqli_error($con);
         echo $error;
         exit();
    }
     $arr_intento = $resultado->fetch_assoc();
     $veces_leido=$arr_intento['veces_leido'];
     

     $sql="SELECT id_pregunta from Respuesta_pregunta where intento=$veces_leido";
      if (!$resultado = $con->query($sql)) 
    {
         $error=mysqli_error($con);
         echo $error;
         exit();
    }
    $arr_fixed_stack_error = $resultado->fetch_assoc();
    $filter_correct_error=$arr_fixed_stack_error['id_pregunta'];
    if (!($filter_correct_error===null))
    {
        $veces_leido++;
    }

     $sql="update Cuento_por_Usuario set veces_leido=$veces_leido, ind_pagina=1,internal_index=0  WHERE id_usuario='$username' and id_cuento=$id_cuento";
    
	 if (!$resultado = $con->query($sql)) 
    {
         $error=mysqli_error($con);
         echo $error;
         exit();
    }

    /////////////////enviar correo/////////////////////////////////////////////////7

    $sql="SELECT correo FROM Usuario WHERE nombre='$username'";
      if (!$resultado = $con->query($sql)) 
    {
         $error=mysqli_error($con);
         echo $error;
         exit();
    }
     $arr_correo = $resultado->fetch_assoc();
     $email=$arr_correo['correo'];
     $username_64=base64_encode($username);
    $link="http://adapt-abook.scienceontheweb.net/reporte.html?user=".$username_64."&id_cuento=".$id_cuento;
    $email_message="el usuario: ".$username."\n ha completado de leer un cuento\n .<br>para ver su puntuacion visite el siguiente link: ".$link ."\n gracias por participar";
   
        //include("PHPMailer/class.smtp.php"); // optional, gets called from within class.phpmailer.php if not already loaded

        $mail = new PHPMailer();
        $mail->IsHTML(true);
        $mail->CharSet = "text/html; charset=UTF-8;";  
        $mail->IsSMTP();  // telling the class to use SMTP    <br/>
        $mail->SMTPAuth = true;         // Enable SMTP authentication  <br/>
        $mail->SMTPSecure = 'ssl' ;   
        $mail->Host    = "smtp.gmail.com" ;// SMTP server <br/>
        $mail->Port = 465; // or 587   <br/>

        $mail->Username = 'team.abook@gmail.com';    // SMTP username <br/>
        $mail->Password = 'eplab2016';     // SMTP password   <br/>

        $mail -> IsHTML(true);  
        $mail->From    = 'team.abook@gmail.com'; 
        $mail->FromName = 'team a-book';


        $mail->addAddress($email,'');  

        $mail->WordWrap = 50;  
        $mail->Subject  = "reporte de usuario"; 
        $mail->Body     = $email_message;

        if(!$mail->Send()) { 
        echo 'Message was not sent.';   
        echo 'Mailer error: ' . $mail->ErrorInfo;  
        echo  json_encode($mail->ErrorInfo);
        } 
        else    
         {   
            echo  json_encode($termino);
        } 



   
 }
 else
 { 
$sql="SELECT ind_pagina FROM Cuento_por_Usuario WHERE id_usuario='$username' and id_cuento=$id_cuento";
	  if (!$resultado = $con->query($sql)) 
    {
         $error=mysqli_error($con);
         echo $error;
         exit();
    }
     $arr_ind_pagina = $resultado->fetch_assoc();
     $ind_pagina=$arr_ind_pagina['ind_pagina'];
     //$_SESSION['num']=$ind_pagina;
	 echo  json_encode($ind_pagina);
}







          


mysqli_close($con);  
unset($con);



?>
