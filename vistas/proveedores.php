<?php require_once '../php/conexion.php'; ?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Gestión de Proveedores</title>
    <link rel="stylesheet" href="../css/estilo.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(to right, #fefefe, #f2f4f7);
            padding: 40px 20px;
            color: #2c3e50;
            margin: 0;
        }
        
        h1, h2 {
            text-align: center;
            margin-bottom: 30px;
            color: #007bff;
        }
        
        form {
            max-width: 600px;
            margin: 0 auto 40px;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            background: #fff;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 8px 18px rgba(0, 0, 0, 0.1);
        }
        
        form input, form button {
            padding: 10px;
            border-radius: 10px;
            border: 1px solid #ccc;
            font-size: 1rem;
            width: 100%;
            box-sizing: border-box;
        }
        
        form button {
            grid-column: span 2;
            background-color: #007bff;
            color: #fff;
            font-weight: bold;
            cursor: pointer;
            transition: background 0.3s ease;
        }
        
        form button:hover {
            background-color: #0056b3;
        }
        
        table {
            width: 100%;
            max-width: 900px;
            margin: 0 auto;
            border-collapse: collapse;
            background: #fff;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.08);
        }
        
        table th, table td {
            padding: 12px 15px;
            border-bottom: 1px solid #ddd;
            text-align: center;
        }
        
        table th {
            background-color: #007bff;
            color: #fff;
        }
        
        table tr:last-child td {
            border-bottom: none;
        }
        
        @media (max-width: 600px) {
            form {
                grid-template-columns: 1fr;
            }
            
            form button {
                grid-column: span 1;
            }
        }
    </style>
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
    <table>
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Dirección</th>
            <th>Correo</th>
            <th>Teléfono</th>
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
<?php include '../php/volver.php'; ?>
</body>
</html>
