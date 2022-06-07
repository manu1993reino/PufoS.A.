<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Informe de Departamentos</title>
    <link rel="stylesheet" href="css/informe_departamentos.css">
</head>
<body>
    <div class="body"></div>
<?php

//Incluimos nuestro archivo de conexión
include ('conexion_a_bbdd.php');

//Hacemos la consulta correspondiente para obtener los datos deseados en el informe de departamento
$tabla=$conn->query("SELECT departamento.departamento_ID as 'ID de Departamento', departamento.nombre as 'Nombre', 
ubicacion.GrupoRegional as 'Ubicación', count(empleados.empleado_ID) as 'Numero de empleados', 
concat(max(empleados.Salario),'€') as 'Salario Maximo del Departamento', concat(min(empleados.Salario), '€') as 'Salario Minimo del Departamento', 
concat(round((sum(empleados.Salario)/(count(empleados.empleado_ID))),2), '€')  as 'Salario Medio del Departamento'
	from departamento
    inner join ubicacion 
		on (departamento.Ubicacion_ID = ubicacion.Ubicacion_ID)
    inner join empleados 
		on (departamento.departamento_ID = empleados.departamento_ID)
    group by departamento.departamento_ID
    ;");
//Sacamos los resultados en un array asociativo
$row = $tabla->fetch(PDO::FETCH_ASSOC);
//Creamos la cabecera de la tabla
echo "<table border>";
echo "<thead>
        <th colspan='7'>INFORME DE DEPARTAMENTOS</th>
    </thead>";
echo "<th> ID de Departamento </th>";
echo "<th> Nombre </th>";
echo "<th> Ubicación </th>";
echo "<th> Numero de empleados </th>";
echo "<th> Salario Maximo del Departamento </th>";
echo "<th> Salario Minimo del Departamento </th>";
echo "<th> Salario Medio del Departamento </th>";
//Pintamos la select dandole formato de tabla
while ($row = $tabla->fetch(PDO::FETCH_ASSOC)){
    
    echo "<tr>";
    foreach($row as $clave=>$valor){
        echo "<td class= 'r' id='a'>" .$valor. "</td>";
    }	
    echo "</tr>";

}
echo "</table>";
?>
<input class='btnMenu' type='button' value='Volver al Menú' onclick='window.location="menu_president.php"'>
<?php
//Boton para volver al menu de presidente.
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