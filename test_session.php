<?php
session_start(); // Iniciar sesión

// Si la variable de sesión no está definida, la inicializamos
if (!isset($_SESSION['test'])) {
    $_SESSION['test'] = "Funciona correctamente ✅";
} else {
    echo "✅ Sesión activa: " . $_SESSION['test'];
}
?>
