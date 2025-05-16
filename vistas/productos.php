<?php
require_once '../php/conexion.php';


?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Gestión de Productos</title>
    <link rel="stylesheet" href="../css/estilo.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 40px 20px;
            background: linear-gradient(to right, #f0f2f5, #d9e4f5);
            color: #2c3e50;
        }

        h1, h2 {
            text-align: center;
            margin-bottom: 30px;
        }

        form {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            max-width: 1000px;
            margin: 0 auto 40px;
            background-color: #ffffffcc;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.1);
        }

        input, select, button {
            padding: 10px 15px;
            border: 1px solid #ccc;
            border-radius: 10px;
            font-size: 1rem;
            width: 100%;
            box-sizing: border-box;
        }

        button {
            grid-column: span 2;
            background: #007bff;
            color: white;
            font-weight: bold;
            cursor: pointer;
            transition: background 0.3s ease;
        }

        button:hover {
            background: #0056b3;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            background: white;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
        }

        table th, table td {
            padding: 12px 15px;
            text-align: center;
            border-bottom: 1px solid #ddd;
        }

        table th {
            background-color: #007bff;
            color: white;
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
    <h1>Gestión de Productos</h1>

    <form action="../php/productos.php" method="POST">
        <input type="text" name="nombre" placeholder="Nombre del producto" required>
        <input type="text" name="descripcion" placeholder="Descripción">
        <select name="categoria" required>
            <option value="">Categoría</option>
            <option value="Camisetas">Camisetas</option>
            <option value="Pantalones">Pantalones</option>
            <option value="Accesorios">Accesorios</option>
            <option value="Otro">Otro</option>
        </select>
        <input type="number" step="0.01" name="precio" placeholder="Precio" required>
        <input type="number" name="stock" placeholder="Stock" required>
        <input type="text" name="talla_color" placeholder="Tallas y/o Colores disponibles">
        <input type="number" step="0.01" name="descuento" placeholder="Descuento (%)">
        <input type="date" name="inicio_oferta" placeholder="Inicio oferta">
        <input type="date" name="fin_oferta" placeholder="Fin oferta">
        <input type="number" name="id_proveedor" placeholder="ID proveedor (opcional)">
        <button type="submit" name="agregar">Agregar Producto</button>
    </form>

    <h2>Listado de Productos</h2>
    <table>
        <tr>
            <th>Nombre</th>
            <th>Descripción</th>
            <th>Categoría</th>
            <th>Precio</th>
            <th>Stock</th>
            <th>Talla/Color</th>
            <th>Descuento</th>
            <th>Oferta Activa</th>
            <th>ID Proveedor</th>
        </tr>

        <?php
        $resultado = $conn->query("SELECT * FROM productos");
        $hoy = date('Y-m-d');
        while ($fila = $resultado->fetch_assoc()) {
            $oferta = ($fila['descuento'] > 0 && $fila['inicio_oferta'] <= $hoy && $fila['fin_oferta'] >= $hoy) ? '✅' : '—';
            echo "<tr>
                <td>{$fila['nombre']}</td>
                <td>{$fila['descripcion']}</td>
                <td>{$fila['categoria']}</td>
                <td>\${$fila['precio']}</td>
                <td>{$fila['stock']}</td>
                <td>{$fila['talla_color']}</td>
                <td>{$fila['descuento']}%</td>
                <td>{$oferta}</td>
                <td>{$fila['id_proveedor']}</td>
            </tr>";
        }
        ?>
    </table>
<?php include '../php/volver.php'; ?>
</body>
</html>

