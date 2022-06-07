<?php

//Inluimos el archivo de conexión a la base de datos
include 'conexion_a_bbdd.php';

if (isset($_POST["btnEnviar"])){

    //Recogemos en estas dos variables el lusuario y la contraseña del formulario de index, por el metodo post.
    $id_usuario = $_POST['usuario'];
    $contrasena = $_POST['contrasena'];

    //Hacemos una select en la que recogeremos el empleado_ID, en este caso valdra tanto para usaurio como para contraseña
    $query = $conn->prepare("SELECT * FROM alumnos WHERE NOMBRE=:id_usuario");
    $query->bindParam(":id_usuario", $id_usuario);
    $query->bindParam(":id_usuario", strtolower($contrasena));
    $query->execute();

    $result = $query->fetch(PDO::FETCH_ASSOC);


    //Entramos en los tres primeros condicionales dependiendo de que cual de las consultas nos haya devuelto datos.
    if($result){
        echo "Bienvenido " . $id_usuario;
    }
    else{
        header("Location: usuarioErroneo.php");
    }

}
?>