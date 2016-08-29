<?php
session_start();   
include("ConectarBaseDatos.php");
include("test_pseudo_ram.php");
include("stack_text_pages.php");
$con=ConectarDB();
$con->set_charset("utf8");
$id_cuento=$_POST['id_cuento'];
$id_numeracion=$_POST['id_numeracion'];

$_SESSION['id_cuento'] = $id_cuento;
$_SESSION['num'] = $id_numeracion;
$username=$_SESSION['username'];

$sql1= "SELECT id_pagina,pagina_texto FROM Pagina where id_cuento=$id_cuento and numeracion=$id_numeracion";

if (!$resultado = $con->query($sql1)) {
        // ¡Oh, no! La consulta falló. 
        echo "error consulta a la base de datos.";
        // De nuevo, no hacer esto en un sitio público, aunque nosotros mostraremos
        // cómo obtener información del error
        echo "Error: La ejecución de la consulta falló debido a: \n";
        echo "Query: " . $sql1 . "\n";
        echo "Errno: " . $con->errno . "\n";
        echo "Error: " . $con->error . "\n";
        exit;
    }
$arr_page = $resultado->fetch_assoc();
$id_pagina=$arr_page['id_pagina'];
$pagina_texto=$arr_page['pagina_texto'];

$sql="SELECT veces_leido FROM Cuento_por_Usuario WHERE id_cuento=$id_cuento and id_usuario='$username'";
if (!$resultado = $con->query($sql)) 
    {
         $error=mysqli_error($con);
         echo $error;
         exit();
    }
$arr_veces_leido=$resultado->fetch_assoc();     
$veces_leido=$arr_veces_leido['veces_leido'];

cross_threshold($username,$id_pagina,$id_cuento,$pagina_texto,$id_numeracion,$veces_leido,$con);

$sql="SELECT id_pagina,texto_pagina FROM Pagina_by_user WHERE id_cuento=$id_cuento and id_usuario='$username' and numeracion=$id_numeracion and intento=$veces_leido";
if (!$resultado = $con->query($sql)) 
    {
         $error=mysqli_error($con);
         echo $error;
         exit();
    }
$cuentos =array();
if ($resultado->num_rows > 0) {
    // output data of each row
    while($row = $resultado->fetch_assoc()) {
        $_SESSION['id_pagina'] = $row["id_pagina"];
        //$imagen=base64_encode($row["imagen"]);
        //$texto = json_encode(stripslashes($row["pagina_texto"]));
       // $texto=json_encode($row["pagina_texto"]);
        array_push($cuentos,$row["texto_pagina"]);
        //array_push($cuentos, $cuento);
        //unset($cuento);
        //$cuento = array();  
        //echo $imagen;
        }

    echo  json_encode($cuentos);
    
} else {

   echo "<script language='javascript'>window.location='main.php'</script>";
}


mysqli_close($con);  
unset($con);



?>
