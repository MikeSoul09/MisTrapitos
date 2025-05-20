<?php
require_once 'conexion.php';
session_start();

if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'admin') {
    header('Location: ../index.php');
    exit();
}

// Agregar usuario
if (isset($_POST['agregar'])) {
    $nombre = $_POST['nombre'];
    $usuario = $_POST['usuario'];
    $rol = $_POST['rol'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $stmt = $conn->prepare("INSERT INTO usuarios (nombre, usuario, rol, password) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $nombre, $usuario, $rol, $password);
    $stmt->execute();
    header('Location: ../vistas/gestion_usuarios.php');
    exit();
}

// Eliminar usuario
if (isset($_GET['eliminar'])) {
    $id = $_GET['eliminar'];
    $stmt = $conn->prepare("DELETE FROM usuarios WHERE id_usuario = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    header('Location: ../vistas/gestion_usuarios.php');
    exit();
}
?>
