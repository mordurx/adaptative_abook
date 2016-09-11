<?
function cross_threshold($username,$id_pagina,$id_cuento,$texto_pagina,$num,$intento,$con)
{	
	$get_solapamiento=get_percent($username,$con);
	if ($get_solapamiento==1)
	{   $posible_overlap=$num;

		# then solapamiento 1, no hay que stackear nada
		$sql='insert ignore into Pagina_by_user (id_pagina,id_cuento,texto_pagina,numeracion,id_usuario,intento,overlap) values ('.$id_pagina.','.$id_cuento.',"'.$texto_pagina.'",'.$num.',"'.$username.'",'.$intento.',1)';
		if (!$resultado = $con->query($sql)) 
    	{
         $error=mysqli_error($con);
         echo $error;
         exit();
    	}
    }	
    	elseif ($get_solapamiento==2) 
    	{	$posible_overlap=$num+1;
		    //$arr_limit=end_Page($posible_overlap,$id_cuento,$con);
		    //$is_Limit=$arr_limit['isLimit'];
		    //if ($is_Limit==1) {
		    		# code...
		    //$num_pages=$arr_limit['num_pages'];
		    //$next_overlap=$num_pages-$num;
		    //$final_overlap=$next_overlap+$num;
		    $texto="";
		    $sql="SELECT pagina_texto FROM Pagina WHERE id_cuento=$id_cuento and numeracion BETWEEN $num and $posible_overlap";
		    if (!$resultado = $con->query($sql)) 
			    	{
			         $error=mysqli_error($con);
			         echo $error;
			         exit();
			    	}
			while($row = $resultado->fetch_assoc()) 
				{
        			$texto.=$row["pagina_texto"]."<br>";
    			}
    			$sql='insert ignore into Pagina_by_user (id_pagina,id_cuento,texto_pagina,numeracion,id_usuario,intento,overlap) values ('.$id_pagina.','.$id_cuento.',"'.$texto.'",'.$num.',"'.$username.'",'.$intento.',2)';
				if (!$resultado = $con->query($sql)) 
			    	{
			         $error=mysqli_error($con);
			         echo $error;
			         exit();
			    	}    	
		    	//}	
    	}
    	elseif ($get_solapamiento==3)
    	{
    		$posible_overlap=$num+2;
    		$texto="";
		    $sql="SELECT pagina_texto FROM Pagina WHERE id_cuento=$id_cuento and numeracion BETWEEN $num and $posible_overlap";
		    if (!$resultado = $con->query($sql)) 
			    	{
			         $error=mysqli_error($con);
			         echo $error;
			         exit();
			    	}
				while($row = $resultado->fetch_assoc()) 
					{
	        			$texto.=$row["pagina_texto"]."<br>";
	    			}
    			$sql='insert ignore into Pagina_by_user (id_pagina,id_cuento,texto_pagina,numeracion,id_usuario,intento,overlap) values ('.$id_pagina.','.$id_cuento.',"'.$texto.'",'.$num.',"'.$username.'",'.$intento.',3)';
				if (!$resultado = $con->query($sql)) 
			    	{
			         $error=mysqli_error($con);
			         echo $error;
			         exit();
			    	}
    	}




    		  // add preegunta random ···········

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
     			$pseudo_random=pseudo_random_tuple($infer,$monit,$struct,'infer','monit','struct');
				
				$sql="SELECT id_pregunta FROM Pregunta where id_pagina in ( SELECT id_pagina FROM Pagina WHERE id_cuento=$id_cuento and numeracion BETWEEN $num and $posible_overlap) and cond_exp in ".$pseudo_random." ORDER BY RAND() LIMIT 1";     			 
				if (!$resultado = $con->query($sql)) 
			    	{
			         $error=mysqli_error($con);
			         echo $error;
			         exit();
			    	}
			    $arr_preg_sel = $resultado->fetch_assoc();
			    $id_next_preg=$arr_preg_sel['id_pregunta'];
			    //validar que no haya una pregunta ya almacenada
			    
                $sql= "SELECT id_pregunta FROM Respuesta_pregunta where id_pagina=$id_pagina and nombre_usuario='$username' and intento=$intento limit 1";
			    if (!$resultado = $con->query($sql)) 
			    	{
			         $error=mysqli_error($con);
			         echo $error;
			         exit();
			    	}
			   	if ($resultado->num_rows == 0) 
			   		{
                           // insertar pregunta elegida by random

                    $sql="insert ignore Respuesta_pregunta (id_pregunta,nombre_usuario,id_pagina,intento) values ". 
                    "($id_next_preg,'$username',$id_pagina,$intento)";
                    if (!$resultado = $con->query($sql)) 
                        {
                         $error=mysqli_error($con);
                         echo $error;
                         exit();
                        }
                        
                    }			   		




					 
					 
	

}

function get_percent($username,$con)
{
	
	$sql="SELECT round((cond_exp_infer/total_infer)*100) as infer_per,round((cond_exp_monit/total_monit)*100)as monit_per,round((cond_exp_struct/total_struct)*100)as struct_per FROM Reader_profile WHERE id_usuario='$username'";
	    if (!$resultado = $con->query($sql)) 
    {
        echo "error consulta a la base de datos.";
        exit;
    }
     $arr_percent = $resultado->fetch_assoc();
     $per_infer=$arr_percent['infer_per'];
     $per_monit=$arr_percent['monit_per'];
     $per_struct=$arr_percent['struct_per'];

     if ($per_infer>=85 and $per_monit>=85 and $per_struct>=85) {
     	return 3;
     }
     elseif ($per_infer>=70 and $per_monit>=70 and $per_struct>=70) {
     	return 2;
     }
     else
     {
     	return 1;

     }
}


function pseudo_random_tuple($x1,$x2,$x3,$cond_1,$cond_2,$cond_3) 
 {  
    if ($x1==$x2 and $x2==$x3 and $x3==$x1)
    {
        return "('".$cond_1."','".$cond_2."','". $cond_3."')";

    }
    else{
        if ($x1!=$x2 and $x2!=$x3 and $x3!=$x1)
        {

            if ($x1<$x2 and$x1<$x3)
            {

                return  "('".$cond_1."')";
            }
            else
            {

                if($x2<$x1 and $x2<$x3)
                {
                    return "('".$cond_2."')";


                }
                else
                {

                    if ($x3<$x1 and $x3<$x2)
                    {

                        return "('".$cond_3."')";
                    }
                }

            }



        }
        else 
        {
          if ($x1==$x2 and $x3>$x1)
          {
            return "('".$cond_1."','".$cond_2."')";

          }
          else
          { 
            if($x1==$x2 and $x3<$x1)
                {
                    return "('".$cond_3."')";
                }
            else
            {
                if($x1==$x3 and $x2>$x1)
            {

                return "('".$cond_1."','".$cond_3."')";
            }
            else
            {

                if($x1==$x3 and $x2<$x1)
                {

                    return "('".$cond_2."')";
                }
                else
            {
                if ($x2==$x3 and $x1>$x2)
                {

                    return  "('".$cond_2."','".$cond_3."')";
                }
                else
                {
                   if ($x2==$x3 and $x1<$x2)
                   {
                    return "('".$cond_1."')";

                   } 
                }
            } 


            }


            
        }

           


          }

        }


    }
}
?>