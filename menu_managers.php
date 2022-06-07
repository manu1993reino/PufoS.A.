<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Menú - Managers</title>
    <link rel="stylesheet" href="css/menu_managers.css">
</head>
<body>
    <div class="body"></div>
    <div class='bienvenida'>BIENVENIDO AL PANEL DE CONTROL PARA MANAGERS DE PUFO S.A</div>
    <div class='seleccione'>¿QUE TABLA DESEA EDITAR?</div>
    <div class="posicionBotones">
    <input class='btnBuscar' type='button' value='Clientes'  onclick="window.location='menu_managers_cliente.php'">
    <input class='btnModificar' type='button' value='Empleados' onclick="window.location='menu_managers_empleados.php'">
    <input class='btnEliminar' type='button' value='Trabajos'  onclick="window.location='menu_managers_trabajos.php'">
    <input class='btnAtras' type='button' value='Departamento' onclick="window.location='menu_managers_departamentos.php'">
    <input class='btnInsertar' type='button' value='Ubicación' onclick="window.location='menu_managers_ubicacion.php'">
    <input class='btnLog' type='button' value='Ver Fichero LOG' onclick="window.location='lectura_managers.php'">
    <input class='btnMenu' type='button' value='Cerrar Sesión' onclick="window.location='index.php'">;
    </div>
</body>
</html>