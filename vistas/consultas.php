<?php require_once '../php/conexion.php'; ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Consultas del Sistema</title>
    <link rel="stylesheet" href="../css/estilo.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: #f4f6f8;
            padding: 40px 20px;
            color: #2c3e50;
            margin: 0;
        }

        h1 {
            text-align: center;
            margin-bottom: 40px;
            color: #007bff;
        }

        .consulta {
            background: #fff;
            padding: 25px;
            margin-bottom: 30px;
            border-radius: 15px;
            box-shadow: 0 6px 16px rgba(0, 0, 0, 0.06);
        }

        .consulta h2 {
            margin-top: 0;
            font-size: 1.2rem;
            color: #333;
        }

        .consulta p, .consulta ul {
            margin-top: 10px;
        }

        ul {
            padding-left: 20px;
        }

        form {
            margin-top: 10px;
        }

        input[type="number"] {
            padding: 8px;
            border-radius: 8px;
            border: 1px solid #ccc;
            width: 200px;
            margin-right: 10px;
        }

        button {
            padding: 8px 15px;
            border: none;
            background-color: #007bff;
            color: white;
            border-radius: 8px;
            cursor: pointer;
            transition: background 0.3s ease;
        }

        button:hover {
            background-color: #0056b3;
        }

        @media (max-width: 600px) {
            input[type="number"] {
                width: 100%;
                margin-bottom: 10px;
            }

            button {
                width: 100%;
            }
        }
    </style>
