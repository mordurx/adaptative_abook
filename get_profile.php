<?php

function Get_data_profile($username,$con1,$con)
{
   
    
    //cargar indices de cond_exp and percents

    //infer all resp correct
        
    $sql="SELECT COUNT(resultado)as infer FROM Respuesta_pregunta ".
        "inner JOIN Pregunta on Respuesta_pregunta.id_pregunta=Pregunta.id_pregunta ".
        "inner join Pagina on Pagina.id_pagina=Pregunta.id_pagina WHERE nombre_usuario='$username' ".
        "and estado=1 and cond_exp='infer' and Respuesta_pregunta.resultado=1";
        
    if (!$resultado = $con->query($sql)) 
        {
            // ¡Oh, no! La consulta falló. 
            $error=mysqli_error($con);
            echo $error;
            exit();
        }
    $arr_infer_corr=$resultado->fetch_assoc();
    $num_infer_corr=$arr_infer_corr['infer'];
        
    



        //monit all resp correct
        $sql="SELECT COUNT(resultado)as monit FROM Respuesta_pregunta ".
        "inner JOIN Pregunta on Respuesta_pregunta.id_pregunta=Pregunta.id_pregunta ".
        "inner join Pagina on Pagina.id_pagina=Pregunta.id_pagina WHERE nombre_usuario='$username' ".
        "and estado=1 and cond_exp='monit' and Respuesta_pregunta.resultado=1 ";
        if (!$resultado = $con->query($sql)) 
            {
                    // ¡Oh, no! La consulta falló. 
                    $error=mysqli_error($con);
                    echo $error;
                    exit();
            }
            $arr_monit_corr=$resultado->fetch_assoc();
            $num_monit_corr=$arr_monit_corr['monit'];


        //struct all resp correct
        $sql="SELECT COUNT(resultado)as struct FROM Respuesta_pregunta ". 
        "inner JOIN Pregunta on Respuesta_pregunta.id_pregunta=Pregunta.id_pregunta ".
        "inner join Pagina on Pagina.id_pagina=Pregunta.id_pagina WHERE nombre_usuario='$username' ".
        "and estado=1 and cond_exp='struct' and Respuesta_pregunta.resultado=1";
         if (!$resultado = $con->query($sql)) 
            {
                    // ¡Oh, no! La consulta falló. 
                    $error=mysqli_error($con);
                    echo $error;
                    exit();
            }
            $arr_struct_corr=$resultado->fetch_assoc();
            $num_struct_corr=$arr_struct_corr['struct'];


        //preguntas all infer respondidas
        $sql="SELECT COUNT(resultado)as infer FROM Respuesta_pregunta ".
        "inner JOIN Pregunta on Respuesta_pregunta.id_pregunta=Pregunta.id_pregunta ".
        "inner join Pagina on Pagina.id_pagina=Pregunta.id_pagina WHERE nombre_usuario='$username' and estado=1 and cond_exp='infer'";
        if (!$resultado = $con->query($sql)) 
            {
                    // ¡Oh, no! La consulta falló. 
                    $error=mysqli_error($con);
                    echo $error;
                    exit();
            }
            $arr_infer_tot=$resultado->fetch_assoc();
            $num_infer_tot=$arr_infer_tot['infer'];

        //preguntas all monit respondidas
        $sql="SELECT COUNT(resultado)as monit FROM Respuesta_pregunta ".
        "inner JOIN Pregunta on Respuesta_pregunta.id_pregunta=Pregunta.id_pregunta ".
        "inner join Pagina on Pagina.id_pagina=Pregunta.id_pagina WHERE nombre_usuario='$username' and estado=1 and cond_exp='monit' ";
        if (!$resultado = $con->query($sql)) 
            {
                    // ¡Oh, no! La consulta falló. 
                    $error=mysqli_error($con);
                    echo $error;
                    exit();
            }
            $arr_monit_tot=$resultado->fetch_assoc();
            $num_monit_tot=$arr_monit_tot['monit'];

        //preguntas all struct
        $sql="SELECT COUNT(resultado)as struct FROM Respuesta_pregunta ".
        "inner JOIN Pregunta on Respuesta_pregunta.id_pregunta=Pregunta.id_pregunta ".
        "inner join Pagina on Pagina.id_pagina=Pregunta.id_pagina WHERE nombre_usuario='$username'".
        "and estado=1 and cond_exp='struct'";
        if (!$resultado = $con->query($sql)) 
            {
                    // ¡Oh, no! La consulta falló. 
                    $error=mysqli_error($con);
                    echo $error;
                    exit();
            }
            $arr_struct_tot=$resultado->fetch_assoc();
            $num_struct_tot=$arr_struct_tot['struct'];
        $sql="insert ignore into Reader_profile (id_usuario,cond_exp_infer,cond_exp_monit,cond_exp_struct,total_infer,total_monit,total_struct) ".
        "values('$username',$num_infer_corr,$num_monit_corr,$num_struct_corr,$num_infer_tot,$num_monit_tot,$num_struct_tot)";
   
        if (!$resultado = $con1->query($sql)) {
            $error=mysqli_error($con1);
            echo $error;
            exit();
        }
       




}

?>
