<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Archivo LOG - Registros</title>
    <link rel="stylesheet" href="css/lectura_log.css">
</head>
<body>
    <div class="posicionBotones">
        <input class='btnMenu' type='button' value='Volver al Menú' onclick="window.location='menu_managers.php'">;
    </div>
<div class="bienvenida">
    <?php
    //Inicializamos una variable con el archivo que deseamos manejar
    $archivo = 'log/log.txt';
    //Abrimos el archivo en modo lectura
    $fp = fopen($archivo,'r');
    //Leemos el archivo
    $texto = fread($fp, filesize($archivo));
    //Transformamos los saltos de linea en etiquetas <br>
    $texto = nl2br($texto);
    //Sacamos por pantalla el texto
    echo $texto;

    ?>
</div>
<div> </div>
</body>
</html>