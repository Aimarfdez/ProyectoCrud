<?php
$midb = AccesoDatos::getModelo();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['login'])) {
    // Verifica si se ha superado el límite de intentos
    if (isset($_SESSION['intentos']) && $_SESSION['intentos'] > 2) {
        session_destroy();

        echo "<script>alert('Se han realizado más de tres intentos fallidos. Por favor, reinicie el navegador.'); window.location.href = '/PROYECTO-CRUD-PAGINACIÓN/';</script>";
        exit;
    }

    $login = $_POST['login'];
    $password = $_POST['password'];

    $hashedPassword = hash('sha256', $password);

    $user = $midb->getUserByLogin($login);

    if ($user) {
        if ($hashedPassword === $user['password']) {
            $_SESSION['user_id'] = $user['id'];
            header("Location: index.php");
            exit;
        } else {
            $error = "Usuario o contraseña incorrectos";
            // Incrementa el contador de intentos
            if (isset($_SESSION['intentos'])) {
                $_SESSION['intentos']++;
            } else {
                $_SESSION['intentos'] = 1;
            }
        }
    } else {
        $error = "Usuario o contraseña incorrectos";
        // Incrementa el contador de intentos
        if (isset($_SESSION['intentos'])) {
            $_SESSION['intentos']++;
        } else {
            $_SESSION['intentos'] = 1;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar sesión</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f2f5;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .login-container {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 300px;
            text-align: center;
        }

        .login-container h1 {
            margin-bottom: 20px;
            font-size: 24px;
            color: #333;
        }

        .login-container form {
            display: flex;
            flex-direction: column;
        }

        .login-container label {
            margin-bottom: 5px;
            font-weight: bold;
            color: #555;
        }

        .login-container input {
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 16px;
        }

        .login-container button {
            padding: 10px;
            background-color: #007bff;
            border: none;
            border-radius: 4px;
            color: #fff;
            font-size: 16px;
            cursor: pointer;
        }

        .login-container button:hover {
            background-color: #0056b3;
        }

        .login-container p {
            color: red;
            font-weight: bold;
        }
    </style>
</head>

<body>
    <div class="login-container">
        <h1>Iniciar sesión</h1>
        <?php if (isset($error)) : ?>
            <p><?= $error ?></p>
        <?php endif; ?>
        <form method="post">
            <label for="login">Usuario:</label>
            <input type="text" name="login" required><br>

            <label for="password">Contraseña:</label>
            <input type="password" name="password" required><br>

            <button type="submit">Iniciar sesión</button>
        </form>
    </div>
</body>

</html></form></body>