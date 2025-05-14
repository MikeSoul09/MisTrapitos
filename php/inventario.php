<?php
require_once 'conexion.php';

if (isset($_POST['agregar'])) {
    $nombre = $_POST['nombre'];
    $categoria = $_POST['categoria'];
    $descripcion = $_POST['descripcion'];
    $precio = $_POST['precio'];
    $stock = $_POST['stock'];
    $talla_color = $_POST['talla_color'];
    $descuento = $_POST['descuento'] ?? 0;
    $inicio_oferta = $_POST['inicio_oferta'] ?? null;
    $fin_oferta = $_POST['fin_oferta'] ?? null;

    $sql = "INSERT INTO productos (nombre, categoria, descripcion, precio, stock, talla_color, descuento, inicio_oferta, fin_oferta)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssdisdss", $nombre, $categoria, $descripcion, $precio, $stock, $talla_color, $descuento, $inicio_oferta, $fin_oferta);

    if ($stmt->execute()) {
        header("Location: ../vistas/inventario.php");
    } else {
        echo "Error al agregar producto: " . $conn->error;
    }

    $stmt->close();
}
?>