</head>
<body>
    <h1>Consultas del Sistema</h1>

    <?php
    function consulta($titulo, $contenido) {
        echo "<div class='consulta'><h2>$titulo</h2>$contenido</div>";
    }

    // 1
    $res = $conn->query("SELECT COUNT(*) AS total FROM productos WHERE stock > 0");
    $row = $res->fetch_assoc();
    consulta("1. ¿Cuántos productos están actualmente disponibles en inventario?",
             "<p>Total: <strong>{$row['total']}</strong> productos disponibles</p>");

    // 2
    $res = $conn->query("SELECT COUNT(*) AS total FROM productos WHERE categoria = 'Camisetas' AND stock > 0");
    $row = $res->fetch_assoc();
    consulta("2. ¿Cuántos productos de la categoría “Camisetas” están disponibles?",
             "<p>Total: <strong>{$row['total']}</strong> tipos de camisetas disponibles</p>");

    // 3
    $res = $conn->query("
    SELECT v.fecha, p.nombre, dv.cantidad, p.precio AS precio
    FROM ventas v
    JOIN detalle_ventas dv ON v.id_venta = dv.id_venta
    JOIN productos p ON dv.id_producto = p.id_producto
    WHERE v.id_cliente = 101
    ORDER BY v.fecha DESC
");

    $html = "<ul>";
while ($row = $res->fetch_assoc()) {
    $html .= "<li>{$row['fecha']} - {$row['nombre']} ({$row['cantidad']})</li>";
}
$html .= "</ul>";
consulta("3. Historial de compras del cliente con ID 101", $html);


    // 4
    $res = $conn->query("
        SELECT nombre, descuento
        FROM productos
        WHERE descuento > 0 AND CURDATE() BETWEEN inicio_oferta AND fin_oferta
    ");
    $html = "<ul>";
    while ($row = $res->fetch_assoc()) {
        $html .= "<li>{$row['nombre']} - {$row['descuento']}%</li>";
    }
    $html .= "</ul>";
    consulta("4. Productos en oferta y su descuento actual", $html);

    // 5
    $res = $conn->query("
        SELECT metodo_pago, COUNT(*) AS total
        FROM ventas
        WHERE fecha >= CURDATE() - INTERVAL 30 DAY
        GROUP BY metodo_pago
        ORDER BY total DESC
    ");
    $html = "<ul>";
    while ($row = $res->fetch_assoc()) {
        $html .= "<li>{$row['metodo_pago']} – {$row['total']} veces</li>";
    }
    $html .= "</ul>";
    consulta("5. Métodos de pago más usados en los últimos 30 días", $html);

    // 6
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
    $html = "<ul>";
    while ($row = $res->fetch_assoc()) {
        $html .= "<li>{$row['nombre']} – {$row['total']} unidades</li>";
    }
    $html .= "</ul>";
    consulta("6. Productos más comprados en el último mes", $html);

    // 7
    $res = $conn->query("SELECT nombre, stock FROM productos ORDER BY stock DESC LIMIT 1");
    $row = $res->fetch_assoc();
    consulta("7. Producto con más unidades en inventario",
             "<p><strong>{$row['nombre']}</strong> con {$row['stock']} unidades</p>");

    // 8
    $res = $conn->query("SELECT COUNT(*) AS total FROM ventas WHERE fecha >= CURDATE() - INTERVAL 3 DAY");
    $row = $res->fetch_assoc();
    consulta("8. Ventas realizadas en los últimos 3 días",
             "<p>Total: <strong>{$row['total']}</strong> ventas</p>");

    // 9
    $res = $conn->query("
        SELECT prov.nombre AS proveedor, COUNT(*) AS total
        FROM productos p
        JOIN proveedores prov ON p.id_proveedor = prov.id_proveedor
        GROUP BY p.id_proveedor
    ");
    $html = "<ul>";
    while ($row = $res->fetch_assoc()) {
        $html .= "<li>{$row['proveedor']} – {$row['total']} productos</li>";
    }
    $html .= "</ul>";
    consulta("9. Productos por proveedor", $html);

    // 10
    $res = $conn->query("
        SELECT p.nombre, COUNT(*) AS veces
        FROM detalle_ventas dv
        JOIN productos p ON dv.id_producto = p.id_producto
        JOIN ventas v ON dv.id_venta = v.id_venta
        GROUP BY v.id_cliente, dv.id_producto
        HAVING veces > 1
        LIMIT 10
    ");
    $html = "<ul>";
    while ($row = $res->fetch_assoc()) {
        $html .= "<li>{$row['nombre']} – comprado más de una vez</li>";
    }
    $html .= "</ul>";
    consulta("10. Productos que un cliente ha comprado más de una vez", $html);

    // 11
    $res = $conn->query("
        SELECT p.categoria, SUM(dv.cantidad) AS total
        FROM detalle_ventas dv
        JOIN productos p ON dv.id_producto = p.id_producto
        JOIN ventas v ON dv.id_venta = v.id_venta
        WHERE v.fecha >= CURDATE() - INTERVAL 30 DAY
        GROUP BY p.categoria
    ");
    $html = "<ul>";
    while ($row = $res->fetch_assoc()) {
        $html .= "<li>{$row['categoria']} – {$row['total']} unidades</li>";
    }
    $html .= "</ul>";
    consulta("11. Productos vendidos por categoría en el último mes", $html);

    // 12
    $precio_html = "
        <form method='get'>
            <input type='number' name='precio_minimo' step='0.01' placeholder='Precio mínimo' required>
            <button type='submit'>Consultar</button>
        </form>
    ";
    if (isset($_GET['precio_minimo'])) {
        $precio = $_GET['precio_minimo'];
        $res = $conn->query("SELECT nombre, precio, stock FROM productos WHERE precio > $precio AND stock > 0");
        $precio_html .= "<ul>";
        while ($row = $res->fetch_assoc()) {
            $precio_html .= "<li>{$row['nombre']} – \${$row['precio']} ({$row['stock']} disponibles)</li>";
        }
        $precio_html .= "</ul>";
    }
    consulta("12. Productos con precio superior a un valor y con stock", $precio_html);

    // 13
    $res = $conn->query("
        SELECT nombre, descuento
        FROM productos
        WHERE descuento > 0
        ORDER BY descuento DESC
        LIMIT 1
    ");
    $row = $res->fetch_assoc();
    consulta("13. Producto con mayor descuento actualmente",
             "<p><strong>{$row['nombre']}</strong> – {$row['descuento']}%</p>");

    // 14
    $res = $conn->query("
        SELECT c.ciudad, p.nombre, COUNT(*) AS total
        FROM clientes c
        JOIN ventas v ON c.id_cliente = v.id_cliente
        JOIN detalle_ventas dv ON v.id_venta = dv.id_venta
        JOIN productos p ON dv.id_producto = p.id_producto
        GROUP BY c.ciudad, p.nombre
    ");
    $html = "<ul>";
    while ($row = $res->fetch_assoc()) {
        $html .= "<li>{$row['ciudad']} – {$row['nombre']} ({$row['total']})</li>";
    }
    $html .= "</ul>";
    consulta("14. Productos comprados por clientes según ciudad", $html);

    // 15
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
    $html = "<ul>";
    while ($row = $res->fetch_assoc()) {
        $html .= "<li>{$row['nombre']}</li>";
    }
    $html .= "</ul>";
    consulta("15. Productos no vendidos en los últimos 3 meses", $html);
    ?>
<?php include '../php/volver.php'; ?>
</body>
</html>
