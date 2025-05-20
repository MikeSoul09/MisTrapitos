<?php
require_once '../php/conexion.php';
session_start();

if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'admin') {
    header('Location: ../index.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Gestión de Usuarios</title>
    <link rel="stylesheet" href="../css/estilo.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 40px 20px;
            background: linear-gradient(to right, #f0f2f5, #d9e4f5);
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
            background-color: #ffffffcc;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.1);
        }

        input, select, button {
            padding: 10px 15px;
            border: 1px solid #ccc;
            border-radius: 10px;
            font-size: 1rem;
            width: 100%;
            box-sizing: border-box;
        }

        button {
            grid-column: span 2;
            background: #28a745;
            color: white;
            font-weight: bold;
            cursor: pointer;
            transition: background 0.3s ease;
        }

        button:hover {
            background: #218838;
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

        .acciones a {
            text-decoration: none;
            padding: 6px 12px;
            margin: 0 4px;
            border-radius: 5px;
            font-weight: 600;
            color: white;
            background-color: #dc3545;
            transition: background 0.3s ease;
        }

        .acciones a:hover {
            background-color: #c82333;
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
    <h1>Gestión de Usuarios</h1>

    <form method="POST" action="../php/usuarios.php">
        <input type="text" name="nombre" placeholder="Nombre completo" required>
        <input type="text" name="usuario" placeholder="Usuario" required>
        <select name="rol" required>
            <option value="">Rol</option>
            <option value="admin">Admin</option>
            <option value="vendedor">Vendedor</option>
        </select>
        <input type="password" name="password" placeholder="Contraseña" required>
        <button type="submit" name="agregar">Agregar Usuario</button>
    </form>

    <h2>Usuarios Registrados</h2>

    <table>
        <tr>
            <th>Nombre</th>
            <th>Correo</th>
            <th>Rol</th>
            <th>Acciones</th>
        </tr>
        <?php
        $usuarios = $conn->query("SELECT * FROM usuarios");
        while ($u = $usuarios->fetch_assoc()) {
            echo "<tr>
                <td>{$u['nombre']}</td>
                <td>{$u['usuario']}</td>
                <td>{$u['rol']}</td>
                <td class='acciones'>
                    <a href='../php/usuarios.php?eliminar={$u['usuario']}' onclick='return confirm(\"¿Eliminar este usuario?\")'>Eliminar</a>
                </td>
            </tr>";
        }
        ?>
    </table>

    <div style="text-align:center; margin-top: 30px;">
        <a href="home.php" style="text-decoration:none; color:#007bff;">← Volver al Home</a>
    </div>
</body>
</html>
