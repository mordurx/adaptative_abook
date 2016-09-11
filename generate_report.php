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
ob_start();
$t=time();
date_default_timezone_set("America/Argentina/La_Rioja");
$date=date('Y-m-d H:i:s');
$con=ConectarDB();
$con->set_charset("utf8");


require_once 'Classes/PHPExcel.php';
//include 'ConectarBaseDatos.php';
/** PHPExcel_Writer_Excel2007 */
include 'Classes/PHPExcel/Writer/Excel2007.php';
// Create new PHPExcel object

$objPHPExcel = new PHPExcel();
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="Reporte "'.$date.'.xls"');
header('Cache-Control: max-age=0');  


$objPHPExcel->getProperties()->setCreator("mordurx");
$objPHPExcel->getProperties()->setLastModifiedBy("mordurx");
$objPHPExcel->getProperties()->setTitle("Office 2007 XLSX Test Document");
$objPHPExcel->getProperties()->setSubject("Office 2007 XLSX Test Document");
$objPHPExcel->getProperties()->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.");



$objPHPExcel->setActiveSheetIndex(0);
//$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, 5, 'php');
$objPHPExcel->getActiveSheet()->SetCellValue('A1', 'Username');
$objPHPExcel->getActiveSheet()->SetCellValue('B1', 'orden_resp');
$objPHPExcel->getActiveSheet()->SetCellValue('C1', 'id_tipo_fb');
$objPHPExcel->getActiveSheet()->SetCellValue('D1', 'respuesta_usuario');
$objPHPExcel->getActiveSheet()->SetCellValue('E1', 'resultado_user');
$objPHPExcel->getActiveSheet()->SetCellValue('F1', 'estado_pregunta');
$objPHPExcel->getActiveSheet()->SetCellValue('G1', 'intento_pregunta');


$objPHPExcel->getActiveSheet()->SetCellValue('H1', 'nºveces_cuento');

$objPHPExcel->getActiveSheet()->SetCellValue('I1', 'ind_pagina');
$objPHPExcel->getActiveSheet()->SetCellValue('K1', '¿pregunta?');
$objPHPExcel->getActiveSheet()->SetCellValue('J1', 'id_pagina');

$objPHPExcel->getActiveSheet()->SetCellValue('L1', 'cond_exp');
$objPHPExcel->getActiveSheet()->SetCellValue('M1', 'respuesta_correcta');
$objPHPExcel->getActiveSheet()->SetCellValue('N1', 'btn_izq');
$objPHPExcel->getActiveSheet()->SetCellValue('O1', 'btn_der');
$objPHPExcel->getActiveSheet()->SetCellValue('P1', 'feedback_correcto');
$objPHPExcel->getActiveSheet()->SetCellValue('Q1', 'feedback_incorrecto');
$objPHPExcel->getActiveSheet()->SetCellValue('R1', 'texto_pagina');
$objPHPExcel->getActiveSheet()->SetCellValue('S1', 'numeracion');

$objPHPExcel->getActiveSheet()->SetCellValue('T1', 'nombre_cuento');
$objPHPExcel->getActiveSheet()->SetCellValue('U1', 'correo');
$objPHPExcel->getActiveSheet()->SetCellValue('V1', 'edad');
$objPHPExcel->getActiveSheet()->SetCellValue('W1', 'id_cuento');
// $objPHPExcel->getActiveSheet()->SetCellValue('D2', 'world!');
$objPHPExcel->getActiveSheet()->getStyle('A1:W1')->getFont()->setBold(true);
$sql = "SELECT Respuesta_pregunta.nombre_usuario,Reader_profile.cond_exp_infer,total_infer, Respuesta_pregunta.orden_preg,Respuesta_pregunta.id_feedback,".
"resp_user,resultado,estado as estado_pregunta,intento,".
"Cuento_por_Usuario.veces_leido,ind_pagina,pregunta_texto,".
"Pagina.id_pagina,cond_exp,respuesta_correcta,".
"btn_izq,btn_der,feedback_correcto,".
"feedback_incorrecto,pagina_texto,numeracion,".
"Cuento.nombre as nombre_cuento,correo,edad,Cuento_por_Usuario.id_cuento ".
"FROM Respuesta_pregunta ".
"inner join Cuento_por_Usuario ON Respuesta_pregunta.nombre_usuario=Cuento_por_Usuario.id_usuario ".
"inner join Pregunta on Respuesta_pregunta.id_pregunta=Pregunta.id_pregunta ".
"INNER JOIN Pagina on Pregunta.id_pagina=Pagina.id_pagina and Cuento_por_Usuario.id_cuento=Pagina.id_cuento ". 
"inner JOIN Cuento on Pagina.id_cuento=Cuento.id_cuento ".
"INNER JOIN Usuario on Cuento_por_Usuario.id_usuario=Usuario.nombre  and Usuario.nombre=Respuesta_pregunta.nombre_usuario ".
"inner join Reader_profile on Cuento_por_Usuario.id_usuario=Reader_profile.id_usuario";

