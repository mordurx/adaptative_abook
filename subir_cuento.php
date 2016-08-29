<?php
header('Content-Type: text/html; charset=UTF-8');

if ($_FILES['archivo']["error"] > 0)
  {
  echo "Error: " . $_FILES['archivo']['error'] . "<br>";
  exit;
  }
if (!isset($_FILES["avatar"]) || $_FILES["avatar"]["error"])
  {
  echo "Error: " . $_FILES['avatar']['error'] . "<br>";
  exit;
  }

else
  {
  include("ConectarBaseDatos.php");
  $con=ConectarDB();
  $con->set_charset("utf8"); 
  //ahora vamos a verificar si el tipo de archivo es un tipo de imagen permitido.
  //y que el tamano del archivo no exceda los 16MB
  $permitidos = array("image/jpg", "image/jpeg", "image/png");
  $limite_kb = 16384;
  if (in_array($_FILES['avatar']['type'], $permitidos) && $_FILES['avatar']['size'] <= $limite_kb * 1024)
    {

      //este es el archivo temporal
      $imagen_temporal  = $_FILES['avatar']['tmp_name'];
      //este es el tipo de archivo
      $tipo = $_FILES['avatar']['type'];
      //leer el archivo temporal en binario
      $fp     = fopen($imagen_temporal, 'r+b');
      $data = fread($fp, filesize($imagen_temporal));
      fclose($fp);
      
      $nombre=$_POST['cuento'];
      
      $con=ConectarDB();
      $con->set_charset("utf8"); 
      //escapar los caracteres

      $data = $con->real_escape_string($data);
      //echo $data;
      $sql1="insert into Cuento (nombre,imagen)values('$nombre','$data')";
    
    if (!$resultado = $con->query($sql1)) {
        // ¡Oh, no! La consulta falló.
        echo "<script> alert('el cuento ya exite'); </script>";
        exit("<script>location.href = 'subir_cuento.html'</script>");
    }
    $sql = "SELECT id_cuento FROM Cuento WHERE nombre ='$nombre'";
    $sth = $con->query($sql);
    $result=mysqli_fetch_array($sth);
    $id_cuento=$result['id_cuento'];
    echo $id_cuento; 


    //$sql = "SELECT imagen FROM Cuento WHERE nombre ='$nombre'";
    //$sth = $con->query($sql);
    //$result=mysqli_fetch_array($sth);

    //echo '<img src="data:image/jpeg;base64,'.base64_encode( $result['imagen'] ).'"/>';
       
      include 'Classes/PHPExcel/IOFactory.php';
      date_default_timezone_set("America/Argentina/Buenos_Aires");
      $inputFileName =$_FILES['archivo']['tmp_name'];
      
      //  Read your Excel workbook
      try {
          $inputFileType = PHPExcel_IOFactory::identify($inputFileName);
          $objReader = PHPExcel_IOFactory::createReader($inputFileType);
          $objPHPExcel = $objReader->load($inputFileName);
      } catch (Exception $e) {
          die('Error loading file "' . pathinfo($inputFileName, PATHINFO_BASENAME) 
          . '": ' . $e->getMessage());
      }
      //  Get worksheet dimensions
      $sheet = $objPHPExcel->getSheet(0);
      $highestRow = $sheet->getHighestRow();
      $highestColumn = $sheet->getHighestColumn();
      $stmt =$con->stmt_init();
      $stmt2 =$con->stmt_init();

      if ($stmt->prepare("INSERT INTO Pagina (numeracion,pagina_texto,id_cuento)VALUES(?,?,?)"))
        {
          if ($stmt2->prepare("INSERT INTO Pregunta (pregunta_texto,id_pagina,cond_exp,respuesta_correcta,btn_izq,btn_der,feedback_correcto,feedback_incorrecto)VALUES(?,?,?,?,?,?,?,?)"))
        {
      
          for ($i=2;$i<=$highestRow; $i++) 
             {

               $numeracion=$sheet->getCellByColumnAndRow(0, $i)->getValue();
               $pagina=$sheet->getCellByColumnAndRow(1, $i)->getValue();
               
               $pregunta_1=$sheet->getCellByColumnAndRow(2, $i)->getValue();
               $cond_exp=$sheet->getCellByColumnAndRow(3, $i)->getValue();
               $resp_correcta=$sheet->getCellByColumnAndRow(4, $i)->getValue();
               
               $btn_izq_1=$sheet->getCellByColumnAndRow(5, $i)->getValue();
               $btn_der_1=$sheet->getCellByColumnAndRow(6, $i)->getValue();
               
               $fb_1_correcto=$sheet->getCellByColumnAndRow(7, $i)->getValue();
               $fb_1_incorrecto=$sheet->getCellByColumnAndRow(8, $i)->getValue();
               
               $pregunta_2=$sheet->getCellByColumnAndRow(9, $i)->getValue();
               $cond_exp_2=$sheet->getCellByColumnAndRow(10, $i)->getValue();
               $resp_correcta_2=$sheet->getCellByColumnAndRow(11, $i)->getValue();
               
               $btn_izq_2=$sheet->getCellByColumnAndRow(12, $i)->getValue();
               $btn_der_2=$sheet->getCellByColumnAndRow(13, $i)->getValue();
               
               $fb_2_correcto=$sheet->getCellByColumnAndRow(14, $i)->getValue();
               $fb_2_incorrecto=$sheet->getCellByColumnAndRow(15, $i)->getValue();
               
               
               $pregunta_3=$sheet->getCellByColumnAndRow(16, $i)->getValue();
               $cond_exp_3=$sheet->getCellByColumnAndRow(17, $i)->getValue();
               $resp_correcta_3=$sheet->getCellByColumnAndRow(18, $i)->getValue();
               
               $btn_izq_3=$sheet->getCellByColumnAndRow(19, $i)->getValue();
               $btn_der_3=$sheet->getCellByColumnAndRow(20, $i)->getValue();
               

               $fb_3_correcto=$sheet->getCellByColumnAndRow(21, $i)->getValue();
               $fb_3_incorrecto=$sheet->getCellByColumnAndRow(22, $i)->getValue();
               


               $vector_pregunta_texto=array($pregunta_1,$pregunta_2,$pregunta_3);
               $vector_cond_exp=array($cond_exp,$cond_exp_2,$cond_exp_3);
               $vector_resp_correct=array($resp_correcta,$resp_correcta_2,$resp_correcta_3);
               
               $vector_btn_izq=array($btn_izq_1,$btn_izq_2,$btn_izq_3);
               $vector_btn_der=array($btn_der_1,$btn_der_2,$btn_der_3);


               $vector_fb_correcto=array($fb_1_correcto,$fb_2_correcto,$fb_3_correcto);
               $vector_fb_incorrecto=array($fb_1_incorrecto,$fb_2_incorrecto,$fb_3_incorrecto);
               print $pregunta;
               if ($pagina =='' or $numeracion=='' or $pregunta=''  or $cond_exp='' or $resp_correcta='')
                  {
                        echo "se la fila ".$i." exiten datos incompletos. <br>";
                        continue;
                  }
                else
                  {
                    $stmt->bind_param('isi', $numeracion,$pagina,$id_cuento);
                    $stmt->execute();
                    $sql1= "SELECT id_pagina FROM Pagina WHERE numeracion=$numeracion and id_cuento=$id_cuento";
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
                     $vect_id_pagina = $resultado->fetch_assoc();
                     $id_pagina=$vect_id_pagina['id_pagina'];
          
                     echo "id_pag ",$id_pagina;
                     
                    for ($j=0;$j<3; $j++) 
                    { 
                     $stmt2->bind_param('sissssss', $vector_pregunta_texto[$j],$id_pagina,$vector_cond_exp[$j],$vector_resp_correct[$j],$vector_btn_izq[$j],$vector_btn_der[$j],$vector_fb_correcto[$j],$vector_fb_incorrecto[$j]);
                     $stmt2->execute();
                    }       
                    echo "row ".$i." Ingresada correctamente. <br>";
                  }
              }
          }        
          }
          mysqli_close($con);  
          unset($con);   
}
                          // $sql1="INSERT INTO Listas (id_lista,id_pregunta)VALUES('$id_lista',(select id_pregunta from Pregunta where item='$item' and cond='$cond' and sentence='$sentence'))";
                          // if (!$resultado = $con2->query($sql1)) {
                          //   // ¡Oh, no! La consulta falló. 
                          //   echo "error insertar datos de lista";
                          //   // De nuevo, no hacer esto en un sitio público, aunque nosotros mostraremos
                          //   // cómo obtener información del error
                          //   echo "Error: La ejecución de la consulta falló debido a: \n";
                          //   echo "Query: " . $sql . "\n";
                          //   echo "Errno: " . $mysqli->errno . "\n";
                          //   echo "Error: " . $mysqli->error . "\n";
                          //   exit;
                          //   }
                           
                         
  }
                        










     //                    }

            

       




  //echo "Nombre: " . $_FILES['avatar']['name'] . "<br>";
  //echo "Tipo: " . $_FILES['avatar']['type'] . "<br>";
  //echo "Tamaño: " . ($_FILES["avatar"]["size"] / 1024) . " kB<br>";
  //echo "Carpeta temporal: " . $_FILES['avatar']['tmp_name'];
  

  // echo "nombre cuento: ".$nombre. "<br>";
  // echo "Nombre: " . $_FILES['archivo']['name'] . "<br>";
  // echo "Tipo: " . $_FILES['archivo']['type'] . "<br>";
  // echo "Tamaño: " . ($_FILES["archivo"]["size"] / 1024) . " kB<br>";
  // echo "Carpeta temporal: " . $_FILES['archivo']['tmp_name'];
  

  






     


 

?>

  
   
