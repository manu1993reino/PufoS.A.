<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Editar Tabla Departamentos</title>
    <link rel="stylesheet" href="css/departamentos.css">
</head>
<body>
<div class="body"></div>
<?php

include 'conexion_a_bbdd.php';

echo "<div class='bienvenida'>TABLA DEPARTAMENTOS</div>";

// Establecemos el formulacio que va a pintar en la web y el mensaje final.
$formularios = false;
$mensaje = '';
echo "</br>";

//Buscar por código de cliente
if(isset($_POST['btnBuscar'])){
    $consulta = "SELECT * FROM departamento WHERE departamento_ID=:codigo;";
    $datos = $conn->prepare($consulta);
    $consultaCodigo = intval($_POST['codigo']);
    $datos->bindParam(':codigo', $consultaCodigo);
    $datos->execute();
    $registro = $datos->fetch(PDO:: FETCH_ASSOC);
    if($registro==0){
        $mensaje =  "<div class='mensajeError'>El departamento ingresado no existe</div>";
    }else{
        $formularios = true;
        }
}

//Insertar registros
if(isset($_REQUEST['btnInsertar'])){
    try{
        $consulta= 'INSERT INTO departamento (departamento_ID, Nombre, Ubicacion_ID) VALUES (:codigo, :nombre, :ubicacion)'; 
        $datos=$conn->prepare($consulta); 
        $datos->bindParam(':codigo', $_POST['codigo']);
        $datos->bindParam(':nombre', $_POST['nombre']);
        $datos->bindParam(':ubicacion', $_POST['ubicacion']);

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
                "########################### TABLA DEPARTAMENTOS ########################". "\r\n" .
                "#departamento_ID# ". $_POST['codigo'] ."\r\n" .
                "#Nombre# ". $_POST['nombre']."\r\n" .
                "#Ubicacion_ID# ". $_POST['ubicacion']."\r\n" .
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
        $consulta = "DELETE FROM departamento WHERE departamento_ID=:codigo;";
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
                "########################### TABLA DEPARTAMENTOS ########################". "\r\n" .
                "#departamento_ID# ". $_POST['codigo'] ."\r\n" .
                "#Nombre# ". $_POST['nombre']."\r\n" .
                "#Ubicacion_ID# ". $_POST['ubicacion']."\r\n" .
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
        $consulta = "UPDATE departamento SET departamento_ID=:codigo, Nombre=:nombre, Ubicacion_ID=:ubicacion WHERE departamento_ID=:codigo;";
        $datos=$conn->prepare($consulta); 
        $datos->bindParam(':codigo', $_POST['codigo']);
        $datos->bindParam(':nombre', $_POST['nombre']);
        $datos->bindParam(':ubicacion', $_POST['ubicacion']);

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
                "########################### TABLA DEPARTAMENTOS ########################". "\r\n" .
                "#departamento_ID# ". $_POST['codigo'] ."\r\n" .
                "#Nombre# ". $_POST['nombre']."\r\n" .
                "#Ubicacion_ID# ". $_POST['ubicacion']."\r\n" .
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
    $html.= "ID de departamento: ";
    $html.= "<input type='text' name='codigo' value=''>";
    $html.= "Nombre: ";
    $html.= "<input type='text' name='nombre' value=''>";
    $html.= "ID de ubicación: ";
    $html.= "<input type='text' name='ubicacion' value=''>";
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
    $html.= "ID de departamento: ";
    $html.= "<input type='text' name='codigo' value='".$registro['departamento_ID']."'>";
    $html.= "Nombre: ";
    $html.= "<input type='text' name='nombre' value='".$registro['Nombre']."'>";
    $html.= "ID de ubicación: ";
    $html.= "<input type='text' name='ubicacion' value='".$registro['Ubicacion_ID']."'>";
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

    $columnas=$conn->query("SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA = 'pufosa' AND TABLE_NAME = 'departamento'");
    $registroColmn = $columnas->fetchAll(PDO::FETCH_ASSOC);
    echo "<table border>";
    foreach($registroColmn as $columnas) {
        foreach($columnas as $nombres)
    
        echo "<th>" .$nombres ."</th>";
        } 

    $tabla=$conn->query("SELECT * FROM departamento");
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
        window.location.replace("menu_president.php");
   </script>      
    <?php
}

?>
</body>
</html>