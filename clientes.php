<?php require_once '../php/conexion.php'; ?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Gestión de Clientes</title>
    <link rel="stylesheet" href="../css/estilo.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 40px 20px;
            background: linear-gradient(to right, #fdfbfb, #ebedee);
            color: #2c3e50;
        }

        h1, h2 {
            text-align: center;
            margin-bottom: 30px;
        }

        form {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            max-width: 800px;
            margin: 0 auto 40px;
            background-color: #ffffffdd;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.1);
        }

        input, button {
            padding: 10px 15px;
            border: 1px solid #ccc;
            border-radius: 10px;
            font-size: 1rem;
            width: 100%;
            box-sizing: border-box;
        }

        button {
            grid-column: span 2;
            background: #007bff;
            color: white;
            font-weight: bold;
            cursor: pointer;
            transition: background 0.3s ease;
        }

        button:hover {
            background: #0056b3;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            background: white;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
        }

        table th, table td {
            padding: 12px 15px;
            text-align: center;
            border-bottom: 1px solid #ddd;
        }

        table th {
            background-color: #007bff;
            color: white;
        }

        table tr:last-child td {
            border-bottom: none;
        }

        @media (max-width: 600px) {
            form {
                grid-template-columns: 1fr;
            }

            button {
                grid-column: span 1;
            }
        }
    </style>
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
    <table>
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Dirección</th>
            <th>Correo</th>
            <th>Teléfono</th>
            <th>Ciudad</th>
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
<?php include '../php/volver.php'; ?>
</body>
</html>
