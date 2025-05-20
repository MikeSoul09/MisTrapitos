<?php
session_start();
require_once '../php/conexion.php';
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reporte de Inventario</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(to right, #f0f2f5, #d9e4f5);
            padding: 40px;
            color: #333;
        }

        h1 {
            text-align: center;
            margin-bottom: 30px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background: #fff;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }

        th, td {
            padding: 12px 15px;
            text-align: center;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #007bff;
            color: white;
        }

        tr:hover {
            background-color: #f1f1f1;
        }

        .btn-back {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 20px;
            background: #007bff;
            color: white;
            text-decoration: none;
            border-radius: 8px;
        }

        .btn-back:hover {
            background: #0056b3;
        }
    </style>
</head>
<body>

    <h1>📦 Reporte de Inventario</h1>

    <table>
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Descripción</th>
                <th>Categoría</th>
                <th>Precio</th>
                <th>Stock</th>
                <th>Talla/Color</th>
                <th>Descuento</th>
                <th>Proveedor</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $sql = "SELECT p.*, pr.nombre AS proveedor 
                    FROM productos p 
                    LEFT JOIN proveedores pr ON p.id_proveedor = pr.id_proveedor";
            $res = $conn->query($sql);

            while ($row = $res->fetch_assoc()) {
                echo "<tr>
                    <td>{$row['nombre']}</td>
                    <td>{$row['descripcion']}</td>
                    <td>{$row['categoria']}</td>
                    <td>\${$row['precio']}</td>
                    <td>{$row['stock']}</td>
                    <td>{$row['talla_color']}</td>
                    <td>{$row['descuento']}%</td>
                    <td>" . ($row['proveedor'] ?? '—') . "</td>
                </tr>";
            }
            ?>
        </tbody>
    </table>
    <form method="get" action="../vistas/reporte_ventas_pdf.php" target="_blank">
                <button type="submit" class="bg-green-600 text-white px-6 py-3 rounded-lg hover:bg-green-700 transition">
                    📄 Generar PDF
                </button>
            </form>
    <a href="../vistas/reportes.php" class="btn-back">← Volver</a>
</body>
</html>
