<?php
require_once 'conexion.php';

if (isset($_POST['agregar'])) {
    $nombre = $_POST['nombre'];
    $direccion = $_POST['direccion'];
    $correo = $_POST['correo'];
    $telefono = $_POST['telefono'];
    $ciudad = $_POST['ciudad'];

    $sql = "INSERT INTO clientes (nombre, direccion, correo, telefono, ciudad) 
            VALUES (?, ?, ?, ?, ?)";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssss", $nombre, $direccion, $correo, $telefono, $ciudad);

    if ($stmt->execute()) {
        header("Location: ../vistas/clientes.php");
    } else {
        echo "Error al registrar cliente: " . $conn->error;
    }

    $stmt->close();
}
?>
