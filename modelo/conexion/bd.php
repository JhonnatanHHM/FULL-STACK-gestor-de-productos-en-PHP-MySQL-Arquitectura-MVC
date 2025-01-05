<?php
$servername = "localhost:3308";
$username = "root";
$password = "";
$database = "crud_api_php";

try {
    //esta linea establece conexion a la base datos
    $conn = new PDO("mysql:host=$servername;dbname=$database", $username, $password);
     // con pdo se revisa si hay errores
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    //lenguaje español latino
    $conn->exec("set names utf8");
}catch (PDOException $e) {
    echo "Error de conexión: " . $e->getMessage();
    die();
}
?>