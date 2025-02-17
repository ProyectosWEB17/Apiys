<?php
// Configuración de la base de datos
$host = "localhost"; 
$user = "root"; 
$pass = ""; 
$dbname = "apiys"; 

// Conexión a la base de datos
$conn = new mysqli($host, $user, $pass, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("❌ Error de conexión: " . $conn->connect_error);
}
?>

