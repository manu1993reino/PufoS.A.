 <?php

//Guardamos en unas variables los datos de acceso a nuestra base de datos.
$servername = "localhost";
$username = "root";
$password = "";

//Creamos un nuevo objeto de la clase PDO, en el que vamos a introducir los parametos
//para aconectarnos a la Base De Datos.
//Con el try catch intentamos la conexion, si se realiza con exito nos da el mensaje de que
//la conexión se ha realizado exitosamente, en caso contrario se ejecuta el catch, en el cual
//nos avisa de que la conexion no se ha podido realizar.
try{
    $conn = new PDO("mysql:host=$servername;dbname=pufosa; charset=utf8" , $username , $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "<span style='color:green'>Conectado con exito</span><br>";

}
catch(PDOException $e){
    echo "Conexion fallida" . $e->getMessage();
}


 ?>