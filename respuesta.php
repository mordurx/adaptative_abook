<?php
session_start();  
include("ConectarBaseDatos.php");
$con=ConectarDB();
$con->set_charset("utf8");
$id_cuento=$_SESSION['id_cuento'];
$id_pagina=$_SESSION['id_pagina'];
$user=$_SESSION['username'];
$id_pregunta=$_GET['id'];
$_SESSION['id_pregunta']=$id_pregunta;
$resp_user=$_GET['resp_user'];
$resp_user=base64_decode($resp_user);
$resp_correcta=$_GET['resp'];
$resp_correcta=base64_decode($resp_correcta);
//$intento=$_SESSION['nveces'];
$id_numeracion=$_SESSION['num'];
include("save_resp.php");
$sql="SELECT veces_leido FROM Cuento_por_Usuario WHERE id_cuento=$id_cuento and id_usuario='$user'";
if (!$resultado = $con->query($sql)) 
    {
         $error=mysqli_error($con);
         echo $error;
         exit();
    }
$arr_veces_leido=$resultado->fetch_assoc();     
$veces_leido=$arr_veces_leido['veces_leido'];

$sql ="SELECT id_feedback FROM Respuesta_pregunta where nombre_usuario='$user' and intento=$veces_leido and id_pregunta=$id_pregunta and estado=1";
if (!$resultado = $con->query($sql)) 
	{
	$error=mysqli_error($con);
	echo $error;
	exit();
	}
$arr_kind_feed_back = $resultado->fetch_assoc();
$id_feedback=$arr_kind_feed_back['id_feedback'];	   
if ($id_feedback===null)
 {
 	insert_Resp_User($con,$user,$id_pregunta,$resp_user,$resp_correcta,$id_cuento,$id_numeracion); 

 }
 else
 {
 	 if ($resp_correcta==$resp_user)
    {
    	 $feedback=base64_encode(1);

    }
    else
    {
    	 $feedback=base64_encode(0);
    }
   
echo '<script type="text/javascript">
           window.location = "feedback.html?id_feed='.$feedback.'"</script>';

} 


 
//$feedback=insert_Resp_User($con,$user,$id_pregunta,$resp_user,$resp_correcta);
 
    




?>
