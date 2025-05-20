<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include 'conexion.php';

    $nombre = $_POST['nombre'];
    $usuario = $_POST['usuario'];
    $contrasena = $_POST['contrasena'];

    $hash = password_hash($contrasena, PASSWORD_DEFAULT);

    $stmt = $conn->prepare("SELECT * FROM usuarios WHERE usuario = ?");
    $stmt->bind_param("s", $usuario);
    $stmt->execute();
    $resultado = $stmt->get_result();

    if ($resultado->num_rows > 0) {
        $error = "El nombre de usuario ya está en uso.";
    } else {
        $rol = 'vendedor';
        $stmt = $conn->prepare("INSERT INTO usuarios (nombre, usuario, password, rol) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $nombre, $usuario, $hash, $rol);


        if ($stmt->execute()) {
            header("Location: ../index.php");
            exit();
        } else {
            $error = "Error al registrar usuario.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registro</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: linear-gradient(to right, #74ebd5, #ACB6E5);
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .form-container {
            background-color: #fff;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0,0,0,0.2);
            width: 350px;
            text-align: center;
        }
        .form-container h2 {
            margin-bottom: 20px;
            text-align: center;
        }
        .form-group {
            margin-bottom: 15px;
        }
        label {
            display: block;
            margin-bottom: 5px;
        }
        input[type="text"], input[type="password"] {
            width: 94%;
            padding: 10px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }
        .btn {
            width: 100%;
            background-color: #007bff;
            color: white;
            padding: 10px;
            border: none;
            border-radius: 5px;
            font-weight: bold;
            cursor: pointer;
        }
        .btn:hover {
            background-color: #0056b3;
        }
        .back {
            margin-top: 15px;
            text-align: center;
        }
        .back a {
            color: #007bff;
            text-decoration: none;
        }
        .error {
            color: red;
            text-align: center;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <div class="form-container">
        <h2>Registro</h2>
        <?php if (isset($error)) echo "<p class='error'>$error</p>"; ?>
        <form method="post">
            <div class="form-group">
                <label>Nombre completo</label>
                <input type="text" name="nombre" required>
            </div>
            <div class="form-group">
                <label>Usuario</label>
                <input type="text" name="usuario" required>
            </div>
            <div class="form-group">
                <label>Contraseña</label>
                <input type="password" name="contrasena" required>
            </div>
            <button type="submit" class="btn">Registrar</button>
        </form>
        <div class="back">
            <a href="../index.php">← Volver al login</a>
        </div>
    </div>
</body>
</html>
