<?php
function insert_Resp_User($con,$user,$id_pregunta,$resp_user,$resp_correct,$id_cuento,$id_num)
{   include("check_end.php");
    $con->set_charset("utf8");
    if ($resp_correct==$resp_user)
    {
    $result=1;
    $sql1="select feedback_correcto from Pregunta where id_pregunta=$id_pregunta";
    if (!$resultado = $con->query($sql1)) 
    {
        echo "error consulta a la base de datos.";
        exit;
    }
     $feedback_vect = $resultado->fetch_assoc();
     $feedback=$feedback_vect['feedback_correcto'];
     
     $feedback_flag=1;
     $flag_puntuacion=1;
    }
    else
    {
        $result=0;
        $sql1="select feedback_incorrecto from Pregunta where id_pregunta=$id_pregunta";
        if (!$resultado = $con->query($sql1)) 
        {
        echo "error consulta a la base de datos.";
        exit;
        }
        $feedback_vect = $resultado->fetch_assoc();
        $feedback=$feedback_vect['feedback_incorrecto'];
        
        $feedback_flag=0;
        $flag_puntuacion=-1;

     
    }
     $sql1="SELECT count(id_pregunta)as order_preg FROM Respuesta_pregunta where nombre_usuario='$user' and estado=1";
        if (!$resultado = $con->query($sql1)) 
        {
        $error=mysqli_error($con);
        echo $error;
        exit;
        }
        $arr_order_preg = $resultado->fetch_assoc();
        $order_preg=$arr_order_preg['order_preg'];
    //
    //print $result;
    //print $user;
    $sql1="update Respuesta_pregunta set resultado=$result,resp_user='$resp_user',id_feedback=$feedback_flag,estado=1,orden_preg=$order_preg+1 where nombre_usuario='$user' and id_pregunta=$id_pregunta and estado=0";
    if (!$resultado = $con->query($sql1)) {
        $error=mysqli_error($con);
         echo $error;
       
        exit;
    }
    // PUNTAJE RESTAR O AUMENTAR !!!
    $sql="SELECT cond_exp from Pregunta WHERE id_pregunta=$id_pregunta";
    if (!$resultado = $con->query($sql)) {
        $error=mysqli_error($con);
         echo $error;
       
        exit;
    }
    $arr_cond_exp_preg=$resultado->fetch_assoc();     
    $cond_exp_kind_preg=$arr_cond_exp_preg['cond_exp'];
    //echo $cond_exp_kind_preg;
    // add or rest the profile
    if ($cond_exp_kind_preg=='infer') {
        # code...
        $sql="UPDATE Reader_profile set cond_exp_infer=cond_exp_infer+$flag_puntuacion where id_usuario='$user' and cond_exp_infer>0";
         if (!$resultado = $con->query($sql)) {
            $error=mysqli_error($con);
             echo $error;
           
            exit;
            }
        $sql="UPDATE Reader_profile set total_infer=1+total_infer where id_usuario='$user'";
         if (!$resultado = $con->query($sql)) {
            $error=mysqli_error($con);
             echo $error;
           
            exit;
            }    

    }
     if ($cond_exp_kind_preg=='monit') {

         $sql="UPDATE Reader_profile set cond_exp_monit=cond_exp_monit+$flag_puntuacion where id_usuario='$user' and cond_exp_monit>0";
         if (!$resultado = $con->query($sql)) {
        $error=mysqli_error($con);
         echo $error;
       
        exit;
        }
        $sql="UPDATE Reader_profile set total_monit=1+total_monit where id_usuario='$user'";
         if (!$resultado = $con->query($sql)) {
        $error=mysqli_error($con);
         echo $error;
       
        exit;
        }   
    }
     if ($cond_exp_kind_preg=='struct') {
        
         $sql="UPDATE Reader_profile set cond_exp_struct=cond_exp_struct+$flag_puntuacion where id_usuario='$user' and cond_exp_struct>0";
         if (!$resultado = $con->query($sql)) {
        $error=mysqli_error($con);
         echo $error;
       
        exit;
        }
        $sql="UPDATE Reader_profile set total_struct=1+total_struct where id_usuario='$user'";
         if (!$resultado = $con->query($sql)) {
        $error=mysqli_error($con);
         echo $error;
       
        exit;
        }         
    }

// SET INDICE DE PAGINA DINAMICO

    $sql="SELECT veces_leido FROM Cuento_por_Usuario WHERE id_cuento=$id_cuento and id_usuario='$user'";
    if (!$resultado = $con->query($sql)) 
        {
             $error=mysqli_error($con);
             echo $error;
             exit();
        }
    $arr_veces_leido=$resultado->fetch_assoc();     
    $veces_leido=$arr_veces_leido['veces_leido'];



    $sql="select ind_pagina from Cuento_por_Usuario where id_cuento=$id_cuento and id_usuario='$user'";
     if (!$resultado = $con->query($sql)) 
    {
     $error=mysqli_error($con);
     echo $error;
     exit();
    }
    $arr_ind_pagina = $resultado->fetch_assoc();
    $ind_pagina=$arr_ind_pagina['ind_pagina'];
    // internal index

     $sql="select internal_index from Cuento_por_Usuario where id_cuento=$id_cuento and id_usuario='$user'";
     if (!$resultado = $con->query($sql)) 
    {
     $error=mysqli_error($con);
     echo $error;
     exit();
    }
    $arr_internal_index = $resultado->fetch_assoc();
    $internal_index=$arr_internal_index['internal_index'];

    //GET POSIBLE OVERLAP
    $sql="SELECT overlap FROM Pagina_by_user WHERE id_usuario='$user' and intento=$veces_leido and numeracion=$id_num and id_cuento=$id_cuento";
    if (!$resultado = $con->query($sql)) 
    {
     $error=mysqli_error($con);
     echo $error;
     exit();
    }
    $arr_overlap = $resultado->fetch_assoc();
    $overlap=$arr_overlap['overlap'];

    $current_ind_pagina=$overlap+$ind_pagina;
    $internal_index=$overlap+$internal_index;

        $sql="update Cuento_por_Usuario set ind_pagina=".$current_ind_pagina." where id_cuento=$id_cuento and id_usuario='$user'";
        if (!$resultado = $con->query($sql)) 
        {
         $error=mysqli_error($con);
         echo $error;
         exit();
        }
    $sql="update Cuento_por_Usuario set internal_index=".$internal_index." where id_cuento=$id_cuento and id_usuario='$user'";
        if (!$resultado = $con->query($sql)) 
        {
         $error=mysqli_error($con);
         echo $error;
         exit();
      
    }
mysqli_close($con);  
unset($con);
$feedback=base64_encode($feedback_flag);
echo '<script type="text/javascript">
           window.location = "feedback.html?id_feed='.$feedback.'"</script>';

} 

?>
