<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Sistema de Gestión - Tienda de Ropa</title>
    <link rel="stylesheet" href="css/estilo.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 0;
            background: linear-gradient(to right, #e0eafc, #cfdef3);
            display: flex;
            flex-direction: column;
            align-items: center;
            min-height: 100vh;
            padding: 40px 20px;
        }

        h1 {
            color: #2c3e50;
            font-size: 2.5rem;
            margin-bottom: 10px;
            text-align: center;
        }

        p {
            color: #34495e;
            font-size: 1.2rem;
            margin-bottom: 30px;
            text-align: center;
        }

        .menu {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 25px;
            width: 100%;
            max-width: 900px;
        }

        .menu a {
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
            background: linear-gradient(145deg, #007bff, #0056b3);
            color: white;
            text-decoration: none;
            border-radius: 15px;
            font-weight: 600;
            font-size: 1.1rem;
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease, background 0.3s ease;
        }

        .menu a:hover {
            background: linear-gradient(145deg, #0056b3, #004494);
            transform: translateY(-5px);
        }

        @media (max-width: 500px) {
            h1 {
                font-size: 1.8rem;
            }

            p {
                font-size: 1rem;
            }

            .menu a {
                font-size: 1rem;
                padding: 15px;
            }
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
