<?php
require_once 'conexion.php';

if (isset($_POST['vender'])) {
    $id_cliente = $_POST['id_cliente'];
    $id_producto = $_POST['id_producto'];
    $cantidad = $_POST['cantidad'];
    $metodo_pago = $_POST['metodo_pago'];

    // Verificar stock
    $check_stock = $conn->prepare("SELECT stock FROM productos WHERE id_producto = ?");
    $check_stock->bind_param("i", $id_producto);
    $check_stock->execute();
    $resultado = $check_stock->get_result()->fetch_assoc();
    $stock_disponible = $resultado['stock'];

    if ($cantidad > $stock_disponible) {
        die("Error: No hay suficiente stock disponible.");
    }

    // Insertar venta
    $stmt = $conn->prepare("INSERT INTO ventas (id_cliente, fecha, metodo_pago) VALUES (?, NOW(), ?)");
    $stmt->bind_param("is", $id_cliente, $metodo_pago);
    $stmt->execute();
    $id_venta = $stmt->insert_id;

    // Insertar detalle de venta
    $stmt2 = $conn->prepare("INSERT INTO detalle_ventas (id_venta, id_producto, cantidad) VALUES (?, ?, ?)");
    $stmt2->bind_param("iii", $id_venta, $id_producto, $cantidad);
    $stmt2->execute();

    // Actualizar inventario
    $stmt3 = $conn->prepare("UPDATE productos SET stock = stock - ? WHERE id_producto = ?");
    $stmt3->bind_param("ii", $cantidad, $id_producto);
    $stmt3->execute();

    header("Location: ../vistas/ventas.php");
}
?>
