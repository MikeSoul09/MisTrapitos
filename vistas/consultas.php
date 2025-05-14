<?php require_once '../php/conexion.php'; ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Consultas del Sistema</title>
    <link rel="stylesheet" href="../css/estilo.css">
</head>
<body>
    <h1>Consultas del Sistema</h1>

    <!-- 1 -->
    <h2>1. ¿Cuántos productos están actualmente disponibles en inventario?</h2>
    <?php
    $res = $conn->query("SELECT COUNT(*) AS total FROM productos WHERE stock > 0");
    $row = $res->fetch_assoc();
    echo "<p>Total: <strong>{$row['total']}</strong> productos disponibles</p>";
    ?>

    <!-- 2 -->
    <h2>2. ¿Cuántos productos de la categoría “Camisetas” están disponibles?</h2>
    <?php
    $res = $conn->query("SELECT COUNT(*) AS total FROM productos WHERE categoria = 'Camisetas' AND stock > 0");
    $row = $res->fetch_assoc();
    echo "<p>Total: <strong>{$row['total']}</strong> camisetas disponibles</p>";
    ?>

    <!-- 3 -->
    <h2>3. Historial de compras del cliente con ID 101</h2>
    <?php
    $res = $conn->query("
        SELECT v.fecha, p.nombre, dv.cantidad, dv.precio_unitario
        FROM ventas v
        JOIN detalle_ventas dv ON v.id_venta = dv.id_venta
        JOIN productos p ON dv.id_producto = p.id_producto
        WHERE v.id_cliente = 101
        ORDER BY v.fecha DESC
    ");
    echo "<ul>";
    while ($row = $res->fetch_assoc()) {
        echo "<li>{$row['fecha']} - {$row['nombre']} ({$row['cantidad']} unidades a \${$row['precio_unitario']})</li>";
    }
    echo "</ul>";
    ?>

    <!-- 4 -->
    <h2>4. Productos en oferta y su descuento actual</h2>
    <?php
    $res = $conn->query("
        SELECT nombre, descuento
        FROM productos
        WHERE descuento > 0 AND CURDATE() BETWEEN inicio_oferta AND fin_oferta
    ");
    echo "<ul>";
    while ($row = $res->fetch_assoc()) {
        echo "<li>{$row['nombre']} - {$row['descuento']}%</li>";
    }
    echo "</ul>";
    ?>

    <!-- 5 -->
    <h2>5. Métodos de pago más usados en los últimos 30 días</h2>
    <?php
    $res = $conn->query("
        SELECT metodo_pago, COUNT(*) AS total
        FROM ventas
        WHERE fecha >= CURDATE() - INTERVAL 30 DAY
        GROUP BY metodo_pago
        ORDER BY total DESC
    ");
    echo "<ul>";
    while ($row = $res->fetch_assoc()) {
        echo "<li>{$row['metodo_pago']} – {$row['total']} veces</li>";
    }
    echo "</ul>";
    ?>

    <!-- 6 -->
    <h2>6. Productos más comprados en el último mes</h2>
    <?php
    $res = $conn->query("
        SELECT p.nombre, SUM(dv.cantidad) AS total
        FROM detalle_ventas dv
        JOIN ventas v ON dv.id_venta = v.id_venta
        JOIN productos p ON dv.id_producto = p.id_producto
        WHERE v.fecha >= CURDATE() - INTERVAL 30 DAY
        GROUP BY dv.id_producto
        ORDER BY total DESC
        LIMIT 5
    ");
    echo "<ul>";
    while ($row = $res->fetch_assoc()) {
        echo "<li>{$row['nombre']} – {$row['total']} unidades</li>";
    }
    echo "</ul>";
    ?>

    <!-- 7 -->
    <h2>7. Producto con más unidades en inventario</h2>
    <?php
    $res = $conn->query("SELECT nombre, stock FROM productos ORDER BY stock DESC LIMIT 1");
    $row = $res->fetch_assoc();
    echo "<p><strong>{$row['nombre']}</strong> con {$row['stock']} unidades</p>";
    ?>

    <!-- 8 -->
    <h2>8. Ventas realizadas en los últimos 3 días</h2>
    <?php
    $res = $conn->query("SELECT COUNT(*) AS total FROM ventas WHERE fecha >= CURDATE() - INTERVAL 3 DAY");
    $row = $res->fetch_assoc();
    echo "<p>Total: <strong>{$row['total']}</strong> ventas</p>";
    ?>

    <!-- 9 -->
    <h2>9. Productos por proveedor</h2>
    <?php
    $res = $conn->query("
        SELECT prov.nombre AS proveedor, COUNT(*) AS total
        FROM productos p
        JOIN proveedores prov ON p.id_proveedor = prov.id_proveedor
        GROUP BY p.id_proveedor
    ");
    echo "<ul>";
    while ($row = $res->fetch_assoc()) {
        echo "<li>{$row['proveedor']} – {$row['total']} productos</li>";
    }
    echo "</ul>";
    ?>

    <!-- 10 -->
    <h2>10. Productos que un cliente ha comprado más de una vez</h2>
    <?php
    $res = $conn->query("
        SELECT p.nombre, COUNT(*) AS veces
        FROM detalle_ventas dv
        JOIN productos p ON dv.id_producto = p.id_producto
        JOIN ventas v ON dv.id_venta = v.id_venta
        GROUP BY v.id_cliente, dv.id_producto
        HAVING veces > 1
        LIMIT 10
    ");
    echo "<ul>";
    while ($row = $res->fetch_assoc()) {
        echo "<li>{$row['nombre']} – comprado más de una vez</li>";
    }
    echo "</ul>";
    ?>

    <!-- 11 -->
    <h2>11. Productos vendidos por categoría en el último mes</h2>
    <?php
    $res = $conn->query("
        SELECT p.categoria, SUM(dv.cantidad) AS total
        FROM detalle_ventas dv
        JOIN productos p ON dv.id_producto = p.id_producto
        JOIN ventas v ON dv.id_venta = v.id_venta
        WHERE v.fecha >= CURDATE() - INTERVAL 30 DAY
        GROUP BY p.categoria
    ");
    echo "<ul>";
    while ($row = $res->fetch_assoc()) {
        echo "<li>{$row['categoria']} – {$row['total']} unidades</li>";
    }
    echo "</ul>";
    ?>

    <!-- 12 -->
    <h2>12. Productos con precio superior a un valor y con stock</h2>
    <form method="get">
        <input type="number" name="precio_minimo" step="0.01" placeholder="Precio mínimo" required>
        <button type="submit">Consultar</button>
    </form>
    <?php
    if (isset($_GET['precio_minimo'])) {
        $precio = $_GET['precio_minimo'];
        $res = $conn->query("SELECT nombre, precio, stock FROM productos WHERE precio > $precio AND stock > 0");
        echo "<ul>";
        while ($row = $res->fetch_assoc()) {
            echo "<li>{$row['nombre']} – \${$row['precio']} ({$row['stock']} disponibles)</li>";
        }
        echo "</ul>";
    }
    ?>

    <!-- 13 -->
    <h2>13. Producto con mayor descuento actualmente</h2>
    <?php
    $res = $conn->query("
        SELECT nombre, descuento
        FROM productos
        WHERE descuento > 0
        ORDER BY descuento DESC
        LIMIT 1
    ");
    $row = $res->fetch_assoc();
    echo "<p><strong>{$row['nombre']}</strong> – {$row['descuento']}%</p>";
    ?>

    <!-- 14 -->
    <h2>14. Productos comprados por clientes según ciudad</h2>
    <?php
    $res = $conn->query("
        SELECT c.ciudad, p.nombre, COUNT(*) AS total
        FROM clientes c
        JOIN ventas v ON c.id_cliente = v.id_cliente
        JOIN detalle_ventas dv ON v.id_venta = dv.id_venta
        JOIN productos p ON dv.id_producto = p.id_producto
        GROUP BY c.ciudad, p.nombre
    ");
    echo "<ul>";
    while ($row = $res->fetch_assoc()) {
        echo "<li>{$row['ciudad']} – {$row['nombre']} ({$row['total']})</li>";
    }
    echo "</ul>";
    ?>

    <!-- 15 -->
    <h2>15. Productos no vendidos en los últimos 3 meses</h2>
    <?php
    $res = $conn->query("
        SELECT p.nombre
        FROM productos p
        WHERE p.id_producto NOT IN (
            SELECT dv.id_producto
            FROM detalle_ventas dv
            JOIN ventas v ON dv.id_venta = v.id_venta
            WHERE v.fecha >= CURDATE() - INTERVAL 90 DAY
        )
    ");
    echo "<ul>";
    while ($row = $res->fetch_assoc()) {
        echo "<li>{$row['nombre']}</li>";
    }
    echo "</ul>";
    ?>

</body>
</html>
