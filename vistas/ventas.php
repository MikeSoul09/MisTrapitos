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
        }

        form {
            max-width: 800px;
            margin: 0 auto 40px;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            background-color: #fff;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 8px 18px rgba(0, 0, 0, 0.1);
        }

        select, input, button {
            padding: 10px;
            border-radius: 10px;
            border: 1px solid #ccc;
            font-size: 1rem;
            box-sizing: border-box;
            width: 100%;
        }

        button {
            grid-column: span 2;
            background-color: #007bff;
            color: white;
            font-weight: bold;
            cursor: pointer;
            transition: 0.3s ease;
        }

        button:hover {
            background-color: #0056b3;
        }

        table {
            width: 100%;
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

            button {
                grid-column: span 1;
            }
        }
    </style>
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
    <table>
        <tr>
            <th>Fecha</th>
            <th>Cliente</th>
            <th>Producto</th>
            <th>Cantidad</th>
            <th>Precio Unitario</th>
            <th>Total</th>
            <th>Método de Pago</th>
        </tr>
        <?php
        $sql = "SELECT 
            v.fecha, 
            c.nombre AS cliente, 
            p.nombre AS producto, 
            dv.cantidad, 
            p.precio,
            v.metodo_pago
        FROM ventas v
        INNER JOIN clientes c ON v.id_cliente = c.id_cliente
        INNER JOIN detalle_ventas dv ON v.id_venta = dv.id_venta
        INNER JOIN productos p ON dv.id_producto = p.id_producto
        ORDER BY v.fecha DESC";

        $ventas = $conn->query($sql);

        if ($ventas) {
            while ($fila = $ventas->fetch_assoc()) {
            $total = $fila['cantidad'] * $fila['precio']; // Cambiar stock por cantidad
            echo "<tr>
                <td>{$fila['fecha']}</td>
                <td>{$fila['cliente']}</td>
                <td>{$fila['producto']}</td>
                <td>{$fila['cantidad']}</td> <!-- Cambiar stock por cantidad -->
                <td>$" . number_format($fila['precio'], 2) . "</td>
                <td>$" . number_format($total, 2) . "</td>
                <td>{$fila['metodo_pago']}</td>
            </tr>";
            }
        } else {
            echo "<tr><td colspan='7'>Error al obtener las ventas: {$conn->error}</td></tr>";
        }
        ?>
    </table>
<?php include '../php/volver.php'; ?>
</body>
</html>
