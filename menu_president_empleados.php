<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Editar Tabla Empleados</title>
    <link rel="stylesheet" href="css/empleados.css">
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
    $consulta = "SELECT * FROM empleados WHERE empleado_ID=:codigo;";
    $datos = $conn->prepare($consulta);
    $consultaCodigo = intval($_POST['codigo']);
    $datos->bindParam(':codigo', $consultaCodigo);
    $datos->execute();
    $registro = $datos->fetch(PDO:: FETCH_ASSOC);
    if($registro==0){
        $mensaje =  "<div class='mensajeError'>El empleado ingresado no existe</div>";
    }else{
        $formularios = true;
        }
}

//Insertar registros
if(isset($_REQUEST['btnInsertar'])){
    try{
        $consulta= 'INSERT INTO empleados (empleado_ID, Apellido, Nombre, Inicial_del_segundo_apellido, Trabajo_ID, Jefe_ID, 
        Fecha_contrato, Salario, Comision, Departamento_ID) VALUES (:codigo, :apellido, :nombre, :inicialSegApe, :trabajoId, :jefeId, :fechacontrato, 
        :salario, :comision, :departamentoId)'; 
        $datos=$conn->prepare($consulta); 
        $datos->bindParam(':codigo', $_POST['codigo']);
        $datos->bindParam(':apellido', $_POST['apellido']);
        $datos->bindParam(':nombre', $_POST['nombre']);
        $datos->bindParam(':inicialSegApe', $_POST['inicialSegApe']);
        $datos->bindParam(':trabajoId', $_POST['trabajoId']);
        $datos->bindParam(':jefeId', $_POST['jefeId']);
        $datos->bindParam(':fechacontrato', $_POST['fechacontrato']);
        $datos->bindParam(':salario', $_POST['salario']);
        $datos->bindParam(':comision', $_POST['comision']);
        $datos->bindParam(':departamentoId', $_POST['departamentoId']);

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
                "########################### TABLA EMPLEADOS ########################". "\r\n" .
                "#empleado_ID# ". $_POST['codigo'] ."\r\n" .
                "#Apellido# ". $_POST['apellido']."\r\n" .
                "#Nombre# ". $_POST['nombre']."\r\n" .
                "#Inicial_del_segundo_apellido# ". $_POST['inicialSegApe']."\r\n" .
                "#Trabajo_ID# ". $_POST['trabajoId']."\r\n" .
                "#Jefe_ID# ". $_POST['jefeId']."\r\n" .
                "#Fecha_contrato# ". $_POST['fechacontrato']."\r\n" .
                "#Salario# ". $_POST['salario']."\r\n" .
                "#Comision# ". $_POST['comision']."\r\n" .
                "#Departamento_ID# ". $_POST['departamentoId']."\r\n" .
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
        $consulta = "DELETE FROM empleados WHERE empleado_ID=:codigo;";
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
                "########################### TABLA EMPLEADOS ########################". "\r\n" .
                "#empleado_ID# ". $_POST['codigo'] ."\r\n" .
                "#Apellido# ". $_POST['apellido']."\r\n" .
                "#Nombre# ". $_POST['nombre']."\r\n" .
                "#Inicial_del_segundo_apellido# ". $_POST['inicialSegApe']."\r\n" .
                "#Trabajo_ID# ". $_POST['trabajoId']."\r\n" .
                "#Jefe_ID# ". $_POST['jefeId']."\r\n" .
                "#Fecha_contrato# ". $_POST['fechacontrato']."\r\n" .
                "#Salario# ". $_POST['salario']."\r\n" .
                "#Comision# ". $_POST['comision']."\r\n" .
                "#Departamento_ID# ". $_POST['departamentoId']."\r\n" .
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
        $consulta = "UPDATE empleados SET empleado_ID=:codigo, Apellido=:apellido, Nombre=:nombre, Inicial_del_segundo_apellido=:inicialSegApe, 
        Trabajo_ID=:trabajoId, Jefe_ID=:jefeId, Fecha_contrato=:fechacontrato, Salario=:salario, Comision=:comision, Departamento_ID=:departamentoId 
        WHERE empleado_ID=:codigo;";
        $datos=$conn->prepare($consulta); 
        $datos->bindParam(':codigo', $_POST['codigo']);
        $datos->bindParam(':apellido', $_POST['apellido']);
        $datos->bindParam(':nombre', $_POST['nombre']);
        $datos->bindParam(':inicialSegApe', $_POST['inicialSegApe']);
        $datos->bindParam(':trabajoId', $_POST['trabajoId']);
        $datos->bindParam(':jefeId', $_POST['jefeId']);
        $datos->bindParam(':fechacontrato', $_POST['fechacontrato']);
        $datos->bindParam(':salario', $_POST['salario']);
        $datos->bindParam(':comision', $_POST['comision']);
        $datos->bindParam(':departamentoId', $_POST['departamentoId']);
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
                "########################### TABLA EMPLEADOS ########################". "\r\n" .
                "#empleado_ID# ". $_POST['codigo'] ."\r\n" .
                "#Apellido# ". $_POST['apellido']."\r\n" .
                "#Nombre# ". $_POST['nombre']."\r\n" .
                "#Inicial_del_segundo_apellido# ". $_POST['inicialSegApe']."\r\n" .
                "#Trabajo_ID# ". $_POST['trabajoId']."\r\n" .
                "#Jefe_ID# ". $_POST['jefeId']."\r\n" .
                "#Fecha_contrato# ". $_POST['fechacontrato']."\r\n" .
                "#Salario# ". $_POST['salario']."\r\n" .
                "#Comision# ". $_POST['comision']."\r\n" .
                "#Departamento_ID# ". $_POST['departamentoId']."\r\n" .
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
    $html.= "Codigo: ";
    $html.= "<input type='text' name='codigo' value=''>";
    $html.= "Apellido: ";
    $html.= "<input type='text' name='apellido' value=''>";
    $html.= "Nombre: ";
    $html.= "<input type='text' name='nombre' value=''>";
    $html.= "Inicial del segundo apellido: ";
    $html.= "<input type='text' name='inicialSegApe' value=''>";
    $html.= "Trabajo ID: ";
    $html.= "<input type='text' name='trabajoId' value=''>";
    $html.= "Jefe ID: ";
    $html.= "<input type='text' name='jefeId' value=''>";
    $html.= "Fecha de contrato: ";
    $html.= "<input type='date' name='fechacontrato' value=''>";
    $html.= "Salario: ";
    $html.= "<input type='text' name='salario' value=''>";
    $html.= "Comision: ";
    $html.= "<input type='text' name='comision' value=''>";
    $html.= "ID de departamento: ";
    $html.= "<input type='text' name='departamentoId' value=''>";
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
    $html.= "Codigo: ";
    $html.= "<input type='text' name='codigo' value='".$registro['empleado_ID']."'>";
    $html.= "Apellido: ";
    $html.= "<input type='text' name='apellido' value='".$registro['Apellido']."'>";
    $html.= "Nombre: ";
    $html.= "<input type='text' name='nombre' value='".$registro['Nombre']."'>";
    $html.= "Inicial del segundo apellido: ";
    $html.= "<input type='text' name='inicialSegApe' value='".$registro['Inicial_del_segundo_apellido']."'>";
    $html.= "Trabajo ID: ";
    $html.= "<input type='text' name='trabajoId' value='".$registro['Trabajo_ID']."'>";
    $html.= "Jefe ID: ";
    $html.= "<input type='text' name='jefeId' value='".$registro['Jefe_ID']."'>";
    $html.= "Fecha de contrato: ";
    $html.= "<input type='date' name='fechacontrato' value='".$registro['Fecha_contrato']."'>";
    $html.= "Salario: ";
    $html.= "<input type='text' name='salario' value='".$registro['Salario']."'>";
    $html.= "Comision: ";
    $html.= "<input type='text' name='comision' value='".$registro['Comision']."'>";
    $html.= "ID de departamento: ";
    $html.= "<input type='text' name='departamentoId' value='".$registro['Departamento_ID']."'>";
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

    $columnas=$conn->query("SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA = 'pufosa' AND TABLE_NAME = 'empleados'");
    $registroColmn = $columnas->fetchAll(PDO::FETCH_ASSOC);
    echo "<table border>";
    foreach($registroColmn as $columnas) {
        foreach($columnas as $nombres)
    
        echo "<th>" .$nombres ."</th>";
        } 

    $tabla=$conn->query("SELECT * FROM empleados");
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