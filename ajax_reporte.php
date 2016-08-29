<?php
session_start();   
include("ConectarBaseDatos.php");
include("check_end.php");
$con=ConectarDB();
$con->set_charset("utf8");
$id_cuento=$_POST['id_cuento'];
$username=$_POST['username'];

$data=array();



$sql="SELECT floor(round(cond_exp_infer/total_infer,2)*100)as infer,floor(round(cond_exp_monit/total_monit,2)*100)as monit,floor(round(cond_exp_struct/total_struct,2)*100)as struct FROM Reader_profile where id_usuario='$username'";
if (!$resultado = $con->query($sql)) 
    {
         $error=mysqli_error($con);
         echo $error;
         exit();
    }

$arr_cond_exp = $resultado->fetch_assoc();
$infer=$arr_cond_exp['infer'];
$monit=$arr_cond_exp['monit'];
$struct=$arr_cond_exp['struct'];

array_push($data,$infer); 
array_push($data,$monit);
array_push($data,$struct);

echo  json_encode($data);

     
mysqli_close($con);  
unset($con);
     




?>
