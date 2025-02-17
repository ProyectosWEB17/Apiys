<?php
session_start();
include "config/config.php";


// Verificar si la tabla `usuarios` existe
$conn->query("CREATE TABLE IF NOT EXISTS usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario VARCHAR(50) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    rol ENUM('admin', 'usuario') NOT NULL
)");

// Verificar si el usuario admin ya existe
$result = $conn->query("SELECT * FROM usuarios WHERE usuario = 'admin'");
if ($result->num_rows == 0) {
    // Si no existe, crear el usuario admin por defecto
    $hashed_password = hash('sha256', '1234'); // Encriptar la contraseña
    $conn->query("INSERT INTO usuarios (usuario, password, rol) VALUES ('admin', '$hashed_password', 'admin')");
}

// Procesar formulario de inicio de sesión
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $usuario = $_POST["usuario"];
    $password = hash('sha256', $_POST["password"]); // Encriptar la contraseña ingresada

    // Buscar usuario en la base de datos
    $sql = "SELECT id, usuario, password, rol FROM usuarios WHERE usuario = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $usuario);
    $stmt->execute();
    $resultado = $stmt->get_result();

    if ($resultado->num_rows === 1) {
        $usuario_data = $resultado->fetch_assoc();

        // Comparar contraseñas encriptadas
        if ($password === $usuario_data["password"]) {
            $_SESSION["usuario"] = $usuario_data["usuario"];
            $_SESSION["rol"] = $usuario_data["rol"];

            if ($usuario_data["rol"] === "admin") {
                header("Location: admin.php");
            } else {
                header("Location: index.php");
            }
            exit();
        } else {
            $error = "❌ Contraseña incorrecta.";
        }
    } else {
        $error = "❌ Usuario no encontrado.";
    }
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Acceso al Panel</title>
</head>
<body>
    <h2>Acceso al Panel</h2>
    <?php if (isset($error)) echo "<p style='color:red;'>$error</p>"; ?>
    
    <form action="login.php" method="post">
        <label>Usuario:</label>
        <input type="text" name="usuario" required><br><br>

        <label>Contraseña:</label>
        <input type="password" name="password" required><br><br>

        <button type="submit">Ingresar</button>
    </form>
</body>
</html>
