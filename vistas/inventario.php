<?php require_once '../php/conexion.php'; ?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Inventario de Productos</title>
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
            max-width: 900px;
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
        a.modificar-btn {
            background-color: #f39c12;
            color: white;
            padding: 6px 12px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: bold;
            transition: background 0.3s;
        }
        a.modificar-btn:hover {
            background-color: #d68910;
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
    <h1>Gestión de Inventario</h1>

    <h2>Agregar Nuevo Producto</h2>
    <form action="../php/inventario.php" method="POST">
        <input type="text" name="nombre" placeholder="Nombre del producto" required>
        <input type="text" name="categoria" placeholder="Categoría (Ej: Camisetas)" required>
        <input type="text" name="descripcion" placeholder="Descripción">
        <input type="number" name="precio" step="0.01" placeholder="Precio" required>
        <input type="number" name="stock" placeholder="Cantidad en stock" required>
        <input type="text" name="talla_color" placeholder="Tallas o colores disponibles">
        <input type="number" name="descuento" step="0.01" placeholder="Descuento (%)">
        <input type="date" name="inicio_oferta">
        <input type="date" name="fin_oferta">
        <button type="submit" name="agregar">Agregar Producto</button>
    </form>

    <h2>Inventario Actual</h2>
    <table>
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Categoría</th>
            <th>Precio</th>
            <th>Stock</th>
            <th>Descuento</th>
            <th>Oferta activa</th>
            <th>Precio final</th>
            <th>Acciones</th>
        </tr>
        <?php
        $sql = "SELECT * FROM productos";
        $productos = $conn->query($sql);
        $hoy = date('Y-m-d');

        while ($p = $productos->fetch_assoc()) {
            $oferta_activa = ($p['inicio_oferta'] <= $hoy && $p['fin_oferta'] >= $hoy && $p['descuento'] > 0) ? '✅' : '—';
            $precio_final = ($oferta_activa === '✅') ? $p['precio'] * (1 - $p['descuento'] / 100) : $p['precio'];
            echo "<tr>
                <td>{$p['id_producto']}</td>
                <td>{$p['nombre']}</td>
                <td>{$p['categoria']}</td>
                <td>\${$p['precio']}</td>
                <td>{$p['stock']}</td>
                <td>{$p['descuento']}%</td>
                <td>$oferta_activa</td>
                <td>" . number_format($precio_final, 2) . "</td>
                <td><a href='modificar_producto.php?id={$p['id_producto']}' class='modificar-btn'>Modificar</a></td>
            </tr>";
        }
        ?>
    </table>

<?php include '../php/volver.php'; ?>
</body>
</html>