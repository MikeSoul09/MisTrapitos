<?php require_once '../php/conexion.php'; ?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Gestión de Clientes</title>
    <link rel="stylesheet" href="../css/estilo.css">
</head>
<body>
    <h1>Gestión de Clientes</h1>

    <form action="../php/clientes.php" method="POST">
        <input type="text" name="nombre" placeholder="Nombre completo" required>
        <input type="text" name="direccion" placeholder="Dirección">
        <input type="email" name="correo" placeholder="Correo electrónico">
        <input type="text" name="telefono" placeholder="Teléfono">
        <input type="text" name="ciudad" placeholder="Ciudad">
        <button type="submit" name="agregar">Registrar Cliente</button>
    </form>

    <h2>Lista de Clientes Registrados</h2>
    <table border="1">
        <tr>
            <th>ID</th><th>Nombre</th><th>Dirección</th><th>Correo</th><th>Teléfono</th><th>Ciudad</th>
        </tr>

        <?php
        $resultado = $conn->query("SELECT * FROM clientes");
        while ($fila = $resultado->fetch_assoc()) {
            echo "<tr>
                <td>{$fila['id_cliente']}</td>
                <td>{$fila['nombre']}</td>
                <td>{$fila['direccion']}</td>
                <td>{$fila['correo']}</td>
                <td>{$fila['telefono']}</td>
                <td>{$fila['ciudad']}</td>
            </tr>";
        }
        ?>
    </table>
</body>
</html>
