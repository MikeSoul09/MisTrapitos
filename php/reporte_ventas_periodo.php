<?php
session_start();
require_once 'conexion.php';

$ventas = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $desde = $_POST['desde'];
    $hasta = $_POST['hasta'];

    $stmt = $conn->prepare("
        SELECT v.id_venta, v.fecha, c.nombre AS cliente, p.nombre AS producto, dv.cantidad, dv.precio_unitario 
        FROM ventas v
        INNER JOIN clientes c ON v.id_cliente = c.id_cliente
        INNER JOIN detalle_ventas dv ON v.id_venta = dv.id_venta
        INNER JOIN productos p ON dv.id_producto = p.id_producto
        WHERE v.fecha BETWEEN ? AND ?
        ORDER BY v.fecha ASC
    ");
    $stmt->bind_param("ss", $desde, $hasta);
    $stmt->execute();
    $result = $stmt->get_result();
    while ($row = $result->fetch_assoc()) {
        $ventas[] = $row;
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reporte de Ventas por Período</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <style>
        
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
    </style>
</head>
<body class="bg-gray-100 text-gray-800">
    <div class="max-w-6xl mx-auto mt-10">
        <h1 class="text-3xl font-bold mb-6 text-center">Reporte de Ventas por Período</h1>

        <!-- Formulario -->
        <form method="post" action="../vistas/reporte_fechas_pdf.php" class="flex gap-4 justify-center mb-6">
            <div>
                <label>Desde:</label>
                <input type="date" name="desde" class="border p-2 rounded" required>
            </div>
            <div>
                <label>Hasta:</label>
                <input type="date" name="hasta" class="border p-2 rounded" required>
            </div>
            <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700">Buscar</button>
        </form>


        <?php if (!empty($ventas)): ?>
        <!-- Tabla -->
        <div class="overflow-x-auto">
            <table class="min-w-full bg-white rounded shadow">
                <thead class="bg-blue-600 text-white">
                    <tr>
                        <th class="py-2 px-4">Fecha</th>
                        <th class="py-2 px-4">Cliente</th>
                        <th class="py-2 px-4">Producto</th>
                        <th class="py-2 px-4">Cantidad</th>
                        <th class="py-2 px-4">Precio Unitario</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($ventas as $v): ?>
                    <tr class="border-t hover:bg-gray-100">
                        <td class="py-2 px-4"><?= $v['fecha'] ?></td>
                        <td class="py-2 px-4"><?= $v['cliente'] ?></td>
                        <td class="py-2 px-4"><?= $v['producto'] ?></td>
                        <td class="py-2 px-4"><?= $v['cantidad'] ?></td>
                        <td class="py-2 px-4">$<?= number_format($v['precio_unitario'], 2) ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <?php elseif ($_SERVER['REQUEST_METHOD'] === 'POST'): ?>
            <p class="text-center mt-6 text-red-500">No se encontraron ventas en ese período.</p>
        <?php endif; ?>
    </div>
<a href="../vistas/reportes.php" class="btn-back">← Volver</a>
</body>
</html>
