<?php
 ob_start();
$t=time();
date_default_timezone_set("America/Argentina/La_Rioja");
$date=date('Y-m-d H:i:s');

require_once 'Classes/PHPExcel.php';

include 'Classes/PHPExcel/Writer/Excel2007.php';
include("ConectarBaseDatos.php");
$con=ConectarDB();
//header("Content-Type: application/csv");
//header("Content-Disposition: attachment;Filename=cars-models.csv");

//echo(date("Y-m-d",$t));
$title="dados_cloze";
$objPHPExcel = new PHPExcel();
$objPHPExcel->createSheet();
$sheet = $objPHPExcel->setActiveSheetIndex(0);
$sheet->setTitle($title);
$sql = "SELECT * FROM Usuario";

if (!$resultado = $con->query($sql)) {
        // ¡Oh, no! La consulta falló. 
        echo "error consulta a la base de datos.";
      	echo "Errno: " . $mysqli->errno . "\n";
        echo "Error: " . $mysqli->error . "\n";
        exit;
}
else
{
$row = 1; // 1-based index
while($row_data =$resultado->fetch_assoc()) {
    $col = 0;
   
    foreach($row_data as $value) {
    	//echo "valores ".$value;
        $sheet->setCellValueByColumnAndRow($col, $row, $value);
        $col++;
    }
    $row++;
}

		 $writer = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');  
		
		 
		$writer->save('php://output');
exit;
mysqli_close($con);  
unset($con);
}











        // $objPHPExcel->setActiveSheetIndex(0)
        //     ->setCellValue('A1', 'Nombre')
        //     ->setCellValue('B1', 'E-mail')
        //     ->setCellValue('C1', 'Twitter')
        //     ->setCellValue('A2', 'David')
        //     ->setCellValue('B2', 'dvd@gmail.com')
        //     ->setCellValue('C2', '@davidvd');

        //$objPHPExcel->getActiveSheet()->setTitle('Datos Cloze'.date("Y-m-d",$t));

 ?>

