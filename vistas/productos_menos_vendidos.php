<?php require_once '../php/conexion.php'; ?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Productos Menos Vendidos</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 p-6">
    <h1 class="text-3xl font-bold text-center mb-6">Productos Menos Vendidos en los Últimos Tres Meses</h1>
    
    <div class="overflow-x-auto">
        <table class="min-w-full bg-white border border-gray-200 rounded-lg shadow-md">
            <thead>
                <tr class="bg-blue-500 text-white">
                    <th class="py-3 px-4 border-b">ID</th>
                    <th class="py-3 px-4 border-b">Nombre</th>
                    <th class="py-3 px-4 border-b">Categoría</th>
                    <th class="py-3 px-4 border-b">Precio</th>
                    <th class="py-3 px-4 border-b">Stock</th>
                    <th class="py-3 px-4 border-b">Total Vendido</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sql = "SELECT p.id_producto, p.nombre, p.categoria, p.precio, p.stock, 
                               COALESCE(SUM(p.stock), 0) AS total_vendido
                        FROM productos p
                        LEFT JOIN ventas v ON p.id_producto = v.id_venta 
                        WHERE v.fecha >= DATE_SUB(CURDATE(), INTERVAL 3 MONTH)
                        GROUP BY p.id_producto
                        ORDER BY total_vendido ASC
                        LIMIT 10";
                
                $productos_menos_vendidos = $conn->query($sql);

               while ($p = $productos_menos_vendidos->fetch_assoc()) {
                    echo "<tr class='hover:bg-gray-100'>
                            <td class='py-3 px-4 border-b text-center'>{$p['id_producto']}</td>
                            <td class='py-3 px-4 border-b text-center'>{$p['nombre']}</td>
                            <td class='py-3 px-4 border-b text-center'>{$p['categoria']}</td>
                            <td class='py-3 px-4 border-b text-center'>\${$p['precio']}</td>
                            <td class='py-3 px-4 border-b text-center'>{$p['stock']}</td>
                            <td class='py-3 px-4 border-b text-center'>{$p['total_vendido']}</td>
                          </tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

    <div class="mt-6 text-center">
        <a href="../vistas/inventario.php" class="bg-blue-500 text-white py-2 px-4 rounded hover:bg-blue-600">Volver al Inventario</a>
    </div>
</body>
</html>
