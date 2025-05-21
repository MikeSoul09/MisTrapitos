<?php
session_start();
if (!isset($_SESSION['rol'])) {
    header("Location: index.php");
    exit();
}
$rol = $_SESSION['rol'];
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Sistema de Gestión - Mis Trapitos</title>
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
            grid-template-columns: repeat(3, 1fr);
            gap: 30px;
            width: 100%;
            max-width: 1000px;
            margin-bottom: 40px;
        }

        .menu a {
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 30px;
            background: linear-gradient(145deg, #007bff, #0056b3);
            color: white;
            text-decoration: none;
            border-radius: 20px;
            font-weight: 600;
            font-size: 1.3rem;
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease, background 0.3s ease;
        }

        .menu a:hover {
            background: linear-gradient(145deg, #0056b3, #004494);
            transform: translateY(-5px);
        }

        .logout-container {
            display: flex;
            justify-content: center;
            width: 100%;
            margin-top: 20px;
        }

        .logout-btn {
            display: inline-block;
            padding: 12px 25px;
            background-color: #e74c3c;
            color: white;
            font-weight: bold;
            border: none;
            border-radius: 10px;
            text-decoration: none;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            transition: background-color 0.3s ease, transform 0.2s ease;
        }

        .logout-btn:hover {
            background-color: #c0392b;
            transform: scale(1.05);
        }

        @media (max-width: 768px) {
            .menu {
                grid-template-columns: 1fr;
            }

            .menu a {
                font-size: 1.1rem;
                padding: 20px;
            }

            .logout-btn {
                padding: 10px 20px;
                font-size: 0.95rem;
            }
        }

        @media (max-width: 500px) {
            h1 {
                font-size: 1.8rem;
            }

            p {
                font-size: 1rem;
            }
        }
    </style>
</head>
<body>
    <body>
    <h1>Sistema de Gestión para Mis Trapitos</h1>
    
    <div class="usuario-info">
    <p>Bienvenido, <strong><?php echo $_SESSION['usuario']; ?></strong></p>
    <p>Rol: <strong><?php echo ucfirst($rol); ?></strong></p>
    </div>
    <p>Selecciona una opción del sistema:</p>
    <div class="menu">
    <?php if ($rol == 'admin' || $rol == 'vendedor'): ?>
        <a href="productos.php" class="menu-item">🛍️ Productos</a>
        <a href="clientes.php" class="menu-item">👤 Clientes</a>
        <a href="ventas.php" class="menu-item">🧾 Ventas</a>
        <a href="reportes.php" class="menu-item">🧾 Reportes Ventas</a>
    <?php endif; ?>

    <?php if ($rol == 'admin'): ?>
        <a href="inventario.php" class="menu-item">📦 Inventario</a>
        <a href="proveedores.php" class="menu-item">📇 Proveedores</a>
        <a href="gestion_usuarios.php" class="menu-item">💼 Usuarios</a>
        <a href="consultas.php" class="menu-item">📊 Consultas</a>
    <?php endif; ?>
</div>

    <div class="logout-container">
        <a href="../php/logout.php" class="logout-btn">🔒 Cerrar sesión</a>
    </div>
</body>
</html>
