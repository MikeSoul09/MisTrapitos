<?php
require_once '../php/conexion.php';

// Obtener clientes
$clientes = $conn->query("SELECT id_cliente, nombre FROM clientes");

// Obtener productos disponibles en inventario
$productos = $conn->query("SELECT id_producto, nombre, stock FROM productos WHERE stock > 0");
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registro de Ventas</title>
    <link rel="stylesheet" href="../css/estilo.css">
</head>
<body>
    <h1>Registrar Venta</h1>

    <form action="../php/ventas.php" method="POST">
        <label>Cliente:</label>
        <select name="id_cliente" required>
            <option value="">Seleccionar cliente</option>
            <?php while ($cliente = $clientes->fetch_assoc()): ?>
                <option value="<?= $cliente['id_cliente'] ?>"><?= $cliente['nombre'] ?></option>
            <?php endwhile; ?>
        </select>

        <label>Producto:</label>
        <select name="id_producto" required>
            <option value="">Seleccionar producto</option>
            <?php while ($producto = $productos->fetch_assoc()): ?>
                <option value="<?= $producto['id_producto'] ?>">
                    <?= $producto['nombre'] ?> (Stock: <?= $producto['stock'] ?>)
                </option>
            <?php endwhile; ?>
        </select>

        <input type="number" name="cantidad" min="1" placeholder="Cantidad" required>

        <label>Método de pago:</label>
        <select name="metodo_pago" required>
            <option value="">Seleccionar</option>
            <option value="Efectivo">Efectivo</option>
            <option value="Tarjeta">Tarjeta</option>
            <option value="Transferencia">Transferencia</option>
        </select>

        <button type="submit" name="vender">Registrar Venta</button>
    </form>

    <h2>Historial de Ventas</h2>
    <table border="1">
        <tr>
            <th>Fecha</th><th>Cliente</th><th>Producto</th><th>Cantidad</th><th>Método de Pago</th>
        </tr>
        <?php
        $sql = "SELECT v.fecha, c.nombre AS cliente, p.nombre AS producto, dv.cantidad, v.metodo_pago
                FROM ventas v
                INNER JOIN clientes c ON v.id_cliente = c.id_cliente
                INNER JOIN detalles_venta dv ON v.id_venta = dv.id_venta
                INNER JOIN productos p ON dv.id_producto = p.id_producto
                ORDER BY v.fecha DESC";
        $ventas = $conn->query($sql);

        while ($fila = $ventas->fetch_assoc()) {
            echo "<tr>
                <td>{$fila['fecha']}</td>
                <td>{$fila['cliente']}</td>
                <td>{$fila['producto']}</td>
                <td>{$fila['cantidad']}</td>
                <td>{$fila['metodo_pago']}</td>
            </tr>";
        }
        ?>
    </table>
</body>
</html>
