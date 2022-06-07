<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Editar Tabla Trabajos</title>
    <link rel="stylesheet" href="css/trabajos.css">
</head>
<body>
<div class="body"></div>
<?php

include 'conexion_a_bbdd.php';

echo "<div class='bienvenida'>TABLA EMPLEADOS</div>";

// Establecemos el formulacio que va a pintar en la web y el mensaje final.
$formularios = false;
$mensaje = '';
echo "</br>";

//Buscar por código de cliente
if(isset($_POST['btnBuscar'])){
    $consulta = "SELECT * FROM trabajos WHERE Trabajo_ID=:codigo;";
    $datos = $conn->prepare($consulta);
    $consultaCodigo = intval($_POST['codigo']);
    $datos->bindParam(':codigo', $consultaCodigo);
    $datos->execute();
    $registro = $datos->fetch(PDO:: FETCH_ASSOC);
    if($registro==0){
        $mensaje =  "<div class='mensajeError'>El tipo de trabajo ingresado no existe</div>";
    }else{
        $formularios = true;
        }
}

//Insertar registros
if(isset($_REQUEST['btnInsertar'])){
    try{
        $consulta= 'INSERT INTO trabajos (Trabajo_ID, Funcion) VALUES (:codigo, :funcion)'; 
        $datos=$conn->prepare($consulta); 
        $datos->bindParam(':codigo', $_POST['codigo']);
        $datos->bindParam(':funcion', $_POST['funcion']);

        if($datos->execute()){
            $mensaje = "<div class='mensaje'>El registro se ha insertado correctamente.</div>";

            $archivo= fopen("log/log.txt", "a+b");

            if($archivo == false){
                $archivo= fopen("log/log.txt", "w+b");
            }
            else{
                date_default_timezone_set('Europe/Madrid');    
                $fechaHoy = date('m-d-Y h:i:s a', time());
                fwrite($archivo, "\r\n");
                $datosInsertados="Se han INSERTADO los siguientes registros a fecha de " . $fechaHoy . "\r\n" .
                "########################### TABLA TRABAJOS ########################". "\r\n" .
                "#Trabajo_ID# ". $_POST['codigo'] ."\r\n" .
                "#Funcion# ". $_POST['funcion']."\r\n" .
                "--------------------------------------------------------------------";
                
                fwrite($archivo, "\r\n");
                fwrite($archivo, $datosInsertados);
                
                $texto = fread($archivo, filesize('log/log.txt'));
                echo $texto;
            }
            fclose($archivo);
        }

        $registro = $datos->fetch(PDO:: FETCH_ASSOC);
        
    }catch(PDOException $e){
        echo "<div class='mensajeErrorInsert'> Error: ".$e->getMessage() . "</div>";
    }
}

//Eliminar registros
if(isset($_REQUEST['btnEliminar'])){
    try{
        $consulta = "DELETE FROM trabajos WHERE Trabajo_ID=:codigo;";
        $datos = $conn->prepare($consulta);
        $datos->bindParam(':codigo', $_POST['codigo']);
        $datos->execute();

        if($datos->execute()){
            $mensaje = "<div class='mensaje'>El registro se ha eliminado correctamente.</div>";

            $archivo= fopen("log/log.txt", "a+b");

            if($archivo == false){
                $archivo= fopen("log/log.txt", "w+b");
            }
            else{
                date_default_timezone_set('Europe/Madrid');    
                $fechaHoy = date('m-d-Y h:i:s a', time());
                fwrite($archivo, "\r\n");
                $datosInsertados="Se han ELIMINADO los siguientes registros a fecha de " . $fechaHoy . "\r\n" .
                "########################### TABLA TRABAJOS ########################". "\r\n" .
                "#Trabajo_ID# ". $_POST['codigo'] ."\r\n" .
                "#Funcion# ". $_POST['funcion']."\r\n" .
                "--------------------------------------------------------------------";
                
                fwrite($archivo, "\r\n");
                fwrite($archivo, $datosInsertados);
                
                $texto = fread($archivo, filesize('log/log.txt'));
                echo $texto;
            }
            fclose($archivo);
        }

        $registro = $datos->fetch(PDO:: FETCH_ASSOC);
        
    }catch(PDOException $e){
        echo "<div class='mensajeErrorInsert'> Error: ".$e->getMessage() . "</div>";
    }
}

