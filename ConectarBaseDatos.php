<?php

function ConectarDB()
{
	// Conectando, seleccionando la base de datos
	$mysqli = new mysqli('pdb11.awardspace.net', '2089430_adapt', 'eplab2016','2089430_adapt');
	/* comprobar la conexión */
	if ($mysqli->connect_errno) {
    	printf("Falló la conexión: %s\n", $mysqli->connect_error);
    	exit();
	}
	else{

		//echo "conexion correcta!!!!";
		return $mysqli; 
	}

}
function ConectarDB_training()
{
	// Conectando, seleccionando la base de datos
	$mysqli = new mysqli('pdb11.awardspace.net', '2089430_abook', 'eplab2016','2089430_abook');
	/* comprobar la conexión */
	if ($mysqli->connect_errno) {
    	printf("Falló la conexión: %s\n", $mysqli->connect_error);
    	exit();
	}
	else{

		//echo "conexion correcta!!!!";
		return $mysqli; 
	}

}
?>

