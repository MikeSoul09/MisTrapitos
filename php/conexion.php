<?php
$host = 'localhost';
$usuario = 'root';        
$contrasena = 'admin';         
$base_datos = 'tienda_ropa';

$conn = new mysqli($host, $usuario, $contrasena, $base_datos);

// Verificar conexión
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// Para UTF-8
$conn->set_charset("utf8");
?>
