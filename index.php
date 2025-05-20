<?php
session_start();
require_once "php/conexion.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $usuario = $conn->real_escape_string($_POST["usuario"]);
    $contrasena = $_POST["contrasena"];

    // Buscar solo por usuario
    $sql = "SELECT * FROM usuarios WHERE usuario = '$usuario'";
    $resultado = $conn->query($sql);

    if ($resultado && $resultado->num_rows === 1) {
        $fila = $resultado->fetch_assoc();
        $hash_almacenado = $fila["password"];

        // Verificar la contraseña ingresada contra el hash guardado
        if (password_verify($contrasena, $hash_almacenado)) {
            $_SESSION["usuario"] = $fila["usuario"];
            $_SESSION["rol"] = $fila["rol"];
            header("Location: vistas/home.php");
            exit();
        } else {
            $error = "Usuario o contraseña incorrectos.";
        }
    } else {
        $error = "Usuario o contraseña incorrectos.";
    }
}
?>


<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Login - Mis Trapitos</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #74ebd5, #ACB6E5);
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .login-container {
            text-align: center;
            background: #fff;
            padding: 40px 30px;
            border-radius: 16px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
            width: 100%;
            max-width: 400px;
        }

        .login-container h2 {
            text-align: center;
            margin-bottom: 24px;
            color: #333;
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            display: block;
            font-weight: bold;
            margin-bottom: 1px;
            color: #555;
        }

        input[type="text"], input[type="password"] {
            width: 93%;
            padding: 12px;
            border: 1px solid #ccc;
            border-radius: 8px;
            outline: none;
            transition: border-color 0.3s;
        }

        input[type="text"]:focus, input[type="password"]:focus {
            border-color: #74ebd5;
        }

        .btn {
            width: 100%;
            background-color: #007bff;
            color: white;
            border: none;
            padding: 14px;
            font-size: 16px;
            border-radius: 10px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .btn:hover {
            background-color: #0056b3;
        }

        .error {
            color: red;
            text-align: center;
            margin-bottom: 10px;
        }
        .btn-registro {
        display: inline-block;
        margin-top: 10px;
        padding: 10px 20px;
        background-color: #007bff;
        color: white;
        border-radius: 8px;
        text-decoration: none;
        font-size: 14px;
        transition: background-color 0.3s ease;
        }

        .btn-registro:hover {
        background-color: #0056b3;
        }


        @media (max-width: 500px) {
            .login-container {
                padding: 30px 20px;
            }
        }
    </style>
</head>
<body>
    <div class="login-container">
        <h2>Iniciar Sesión</h2>
        <?php if (isset($error)) echo "<p class='error'>$error</p>"; ?>
        <form method="post">
            <div class="form-group">
                <label for="usuario">Usuario</label>
                <input type="text" name="usuario" id="usuario" required>
            </div>
            <div class="form-group">
                <label for="contrasena">Contraseña</label>
                <input type="password" name="contrasena" id="contrasena" required>
            </div>
            <input type="submit" value="Iniciar Sesión" class="btn">
            <div class="form-group" style="text-align: center; margin-top: 15px;">

            </div>
        </form>
    </div>


</body>
</html>
