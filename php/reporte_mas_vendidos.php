<?php
require 'conexion.php'; // tu archivo de conexión a la BD

// Consulta para obtener los productos más vendidos
$sql = "SELECT p.nombre, SUM(dv.cantidad) as total_vendido
        FROM detalle_ventas dv
        INNER JOIN productos p ON dv.id_producto = p.id_producto
        GROUP BY dv.id_producto
        ORDER BY total_vendido DESC";

$resultado = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reporte de Productos Más Vendidos</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 p-8">
    <div class="max-w-4xl mx-auto bg-white shadow-lg rounded-lg p-6">
        <h1 class="text-2xl font-bold text-center text-blue-700 mb-6">Productos Más Vendidos</h1>

        <div class="overflow-x-auto">
            <table class="min-w-full text-left border border-gray-300">
                <thead>
                    <tr class="bg-blue-600 text-white">
                        <th class="py-2 px-4 border">Producto</th>
                        <th class="py-2 px-4 border">Total Vendido</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $resultado->fetch_assoc()): ?>
                        <tr class="hover:bg-gray-100">
                            <td class="py-2 px-4 border"><?php echo $row['nombre']; ?></td>
                            <td class="py-2 px-4 border"><?php echo $row['total_vendido']; ?></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>

        <div class="text-center mt-6">
            <form action="generar_pdf_MV.php" method="post">
                <button type="submit" class="bg-blue-600 text-white font-semibold py-2 px-6 rounded hover:bg-blue-700 transition">
                    Generar PDF
                </button>
            </form>
        </div>

        <div class="text-center mt-4">
            <a href="../vistas/reportes.php" class="text-blue-600 hover:underline">← Volver a Reportes</a>
        </div>
    </div>
</body>
</html>
