<?php
include("ConectarBaseDatos.php");
$con=ConectarDB();
$con->set_charset("utf8");
$username=$_POST['username'];
$edad=(int)$_POST['edad'];
//$edad=intval($edad);   
$correo=$_POST['email'];

$sql1="SELECT COUNT(nombre)as count_user FROM Usuario WHERE nombre='$username'";

if (!$resultado = $con->query($sql1)) {
        // ¡Oh, no! La consulta falló. 
        $error=mysqli_error($con);
        echo $error;
        exit();
    }
    $arr_nombre=$resultado->fetch_assoc();
    $nombre=$arr_nombre['count_user'];
    if ($nombre>0)
    {
    #si no existe el correo en la bd
       echo  json_encode(-1);
       exit();

      
    }
    else
    {
    $sql="insert into Usuario (nombre,edad,correo)values('$username',$edad,'$correo')";
   
        if (!$resultado = $con->query($sql)) {
            $error=mysqli_error($con);
            echo $error;
            exit();
        }
        echo  json_encode(1);
    

    }
    

    
    


mysqli_close($con);  
unset($con);



?>
