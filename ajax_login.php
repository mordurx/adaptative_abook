<?php
session_start();   
include("ConectarBaseDatos.php");
include("get_profile.php");
$con=ConectarDB();
$con->set_charset("utf8");
$username=$_POST['username'];
$con2=ConectarDB_training();
$con2->set_charset("utf8");

// con2= training database
// con= adapt database


$sql1="SELECT COUNT(nombre)as count_user FROM Usuario WHERE nombre='$username'";

if (!$resultado = $con2->query($sql1)) {
        // ¡Oh, no! La consulta falló. 
        $error=mysqli_error($con2);
        echo $error;
        exit();
    }
    $arr_nombre=$resultado->fetch_assoc();
    $nombre=$arr_nombre['count_user'];
    if ($nombre<1)
    {
    #si no existe el user en la bd
       echo  json_encode(-1);
       exit();

      
    }
    else
    {
        $sql1="SELECT id_usuario,nombre,correo,edad FROM Usuario WHERE nombre='$username'";

        if (!$resultado = $con2->query($sql1)) {
                // ¡Oh, no! La consulta falló. 
                $error=mysqli_error($con2);
                echo $error;
                exit();
            }
        $user_data=$resultado->fetch_assoc();
        $id_usuario=$user_data['id_usuario'];
        $nombre=$user_data['nombre'];
        $edad=$user_data['edad'];
        $correo=$user_data['correo'];
        //removi insert el id de usuario      
        $sql="insert ignore into Usuario (nombre,edad,correo)values('$nombre',$edad,'$correo')";
   
        if (!$resultado = $con->query($sql)) {
            $error=mysqli_error($con);
            echo $error;
            exit();
        }
        Get_data_profile($username,$con,$con2);
        $sql="INSERT ignore INTO Cuento_por_Usuario (id_usuario,id_cuento) SELECT Usuario.nombre, id_cuento FROM Usuario INNER JOIN Cuento where Usuario.nombre='$username'";
                if (!$resultado = $con->query($sql)) 
                {
                    $error=mysqli_error($con);
                    //echo $error;
                    exit();
                }
                
                $_SESSION['username'] = $username;
                echo  json_encode(1);
    

    }
    

    
    


mysqli_close($con);  
unset($con);
mysqli_close($con2);  
unset($con2);    



?>