//Modificar registros
if(isset($_REQUEST['btnModificar'])){
    try{
        $consulta = "UPDATE trabajos SET Trabajo_ID=:codigo, Funcion=:funcion WHERE Trabajo_ID=:codigo;";
        $datos=$conn->prepare($consulta); 
        $datos->bindParam(':codigo', $_POST['codigo']);
        $datos->bindParam(':funcion', $_POST['funcion']);

        $datos->execute();

        if($datos->execute()){
            $mensaje = "<div class='mensaje'>El registro se ha actualizado correctamente.</div>";

            $archivo= fopen("log/log.txt", "a+b");

            if($archivo == false){
                $archivo= fopen("log/log.txt", "w+b");
            }
            else{
                date_default_timezone_set('Europe/Madrid');    
                $fechaHoy = date('m-d-Y h:i:s a', time());
                fwrite($archivo, "\r\n");
                $datosInsertados="Se han ACTUALIZADO los siguientes registros a fecha de " . $fechaHoy . "\r\n" .
                "########################### TABLA TRABAJOS ########################". "\r\n" .
                "#Trabajo_ID# ". $_POST['codigo'] ."\r\n" .
                "#Funcion# ". $_POST['funcion']."\r\n" .
                "--------------------------------------------------------------------";
                
                fwrite($archivo, "\r\n");
                fwrite($archivo, $datosInsertados);
                
                $texto = fread($archivo, filesize('log/log.txt'));
                echo $texto;
            }
            fclose($archivo);
        }

        $registro = $datos->fetch(PDO:: FETCH_ASSOC);
        
    }catch(PDOException $e){
        echo "<div class='mensajeErrorInsert'> Error: ".$e->getMessage() . "</div>";
    }
}



//Formularios:
$html = '';
if($formularios == false){
    $html = "<div class='divForm'><form class='formEmpleados' action='' method='post'>";
    $html.= "<fieldset>";
    $html.= "ID de Trabajo: ";
    $html.= "<input type='text' name='codigo' value=''>";
    $html.= "Funcion: ";
    $html.= "<input type='text' name='funcion' value=''>";
    $html.= "<input class='btnBuscar' type='submit' name='btnBuscar' value='Buscar' style='background-color: rgb(52, 153, 21);color: aliceblue;'>";
    $html.= "<input class='btnInsertar' type='submit' name='btnInsertar' value='Insertar'>";
    $html.= "<input class='btnTabla' type='submit' name='btnTabla' value='Ver Tabla'>";
    $html.= "<input class='btnMenu' type='submit' name='btnMenu' value='Volver al Menú'>";
    $html.= "</fieldset>";
    $html.= "</form></div>";

    echo $html;
}

if ($formularios == true){
    $html = "<div class='divForm'><form class='formEmpleados' action='' method='post'>";
    $html.= "<fieldset>";
    $html.= "ID de trabajo: ";
    $html.= "<input type='text' name='codigo' value='".$registro['Trabajo_ID']."'>";
    $html.= "Funcion: ";
    $html.= "<input type='text' name='funcion' value='".$registro['Funcion']."'>";
    $html.= "<input class='btnBuscar' type='submit' name='btnBuscar' value='Buscar' style='background-color: rgb(52, 153, 21);color: aliceblue;'>";
    $html.= "<input class='btnInsertar' type='submit' name='btnInsertar' value='Insertar'>";
    $html.= "<input class='btnModificar' type='submit' name='btnModificar' value='Modificar'>";
    $html.= "<input class='btnEliminar' type='submit' name='btnEliminar' value='Eliminar'>";
    $html.= "<input class='btnAtras' type='button' value='Atrás' onclick='history.back();'>";
    $html.= "<input class='btnTabla' type='submit' name='btnTabla' value='Ver Tabla'>";
    $html.= "</fieldset>";
    $html.= "</form></div>";
    echo $html;
}
 echo "</br></br>$mensaje";

  //Pintar tabla
 if(isset($_REQUEST['btnTabla'])){

    $columnas=$conn->query("SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA = 'pufosa' AND TABLE_NAME = 'trabajos'");
    $registroColmn = $columnas->fetchAll(PDO::FETCH_ASSOC);
    echo "<table border>";
    foreach($registroColmn as $columnas) {
        foreach($columnas as $nombres)
    
        echo "<th>" .$nombres ."</th>";
        } 

    $tabla=$conn->query("SELECT * FROM trabajos");
    while ($row = $tabla->fetch(PDO::FETCH_ASSOC)){
        echo "<tr>";
        foreach($row as $i){
            echo "<td class= 'r' id='a'>" . $i . "</td>";
        }	
        echo "</tr>";
            
    }
    echo "</table>";

}
//Cerrar sesión
if(isset($_POST['btnMenu'])){
    ?>
    <script type="text/javascript">
        window.location.replace("menu_managers.php");
   </script>      
    <?php
}

?>
</body>
</html>