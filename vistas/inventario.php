<?php require_once '../php/conexion.php'; ?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Inventario de Productos</title>
    <link rel="stylesheet" href="../css/estilo.css">
</head>
<body>
    <h1>Gestión de Inventario</h1>

    <h2>Agregar Nuevo Producto</h2>
    <form action="../php/inventario.php" method="POST">
        <input type="text" name="nombre" placeholder="Nombre del producto" required>
        <input type="text" name="categoria" placeholder="Categoría (Ej: Camisetas)" required>
        <input type="text" name="descripcion" placeholder="Descripción">
        <input type="number" name="precio" step="0.01" placeholder="Precio" required>
        <input type="number" name="stock" placeholder="Cantidad en stock" required>
        <input type="text" name="talla_color" placeholder="Tallas o colores disponibles">
        <input type="number" name="descuento" step="0.01" placeholder="Descuento (%)">
        <input type="date" name="inicio_oferta">
        <input type="date" name="fin_oferta">
        <button type="submit" name="agregar">Agregar Producto</button>
    </form>

    <h2>Inventario Actual</h2>
    <table border="1">
        <tr>
            <th>ID</th><th>Nombre</th><th>Categoría</th><th>Precio</th><th>Stock</th><th>Descuento</th><th>Oferta activa</th>
        </tr>
        <?php
        $sql = "SELECT * FROM productos";
        $productos = $conn->query($sql);
        $hoy = date('Y-m-d');

        while ($p = $productos->fetch_assoc()) {
            $oferta_activa = ($p['inicio_oferta'] <= $hoy && $p['fin_oferta'] >= $hoy && $p['descuento'] > 0) ? '✅' : '—';
            echo "<tr>
                <td>{$p['id_producto']}</td>
                <td>{$p['nombre']}</td>
                <td>{$p['categoria']}</td>
                <td>\${$p['precio']}</td>
                <td>{$p['stock']}</td>
                <td>{$p['descuento']}%</td>
                <td>$oferta_activa</td>
            </tr>";
        }
        ?>
    </table>
</body>
</html>
