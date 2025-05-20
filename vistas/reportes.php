<?php
session_start();

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reportes</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-r from-blue-100 to-blue-200 min-h-screen flex items-center justify-center">

    <div class="bg-white p-10 rounded-2xl shadow-lg w-full max-w-3xl text-center">
        <h1 class="text-3xl font-bold mb-8 text-blue-700">📊 Panel de Reportes</h1>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <a href="../php/reporte_inventario.php" class="bg-blue-500 hover:bg-blue-600 text-white font-semibold py-4 px-6 rounded-xl shadow flex items-center justify-center gap-3 transition duration-300">
                📦 Reporte de Inventario
            </a>

            <a href="../php/reporte_ventas_periodo.php" class="bg-green-500 hover:bg-green-600 text-white font-semibold py-4 px-6 rounded-xl shadow flex items-center justify-center gap-3 transition duration-300">
                📈 Ventas por Período
            </a>

            <a href="../php/reporte_mas_vendidos.php" class="bg-purple-500 hover:bg-purple-600 text-white font-semibold py-4 px-6 rounded-xl shadow flex items-center justify-center gap-3 transition duration-300 col-span-1 md:col-span-2">
                🔝 Productos Más Vendidos
            </a>
        </div>

        <a href="home.php" class="block mt-8 text-blue-600 hover:underline">← Volver al menú principal</a>
    </div>

</body>
</html>
