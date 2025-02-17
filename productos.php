<?php
include "config/config.php";
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Todos los Productos - Apiys</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 text-gray-900">

    <!-- 🔹 HEADER CON EL CARRITO -->
    <?php include "header.php"; ?>

    <!-- 🔹 ESPACIADO PARA EVITAR QUE EL HEADER TAPE EL CONTENIDO -->
    <div class="mt-24"></div>

    <!-- 🔹 TÍTULO -->
    <div class="container mx-auto mt-6 px-4">
        <h1 class="text-2xl font-bold text-center mb-4">Todos los Productos</h1>
        <p class="text-center text-gray-600">Explora nuestra selección de productos de alta calidad.</p>
    </div>

    <!-- 🔹 LISTADO DE PRODUCTOS -->
    <div class="container mx-auto mt-6 px-4">
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            <?php
            // Obtener productos desde la base de datos
            $sql = "SELECT * FROM productos WHERE stock > 0 ORDER BY fecha_creacion DESC";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while ($producto = $result->fetch_assoc()) {
                    $imagen = !empty($producto['imagen']) ? $producto['imagen'] : 'img/default.jpg';
                    $nombre = htmlspecialchars($producto['nombre'], ENT_QUOTES, 'UTF-8');
                    $precio = number_format($producto['precio'], 0, ',', '.');
                    
                    echo "<div class='bg-white p-4 rounded-lg shadow-md text-center flex flex-col justify-between transform transition duration-300 hover:scale-105'>";
                    echo "<img src='{$imagen}' class='w-full h-40 object-cover rounded mb-3' alt='{$nombre}'>";
                    echo "<div class='flex-grow'>";
                    echo "<h2 class='text-md font-semibold text-gray-800'>{$nombre}</h2>";
                    echo "<p class='text-lg font-bold text-red-600 mt-2'>$ {$precio} CLP</p>";
                    echo "<p class='text-xs text-gray-500'>IVA incluido</p>";
                    echo "</div>";
                    echo "<a href='producto.php?id={$producto['id']}' 
                            class='bg-blue-600 text-white px-4 py-2 mt-3 rounded hover:bg-blue-700 w-full'>Ver Detalles</a>";
                    echo "</div>";
                }
            } else {
                echo "<p class='text-center text-gray-600 col-span-full'>No hay productos disponibles.</p>";
            }
            ?>
        </div>
    </div>

    <!-- 🔹 FOOTER -->
    <?php include "footer.php"; ?>

    <!-- 🔹 INCLUIR EL MANEJO DEL CARRITO -->
    <script src="js/carrito.js"></script>

</body>
</html>
