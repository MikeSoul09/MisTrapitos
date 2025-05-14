<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Sistema de Gestión - Tienda de Ropa</title>
    <link rel="stylesheet" href="css/estilo.css">
    <style>
        .menu {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            margin-top: 40px;
        }

        .menu a {
            display: inline-block;
            padding: 20px;
            background-color: #007bff;
            color: white;
            text-decoration: none;
            border-radius: 10px;
            font-weight: bold;
            text-align: center;
            width: 200px;
            transition: 0.3s;
        }

        .menu a:hover {
            background-color: #0056b3;
        }

        h1 {
            color: #333;
        }
    </style>
</head>
<body>
    <h1>Sistema de Gestión para Tienda de Ropa</h1>
    <p>Selecciona una opción del sistema:</p>

    <div class="menu">
        <a href="vistas/productos.php">🛍️ Productos</a>
        <a href="vistas/clientes.php">👤 Clientes</a>
        <a href="vistas/ventas.php">🧾 Ventas</a>
        <a href="vistas/inventario.php">📦 Inventario</a>
        <a href="vistas/proveedores.php">📇 Proveedores</a>
        <a href="vistas/consultas.php">📊 Consultas</a>
    </div>
</body>
</html>
