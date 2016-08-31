<?php 
include("ConectarBaseDatos.php");
$con=ConectarDB();
$con->set_charset("utf8"); 
$username=$_POST['username'];
$sql1= "SELECT Cuento.id_cuento,nombre,imagen,ind_pagina FROM Cuento inner join Cuento_por_Usuario on Cuento.id_cuento=Cuento_por_Usuario.id_cuento where veces_leido<4 and id_usuario='$username' and disponible=True";
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
$cuento =array();
$cuentos =array();
if ($resultado->num_rows > 0) {
    // output data of each row
    while($row = $resultado->fetch_assoc()) {
        $imagen=base64_encode($row["imagen"]);
        array_push($cuento,(int)$row["id_cuento"],$row["nombre"],$imagen,$row["ind_pagina"]);
        array_push($cuentos, $cuento);
        unset($cuento);
        $cuento = array();  
        //echo $imagen;
    }

    echo  json_encode($cuentos);
    
} else {
   echo  json_encode(-1);
}


mysqli_close($con);  
unset($con);



?>