if (!$resultado = $con->query($sql) or empty($resultado)) {
        // ¡Oh, no! La consulta falló. 
    echo "no existen datos.";
    // De nuevo, no hacer esto en un sitio público, aunque nosotros mostraremos
    // cómo obtener información del error
    echo "Error: La ejecución de la consulta falló debido a: \n";
    echo "Query: " . $sql . "\n";
    echo "Errno: " . $mysqli->errno . "\n";
    echo "Error: " . $mysqli->error . "\n";
    exit;
    }

    else
    {








    	while($row_data = $resultado->fetch_array()) {

    		$rows[] = $row_data;

    	}
    	$cont=2;
    	if (!empty($rows)){
         foreach($rows as $row)
    {
      $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, $cont, $row['nombre_usuario']);
      $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, $cont, $row['orden_preg']);
      $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2, $cont, $row['id_feedback']);
      $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3, $cont, $row['resp_user']);
      $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(4, $cont, $row['resultado']);
      $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(5, $cont, $row['estado_pregunta']);
      $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(6, $cont, $row['intento']);

      
      $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(7, $cont, $row['veces_leido']);
      $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(8, $cont, $row['ind_pagina']);
      $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(9, $cont, $row['pregunta_texto']);
      $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(10, $cont, $row['id_pagina']);

      $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(11, $cont, $row['cond_exp']);
      $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(12, $cont, $row['respuesta_correcta']);
      $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(13, $cont, $row['btn_izq']);
      $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(14, $cont, $row['btn_der']);
      $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(15, $cont, $row['feedback_correcto']);

      $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(16, $cont, $row['feedback_incorrecto']);
      $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(17, $cont, $row['pagina_texto']);
      $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(18, $cont, $row['numeracion']);
      $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(19, $cont, $row['nombre_cuento']);
      $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(20, $cont, $row['correo']); 
      $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(21, $cont, $row['edad']);
      $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(22, $cont, $row['id_cuento']);

      //latency
      $cont++;
    }
  
       
      }
     




	/* free result set */
	$resultado->close();

    }






$objPHPExcel->getActiveSheet()->setTitle('repote abook training');


/*
 * These lines are commented just for this demo purposes
 * This is how the excel file is written to the disk, 
 * but in this case we don't need them since the file was written at the first run
 */
//$objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
//$objWriter->save(str_replace('.php', '.xlsx', __FILE__));
$writer = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');  
mysqli_close($con);  
unset($con);

// This line will force the file to download    
$writer->save('php://output');





        // $objPHPExcel->setActiveSheetIndex(0)
        //     ->setCellValue('A1', 'Nombre')
        //     ->setCellValue('B1', 'E-mail')
        //     ->setCellValue('C1', 'Twitter')
        //     ->setCellValue('A2', 'David')
        //     ->setCellValue('B2', 'dvd@gmail.com')
        //     ->setCellValue('C2', '@davidvd');

        //$objPHPExcel->getActiveSheet()->setTitle('Datos Cloze'.date("Y-m-d",$t));

ob_end_flush();

 ?>

