<?php

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Iniciar Sesión</title>
    <link rel="stylesheet" href="css/index.css">
</head>
<body>
    <div class="body"></div>
        <div class="grad"></div>
            <div class="header">
                <div>PUFO<span> S.A.</span></div>
            </div>
            <br>
        <div class="login">
            <form action="sesion.php" method="post">
                <input type="text" placeholder="Su ID de usuario" name="usuario"><br>
                <input type="password" placeholder="Contraseña" name="contrasena"><br>
                <input type="submit" name="btnEnviar" value="Acceder">
            </form>
    </div>
</body>
</html>