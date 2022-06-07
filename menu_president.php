<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Menú - Presidente</title>
    <link rel="stylesheet" href="css/menu_president.css">
</head>
<body>
    <div class="body"></div>
    <div class='bienvenida'>BIENVENIDO AL PANEL DE CONTROL, SR.FRANCIS KING</div>
    <div class='seleccione'>PUEDE SELECCIONAR UNA TABLA PARA EDITAR O VER UN INFORME DE DEPARTAMENTOS</div>
    <div class="posicionBotones">
    <input class='btnBuscar' type='button' value='Clientes'  onclick="window.location='menu_president_cliente.php'">
    <input class='btnModificar' type='button' value='Empleados' onclick="window.location='menu_president_empleados.php'">
    <input class='btnEliminar' type='button' value='Trabajos'  onclick="window.location='menu_president_trabajos.php'">
    <input class='btnAtras' type='button' value='Departamento' onclick="window.location='menu_president_departamentos.php'">
    <input class='btnInsertar' type='button' value='Ubicación' onclick="window.location='menu_president_ubicacion.php'">
    <input class='btnDeptm' type='button' value='Ver informe de departamentos' onclick="window.location='informe_departamentos.php'">
    <input class='btnLog' type='button' value='Ver Fichero LOG' onclick="window.location='lectura_president.php'">
    <input class='btnMenu' type='button' value='Cerrar Sesión' onclick="window.location='index.php'">;
    </div>
</body>
</html>