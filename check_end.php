<?
function Is_End($con,$user,$id_cuento)
{ 
	  $con->set_charset("utf8");
	  $sql="SELECT internal_index FROM Cuento_por_Usuario WHERE id_usuario='$user' and id_cuento=$id_cuento";
	    if (!$resultado = $con->query($sql)) 
    {
         $error=mysqli_error($con);
         echo $error;
         exit();
    }
     $arr_internal_index = $resultado->fetch_assoc();
     $internal_index=$arr_internal_index['internal_index'];


	$sql="SELECT COUNT(id_pagina) as num_pages FROM Pagina where id_cuento=$id_cuento";
    if (!$resultado = $con->query($sql)) 
    {
         $error=mysqli_error($con);
         echo $error;
         exit();
    }
	    $arr_num_pages= $resultado->fetch_assoc();
     	$num_pages=$arr_num_pages['num_pages'];
        $pag_restantes=$num_pages-$internal_index;
     	if ($pag_restantes>0)
     	{

     		return False;
     	}
     	else
     	{
     		return True;
     	}

mysqli_close($con);  
unset($con);

}

?>