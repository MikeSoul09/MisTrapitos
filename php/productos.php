<?php
require_once 'conexion.php';

if (isset($_POST['agregar'])) {
    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];
    $categoria = $_POST['categoria'];
    $precio = $_POST['precio'];
    $stock = $_POST['stock'];
    $talla_color = $_POST['talla_color'];

    // Campos opcionales
    $descuento = isset($_POST['descuento']) && $_POST['descuento'] !== '' ? $_POST['descuento'] : 0;
    $inicio_oferta = !empty($_POST['inicio_oferta']) ? $_POST['inicio_oferta'] : null;
    $fin_oferta = !empty($_POST['fin_oferta']) ? $_POST['fin_oferta'] : null;
    $id_proveedor = !empty($_POST['id_proveedor']) ? $_POST['id_proveedor'] : null;

    // Preparar la consulta SQL
    $sql = "INSERT INTO productos (
                nombre, descripcion, categoria, precio, stock, talla_color,
                descuento, inicio_oferta, fin_oferta, id_proveedor
            )
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param(
        "sssdsdsssi",
        $nombre,
        $descripcion,
        $categoria,
        $precio,
        $stock,
        $talla_color,
        $descuento,
        $inicio_oferta,
        $fin_oferta,
        $id_proveedor
    );

    if ($stmt->execute()) {
        header("Location: ../vistas/productos.php");
        exit;
    } else {
        echo "Error al agregar producto: " . $conn->error;
    }

    $stmt->close();
}
?>
