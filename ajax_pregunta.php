<?php
session_start();   
include("ConectarBaseDatos.php");
$con=ConectarDB();
$con->set_charset("utf8");

$id_cuento=$_POST['id_cuento'];
$id_numeracion=$_POST['id_num'];
$username=$_SESSION['username'];
$id_pagina=$_SESSION['id_pagina'];


$sql="SELECT Pregunta.id_pregunta as id_pregunta,Pregunta.pregunta_texto, Pregunta.btn_izq,Pregunta.btn_der,Pregunta.respuesta_correcta FROM Respuesta_pregunta INNER JOIN Pagina_by_user ON Respuesta_pregunta.id_pagina=Pagina_by_user.id_pagina AND Respuesta_pregunta.nombre_usuario=Pagina_by_user.id_usuario inner join Pregunta on Respuesta_pregunta.id_pregunta=Pregunta.id_pregunta where Respuesta_pregunta.nombre_usuario='$username' and id_cuento=$id_cuento and Pagina_by_user.numeracion=$id_numeracion";


if (!$resultado = $con->query($sql)) 
    {
         $error=mysqli_error($con);
         echo $error;
         exit();
    }
    $pregunta_ramdom_vect=$resultado->fetch_assoc();
    if (is_null($pregunta_ramdom_vect['id_pregunta'])) {
        echo json_encode(-1);
    }
    else{
    $_SESSION['id_pregunta']=$pregunta_ramdom_vect['id_pregunta'];
   
    echo json_encode($pregunta_ramdom_vect);
    }













mysqli_close($con);  
unset($con);


?>
