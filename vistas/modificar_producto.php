<?php
session_start();
require_once '../php/conexion.php';

// Verificar acceso solo para admin
if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'admin') {
    header("Location: ../index.php");
    exit();
}

if (!isset($_GET['id'])) {
    echo "ID de producto no proporcionado.";
    exit();
}

$id_producto = $_GET['id'];

// Obtener datos actuales del producto
$stmt = $conn->prepare("SELECT * FROM productos WHERE id_producto = ?");
$stmt->bind_param("i", $id_producto);
$stmt->execute();
$resultado = $stmt->get_result();

if ($resultado->num_rows === 0) {
    echo "Producto no encontrado.";
    exit();
}

$producto = $resultado->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];
    $categoria = $_POST['categoria'];
    $precio = $_POST['precio'];
    $stock = $_POST['stock'];
    $talla_color = $_POST['talla_color'];
    $descuento = $_POST['descuento'];
    $inicio = $_POST['inicio_oferta'];
    $fin = $_POST['fin_oferta'];
    $proveedor = $_POST['id_proveedor'];
    if (!empty($proveedor)) {
        $check = $conn->prepare("SELECT 1 FROM proveedores WHERE id_proveedor = ?");
        $check->bind_param("i", $proveedor);
        $check->execute();
        $check->store_result();

    if ($check->num_rows === 0) {
        echo "⚠️ El proveedor ingresado no existe.";
        exit();
        }
    }


    $stmt = $conn->prepare("UPDATE productos SET nombre=?, descripcion=?, categoria=?, precio=?, stock=?, talla_color=?, descuento=?, inicio_oferta=?, fin_oferta=?, id_proveedor=? WHERE id_producto=?");
    $stmt->bind_param("sssdissssii", $nombre, $descripcion, $categoria, $precio, $stock, $talla_color, $descuento, $inicio, $fin, $proveedor, $id_producto);


    if ($stmt->execute()) {
        header("Location: productos.php");
        exit();
    } else {
        echo "Error al actualizar.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Modificar Producto</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(to right, #f0f2f5, #d9e4f5);
            margin: 0;
            padding: 40px 20px;
            color: #2c3e50;
        }

        .form-container {
            max-width: 800px;
            margin: auto;
            background: #fff;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 8px 20px rgba(0,0,0,0.1);
        }

        h1 {
            text-align: center;
            margin-bottom: 25px;
        }

        form {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
        }

        input, select, button {
            padding: 12px;
            border-radius: 10px;
            border: 1px solid #ccc;
            font-size: 1rem;
            width: 100%;
            box-sizing: border-box;
        }

        button {
            grid-column: span 2;
            background-color: #007bff;
            color: white;
            font-weight: bold;
            border: none;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #0056b3;
        }

        .back {
            text-align: center;
            margin-top: 20px;
        }

        .back a {
            text-decoration: none;
            color: #007bff;
        }

        @media (max-width: 600px) {
            button {
                grid-column: span 1;
            }
        }
    </style>
</head>
<body>
    <div class="form-container">
        <h1>Modificar Producto</h1>
        <form method="post">
            <input type="text" name="nombre" value="<?= htmlspecialchars($producto['nombre']) ?>" required>
            <input type="text" name="descripcion" value="<?= htmlspecialchars($producto['descripcion']) ?>">
            <input type="text" name="categoria" value="<?= htmlspecialchars($producto['categoria']) ?>" required>
            <input type="number" step="0.01" name="precio" value="<?= htmlspecialchars($producto['precio']) ?>" required>
            <input type="number" name="stock" value="<?= htmlspecialchars($producto['stock']) ?>" required>
            <input type="text" name="talla_color" value="<?= htmlspecialchars($producto['talla_color']) ?>">
            <input type="number" step="0.01" name="descuento" value="<?= htmlspecialchars($producto['descuento']) ?>">
            <input type="date" name="inicio_oferta" value="<?= htmlspecialchars($producto['inicio_oferta']) ?>">
            <input type="date" name="fin_oferta" value="<?= htmlspecialchars($producto['fin_oferta']) ?>">
            <input type="number" name="id_proveedor" value="<?= htmlspecialchars($producto['id_proveedor']) ?>">
            <button type="submit">Guardar Cambios</button>
        </form>
        <div class="back">
            <a href="productos.php">← Volver</a>
        </div>
    </div>
</body>
</html>
