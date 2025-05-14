<?php require_once '../php/conexion.php'; ?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Gestión de Proveedores</title>
    <link rel="stylesheet" href="../css/estilo.css">
</head>
<body>
    <h1>Proveedores</h1>

    <h2>Agregar Nuevo Proveedor</h2>
    <form action="../php/proveedores.php" method="POST">
        <input type="text" name="nombre" placeholder="Nombre del proveedor" required>
        <input type="text" name="direccion" placeholder="Dirección">
        <input type="email" name="correo" placeholder="Correo electrónico">
        <input type="text" name="telefono" placeholder="Teléfono">
        <button type="submit" name="agregar">Agregar Proveedor</button>
    </form>

    <h2>Lista de Proveedores</h2>
    <table border="1">
        <tr>
            <th>ID</th><th>Nombre</th><th>Dirección</th><th>Correo</th><th>Teléfono</th>
        </tr>
        <?php
        $result = $conn->query("SELECT * FROM proveedores");
        while ($row = $result->fetch_assoc()) {
            echo "<tr>
                <td>{$row['id_proveedor']}</td>
                <td>{$row['nombre']}</td>
                <td>{$row['direccion']}</td>
                <td>{$row['correo']}</td>
                <td>{$row['telefono']}</td>
            </tr>";
        }
        ?>
    </table>
</body>
</html>
