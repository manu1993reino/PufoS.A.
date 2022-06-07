<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Editar Tabla Clientes</title>
    <link rel="stylesheet" href="css/menu_empleados.css">
</head>
<body>
<div class="body"></div>
<?php

//##COMO TODAS LAS PAGINAS DE TRABAJAR CON TABLAS FUNCIONAN IGUAL PERO CAMBIANDO LOS PARAMETROS Y EL NUMERO##
//###DE ELLOS, SOLO HABRA COMENTARIOS EXPLICATIVOS EN ESTA PAGINA, SERIA REPETIR LO MISMO 20 VECES SI NO.####

//Inclumos la conexion a la base de datos
include 'conexion_a_bbdd.php';

echo "<div class='bienvenida'>BIENVENIDO AL PANEL DE CONTROL PARA EMPLEADOS DE PUFO S.A</div>";

//Inicializamos la variable formularios a modo booleano, para mas adelante, segun sea true o false
//nos pintara un formulario relleno con los parametros de busqueda o uno vacio para rellenar.
$formularios = false;
//Inicializamos la variable mensaje, la cual vamos a usar para los avisos de si las operaciones se
//han ejecutado con exito.
$mensaje = '';
echo "</br>";

//Buscar por codigo de cliente
if(isset($_POST['btnBuscar'])){
    $consulta = "SELECT * FROM cliente WHERE CLIENTE_ID=:codigo;";
    $datos = $conn->prepare($consulta);
    $consultaCodigo = intval($_POST['codigo']);
    $datos->bindParam(':codigo', $consultaCodigo);
    $datos->execute();
    $registro = $datos->fetch(PDO:: FETCH_ASSOC);
    //Si se devuelven 0 registros con el CLIENTE_ID indicado (clave primaria) significa que el usuario no existe
    //y lo indicamos con la variable $mensaje
    if($registro==0){
        $mensaje =  "<div class='mensajeError'>El cliente ingresado no existe</div>";
    }else{
        $formularios = true;
        }
}

