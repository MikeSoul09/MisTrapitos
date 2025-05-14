<?php
require_once 'conexion.php';

if (isset($_POST['agregar'])) {
    $nombre = $_POST['nombre'];
    $direccion = $_POST['direccion'];
    $correo = $_POST['correo'];
    $telefono = $_POST['telefono'];

    $sql = "INSERT INTO proveedores (nombre, direccion, correo, telefono) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssss", $nombre, $direccion, $correo, $telefono);

    if ($stmt->execute()) {
        header("Location: ../vistas/proveedores.php");
    } else {
        echo "Error al registrar proveedor: " . $conn->error;
    }

    $stmt->close();
}
?>
