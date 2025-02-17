<?php
include "config/config.php";
include "header.php"
?>
<script src="js/carrito.js"></script>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Apiys - Tienda Online</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        /* 🔹 Navbar fija */
        .navbar-fixed {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            z-index: 50; /* Asegura que no se esconda */
            background: white;
            box-shadow: 0px 2px 10px rgba(0, 0, 0, 0.1);
        }
        /* 🔹 Menú desplegable */
        #menu {
            z-index: 1000; /* Asegura que quede encima */
        }
        /* 🔹 Espaciado para evitar que el menú tape el slider */
        .content {
            padding-top: 120px;
        }
        /* 🔹 Productos destacados */
        .product-card {
            background: white;
            border-radius: 10px;
            padding: 16px;
            text-align: center;
            box-shadow: 0px 2px 10px rgba(0, 0, 0, 0.1);
            transition: transform 0.2s;
        }
        .product-card:hover {
            transform: translateY(-5px);
        }
        /* 🔹 Modal del carrito */
        .modal {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            display: flex;
            align-items: center;
            justify-content: center;
            display: none;
        }
        .modal-content {
            background: white;
            padding: 20px;
            border-radius: 10px;
            width: 400px;
            text-align: center;
        }
    </style>
</head>
<body class="bg-gray-100 text-gray-900">


    <!-- 🔹 SLIDER MEJORADO -->
<div class="relative w-full h-[60vh] overflow-hidden">
    <!-- Contenedor de imágenes -->
    <div id="sliderContainer" class="relative w-full h-full">
        <img src="img/banner1.jpg" class="absolute w-full h-full object-cover object-center slider-image">
        <img src="img/banner2.jpg" class="absolute w-full h-full object-cover object-center slider-image hidden">
        <img src="img/banner3.jpg" class="absolute w-full h-full object-cover object-center slider-image hidden">
    </div>

    <!-- Botón Izquierda -->
    <button id="prevSlide" class="absolute left-4 top-1/2 transform -translate-y-1/2 bg-black/50 text-white p-2 rounded-full hover:bg-black transition-opacity opacity-50 hover:opacity-100">
        ⬅️
    </button>
    
    <!-- Botón Derecha -->
    <button id="nextSlide" class="absolute right-4 top-1/2 transform -translate-y-1/2 bg-black/50 text-white p-2 rounded-full hover:bg-black transition-opacity opacity-50 hover:opacity-100">
        ➡️
    </button>
</div>


    <!-- 🔹 PRODUCTOS DESTACADOS -->
<div class="container mx-auto mt-10">
    <h2 class="text-xl font-bold text-center mb-4">Productos Destacados</h2>
    
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-6 px-4">
        <?php
        // Consulta SQL para obtener productos destacados con stock disponible
        $sql = "SELECT id, nombre, descripcion, precio, imagen FROM productos WHERE stock > 0 ORDER BY fecha_creacion DESC LIMIT 6";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while ($producto = $result->fetch_assoc()) {
                // Si la imagen no está definida, usamos una imagen por defecto
                $imagen = !empty($producto['imagen']) ? $producto['imagen'] : 'img/default.jpg';

                echo "<div class='product-card bg-white p-4 rounded shadow-md text-center'>";
                echo "<img src='{$imagen}' class='w-full h-40 object-cover mb-3' alt='{$producto['nombre']}'>";
                echo "<h2 class='text-md font-semibold'>{$producto['nombre']}</h2>";
                echo "<p class='text-sm text-gray-600 truncate'>{$producto['descripcion']}</p>";
                echo "<p class='text-lg font-bold text-red-600 mt-2'>\$" . number_format($producto['precio'], 0, ',', '.') . " CLP</p>";
                echo "<p class='text-xs text-gray-500'>IVA incluido</p>";
                echo "<a href='producto.php?id={$producto['id']}' class='bg-blue-600 text-white px-4 py-2 mt-3 rounded hover:bg-blue-700 inline-block'>Ver más</a>";
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




    <!-- 🔹 MODAL DEL CARRITO -->
    <div id="cartModal" class="modal">
        <div class="modal-content">
            <h2 class="text-xl font-bold">🛒 Tu Carrito</h2>
            <ul id="cartItems" class="mt-4 text-gray-700"></ul>
            <button onclick="toggleCart()" class="mt-4 bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600">Cerrar</button>
        </div>
    </div>

    <!-- 🔹 JAVASCRIPT -->
    


</body>
</html>
