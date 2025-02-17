<?php
include "config/config.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST["nombre"];
    $descripcion = $_POST["descripcion"];
    $precio = $_POST["precio"];
    $stock = $_POST["stock"]; // Nuevo campo de stock

    // Manejo de imagen
    $imagen = "img/default.jpg"; // Imagen por defecto
    if (!empty($_FILES["imagen"]["name"])) {
        $ruta_imagen = "img/" . basename($_FILES["imagen"]["name"]);
        if (move_uploaded_file($_FILES["imagen"]["tmp_name"], $ruta_imagen)) {
            $imagen = $ruta_imagen;
        }
    }

    // Insertar producto en la base de datos con stock
    $sql = "INSERT INTO productos (nombre, descripcion, precio, imagen, stock) 
            VALUES ('$nombre', '$descripcion', '$precio', '$imagen', '$stock')";

    if ($conn->query($sql) === TRUE) {
        echo "<p style='color:green;'>✅ Producto agregado correctamente.</p>";
    } else {
        echo "<p style='color:red;'>❌ Error: " . $conn->error . "</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Agregar Producto</title>
</head>
<body>
    <h2>Agregar Nuevo Producto</h2>
    <form action="agregar_producto.php" method="post" enctype="multipart/form-data">
        <label>Nombre:</label>
        <input type="text" name="nombre" required><br><br>

        <label>Descripción:</label>
        <textarea name="descripcion" required></textarea><br><br>

        <label>Precio:</label>
        <input type="number" name="precio" step="0.01" required><br><br>

        <label>Stock:</label>
        <input type="number" name="stock" min="0" required><br><br>

        <label>Imagen:</label>
        <input type="file" name="imagen"><br><br>

        <button type="submit">Agregar Producto</button>
    </form>
</body>
</html>
