<?php
session_start();   
include("ConectarBaseDatos.php");
$con=ConectarDB();
$con->set_charset("utf8");
$id_feedback=$_POST['id_feedback'];

$id_pregunta=$_SESSION['id_pregunta'];

$sql1= "SELECT feedback_correcto,feedback_incorrecto FROM Pregunta where id_pregunta=$id_pregunta";

if (!$resultado = $con->query($sql1)) {
         $error=mysqli_error($con);
         echo $error;
         exit();
    }
$arr_feedback=$resultado->fetch_assoc();
if ($id_feedback==1) {
    $feedback=$arr_feedback['feedback_correcto'];
     echo  json_encode( $feedback);
   }
elseif ($id_feedback==0) {
    $feedback=$arr_feedback['feedback_incorrecto'];
    echo  json_encode($feedback); 
    }      


mysqli_close($con);  
unset($con);



?>
