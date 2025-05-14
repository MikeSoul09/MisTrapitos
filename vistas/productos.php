<?php
require_once '../php/conexion.php';
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Gestión de Productos</title>
    <link rel="stylesheet" href="../css/estilo.css">
</head>
<body>
    <h1>Gestión de Productos</h1>

    <form action="../php/productos.php" method="POST">
        <input type="text" name="nombre" placeholder="Nombre del producto" required>
        <input type="text" name="descripcion" placeholder="Descripción">
        <select name="categoria" required>
            <option value="">Categoría</option>
            <option value="Camisetas">Camisetas</option>
            <option value="Pantalones">Pantalones</option>
            <option value="Accesorios">Accesorios</option>
            <option value="Otro">Otro</option>
        </select>
        <input type="number" step="0.01" name="precio" placeholder="Precio" required>
        <input type="number" name="stock" placeholder="Stock" required>
        <input type="text" name="talla_color" placeholder="Tallas y/o Colores disponibles">
        <input type="number" step="0.01" name="descuento" placeholder="Descuento (%)">
        <input type="date" name="inicio_oferta" placeholder="Inicio oferta">
        <input type="date" name="fin_oferta" placeholder="Fin oferta">
        <input type="number" name="id_proveedor" placeholder="ID proveedor (opcional)">
        <button type="submit" name="agregar">Agregar Producto</button>
    </form>

    <h2>Listado de Productos</h2>
    <table border="1">
        <tr>
            <th>Nombre</th>
            <th>Descripción</th>
            <th>Categoría</th>
            <th>Precio</th>
            <th>Stock</th>
            <th>Talla/Color</th>
            <th>Descuento</th>
            <th>Oferta Activa</th>
            <th>ID Proveedor</th>
        </tr>

        <?php
        $resultado = $conn->query("SELECT * FROM productos");
        $hoy = date('Y-m-d');
        while ($fila = $resultado->fetch_assoc()) {
            $oferta = ($fila['descuento'] > 0 && $fila['inicio_oferta'] <= $hoy && $fila['fin_oferta'] >= $hoy) ? '✅' : '—';
            echo "<tr>
                <td>{$fila['nombre']}</td>
                <td>{$fila['descripcion']}</td>
                <td>{$fila['categoria']}</td>
                <td>\${$fila['precio']}</td>
                <td>{$fila['stock']}</td>
                <td>{$fila['talla_color']}</td>
                <td>{$fila['descuento']}%</td>
                <td>{$oferta}</td>
                <td>{$fila['id_proveedor']}</td>
            </tr>";
        }
        ?>
    </table>
</body>
</html>
