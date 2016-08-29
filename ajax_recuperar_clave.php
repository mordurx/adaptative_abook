<?php
include("ConectarBaseDatos.php");
$con=ConectarDB();
$con->set_charset("utf8");
$email=$_POST['email'];
$sql1= "SELECT count(correo) as correo FROM Usuario  WHERE correo='$email'";

if (!$resultado = $con->query($sql1)) {
        // ¡Oh, no! La consulta falló. 
        echo "error consulta a la base de datos.";
        // De nuevo, no hacer esto en un sitio público, aunque nosotros mostraremos
        // cómo obtener información del error
        echo "Error: La ejecución de la consulta falló debido a: \n";
        echo "Query: " . $sql1 . "\n";
        echo "Error: " . $con->error . "\n";
        exit;
    }
    $arr_email=$resultado->fetch_assoc();
    $correo=$arr_email['correo'];
    if ($correo<1)
    {
    #si no existe el correo en la bd
       echo  json_encode(-1);
       exit();

      
    }
    else
    {
    $sql1= "SELECT nombre FROM Usuario  WHERE correo='$email'";
   
        if (!$resultado = $con->query($sql1)) {
        // ¡Oh, no! La consulta falló. 
        echo "error consulta a la base de datos.";
        echo "Query: " . $sql1 . "\n";
        echo "Error: " . $con->error . "\n";
        exit;
        }

    if ($correo==1)
    {    
        $arr_email=$resultado->fetch_assoc();
        $username=$arr_email['nombre'];
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
        $mail->FromName = 'team a-book';   
        $mail->addAddress($email,$username);  

        $mail->WordWrap = 50;  
        $mail->Subject  = "recuperacion de nombre de usuario"; 
        $mail->Body     = "su nombre de usuario es : ".$username;

        if(!$mail->Send()) { 
        echo 'Message was not sent.';   
        echo 'Mailer error: ' . $mail->ErrorInfo;  

        } else    
         {   
        echo  json_encode($email);
        }  
       
        // $email_from="team.abook@gmail.com";
        // $email_to = $email;
        // $email_subject = "recuperacion de nombre de usuario";
        // $email_message="su nombre de usuario es : ".$username;
        // // Ahora se envía el e-mail usando la función mail() de PHP
        // $headers = 'From: '.$email_from."\r\n".
        // 'Reply-To: '.$email_from."\r\n" .
        // 'X-Mailer: PHP/' . phpversion();
        // @mail($email_to, $email_subject, $email_message,$headers);

        


        //echo "¡El formulario se ha enviado con éxito!";
         
    }
    else{
        if($correo>1)
        {   
             $email_message="se han detectado varios nombre de usuario vinculados a su cuenta <br> \n \n \t";
             while($row = $resultado->fetch_assoc())
                {
                    $username=$row["nombre"];
                    $email_message.="usuario: ".$username."<br>\n \t";
                      
                    //echo $imagen;
                }
            require_once('PHPMailer/PHPMailerAutoload.php');
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
            $mail->addAddress($email,$username);  

            $mail->WordWrap = 50;  
            $mail->Subject  = "recuperacion de nombre de usuario"; 
            $mail->Body     =$email_message;

            if(!$mail->Send()) { 
            echo 'Message was not sent.';   
            echo 'Mailer error: ' . $mail->ErrorInfo;  

            } else    
             {   
            echo  json_encode($email);
            }  


        }
}
     

    }
    


mysqli_close($con);  
unset($con);



?>
