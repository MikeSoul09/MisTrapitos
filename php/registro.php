<?php
require_once "conexion.php";

if (!isset($conn)) {
    die("❌ Error: No se estableció la conexión a la base de datos.");}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = trim($_POST["nombre"]);
    $usuario = trim($_POST["usuario"]);
    $contrasena = $_POST["contrasena"];
    $rol = 'vendedor'; // fijo

    $nombre = $conn->real_escape_string($nombre);
    $usuario = $conn->real_escape_string($usuario);

    // Verificar si el usuario ya existe
    $check_sql = "SELECT id FROM usuarios WHERE usuario = '$usuario'";
    $check_resultado = $conn->query($check_sql);

    if ($check_resultado->num_rows > 0) {
        $error = "⚠️ El nombre de usuario ya está en uso. Elige otro.";
    } else {
        // Cifrar la contraseña
        $password_hash = password_hash($contrasena, PASSWORD_DEFAULT);

        $sql = "INSERT INTO usuarios (nombre, usuario, password, rol) 
                VALUES ('$nombre', '$usuario', '$password_hash', '$rol')";

        if ($conn->query($sql)) {
            header("Location: index.php?registro=exitoso");
            exit();
        } else {
            $error = "❌ Error al registrar: " . $conn->error;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registro de Usuario</title>
    <style>
        body {
            background: linear-gradient(135deg, #FFDEE9, #B5FFFC);
            font-family: 'Segoe UI', sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .form-container {
            background: white;
            padding: 30px;
            border-radius: 16px;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 420px;
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #333;
        }

        .form-group {
            margin-bottom: 15px;
        }

        label {
            display: block;
            margin-bottom: 5px;
            font-weight: 500;
        }

        input {
            width: 100%;
            padding: 10px;
            border: 1px solid #bbb;
            border-radius: 8px;
            outline: none;
        }

        .btn {
            width: 100%;
            padding: 12px;
            background-color: #2196F3;
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            cursor: pointer;
        }

        .btn:hover {
            background-color: #0b7dda;
        }

        .error {
            color: red;
            text-align: center;
            margin-bottom: 10px;
        }

        .success {
            color: green;
            text-align: center;
        }

        .back {
            text-align: center;
            margin-top: 10px;
        }

        .back a {
            color: #2196F3;
            text-decoration: none;
        }

        .back a:hover {
            text-decoration: underline;
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