//Isertar Cliente
if(isset($_POST['btnInsertar'])){
    try{
        $consulta= 'INSERT INTO cliente (CLIENTE_ID, nombre, Direccion, Ciudad, Estado, CodigoPostal, 
        CodigoDeArea, Telefono, Vendedor_ID, Limite_De_Credito, Comentarios) VALUES (:codigo, :nombre, 
        :direccion, :ciudad, :estado, :cp, :ca, :telefono, :vid, :ldc, :comentarios)'; 
        $datos=$conn->prepare($consulta); 
        $datos->bindParam(':codigo', $_POST['codigo']);
        $datos->bindParam(':nombre', $_POST['nombre']);
        $datos->bindParam(':direccion', $_POST['direccion']);
        $datos->bindParam(':ciudad', $_POST['ciudad']);
        $datos->bindParam(':estado', $_POST['estado']);
        $datos->bindParam(':cp', $_POST['cp']);
        $datos->bindParam(':ca', $_POST['ca']);
        $datos->bindParam(':telefono', $_POST['telefono']);
        $datos->bindParam(':vid', $_POST['vid']);
        $datos->bindParam(':ldc', $_POST['ldc']);
        $datos->bindParam(':comentarios', $_POST['comentarios']);

        //Si la consulta de inserción se ejecuta correctamente nos sale por pantalla un mensaje indicandonoslo
        //y se procede a escribir en el archivo log los datos del registro actualizado.
        if($datos->execute()){
            $mensaje = "<div class='mensaje'>El registro se ha insertado correctamente.</div>";
            
            //Abrir archivo
            $archivo= fopen("log/log.txt", "a+b");
            //Si el archivo no existe se crea
            if($archivo == false){
                $archivo= fopen("log/log.txt", "w+b");
            }
            else{
                date_default_timezone_set('Europe/Madrid');    
                $fechaHoy = date('m-d-Y h:i:s a', time());
                fwrite($archivo, "\r\n");
                $datosInsertados="Se han INSERTADO los siguientes registros a fecha de " . $fechaHoy . "\r\n" .
                "########################### TABLA CLIENTES ########################". "\r\n" .
                "#CLIENTE_ID# ". $_POST['codigo'] ."\r\n" .
                "#nombre# ". $_POST['nombre']."\r\n" .
                "#Direccion# ". $_POST['direccion']."\r\n" .
                "#Ciudad# ". $_POST['ciudad']."\r\n" .
                "#Estado# ". $_POST['estado']."\r\n" .
                "#CodigoPostal# ". $_POST['cp']."\r\n" .
                "#CodigoDeArea# ". $_POST['ca']."\r\n" .
                "#Telefono# ". $_POST['telefono']."\r\n" .
                "#Vendedor_ID# ". $_POST['vid']."\r\n" .
                "#Limite_De_Credito# ". $_POST['ldc']."\r\n" .
                "#Comentarios# ". $_POST['comentarios']. "\r\n" .
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


//Eliminar Cliente
if(isset($_POST['btnEliminar'])){
    try{
        $consulta = "DELETE FROM cliente WHERE CLIENTE_ID=:codigo;";
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
                "########################### TABLA CLIENTES ########################". "\r\n" .
                "#CLIENTE_ID# ". $_POST['codigo'] ."\r\n" .
                "#nombre# ". $_POST['nombre']."\r\n" .
                "#Direccion# ". $_POST['direccion']."\r\n" .
                "#Ciudad# ". $_POST['ciudad']."\r\n" .
                "#Estado# ". $_POST['estado']."\r\n" .
                "#CodigoPostal# ". $_POST['cp']."\r\n" .
                "#CodigoDeArea# ". $_POST['ca']."\r\n" .
                "#Telefono# ". $_POST['telefono']."\r\n" .
                "#Vendedor_ID# ". $_POST['vid']."\r\n" .
                "#Limite_De_Credito# ". $_POST['ldc']."\r\n" .
                "#Comentarios# ". $_POST['comentarios']. "\r\n" .
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

//Actualizar/Modificar cliente
if(isset($_POST['btnModificar'])){
    try{
        $consulta = "UPDATE cliente SET CLIENTE_ID=:codigo, nombre=:nombre, Direccion=:direccion, Ciudad=:ciudad, 
        Estado=:estado, CodigoPostal=:cp, CodigoDeArea=:ca, Telefono=:telefono, Vendedor_ID=:vid, Limite_De_Credito=:ldc, 
        Comentarios=:comentarios WHERE CLIENTE_ID=:codigo;";
        $datos=$conn->prepare($consulta); 
        $datos->bindParam(':codigo', $_POST['codigo']);
        $datos->bindParam(':nombre', $_POST['nombre']);
        $datos->bindParam(':direccion', $_POST['direccion']);
        $datos->bindParam(':ciudad', $_POST['ciudad']);
        $datos->bindParam(':estado', $_POST['estado']);
        $datos->bindParam(':cp', $_POST['cp']);
        $datos->bindParam(':ca', $_POST['ca']);
        $datos->bindParam(':telefono', $_POST['telefono']);
        $datos->bindParam(':vid', $_POST['vid']);
        $datos->bindParam(':ldc', $_POST['ldc']);
        $datos->bindParam(':comentarios', $_POST['comentarios']);
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
                "########################### TABLA CLIENTES ########################". "\r\n" .
                "#CLIENTE_ID# ". $_POST['codigo'] ."\r\n" .
                "#nombre# ". $_POST['nombre']."\r\n" .
                "#Direccion# ". $_POST['direccion']."\r\n" .
                "#Ciudad# ". $_POST['ciudad']."\r\n" .
                "#Estado# ". $_POST['estado']."\r\n" .
                "#CodigoPostal# ". $_POST['cp']."\r\n" .
                "#CodigoDeArea# ". $_POST['ca']."\r\n" .
                "#Telefono# ". $_POST['telefono']."\r\n" .
                "#Vendedor_ID# ". $_POST['vid']."\r\n" .
                "#Limite_De_Credito# ". $_POST['ldc']."\r\n" .
                "#Comentarios# ". $_POST['comentarios']. "\r\n" .
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


//Formularios - Si el valor booleano declarado al principio del documento es false, se pinta este primer formulario.
$html = '';
if($formularios == false){
    $html = "<div class='divForm'><form class='formEmpleados' action='' method='post'>";
    $html.= "<fieldset>";
    $html.= "Codigo: ";
    $html.= "<input type='text' name='codigo' value=''>";
    $html.= " Nombre: ";
    $html.= "<input type='text' name='nombre' value=''>";
    $html.= " Dirección: ";
    $html.= "<input type='text' name='direccion' value=''>";
    $html.= " Ciudad: ";
    $html.= "<input type='text' name='ciudad' value=''>";
    $html.= " Estado: ";
    $html.= "<input type='text' name='estado' value=''>";
    $html.= " CodigoPostal: ";
    $html.= "<input type='text' name='cp' value=''>";
    $html.= " CodigoDeArea: ";
    $html.= "<input type='text' name='ca' value=''>";
    $html.= " Teléfono: ";
    $html.= "<input type='text' name='telefono' value=''>";
    $html.= " Vendor_ID: ";
    $html.= "<input type='text' name='vid' value=''>";
    $html.= " Limite de crédito: ";
    $html.= "<input type='text' name='ldc' value=''>";
    $html.= " Comentarios: ";
    $html.= "<input type='text' name='comentarios' value=''>";
    $html.= "<input class='btnBuscar' type='submit' name='btnBuscar' value='Buscar' style='background-color: rgb(52, 153, 21);color: aliceblue;'>";
    $html.= "<input class='btnInsertar' type='submit' name='btnInsertar' value='Insertar'>";
    $html.= "<input class='btnTabla' type='submit' name='btnTabla' value='Ver Tabla'>";
    $html.= "<input class='btnMenu' type='submit' name='btnMenu' value='Cerrar Sesión'>";
    $html.= "</fieldset>";
    $html.= "</form></div>";

    echo $html;
}

//En caso de ser true, se pintara este, que nos saca por pantalla los datos de los campos correspondientes.
if ($formularios == true){
    $html = "<div class='divForm'><form class='formEmpleados' action='' method='post'>";
    $html.= "<fieldset>";
    $html.= "Codigo: ";
    $html.= "<input type='text' name='codigo' value='".$registro['CLIENTE_ID']."'>";
    $html.= " Nombre: ";
    $html.= "<input type='text' name='nombre' value='".$registro['nombre']."'>";
    $html.= " Dirección: ";
    $html.= "<input type='text' name='direccion' value='".$registro['Direccion']."'>";
    $html.= " Ciudad: ";
    $html.= "<input type='text' name='ciudad' value='".$registro['Ciudad']."'>";
    $html.= " Estado: ";
    $html.= "<input type='text' name='estado' value='".$registro['Estado']."'>";
    $html.= " CodigoPostal: ";
    $html.= "<input type='text' name='cp' value='".$registro['CodigoPostal']."'>";
    $html.= " CodigoDeArea: ";
    $html.= "<input type='text' name='ca' value='".$registro['CodigoDeArea']."'>";
    $html.= " Teléfono: ";
    $html.= "<input type='text' name='telefono' value='".$registro['Telefono']."'>";
    $html.= " Vendor_ID: ";
    $html.= "<input type='text' name='vid' value='".$registro['Vendedor_ID']."'>";
    $html.= " Limite de crédito: ";
    $html.= "<input type='text' name='ldc' value='".$registro['Limite_De_Credito']."'>";
    $html.= " Comentarios: ";
    $html.= "<textarea type='text'rows='10' cols='40' name='comentarios'>" .$registro['Comentarios']. "</textarea>";
    $html.= "<input class='btnBuscar' type='submit' name='btnBuscar' value='Buscar'>";
    $html.= "<input class='btnInsertar' type='submit' name='btnInsertar' value='Insertar'>";
    $html.= "<input class='btnModificar' type='submit' name='btnModificar' value='Modificar'>";
    $html.= "<input class='btnEliminar' type='submit' name='btnEliminar' value='Eliminar'>";
    $html.= "<input class='btnTabla' type='submit' name='btnTabla' value='Ver Tabla'>";
    $html.= "<input class='btnAtras' type='button' value='Atrás' onclick='history.back();'>";
    $html.= "</fieldset>";
    $html.= "</form></div>";
    echo $html;
}
 echo "</br></br>$mensaje";

//Con esta parte de codigo damos la opcion de que pulsando un botón se nos pinte la tabla correspondiente.
 if(isset($_POST['btnTabla'])){

    //Sacamos y pintamos con foreach el nombre de las columnas
    $columnas=$conn->query("SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA = 'pufosa' AND TABLE_NAME = 'cliente'");
    $registroColmn = $columnas->fetchAll(PDO::FETCH_ASSOC);
    echo "<table border>";
    foreach($registroColmn as $columnas) {
        foreach($columnas as $nombres)
    
        echo "<th>" .$nombres ."</th>";
        } 
    //Sacamos y pintamos con while y foreach los registros.
    $tabla=$conn->query("SELECT * FROM cliente");
    while ($row = $tabla->fetch(PDO::FETCH_ASSOC)){
        echo "<tr>";
        foreach($row as $i){
            echo "<td class= 'r' id='a'>" . $i . "</td>";
        }	
        echo "</tr>";
            
    }
    echo "</table>";

}

//Opcion de cerrar sesión y volver a la pagina de login.
if(isset($_POST['btnMenu'])){
    ?>
    <script type="text/javascript">
        window.location.replace("index.php");
   </script>      
    <?php
}


?>
</body>
</html>